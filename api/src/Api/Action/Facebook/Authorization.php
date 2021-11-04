<?php


namespace App\Api\Action\Facebook;


use App\Service\Facebook\FacebookService;
use App\Service\Request\RequestService;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Facebook\Exceptions\FacebookSDKException;
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

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws FacebookSDKException
     */
    public function __invoke(Request $request): JsonResponse
    {
        return new JsonResponse(['token' => $this->facebookService->authorize(RequestService::getField($request, 'accessToken'))]);
    }
}