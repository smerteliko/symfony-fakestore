<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Event\UserCreatedEvent;
use App\Repository\UserRepository;
use App\Service\Mail\EmailNotification\EmailNotification;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Lexik\Bundle\JWTAuthenticationBundle\Security\Http\Authentication\AuthenticationSuccessHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/user', name: 'app_user')]
class UserController extends AbstractController
{
    public function __construct(
	    private readonly SerializerInterface          $serializer,
	    private readonly TokenStorageInterface        $tokenStorage,
	    private readonly UserRepository               $userRepository,
	    private readonly AuthenticationSuccessHandler $authenticationSuccessHandler,
	    private readonly EventDispatcherInterface     $dispatcher,
	    private readonly MessageBusInterface $bus,
	    private readonly TranslatorInterface          $translator)
    {
    }

    #[Route('/login', name: '_login', methods: ['POST'])]
    public function login(#[CurrentUser] ?User $user): JsonResponse
    {

        return new JsonResponse([$user], 200);
    }

    #[Route('/logout', name: '_logout', methods: ['POST'])]
    public function logout(#[CurrentUser] ?User $user): JsonResponse
    {
        $this->tokenStorage->setToken(null);

        return new JsonResponse([], 200);
    }

    #[Route('/profile', name: '_profile', methods: ['GET'])]
    #[Route('/profile/{vue}',
        name: '_vue_profile',
        requirements: ['vue' => '^(?!.*api|_wdt|_profiler).+'],
        methods: ['GET'])
    ]
    public function profile(): Response
    {
	    $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY', NULL, $this->translator->trans('user.login.not_login', [],'user'));

        return $this->render('base.html.twig', []);
    }

    #[Route('/is_authorized', name: '_is_authorized', methods: ['GET'])]
    public function isAuthorized(UserRepository $userRepository): JsonResponse
    {
        $currentUser = $this->getUser();

        $userArray = [];
        if ($currentUser) {
            $userArray = $userRepository->findOneBy(['email' => $currentUser->getUserIdentifier()]);
            $userArray = $userArray->toArray();
        }

        $user = $this->serializer->serialize($userArray, 'json');

        $isAuth = filter_var(null !== $userArray, FILTER_VALIDATE_BOOL);

        if ($isAuth) {
            return new JsonResponse(
                [
                    'is_authenticated' => $isAuth,
                    'user' => $user,
                    'code' => Response::HTTP_OK,
                ],
                Response::HTTP_OK
            );
        }

        return new JsonResponse(
            [
                'is_authenticated' => $isAuth,
                'message' => $this->translator->trans('user.login.not_login', [],'user'),
                'code' => Response::HTTP_FORBIDDEN,
            ], Response::HTTP_FORBIDDEN
        );
    }

	#[Route('/update_info', name: '_update_info', methods: ['POST'])]
	public function updateUserInfo(
		Request $request,
		#[CurrentUser] ?User $user): JsonResponse
	{
		$requestTransformed = $this->transformJsonBody($request);
		$updatedUser =$requestTransformed->get('user');
		if(!$user) {
			return new JsonResponse([
				'message' => $this->translator->trans('user.login.not_login', [],'user'),
				'code' =>   Response::HTTP_FORBIDDEN]
				, 500);
		}
		$this->userRepository->updatePersonalInfo($updatedUser, $user);

		return new JsonResponse(
			[
				'message' => $this->translator->trans('user.update.success', [], 'user'),
				'code' =>   Response::HTTP_OK
			], Response::HTTP_OK
		);
	}

	/**
	 * @throws \JsonException
	 */
	#[Route('/register', name: '_register', methods: [ 'POST'])]
	public function register(Request $request,EventDispatcherInterface $dispatcher,): JsonResponse {
		$requestTransformed = $this->transformJsonBody($request);
		$newUser =$requestTransformed->get('user');
		try {
			$lastUser = $this->userRepository->createUser($newUser);
		} catch (UniqueConstraintViolationException $exception) {
			return new JsonResponse([
				'message' => $this->translator->trans('user.create.exists', ['email' => $newUser['email']], 'user'),
				'code' => Response::HTTP_BAD_REQUEST
			],Response::HTTP_BAD_REQUEST);
		}

		if(!$lastUser->getUuid()) {
			return new JsonResponse([
				'message' =>  $this->translator->trans('user.create.failure', [], 'user'),
				'code' => Response::HTTP_INTERNAL_SERVER_ERROR
			], Response::HTTP_INTERNAL_SERVER_ERROR);
		}

		$this->dispatcher->dispatch(new UserCreatedEvent($lastUser));
		return new JsonResponse(
			[
				'message' => [
					$this->translator->trans('user.create.success', [], 'user'),
					$this->translator->trans('user.create.authorize', [], 'user'),
					$this->translator->trans('user.create.check_email',[],'user')
				],
				'code' =>   Response::HTTP_OK
			], Response::HTTP_OK
		);
	}

	/**
	 * @throws \JsonException
	 */
	#[Route('/verify', name: '_verify', methods: [ 'POST'])]
	public function verify(Request $request,#[CurrentUser] ?User $user): JsonResponse {
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY', NULL, $this->translator->trans('user.login.not_login', [],'user'));

		if(!$user) {
			return new JsonResponse([
				                        'message' =>$this->translator->trans('user.login.not_login', [],'user'),
				                        'code' =>   Response::HTTP_FORBIDDEN
			                        ], Response::HTTP_FORBIDDEN);
		}
		$data = json_decode($request->getContent(), true);
		$code = $user->getVerificationCode();
		if (!$code) {
			return new JsonResponse([],Response::HTTP_INTERNAL_SERVER_ERROR);
		}

		if($data['code'] !== $code->getCode()) {
			return new JsonResponse([
				'message' => $this->translator->trans('verify.code.code_wrong', [], 'user'),
				'code' =>   Response::HTTP_BAD_REQUEST
			],Response::HTTP_BAD_REQUEST);
		}

		$user->verify();
		$this->userRepository->save($user);
		
		return new JsonResponse(
			[
				'message' => $this->translator->trans('verify.success',[],'user'),
				'code' =>   Response::HTTP_OK
			], Response::HTTP_OK
		);
	}

	/**
	 * @throws \JsonException
	 */
	#[Route('/verify_resend_code', name: '_verify_resend_code', methods: [ 'POST'])]
	public function resendVerifyCode(Request $request,#[CurrentUser] ?User $user): JsonResponse {
		$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY', NULL, $this->translator->trans('user.login.not_login', [],'user'));

		if(!$user) {
			return new JsonResponse([
				'message' =>  $this->translator->trans('user.login.not_login', [],'user'),
				'code' =>   Response::HTTP_FORBIDDEN
			], Response::HTTP_FORBIDDEN);
		}

		$subject = $this->translator->trans(
			'email.verification.code.subject', [], 'mail'
		);

		$verifyAccount = $this->translator->trans(
			'email.verification.code.explanation', [], 'mail'
		);

		$this->bus->dispatch(
			new EmailNotification(
				$user->getEmail(),
				$subject,
				[
					'subject' => $subject,
					'verifyAccount' => $verifyAccount,
					'code' => $user->getVerificationCode()->getCode()
				],
				'user_account_confirmation'
			),
			[new AmqpStamp('user-email', AMQP_NOPARAM, [])]
		);
		return new JsonResponse(
			[
				'message' =>  $this->translator->trans('verify.code.resend.success',[],'user'),
				'code' =>   Response::HTTP_OK
			], Response::HTTP_OK
		);
	}


	/**
	 * this method allows us to accept JSON payloads in POST requests
	 * since Symfony doesn't handle that automatically:
	 *
	 * @param Request $request
	 * @return object
	 * @throws \JsonException
	 */
	private  function transformJsonBody(Request $request): object
	{
		$data = json_decode($request->getContent(),
		                    TRUE,
		                    512,
		                    JSON_THROW_ON_ERROR);

		if (json_last_error() !== JSON_ERROR_NONE) {
			return (object)[];
		}

		if ($data === null) {
			return $request;
		}

		$request->request->replace($data);

		return $request;
	}

}
