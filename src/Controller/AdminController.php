<?php

namespace App\Controller;

use App\Service\Admin\Entities;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin', name: 'app_admin')]
class AdminController extends AbstractController
{
	public function __construct(
	)
	{
	}

    #[Route('/{vue}', name: '_vue_main', requirements: ['vue' => '^(?!.*api|_wdt|_profiler|ajax).+'], methods: ['GET'])]
    public function index(Request $request): Response
    {

        return $this->render('admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

	#[Route('/api/entities', name: '_entity_list', methods: ['GET'])]
	public function entityList(Entities $entities): JsonResponse
	{

		return new JsonResponse([
			'mappingErrors' => $entities->getMappingErrors()?:[],
			'entities' => $entities->getEntities()?:[],
		],Response::HTTP_OK);
	}

	#[Route('/api/ping', name: '_ping', methods: ['GET'])]
	public function ping(): JsonResponse
	{
		return new JsonResponse(['timestamp' => time()],200);
	}

	#[Route('/api/phpinfo', name: '_phpinfo', methods: ['GET'])]
	public function phpinfoAction(): JsonResponse
	{

		ob_start();
		phpinfo();
		$phpinfo = ob_get_clean();

		return new JsonResponse([$phpinfo], 200);
	}
}