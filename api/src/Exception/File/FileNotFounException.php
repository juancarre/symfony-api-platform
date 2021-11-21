<?php


namespace App\Exception\File;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileNotFounException extends NotFoundHttpException
{

    /**
     * FileNotFounException constructor.
     */
    public function __construct()
    {
        parent::__construct('File not found in the server');
    }
}