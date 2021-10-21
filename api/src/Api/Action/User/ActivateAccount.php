<?php


namespace App\Api\Action\User;


use App\Entity\User;
use App\Service\User\ActivateAccountService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Request;

class ActivateAccount
{
    /**
     * @var ActivateAccountService
     */
    private ActivateAccountService $activateAccountService;

    /**
     * ActivateAccount constructor.
     * @param ActivateAccountService $activateAccountService
     */
    public function __construct(ActivateAccountService $activateAccountService)
    {
        $this->activateAccountService = $activateAccountService;
    }

    /**
     * @param Request $request
     * @param string $id
     * @return User
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(Request $request, string $id): User
    {
        return $this->activateAccountService->activate($request, $id);
    }
}