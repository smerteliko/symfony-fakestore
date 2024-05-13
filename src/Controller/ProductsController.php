<?php

namespace App\Controller;

use App\Repository\ProductImagesRepository;
use App\Repository\ProductRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products', name: 'app_products')]
class ProductsController extends AbstractController
{
	private ProductImagesRepository $productImagesRepository;
	private ProductRepository       $productRepository;
	public function __construct(
		ProductRepository $productRepository,
		ProductImagesRepository $productImagesRepository
	) {
		$this->productRepository = $productRepository;
		$this->productImagesRepository = $productImagesRepository;
	}

    #[Route('/', name: 'app_products')]
    public function index(): Response {
	    return $this->render('base.html.twig', []);
    }

	#[Route('/{id}', name: 'app_product')]
	public function product(): Response {
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

	/**
	 * @throws InvalidArgumentException
	 */
	#[Route('/ajax/{id}', name: 'app_product_data', methods: [ 'GET'])]
	public function ProductData(int $id): Response {
		return new JsonResponse(['productData'=>$this->productRepository->findCachedProductDataBy(['id'=>$id])[0]]);
	}

	/**
	 * @throws InvalidArgumentException
	 */
	#[Route('/ajax/{id}/images/', name: 'app_product_images', methods: [ 'GET'])]
	public function ProductImages(int $id): Response {
		return new JsonResponse(['productImages'=>
			                         $this->productImagesRepository->findCachedProductImagesBy(['prodId'=>$id])]);
	}
}
