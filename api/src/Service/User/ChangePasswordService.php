<?php


namespace App\Service\User;


use App\Entity\User;
use App\Exception\Password\PasswordException;
use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use App\Service\Request\RequestService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class ChangePasswordService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;
    /**
     * @var EncoderService
     */
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
     * @param Request $request
     * @param User $user
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function changePassword(Request $request, User $user): User
    {
        $oldPassword = RequestService::getField($request, 'oldPassword');
        $newPassword = RequestService::getField($request, 'newPassword');

        if (!$this->encoderService->isValidPassword($user, $oldPassword)) {
            throw PasswordException::oldPasswordDoesNotMatch();
        }

        $user->setPassword($this->encoderService->generateEncodedPassword($user, $newPassword));

        $this->userRepository->save($user);

        return $user;
    }
}