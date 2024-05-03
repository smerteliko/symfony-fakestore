<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;

#[Route('/catalog')]
class CatalogController extends AbstractController
{
	private CategoryRepository $categoryRepository;
	public function __construct(CategoryRepository $categoryRepository, ){
		$this->categoryRepository = $categoryRepository;
	}
	#[Route('/', name: 'app_catalog')]
	public function index(): Response {
		return $this->render('base.html.twig', []);
	}

	#[Route('/category/{catID}', name: 'app_catalog_category')]
	public function category(int $catID): Response {
		return $this->render('base.html.twig',[

		]);
	}

	#[Route('/category/{catID}/subcategory/{subID}', name: 'app_catalog_subcat_by_category')]
	public function subCatBuCategory(int $catID, int $subID): Response {
		return $this->render('base.html.twig',[

		]);
	}

	#[Route('/new', name: 'app_catalog_new')]
	public function newCatalog(CategoryRepository $categoryRepository): void {
	}

	/**
	 * @throws InvalidArgumentException
	 */
	#[Route('/ajax/list', name: 'app_catalog_list', methods: [ 'GET'])]
	public function catalogList(CacheInterface $cache): JsonResponse {
		return new JsonResponse(
			[
				'list'=>$this->categoryRepository->getAllCategoriesCached()
			],
			Response::HTTP_OK);
	}

	/**
	 */
	#[Route('/ajax/category/{id}', name: 'app_catalog_category_ajax', methods: [ 'GET'])]
	public function ajaxCategory(int $id): JsonResponse {
		$category = $this->categoryRepository->findCategoriesBy(['id'=> $id, 'withSubs'=>true])?:[];
		return new JsonResponse(
			[
				"list"=>$category[0]
			],
			Response::HTTP_OK);
	}

}
