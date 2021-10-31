<?php

namespace App\Service\User;

use App\Entity\User;
use App\Exception\Password\PasswordException;
use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ChangePasswordService
{
    private UserRepository $userRepository;

    private EncoderService $encoderService;

    /**
     * ChangePasswordService constructor.
     * @param UserRepository $userRepository
     * @param EncoderService $encoderService
     */
    public function __construct(UserRepository $userRepository, EncoderService $encoderService)
    {
        $this->userRepository = $userRepository;
        $this->encoderService = $encoderService;
    }

    /**
     * @param string $userId
     * @param string $newPassword
     * @param string $oldPassword
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function changePassword(string $userId, string $newPassword, string $oldPassword): User
    {
        $user = $this->userRepository->findOneByIdOrFail($userId);

        if (!$this->encoderService->isValidPassword($user, $oldPassword)) {
            throw PasswordException::oldPasswordDoesNotMatch();
        }

        $user->setPassword($this->encoderService->generateEncodedPassword($user, $newPassword));

        $this->userRepository->save($user);

        return $user;
    }
}
