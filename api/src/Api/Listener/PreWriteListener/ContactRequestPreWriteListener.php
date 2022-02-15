<?php


namespace App\Api\Listener\PreWriteListener;


use App\Entity\Category;
use App\Entity\ContactRequest;
use App\Entity\User;
use App\Exception\Category\CannotCreateCategoryForAnotherGroupException;
use App\Exception\Category\CannotCreateCategoryForAnotherUserException;
use App\Exception\Category\UnsupportedCategoryTypeException;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ContactRequestPreWriteListener implements PreWriteListener
{
    private const CONTACT_REQUEST_POST = 'api_contact_requests_post_collection';
    private TokenStorageInterface $tokenStorage;

    /**
     * ContactRequestPreWriteListener constructor.
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;
    }


    public function onKernelView(ViewEvent $event): void
    {
        /** @var User|null $tokenUser */
        $tokenUser = $this->tokenStorage->getToken()
            ? $this->tokenStorage->getToken()->getUser()
            : null;

        $request = $event->getRequest();

    }
}