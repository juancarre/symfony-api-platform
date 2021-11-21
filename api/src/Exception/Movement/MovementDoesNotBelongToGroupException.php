<?php


namespace App\Exception\Movement;


use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class MovementDoesNotBelongToGroupException extends AccessDeniedHttpException
{
    /**
     * MovementDoesNotBelongToGroupException constructor.
     */
    public function __construct()
    {
        parent::__construct('This movement does not belong to this group');
    }
}