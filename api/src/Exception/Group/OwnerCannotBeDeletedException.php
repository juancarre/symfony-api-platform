<?php


namespace App\Exception\Group;


use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class OwnerCannotBeDeletedException extends ConflictHttpException
{

    /**
     * OwnerCannotBeDeletedException constructor.
     */
    public function __construct()
    {
        parent::__construct('Owner can not be deleted from a group. Try deleting the group instead');
    }
}