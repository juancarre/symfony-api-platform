<?php


namespace App\Service\Group;


use App\Entity\User;
use App\Exception\Group\OwnerCannotBeDeletedException;
use App\Exception\Group\UserNotMemberOfGroupException;
use App\Repository\GroupRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Throwable;

class RemoveUserService
{
    /**
     * @var GroupRepository
     */
    private GroupRepository $groupRepository;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * RemoveUserService constructor.
     */
    public function __construct(GroupRepository $groupRepository, UserRepository $userRepository)
    {
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws Throwable
     */
    public function remove(string $groupId, string $userId, User $requester): void
    {
        $group = $this->groupRepository->findOneByIdOrFail($groupId);
        $user = $this->userRepository->findOneByIdOrFail($userId);

        if ($user->equals($requester)) {
            throw new OwnerCannotBeDeletedException();
        }

        if (!$user->isMemberOfGroup($group)) {
            throw new UserNotMemberOfGroupException();
        }

        $this->groupRepository->getEntityManager()->transactional(
            function (EntityManagerInterface $em) use ($group, $user) {
                $group->removeUsers($user);
                $user->removeGroup($group);

                $em->persist($group);
            }
        );
    }
}