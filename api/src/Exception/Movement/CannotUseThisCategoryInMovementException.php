<?php


namespace App\Exception\Movement;


use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class CannotUseThisCategoryInMovementException extends AccessDeniedHttpException
{
    /**
     * CannotUseThisCategoryInMovementException constructor.
     */
    public function __construct()
    {
        parent::__construct('You can not use this category in this movement');
    }
}