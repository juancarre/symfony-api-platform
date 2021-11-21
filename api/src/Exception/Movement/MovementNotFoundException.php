<?php


namespace App\Exception\Movement;


use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class MovementNotFoundException extends NotFoundHttpException
{
    private const MESSAGE_BY_ID = 'Movement with id %s not found';
    private const MESSAGE_BY_FILE_PATH = 'Movement with file path %s not found';

    public static function fromId(string $id): self
    {
        throw new self(sprintf(self::MESSAGE_BY_ID, $id));
    }

    public static function fromFilePath(string $filePath): self
    {
        throw new self(sprintf(self::MESSAGE_BY_FILE_PATH, $filePath));
    }
}