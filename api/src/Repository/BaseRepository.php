<?php

declare(strict_types=1);

namespace App\Repository;


use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\Mapping\MappingException;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Persistence\ObjectRepository;

abstract class BaseRepository
{
    /**
     * @var ManagerRegistry
     */
    private ManagerRegistry $managerRegistry;
    /**
     * @var Connection
     */
    protected Connection $connection;
    /**
     * @var ObjectRepository
     */
    protected ObjectRepository $objectRepository;

    /**
     * BaseRepository constructor.
     * @param ManagerRegistry $managerRegistry
     * @param Connection $connection
     */
    public function __construct(ManagerRegistry $managerRegistry, Connection $connection)
    {
        $this->managerRegistry = $managerRegistry;
        $this->connection = $connection;
        $this->objectRepository = $this->getEntityManager()->getRepository($this->entityClass());
    }

    abstract protected static function entityClass(): string;

    /**
     * @param Object $entity
     * @throws ORMException
     */
    public function persistEntity(Object $entity): void
    {
        $this->getEntityManager()->persist($entity);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws MappingException
     */
    public function flushData(): void
    {
        $this->getEntityManager()->flush();
        $this->getEntityManager()->clear();
    }

    /**
     * @param Object $entity
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function saveEntity(Object $entity)
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param Object $entity
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeEntity(Object $entity)
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }

    /**
     * @param string $query
     * @param array $params
     * @return array
     * @throws Exception
     */
    protected function executeFetchQuery(string $query, $params = []): array
    {
        return $this->connection->executeQuery($query, $params)->fetchAll();
    }

    /**
     * @param string $query
     * @param array $params
     * @throws Exception
     */
    protected function executeQuery(string $query, $params = []): void
    {
        $this->connection->executeQuery($query, $params);
    }

    /**
     * @return ObjectManager|EntityManager
     */
    private function getEntityManager(){
        $entityManager = $this->managerRegistry->getManager();

        if ($entityManager->isOpen()){
            return $entityManager;
        }

        return $this->managerRegistry->resetManager();
    }
}