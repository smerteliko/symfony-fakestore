<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserImagesRepository;
use App\Service\File\ImageFileUploader;
use JsonException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/file', name: 'app_file')]
class FileController extends AbstractController
{
    public function __construct(
        private readonly ImageFileUploader $fileUploader)
    {
    }

    #[Route('/new', name: '_new', methods: ['POST'])]
    public function newFile(
        Request $request,
        string $publicUploadsPath): Response
    {
        $data = [];
        $file = $request->files->get('file');

        $filename = '';
        if ($file) {
            $filename = $this->fileUploader->upload($file, true);
        }

        return new JsonResponse([$filename]);
    }

	/**
	 * @throws JsonException
	 */
	#[Route('/user-avatar', name: '_user_avatar', methods: ['POST', 'PATCH'])]
    public function newUserAvatar(Request $request,
        ImageFileUploader $fileUploader,
        UserImagesRepository $userImagesRepository,
		#[CurrentUser] ?User $currentUser
	): JsonResponse
    {
		$fileUploader->setTargetDirectory('/user-avatar');
        $file = $request->files->get('user-avatar');
        $violation = $fileUploader->validateImage($file);
        if ($violation) {
            return new JsonResponse(['errors' => $violation->getMessage()], Response::HTTP_BAD_REQUEST);
        }


        $oldFile = $currentUser?->getUserImages()?->getImageFile();
        $lastFile = null;
        if ($file) {
            $lastFile = $fileUploader->upload($file);
        }

        $userImagesRepository->updateOrSetNewAvatar($currentUser,
            ['FileID' => $lastFile->getId()],
        );

        if ($oldFile) {
            $fileUploader->delete($oldFile);
        }
        return new JsonResponse([
            'fileName' => $lastFile->getFileName(),
        ]);
    }
}
