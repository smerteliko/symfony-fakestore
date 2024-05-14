<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'app_main')]
    public function index(CategoryRepository $categoryRepository): Response
    {
        return $this->render('base.html.twig', [
            'category' => $categoryRepository->findAll(),
        ]);
    }
}
