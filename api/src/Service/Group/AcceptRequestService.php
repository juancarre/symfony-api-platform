<?php


namespace App\Service\Group;


use App\Entity\GroupRequest;
use App\Repository\GroupRepository;
use App\Repository\GroupRequestRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class AcceptRequestService
{
    /**
     * @var GroupRequestRepository
     */
    private GroupRequestRepository $groupRequestRepository;
    /**
     * @var GroupRepository
     */
    private GroupRepository $groupRepository;
    /**
     * @var UserRepository
     */
    private UserRepository $userRepository;

    /**
     * AcceptRequestService constructor.
     */
    public function __construct(GroupRequestRepository $groupRequestRepository, GroupRepository $groupRepository, UserRepository $userRepository)
    {
        $this->groupRequestRepository = $groupRequestRepository;
        $this->groupRepository = $groupRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @throws \Throwable
     */
    public function accept(string $groupId, string $userId, string $token): void
    {
        $groupRequest = $this->groupRequestRepository->findOnePendingByGroupIdUserIdAndTokenOrFail($groupId, $userId, $token);
        $groupRequest->setStatus(GroupRequest::ACCEPTED);
        $groupRequest->setAcceptedAt(new \DateTime());

        $user = $this->userRepository->findOneByIdOrFail($userId);
        $group = $this->groupRepository->findOneByIdOrFail($groupId);
        $group->addUser($user);
        $user->addGroup($group);

        $this->groupRequestRepository->getEntityManager()->transactional(
            function (EntityManagerInterface $em) use ($groupRequest, $group) {
                $em->persist($groupRequest);
                $em->persist($group);
            }
        );
    }
}