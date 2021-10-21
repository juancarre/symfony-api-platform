<?php


namespace App\Repository;


use App\Entity\User;
use App\Exception\User\UserNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class UserRepository extends BaseRepository
{

    protected static function entityClass(): string
    {
        return User::class;
    }

    /**
     * @param string $email
     * @return User
     */
    public function findOneByEmailOrFail(string $email): User
    {
        if (null === $user = $this->objectRepository->findOneBy(['email' => $email])){
            throw UserNotFoundException::fromEmail($email);
        }

        return $user;
    }

    /**
     * @param string $id
     * @param string $token
     * @return User
     */
    public function findOneInactiveByIdAndTokenOrFail(string $id, string $token): User
    {
        if (null === $user = $this->objectRepository->findOneBy(['id' => $id, 'token' => $token, 'active' => false])) {
            throw UserNotFoundException::fromUserIdAndToken($id, $token);
        }

        return $user;
    }

    /**
     * @param User $user
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(User $user): void
    {
        $this->saveEntity($user);
    }

    /**
     * @param User $user
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(User $user): void
    {
        $this->removeEntity($user);
    }
}