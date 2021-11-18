<?php


namespace App\Api\Action\Group;


use App\Service\Group\AcceptRequestService;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AcceptRequest
{
    /**
     * @var AcceptRequestService
     */
    private AcceptRequestService $acceptRequestService;

    /**
     * AcceptRequest constructor.
     */
    public function __construct(AcceptRequestService $acceptRequestService)
    {
        $this->acceptRequestService = $acceptRequestService;
    }

    public function __invoke(Request $request, string $id): JsonResponse
    {
        $this->acceptRequestService->accept(
            $id,
            RequestService::getField($request, 'userId'),
            RequestService::getField($request, 'token')
        );

        return new JsonResponse(['message' => 'User has been added to the group']);
    }
}