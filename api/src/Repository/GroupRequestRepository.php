<?php


namespace App\Repository;


use App\Entity\GroupRequest;
use App\Exception\GroupRequest\GroupRequestNotFoundException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

class GroupRequestRepository extends BaseRepository
{

    protected static function entityClass(): string
    {
        return GroupRequest::class;
    }

    public function findOnePendingByGroupIdUserIdAndTokenOrFail(
        string $groupId,
        string $userId,
        string $token
    ): GroupRequest {
        if (null === $groupRequest = $this->objectRepository->findOneBy(
                [
                    'group' => $groupId,
                    'user' => $userId,
                    'token' => $token,
                    'status' => GroupRequest::PENDING
                ]
            )) {
            throw GroupRequestNotFoundException::fromGroupIdUserIdAndToken($groupId, $userId, $token);
        }

        return $groupRequest;
    }

    /**
     * @param GroupRequest $groupRequest
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(GroupRequest $groupRequest): void
    {
        $this->saveEntity($groupRequest);
    }
}