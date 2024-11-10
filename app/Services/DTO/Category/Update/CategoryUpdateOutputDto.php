<?php

namespace App\Services\DTO\Category\Update;


class CategoryUpdateOutputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $color,
        public string $created_at,
        public string $updated_at
    ) {}
}
