<?php

namespace App\Services\DTO\Category\Create;


class CategoryCreateInputDto
{
    public function __construct(
        public string $name,
        public string $color
    ) {}
}
