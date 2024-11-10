<?php

namespace App\Services\DTO\Category\Update;


class CategoryUpdateInputDto
{
    public function __construct(
        public string $id,
        public string $name,
        public string $color
    ) {}
}
