<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ProductDescriptionRepository;
use App\Repository\ProductImagesRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/products', name: 'app_products')]
class ProductsController extends AbstractController
{
    private ProductImagesRepository $productImagesRepository;
    private ProductRepository $productRepository;

    public function __construct(
        ProductRepository $productRepository,
        ProductImagesRepository $productImagesRepository,
        ProductDescriptionRepository $productDescriptionRepository)
    {
        $this->productRepository = $productRepository;
        $this->productImagesRepository = $productImagesRepository;
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
    public function listByCategory(int $id): Response
    {
        return new JsonResponse(
            $this->productRepository->findProductBy([
                'catID' => $id,
                'withImages' => true,
                'withDescriptions' => true,
                'withAdditionalFields' => true,
            ])
        );
    }

    #[Route('/ajax/subcategory/{id}', name: '_list_subcategory', methods: ['GET'])]
    public function listBySubcategory(int $id): Response
    {
        return new JsonResponse(
            $this->productRepository->findProductBy([
                'subID' => $id,
                'withImages' => true,
                'withDescriptions' => true,
                'withAdditionalFields' => true,
            ])
        );
    }

    #[Route('/ajax/list', name: '_list_ajax', methods: ['GET'])]
    public function listProducts(): Response
    {
        return new JsonResponse(
            $this->productRepository->findProductBy([
                'withImages' => true,
                'withDescriptions' => true,
                'withAdditionalFields' => true,
            ])
        );
    }

    #[Route('/ajax/{id}', name: '_item_ajax', methods: ['GET'])]
    public function ProductData(int $id): Response
    {
        return new JsonResponse([
            'productData' => $this->productRepository->find($id)->toArray(),
        ]);
    }

    #[Route('/ajax/{id}/images/', name: '_images', methods: ['GET'])]
    public function ProductImages(int $id): Response
    {
        return new JsonResponse([
            'productImages' => $this->productImagesRepository->findProductImagesBy(
                ['prodId' => $id]
            ),
        ]);
    }
}
