<?php
/**
 * User: smerteliko
 * Date: 26.05.2024
 * Time: 21:23.
 */
declare(strict_types=1);

namespace App\Service\File;

use App\Entity\Files;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileServiceInterface
{
    public function getTargetDirectory();

    public function upload(UploadedFile $file);

    public function uploadFileToDB(UploadedFile $file, string $fileName);

    public function delete(Files $file);

    public function deleteFromDB(Files $file);

    public function getFileName(UploadedFile $file);

    public function parseFilesize(string $size);

    public function transliterate(string $filename);
}
