<?php
/**
 * User: smerteliko
 * Date: 23.05.2024
 * Time: 19:11.
 */

declare(strict_types=1);

namespace App\Service\File;

use App\Entity\Files;
use App\Repository\FilesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ImageFileUploader implements FileServiceInterface
{
    private EntityManagerInterface $em;
    private FilesRepository $filesRepository;
    private LoggerInterface $logger;
    private string $publicUploadsDir;
    private ValidatorInterface $validator;

    public function __construct($publicUploadsDir,
        FilesRepository $filesRepository,
        ValidatorInterface $validator,
        LoggerInterface $logger
    ) {
        $this->publicUploadsDir = $publicUploadsDir;
        $this->filesRepository = $filesRepository;
        $this->validator = $validator;
        $this->logger = $logger;
    }

    public function upload(UploadedFile $file, bool $toDB = false): array
    {
        $fileName = $this->getFileName($file);
        $lastFile = null;
        if ($toDB) {
            $lastFile = $this->uploadFileToDB($file, $fileName);
        }

        $file->move($this->getTargetDirectory(), $fileName);

        return [$fileName, $lastFile];
    }

    public function delete(array $file = [], bool $fromDB = false): void
    {
        $fileEnt = $this->filesRepository->find((int) $file['id']);
        if ($fromDB && $fileEnt) {
            $this->deleteFromDB($fileEnt);
        }

        $fileSystem = new Filesystem();
        $fileSystem->remove($this->getTargetDirectory().'/'.$file['FileName']);
    }

    public function deleteFromDB(Files $file): void
    {
        try {
            $this->filesRepository->remove($file);
        } catch (ORMException $e) {
            $this->logger->error($e->getMessage());
        }
    }

    public function getTargetDirectory(): string
    {
        return $this->publicUploadsDir;
    }

    public function uploadFileToDB(UploadedFile $file, string $fileName): Files|ORMException
    {
        try {
            return $this->filesRepository->saveNewFile($file, $fileName);
        } catch (ORMException $e) {
            $this->logger->error($e->getMessage());

            return $e;
        }
    }

    /**
     * Transliterate the filename for upload.
     *
     * @param string $filename filename to transliterate in latin
     */
    public function transliterate(string $filename): string
    {
        return transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $filename);
    }

    public function parseFilesize(string $size): int
    {
        if ('' === $size) {
            return 0;
        }

        $size = strtolower($size);

        $max = ltrim($size, '+');
        if (str_starts_with($max, '0x')) {
            $max = \intval($max, 16);
        } elseif (str_starts_with($max, '0')) {
            $max = \intval($max, 8);
        } else {
            $max = (int) $max;
        }

        switch (substr($size, -1)) {
            case 't': $max *= 1024;
                // no break
            case 'g': $max *= 1024;
                // no break
            case 'm': $max *= 1024;
                // no break
            case 'k': $max *= 1024;
        }

        return $max;
    }

    public function getFileName(UploadedFile $file): string
    {
        $originalFilename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFilename = $this->transliterate($originalFilename);

        return $safeFilename.'-'.uniqid('', true).'.'.$file->guessExtension();
    }

    public function validateImage(UploadedFile $file): array|ConstraintViolation
    {
        $violations = $this->validator->validate(
            $file,
            new File([
                'maxSize' => '5M',
                'extensions' => [
                    'png',
                    'jpg',
                    'jpeg',
                    'tiff',
                    'webp',
                ],
            ])
        );
        $violation = [];
        if ($violations->count() > 0) {
            /** @var ConstraintViolation $violation */
            $violation = $violations[0];
        }

        return $violation;
    }
}
