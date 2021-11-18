<?php


namespace App\Exception\Group;


use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class UserNotMemberOfGroupException extends AccessDeniedHttpException
{

    /**
     * UserNotMemberOfGroupException constructor.
     */
    public function __construct()
    {
        parent::__construct('This user is not member of this group');
    }
}