<?php

namespace App\Services\DTO\Todo\Create;

use App\Enums\Status;

class TodoCreateOutputDto
{
    public function __construct(
        public readonly string $id,
        public readonly string $name,
        public readonly string $description,
        public readonly Status $status,
        public readonly string $created_at,
        public readonly string $updated_at,
    )
    {
    }
}
