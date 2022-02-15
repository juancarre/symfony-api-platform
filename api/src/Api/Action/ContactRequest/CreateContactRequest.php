<?php


namespace App\Api\Action\ContactRequest;


use App\Entity\ContactRequest;
use App\Entity\User;
use App\Service\ContactRequest\CreateRequestService;
use Symfony\Component\HttpFoundation\Request;

class CreateContactRequest
{
    private CreateRequestService $createRequestService;

    /**
     * CreateContactRequest constructor.
     * @param CreateRequestService $createRequestService
     */
    public function __construct(CreateRequestService $createRequestService)
    {
        $this->createRequestService = $createRequestService;
    }

    public function __invoke(Request $request): ContactRequest
    {
        return $this->createRequestService->createContactRequest($request);
    }

}