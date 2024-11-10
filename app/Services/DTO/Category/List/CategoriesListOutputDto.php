<?php


namespace App\Services\DTO\Category\List;



class CategoriesListOutputDto
{
    public function __construct(
        public array $items
    ) {}
}
