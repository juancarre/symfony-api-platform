<?php


namespace App\Api\Action\Facebook;


use App\Service\Facebook\FacebookService;
use App\Service\Request\RequestService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class Authorization
{
    /**
     * @var FacebookService
     */
    private FacebookService $facebookService;

    /**
     * Authorization constructor.
     * @param FacebookService $facebookService
     */
    public function __construct(FacebookService $facebookService)
    {

        $this->facebookService = $facebookService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(['token' => $this->facebookService->authorize(RequestService::getField('accessToken'))]);
    }
}