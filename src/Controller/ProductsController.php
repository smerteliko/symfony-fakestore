<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\SubCategory;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products', name: 'app_products')]
class ProductsController extends AbstractController
{
	private ProductRepository $productRepository;
	public function __construct(ProductRepository $productRepository) {
		$this->productRepository = $productRepository;
	}

    #[Route('/', name: 'app_products')]
    public function index(): Response {
	    return $this->render('base.html.twig', []);
    }

	#[Route('/ajax/category/{id}', name: 'app_products_list_category', methods: ['GET'])]
	 public function listByCategory(int $id): Response {
		return new JsonResponse($this->productRepository->findProductsBy(['catID'=>$id]));
	 }

	#[Route('/ajax/subcategory/{id}', name: 'app_products_list_subcategory', methods: ['GET'])]
	 public function listBySubcategory(int $id): Response {
		return new JsonResponse($this->productRepository->findProductsBy(['subID'=>$id]));
	 }

	#[Route('/ajax/list', name: 'app_products_list', methods: ['GET'])]
	public function listProducts(): Response {
		return new JsonResponse($this->productRepository->findProductsBy([]));
	}
}
