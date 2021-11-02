<?php


namespace App\Api\Action\User;


use App\Entity\User;
use App\Service\User\UploadAvatarService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class UploadAvatar
{
    /**
     * @var UploadAvatarService
     */
    private UploadAvatarService $uploadAvatarService;

    /**
     * UploadAvatar constructor.
     * @param UploadAvatarService $uploadAvatarService
     */
    public function __construct(UploadAvatarService $uploadAvatarService)
    {
        $this->uploadAvatarService = $uploadAvatarService;
    }

    /**
     * @param Request $request
     * @param User $user
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(Request $request, User $user): User
    {
        return $this->uploadAvatarService->uploadAvatar($request, $user);
    }
}