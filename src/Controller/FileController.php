<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\UserImagesRepository;
use App\Service\File\ImageFileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

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
	 * @throws \JsonException
	 */
	#[Route('/new_user_avatar', name: '_new_avatar', methods: [ 'POST'])]
    public function newUserAvatar(Request $request,
        ImageFileUploader $fileUploader,
        UserImagesRepository $userImagesRepository,
        string $publicUploadsPath): JsonResponse
    {
        $file = $request->files->get('file');
        $violation = $fileUploader->validateImage($file);
        if ($violation) {
            return new JsonResponse(['errors' => $violation->getMessage()], Response::HTTP_BAD_REQUEST);
        }

        $userEntity = json_decode($request->get('entity'),
                                  TRUE,
                                  512,
                                  JSON_THROW_ON_ERROR);

        $oldFile = $userEntity['Images']['file'] ?? [];

        $filename = null;
        $lastFile = null;
        $fileSize = '';
        if ($file) {
            [$filename, $lastFile] = $fileUploader->upload($file, true);
        }

        $userImagesRepository->updateOrSetNewAvatar([
            'UserEntity' => $userEntity,
            'FileID' => $lastFile->getId(),
        ]);

        if ($oldFile) {
            $fileUploader->delete($userEntity['Images']['file'], true);
        }

        return new JsonResponse([
            'fileName' => $filename,
            'fileSize' => $fileSize,
        ]);
    }
}
