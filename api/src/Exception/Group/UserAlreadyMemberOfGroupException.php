<?php


namespace App\Exception\Group;


use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class UserAlreadyMemberOfGroupException extends ConflictHttpException
{

    /**
     * UserAlreadyMemberOfGroupException constructor.
     */
    public function __construct()
    {
        parent::__construct('This user is already member of this group');
    }
}