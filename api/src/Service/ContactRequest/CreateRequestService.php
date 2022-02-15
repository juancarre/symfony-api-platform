<?php


namespace App\Service\ContactRequest;


use App\Entity\ContactRequest;
use App\Entity\User;
use App\Repository\ContactRequestRepository;
use App\Repository\UserRepository;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\Request;

class CreateRequestService
{
    private ContactRequestRepository $contactRequestRepository;
    private UserRepository $userRepository;

    /**
     * CreateRequestService constructor.
     * @param ContactRequestRepository $contactRequestRepository
     */
    public function __construct(
        ContactRequestRepository $contactRequestRepository,
        UserRepository $userRepository
    )
    {
        $this->contactRequestRepository = $contactRequestRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @return ContactRequest
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createContactRequest(Request $request): ContactRequest
    {
        $owner = RequestService::getField($request, 'owner');
        $email = RequestService::getField($request, 'email');
        $contactReason = RequestService::getField($request, 'reason', false);
        $message = RequestService::getField($request, 'message', false)
            ? RequestService::getField($request, 'message')
            : null;
        $requieredSkills = RequestService::getField($request, 'requieredSkills', false)
            ? RequestService::getField($request, 'requieredSkills')
            : '';
        $joinMyTeam = RequestService::getField($request, 'joinMyTeam', false)
            ? RequestService::getField($request, 'joinMyTeam')
            : false;
        $orderProject = RequestService::getField($request, 'orderProject', false)
            ? RequestService::getField($request, 'orderProject')
            : false;
        $meetingDate = RequestService::getField($request, 'date', false)
            ? new \DateTime(RequestService::getField($request, 'date'))
            : null;

        $user = $this->userRepository->findOneByIdOrFail(str_ireplace('api/v1/users/', '', $owner));
        $contactRequest = new ContactRequest($user, $email);

        $contactRequest->setContactReason($contactReason);
        $contactRequest->setMessage($message);
        $contactRequest->setRequieredSkills($requieredSkills);
        $contactRequest->setJoinMyTeam($joinMyTeam);
        $contactRequest->setOrderProject($orderProject);
        $contactRequest->setMeetingDate($meetingDate);


        $this->contactRequestRepository->save($contactRequest);

        return $contactRequest;
    }
}