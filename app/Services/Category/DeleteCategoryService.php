<?php


namespace App\Services\Category;

use App\Models\Category;
use App\Services\DTO\Category\CategoryInputDto;
use App\Services\DTO\Category\Delete\CategoryDeleteOutputDto;
use App\Services\Exception\NotFoundException;
use Auth;

class DeleteCategoryService
{
    public function execute(CategoryInputDto $input): CategoryDeleteOutputDto
    {
        $category = Auth::user()->categories()->find($input->id);

        if (!$category) {
            throw new NotFoundException(sprintf('Category not found with id %s', $input->id));
        }

        return new CategoryDeleteOutputDto(success: $category->delete());
    }
}
