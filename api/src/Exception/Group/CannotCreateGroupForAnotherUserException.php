<?php


namespace App\Exception\Group;


use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CannotCreateGroupForAnotherUserException extends AccessDeniedHttpException
{

    /**
     * CannotCreateGroupForAnotherUserException constructor.
     */
    public function __construct()
    {
        parent::__construct('You can not create group for another user');
    }
}