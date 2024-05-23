<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
		private readonly TokenStorageInterface $tokenStorage) { }

    #[Route('/login', name: '_login', methods: ['POST'])]
    public function login(#[CurrentUser] ?User $user): JsonResponse {

        return new JsonResponse([$user], 200);
    }

     #[Route('/logout', name: '_logout', methods: ['POST'])]
     public function logout(#[CurrentUser] ?User $user): JsonResponse {
	     $this->tokenStorage->setToken(null);
		 return new JsonResponse([],200);
     }

    #[Route('/profile', name: '_profile', methods: ['GET'])]
    #[Route('/profile/{vue}',
	    name: '_vue_profile',
	    requirements: [ 'vue' =>'^(?!.*api|_wdt|_profiler).+'],
	    methods: [ 'GET'] )
    ]
    public function profile() : Response
    {
	    return $this->render('base.html.twig', []);
    }


     #[Route('/is_authorized', name: '_is_authorized', methods: ['GET'])]
     public function isAuthorized(): JsonResponse
     {
         $currentUser = $this->getUser();
        if($currentUser) {
            $userArray = [
                 'id' => $currentUser->getId(),
                 'email' => $currentUser->getUserIdentifier(),
                 'roles' => $currentUser->getRoles(),
            ] ;
        }

        $user = $this->serializer->serialize($userArray, 'json');

        $isAuth = filter_var($user !== NULL, FILTER_VALIDATE_BOOL);

        if ($isAuth) {
            return  new JsonResponse(
                [
                    'is_authenticated' => $isAuth,
                    'user' => $user,
                    'code' =>   Response::HTTP_OK
                ],
                Response::HTTP_OK
            );
        }
        return  new JsonResponse(
            [
                'is_authenticated' => $isAuth,
                'message' => 'User not in',
                'code' =>  Response::HTTP_FORBIDDEN
            ]
            , Response::HTTP_FORBIDDEN
        );
     }
     
}
