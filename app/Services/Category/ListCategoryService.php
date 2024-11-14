<?php


namespace App\Services\Category;

use App\Models\Category;
use App\Services\DTO\Category\CategoryInputDto;
use App\Services\DTO\Category\CategoryOutputDto;
use App\Services\Exception\CategoryException;
use App\Services\Exception\NotFoundException;
use Auth;

class ListCategoryService
{


    public function execute(CategoryInputDto $input): CategoryOutputDto
    {
        $category = Auth::user()->categories()->find($input->id);

        if (!$category) {
            throw new NotFoundException(sprintf('Category not found with id %s', $input->id));
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
