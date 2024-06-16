<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/user', name: 'app_user')]
class UserController extends AbstractController
{
    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly TokenStorageInterface $tokenStorage,
        private readonly UserRepository $userRepository,
    )
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
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

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
                'message' => 'User not in',
                'code' => Response::HTTP_FORBIDDEN,
            ], Response::HTTP_FORBIDDEN
        );
    }

	#[Route('/update_info', name: '_update_info', methods: ['POST', 'GET'])]
	public function updateUserInfo(
		Request $request,
		#[CurrentUser] ?User $user): JsonResponse
	{
		$requestTransformed = $this->transformJsonBody($request);
		$updatedUser =$requestTransformed->get('user');
		if(!$user) {
			return new JsonResponse([
				'message' => 'No user to update',
				'code' =>   Response::HTTP_INTERNAL_SERVER_ERROR]
				, 500);
		}
		$this->userRepository->updatePersonalInfo($updatedUser, $user);

		return new JsonResponse(
			[
				'message' => 'User was updated successfully',
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
	 */
	private  function transformJsonBody(Request $request): object
	{
		$data = json_decode($request->getContent(), true);

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
