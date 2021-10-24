<?php


namespace App\Api\Action\User;


use App\Entity\User;
use App\Service\User\ResetPasswordService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class ResetPassword
{
    /**
     * @var ResetPasswordService
     */
    private ResetPasswordService $resetPasswordService;

    /**
     * ResetPassword constructor.
     * @param ResetPasswordService $resetPasswordService
     */
    public function __construct(ResetPasswordService $resetPasswordService)
    {
        $this->resetPasswordService = $resetPasswordService;
    }


    /**
     * @param Request $request
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(Request $request): User
    {
        return $this->resetPasswordService->reset($request);
    }
}