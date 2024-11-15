<?php

namespace App\Services\DTO\Todo\Delete;

class TodoDeleteOutputDto
{
    public function __construct(
        public readonly bool $success
    )
    {

    }
}
