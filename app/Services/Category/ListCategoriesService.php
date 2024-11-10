<?php


namespace App\Services\Category;

use App\Services\DTO\Category\List\CategoriesListOutputDto;
use Auth;

class ListCategoriesService
{


    public function execute(): CategoriesListOutputDto
    {
        $categories = Auth::user()->categories()->get();

        return new CategoriesListOutputDto(
            items: $categories->toArray()
        );
    }
}
