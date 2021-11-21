<?php


namespace App\Service\Movement;


use App\Entity\User;
use App\Exception\Movement\MovementDoesNotBelongToGroupException;
use App\Exception\Movement\MovementDoesNotBelongToUserException;
use App\Repository\MovementRepository;
use App\Service\File\FileService;

class DownloadFileService
{
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;
    /**
     * @var FileService
     */
    private FileService $fileService;

    /**
     * DownloadFileService constructor.
     */
    public function __construct(MovementRepository $movementRepository, FileService $fileService)
    {
        $this->movementRepository = $movementRepository;
        $this->fileService = $fileService;
    }

    public function downloadFile(User $user, string $filePath): ?string
    {
        $movement = $this->movementRepository->findOneByFilePAthOrFail($filePath);

        if (null !== $group = $movement->getGroup()) {
            if (!$user->isMemberOfGroup($group)) {
                throw new MovementDoesNotBelongToGroupException();
            }
        }

        if (!$movement->isOwnedBy($user)) {
            throw new MovementDoesNotBelongToUserException();
        }

        return $this->fileService->downloadFile($filePath);
    }
}