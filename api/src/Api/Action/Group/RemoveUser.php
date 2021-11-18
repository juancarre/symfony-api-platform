<?php


namespace App\Api\Action\Group;


use App\Entity\User;
use App\Service\Group\RemoveUserService;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class RemoveUser
{
    private RemoveUserService $removeUserService;

    /**
     * RemoveUser constructor.
     */
    public function __construct(RemoveUserService $removeUserService)
    {
        $this->removeUserService = $removeUserService;
    }

    /**
     * @throws Throwable
     */
    public function __invoke(Request $request, User $user, string $id): JsonResponse
    {
        $this->removeUserService->remove($id, RequestService::getField($request, 'userId'), $user);

        return new JsonResponse(['message' => 'User has been deleted!']);
    }
}