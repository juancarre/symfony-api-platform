<?php

namespace App\Service\User;

use App\Entity\User;
use App\Exception\User\UserAlreadyExistException;
use App\Messenger\Message\UserRegisteredMessage;
use App\Messenger\RoutingKey;
use App\Repository\UserRepository;
use App\Service\Password\EncoderService;
use App\Service\Request\RequestService;
use Doctrine\ORM\Exception\ORMException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\MessageBusInterface;

class UserRegisterService
{
    private UserRepository $userRepository;
    private EncoderService $encoderService;
    private MessageBusInterface $messageBus;

    /**
     * UserRegisterService constructor.
     * @param UserRepository $userRepository
     * @param EncoderService $encoderService
     * @param MessageBusInterface $messageBus
     */
    public function __construct(
        UserRepository $userRepository,
        EncoderService $encoderService,
        MessageBusInterface $messageBus
    )
    {
        $this->userRepository = $userRepository;
        $this->encoderService = $encoderService;
        $this->messageBus = $messageBus;
    }

    /**
     * @param Request $request
     * @return User
     * @throws \Doctrine\ORM\ORMException
     */
    public function create(Request $request): User
    {
        $name = RequestService::getField($request, 'name');
        $email = RequestService::getField($request, 'email');
        $password = RequestService::getField($request, 'password');
        $companyName = RequestService::getField($request, 'companyName', false)
            ? RequestService::getField($request, 'companyName')
            : null;
        $companyWeb = RequestService::getField($request, 'companyWeb', false)
            ? RequestService::getField($request, 'companyWeb')
            : null;
        $phoneNumber = RequestService::getField($request, 'phoneNumber', false)
            ? RequestService::getField($request, 'phoneNumber')
            : null;
        $userType = RequestService::getField($request, 'userType', false)
            ? RequestService::getField($request, 'userType')
            : null;

        $user = new User($name, $email);
        $user->setPassword($this->encoderService->generateEncodedPassword($user, $password));
        $user->setCompanyName($companyName);
        $user->setCompanyWeb($companyWeb);
        $user->setPhoneNumber($phoneNumber);
        $user->setUserType($userType);

        try {
            $this->userRepository->save($user);
        } catch (ORMException $e) {
            throw UserAlreadyExistException::fromEmail($email);
        }

        $this->messageBus->dispatch(
            new UserRegisteredMessage($user->getId(), $user->getName(), $user->getEmail(), $user->getToken()),
            [new AmqpStamp(RoutingKey::USER_QUEUE)]
        );

        return $user;
    }
}
