<?php


namespace App\Services\Category;

use App\Models\Category;
use App\Services\DTO\Category\CategoryInputDto;
use App\Services\DTO\Category\CategoryOutputDto;
use App\Services\Exception\CategoryException;

class ListCategoryService
{


    public function execute(CategoryInputDto $input): CategoryOutputDto
    {

        $category = Category::find($input->id);

        if (!$category) {
            throw CategoryException::notFound($input->id);
        }

        return new CategoryOutputDto(
            id: $category->id,
            name: $category->name,
            color: $category->color,
            created_at: $category->created_at,
            updated_at: $category->updated_at,
        );
    }
}
