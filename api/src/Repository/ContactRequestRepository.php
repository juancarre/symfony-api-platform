<?php

namespace App\Repository;

use App\Entity\ContactRequest;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class ContactRequestRepository extends BaseRepository
{
    protected static function entityClass(): string
    {
        return ContactRequest::class;
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(ContactRequest $contactRequest): void
    {
        $this->saveEntity($contactRequest);
    }
}