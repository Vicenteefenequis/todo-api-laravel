<?php


namespace App\Services\Category;

use App\Config\Validate\HexColor;
use App\Services\DTO\Category\Create\CategoryCreateInputDto;
use App\Services\DTO\Category\Create\CategoryCreateOutputDto;
use App\Services\Exception\EntityValidationException;
use Auth;

class CreateCategoryService
{
    public function execute(CategoryCreateInputDto $input): CategoryCreateOutputDto
    {
        $user = Auth::user();

        if (!HexColor::make($input->color)->is_valid()) {
            throw new EntityValidationException(sprintf("Color {$input->color} is not valid!"));
        }

        $category = $user->categories()->create([
            'name' => $input->name,
            'color' => $input->color
        ]);

        return new CategoryCreateOutputDto(
            id: $category->id,
            name: $category->name,
            color: $category->color,
            created_at: $category->created_at,
            updated_at: $category->updated_at
        );
    }

}
