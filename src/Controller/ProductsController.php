<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProductImagesRepository;
use App\Repository\ProductRepository;
use App\Service\Currency\CurrencyOperations;
use App\Service\Product\ProductPriceService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products', name: 'app_products')]
class ProductsController extends AbstractController
{
	private CurrencyOperations      $currencyOperations;
	private ProductImagesRepository $productImagesRepository;
	private ProductPriceService     $productPriceService;
	private ProductRepository       $productRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductImagesRepository $productImagesRepository,
        ProductPriceService  $productPriceService)
    {
        $this->productRepository = $productRepository;
        $this->productImagesRepository = $productImagesRepository;
		$this->productPriceService = $productPriceService;
    }

    #[Route('/', name: '_list')]
    public function index(): Response
    {
        return $this->render('base.html.twig', []);
    }

    #[Route('/{id}', name: '_item')]
    public function product(): Response
    {
        return $this->render('base.html.twig', []);
    }

    #[Route('/ajax/category/{id}', name: '_list_category', methods: ['GET'])]
    public function listByCategory(string $id): Response
    {
	    $list =    $this->productRepository->findProductBy([
		                                                       'catID' => $id,
		                                                       'withImages' => true,
		                                                       'withDescriptions' => true,
		                                                       'withAdditionalFields' => true,
	                                                       ]);

			$products = $this->productPriceService->getProductListPricesInAllCurr($list);


        return new JsonResponse(
	        $products
        );
    }

    #[Route('/ajax/subcategory/{id}', name: '_list_subcategory', methods: ['GET'])]
    public function listBySubcategory(string $id): Response
    {
	    $list =   $this->productRepository->findProductBy([
		                                                      'subID' => $id,
		                                                      'withImages' => true,
		                                                      'withDescriptions' => true,
		                                                      'withAdditionalFields' => true,
	                                                      ]);
	    $products = $this->productPriceService->getProductListPricesInAllCurr($list);
        return new JsonResponse(
	        $products
        );
    }

    #[Route('/ajax/list', name: '_list_ajax', methods: ['GET'])]
    public function listProducts(): Response
    {
		$list =  $this->productRepository->findProductBy([
			                                                 'withImages' => true,
			                                                 'withDescriptions' => true,
			                                                 'withAdditionalFields' => true,
		                                                 ]);
	    $products = $this->productPriceService->getProductListPricesInAllCurr($list);
        return new JsonResponse(
	        $products

        );
    }

    #[Route('/ajax/{id}', name: '_item_ajax', methods: ['GET'])]
    public function ProductData(string $id): Response
    {
		$product = $this->productRepository->find($id)?->toArray();
	    $product['productPrice'] = $this->productPriceService->getProductPriceInAllCurr($product['productPrice']);
        return new JsonResponse([
            'productData' => $product
        ]);
    }

    #[Route('/ajax/{id}/images/', name: '_images', methods: ['GET'])]
    public function ProductImages(string $id): Response
    {
        return new JsonResponse([
            'productImages' => $this->productImagesRepository->findProductImagesBy(
                ['prodId' => $id]
            ),
        ]);
    }
}
