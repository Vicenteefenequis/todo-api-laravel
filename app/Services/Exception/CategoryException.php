<?php


namespace App\Services\Exception;

use Exception;

class CategoryException extends Exception
{
    public static function colorNotValid()
    {
        return new self('Color is not valid');
    }

    public static function notFound(string $id)
    {
        return new self(sprintf('Category with id %s not found', $id));
    }
}
