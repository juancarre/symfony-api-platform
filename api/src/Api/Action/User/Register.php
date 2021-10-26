<?php


namespace App\Api\Action\User;


use App\Entity\User;
use App\Service\Request\RequestService;
use App\Service\User\UserRegisterService;
use Symfony\Component\HttpFoundation\Request;

class Register
{
    /**
     * @var UserRegisterService
     */
    private UserRegisterService $userRegisterService;

    /**
     * Register constructor.
     * @param UserRegisterService $userRegisterService
     */
    public function __construct(UserRegisterService $userRegisterService)
    {
        $this->userRegisterService = $userRegisterService;
    }

    /**
     * @param Request $request
     * @return User
     */
    public function __invoke(Request $request): User
    {
        $name = RequestService::getField($request, 'name');
        $email = RequestService::getField($request, 'email');
        $password = RequestService::getField($request, 'password');

        return $this->userRegisterService->create($name, $email, $password);
    }
}