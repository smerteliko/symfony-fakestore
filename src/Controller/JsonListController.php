<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\CurRatesRepository;
use App\Repository\CurrencyRepository;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/json', name: 'app_json_')]
class JsonListController extends AbstractController
{

    /**
     * @throws InvalidArgumentException
     */
    #[Route('/catalogs', name: 'catalog', methods: ['GET'])]
    public function catalogList(CategoryRepository $categoryRepository): JsonResponse
    {
        return new JsonResponse([
            'categories' => $categoryRepository->getAllCategoriesCached(),
        ],
            Response::HTTP_OK);
    }

	/**
	 * @throws InvalidArgumentException
	 */
	#[Route('/currency', name: 'currency', methods: [ 'GET'])]
	public function rates(CurRatesRepository $ratesRepository,CurrencyRepository $currencyRepository): JsonResponse {

		return new JsonResponse([
			'currencies' => $currencyRepository->getCurrencyListCached(),
		], Response::HTTP_OK);
	}
}
