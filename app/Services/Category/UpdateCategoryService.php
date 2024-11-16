<?php


namespace App\Services\Category;

use App\Config\Validate\HexColor;
use App\Models\Category;
use App\Services\DTO\Category\Update\CategoryUpdateInputDto;
use App\Services\DTO\Category\Update\CategoryUpdateOutputDto;
use Illuminate\Support\Facades\Auth;
use App\Services\Exception\{
    NotFoundException,
    EntityValidationException
};

class UpdateCategoryService
{

    public function execute(CategoryUpdateInputDto $input): CategoryUpdateOutputDto
    {
        if (!HexColor::make($input->color)->is_valid()) {
            throw new EntityValidationException(sprintf("Color {$input->color} is not valid!"));
        }

        if (!$category = Auth::user()->categories()->find($input->id)) {
            throw new NotFoundException(sprintf('category with id %s not found', $input->id));
        }

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

}
