<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/user', name: 'app_user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user')]
    public function index(): JsonResponse
    {
        return $this->json([
        ]);
    }

	#[Route('/login', name: 'app_user_login ', methods: ['POST'])]
	public function login(#[CurrentUser] ?User $user): JsonResponse
	{
		return $this->json([ ]);
	}
}
