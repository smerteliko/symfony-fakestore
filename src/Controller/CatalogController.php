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

    #[Route('/', name: 'app_catalog')]
    public function index(): Response
    {
        return $this->render('base.html.twig', []);
    }

    #[Route('/category/{catID}', name: 'app_catalog_category')]
    public function category(string $catID): Response
    {
        return $this->render('base.html.twig', []);
    }

    #[Route('/category/{catID}/subcategory/{subID}', name: 'app_catalog_subcat_by_category')]
    public function subCatBuCategory(string $catID, string $subID): Response
    {
        return $this->render('base.html.twig', [
        ]);
    }

    #[Route('/new', name: 'app_catalog_new')]
    public function newCatalog(CategoryRepository $categoryRepository): void
    {
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
