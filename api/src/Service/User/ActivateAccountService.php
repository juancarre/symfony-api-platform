<?php


namespace App\Service\User;


use App\Entity\User;
use App\Repository\UserRepository;
use App\Service\Request\RequestService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class ActivateAccountService
{
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * ActivateAccountService constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param string $id
     * @param string $token
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function activate(string $id, string $token): User
    {
        $user = $this->userRepository->findOneInactiveByIdAndTokenOrFail($id, $token);

        $user->setActive(true);
        $user->setToken(null);

        $this->userRepository->save($user);

        return $user;
    }

}