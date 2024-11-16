<?php

namespace App\Services\DTO\Todo;

use App\Enums\Status;

class TodoInputDto
{
    public function __construct(
        public readonly string $id
    )
    {

    }

}
