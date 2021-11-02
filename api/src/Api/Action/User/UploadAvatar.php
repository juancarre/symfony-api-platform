<?php


namespace App\Api\Action\User;


use App\Entity\User;
use App\Service\User\UploadAvatarService;
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

    public function __invoke(Request $request, User $user): User
    {
        return $this->uploadAvatarService->uploadAvatar($request, $user);
    }
}