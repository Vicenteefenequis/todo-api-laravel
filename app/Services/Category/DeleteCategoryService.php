<?php


namespace App\Services\Category;

use App\Models\Category;
use App\Services\DTO\Category\CategoryInputDto;
use App\Services\DTO\Category\Delete\CategoryDeleteOutputDto;
use App\Services\Exception\CategoryException;

class DeleteCategoryService
{
    public function execute(CategoryInputDto $input): CategoryDeleteOutputDto
    {
        $category = Category::find($input->id);

        if (!$category) throw CategoryException::notFound($input->id);

        return new CategoryDeleteOutputDto(success: $category->delete());
    }
}
