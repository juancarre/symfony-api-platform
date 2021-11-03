<?php


namespace App\Tests\Unit\File;


use App\Service\File\FileService;
use League\Flysystem\FilesystemException;
use League\Flysystem\FilesystemOperator;
use League\Flysystem\UnableToDeleteFile;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Filesystem\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class FileServiceTest extends TestCase
{
    /** @var FilesystemOperator|MockObject */
    private $storage;

    /** @var LoggerInterface */
    private $logger;

    private string $mediaPath;

    private FileService $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->storage = $this->getMockBuilder(FilesystemOperator::class)->disableOriginalConstructor()->getMock();
        $this->logger = $this->getMockBuilder(LoggerInterface::class)->disableOriginalConstructor()->getMock();
        $this->mediaPath = 'https://storage.com';
        $this->service = new FileService($this->storage, $this->logger, $this->mediaPath);
    }

    public function testUploadFile(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $uploadedFile->method('getPathname')->willReturn('/tmp');
        $uploadedFile->method('guessExtension')->willReturn('png');
        $prefix = 'avatar';

        $response = $this->service->uploadFile($uploadedFile, $prefix);

        $this->assertIsString($response);
    }

    public function testValidateFile(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $request = new Request([], [], [], [], ['avatar' => $uploadedFile]);

        $response = $this->service->validateFile($request, FileService::AVATAR_INPUT_NAME);

        $this->assertInstanceOf(UploadedFile::class, $response);
    }

    public function testValidateInvalidFile(): void
    {
        $uploadedFile = $this->getMockBuilder(UploadedFile::class)->disableOriginalConstructor()->getMock();
        $request = new Request([], [], [], [], ['file' => $uploadedFile]);

        $this->expectException(BadRequestHttpException::class);

        $this->service->validateFile($request, FileService::AVATAR_INPUT_NAME);
    }

    public function testDeleteFile(): void
    {
        $path = sprintf('%s%s', $this->mediaPath, 'avatar/123.png');

        $this->storage
            ->expects($this->exactly(1))
            ->method('delete')
            ->with(explode($this->mediaPath, $path)[1]);

        $this->service->deleteFile($path);
    }

    public function testDeleteNonExistingFile(): void
    {
        $path = sprintf('%s%s', $this->mediaPath, 'avatar/123.png');

        $this->storage
            ->expects($this->exactly(1))
            ->method('delete')
            ->with(explode($this->mediaPath, $path)[1])
            ->willThrowException(new FileNotFoundException($path));

        $this->logger
            ->expects($this->exactly(1))
            ->method('warning')
            ->with($this->isType('string'));

        $this->service->deleteFile($path);

    }
}