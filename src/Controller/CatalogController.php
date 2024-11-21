<?php

declare(strict_types=1);

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

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    #[Route('/api/category/{id}', name: 'app_catalog_category_ajax', methods: ['GET'])]
    public function ajaxCategory(string $id): JsonResponse
    {
        $category = $this->categoryRepository->findCategoriesBy(['id' => $id, 'withSubs' => true]) ?: [];

        return new JsonResponse(
            [
                'list' => $category[0],
            ],
            Response::HTTP_OK);
    }
}
