<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/catalog')]
class CatalogController extends AbstractController
{
	private CategoryRepository $categoryRepository;
	public function __construct(CategoryRepository $categoryRepository){
		$this->categoryRepository = $categoryRepository;
	}
	#[Route('/', name: 'app_catalog')]
	public function index(): Response
	{
		return $this->render('base.html.twig', [
		]);
	}

	#[Route('/category/{id}', name: 'app_catalog_category')]
	public function category(int $id): Response {
		return new JsonResponse([ ],Response::HTTP_OK);
	}

	#[Route('/new', name: 'app_catalog_new')]
	public function newCatalog(CategoryRepository $categoryRepository): void {
	}

	#[Route('/list', name: 'app_catalog_list', methods: ['GET'])]
	public function catalogList(CategoryRepository $categoryRepository): JsonResponse {
		return new JsonResponse([
			'list'=> $this->categoryRepository->findAllArray()], Response::HTTP_OK);
	}

}
