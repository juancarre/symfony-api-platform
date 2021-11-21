<?php


namespace App\Service\User;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\File\FileService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use League\Flysystem\FilesystemException;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Component\HttpFoundation\Request;

class UploadAvatarService
{
    private UserRepository $userRepository;
    private FileService $fileService;
    private string $mediaPath;

    /**
     * UploadAvatarService constructor.
     * @param UserRepository $userRepository
     * @param FileService $fileService
     * @param string $mediaPath
     */
    public function __construct(UserRepository $userRepository, FileService $fileService, string $mediaPath)
    {
        $this->userRepository = $userRepository;
        $this->fileService = $fileService;
        $this->mediaPath = $mediaPath;
    }

    /**
     * @param Request|MockObject $request
     * @param User $user
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws FilesystemException
     */
    public function uploadAvatar(Request $request, User $user): User
    {
        $file = $this->fileService->validateFile($request, FileService::AVATAR_INPUT_NAME);

        $this->fileService->deleteFile($user->getAvatar());

        $fileName = $this->fileService->uploadFile($file, FileService::AVATAR_INPUT_NAME, 'public');

        $user->setAvatar($fileName);

        $this->userRepository->save($user);

        return $user;
    }
}