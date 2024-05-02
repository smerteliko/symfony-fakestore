<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/cart')]
class CartController extends AbstractController
{
	#[Route('/', name: 'app_cart')]
	public function index(): Response {
		return $this->render('base.html.twig', []);
	}
}