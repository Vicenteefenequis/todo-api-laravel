<?php

namespace App\Services\DTO\Todo\Create;

use App\Enums\Status;

class TodoCreateInputDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $description,
        public readonly ?Status $status,
        public readonly string $category_id
    )
    {
    }
}
