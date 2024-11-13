<?php


namespace App\Services\Category;

use App\Models\Category;
use App\Services\DTO\Category\Update\CategoryUpdateInputDto;
use App\Services\DTO\Category\Update\CategoryUpdateOutputDto;
use App\Services\Exception\{
    NotFoundException,
    EntityValidationException
};

class UpdateCategoryService
{
    public function execute(CategoryUpdateInputDto $input): CategoryUpdateOutputDto
    {

        if (!$this->isValidHexColor($input->color)) throw new EntityValidationException('Color is not valid!');

        $category =  Category::find($input->id);

        if (!$category) throw new NotFoundException(sprintf('category with id %s not found', $input->id));

        $category->update([
            'name' => $input->name,
            'color' => $input->color
        ]);


        return new CategoryUpdateOutputDto(
            id: $category->id,
            name: $category->name,
            color: $category->color,
            created_at: $category->created_at,
            updated_at: $category->updated_at
        );
    }


    private function isValidHexColor(string $color): bool
    {
        return preg_match('/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/', $color);
    }
}
