<?php


namespace App\Service\File;

use App\Exception\File\FileNotFounException;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileService
{
    public const AVATAR_INPUT_NAME = 'avatar';
    public const MOVEMENT_INPUT_NAME = 'file';

    private FilesystemOperator $defaultStorage;
    private LoggerInterface $logger;
    private string $mediaPath;

    /**
     * FileService constructor.
     * @param FilesystemOperator $defaultStorage
     * @param LoggerInterface $logger
     * @param string $mediaPath
     */
    public function __construct(FilesystemOperator $defaultStorage, LoggerInterface $logger, string $mediaPath)
    {
        $this->defaultStorage = $defaultStorage;
        $this->logger = $logger;
        $this->mediaPath = $mediaPath;
    }

    /**
     * @throws FilesystemException
     */
    public function uploadFile(UploadedFile $file, string $prefix, string $visibility): string
    {
        $filename = sprintf('%s/%s.%s', $prefix, sha1(uniqid()), $file->guessExtension());

        $this->defaultStorage->writeStream(
            $filename,
            fopen($file->getPathname(), 'r'),
            ['visibility' => $visibility]
        );

        return $filename;
    }

    public function downloadFile(string $path): ?string
    {
        try {
            return $this->defaultStorage->read($path);
        } catch (FileNotFoundException $e) {
            throw new FileNotFounException();
        }
    }

    public function validateFile(Request $request, string $inputName): UploadedFile
    {
        if (null === $file = $request->files->get($inputName)) {
            throw new BadRequestHttpException(sprintf('Can not get file with input name: %s', $inputName));
        }

        return $file;
    }

    public function deleteFile(?string $path): void
    {
        try {
            if (null !== $path) {
                $this->defaultStorage->delete($path);
            }
        } catch (\Exception $e) {
            $this->logger->warning(sprintf('File %s not found in the storage', $path));
        }
    }
}