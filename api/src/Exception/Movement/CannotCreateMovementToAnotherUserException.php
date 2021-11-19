<?php


namespace App\Exception\Movement;


use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CannotCreateMovementToAnotherUserException extends AccessDeniedHttpException
{
    /**
     * CannotCreateMovementToAnotherUserException constructor.
     */
    public function __construct()
    {
        parent::__construct('You can not create movements for another user');
    }
}