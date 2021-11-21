<?php


namespace App\Repository;


use App\Entity\Movement;
use App\Exception\Movement\MovementNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class MovementRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return Movement::class;
    }

    public function findOneByIdOrFail(string $id): Movement
    {
        /** @var Movement|null $movement */
        if (null === $movement = $this->objectRepository->find($id)) {
            throw MovementNotFoundException::fromId($id);
        }

        return $movement;
    }

    public function findOneByFilePAthOrFail(string $filePath): Movement
    {
        /** @var Movement $movement */
        if (null === $movement = $this->objectRepository->findOneBy(['filePath' => $filePath])) {
            throw MovementNotFoundException::fromFilePath($filePath);
        }

        return $movement;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Movement $movement): void
    {
        $this->saveEntity($movement);
    }
}