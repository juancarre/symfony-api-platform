<?php


namespace App\Service\Movement;


use App\Entity\Movement;
use App\Entity\User;
use App\Exception\Movement\MovementDoesNotBelongToGroupException;
use App\Exception\Movement\MovementDoesNotBelongToUserException;
use App\Repository\MovementRepository;
use App\Service\File\FileService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use League\Flysystem\FilesystemException;
use Symfony\Component\HttpFoundation\Request;

class UploadFileService
{
    /**
     * @var FileService
     */
    private FileService $fileService;
    /**
     * @var MovementRepository
     */
    private MovementRepository $movementRepository;

    /**
     * UploadFileService constructor.
     */
    public function __construct(FileService $fileService, MovementRepository $movementRepository)
    {
        $this->fileService = $fileService;
        $this->movementRepository = $movementRepository;
    }

    /**
     * @throws FilesystemException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function uploadFile(Request $request, User $user, string $id): Movement
    {
        $movement = $this->movementRepository->findOneByIdOrFail($id);

        if (null !== $group = $movement->getGroup()) {
            if (!$user->isMemberOfGroup($group)) {
                throw new MovementDoesNotBelongToGroupException();
            }
        }

        if (!$movement->isOwnedBy($user)) {
            throw new MovementDoesNotBelongToUserException();
        }

        $file = $this->fileService->validateFile($request, FileService::MOVEMENT_INPUT_NAME);

        $this->fileService->deleteFile($movement->getFilePath());

        $fileName = $this->fileService->uploadFile(
            $file,
            FileService::MOVEMENT_INPUT_NAME,
            'private'
        );

        $movement->setFilePath($fileName);

        $this->movementRepository->save($movement);

        return $movement;
    }
}