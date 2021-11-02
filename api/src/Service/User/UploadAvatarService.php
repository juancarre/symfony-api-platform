<?php


namespace App\Service\User;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class UploadAvatarService
{

    /**
     * UploadAvatarService constructor.
     */
    public function __construct()
    {
    }

    public function uploadAvatar(Request $request, User $user): User
    {
        
    }
}