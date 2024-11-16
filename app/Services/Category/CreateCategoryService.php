<?php


namespace App\Services\Category;

use App\Services\DTO\Category\Create\CategoryCreateInputDto;
use App\Services\DTO\Category\Create\CategoryCreateOutputDto;
use App\Services\Exception\EntityValidationException;
use Auth;

class CreateCategoryService
{
    private const VALID_HEX_COLOR_PATTERN = '/^#([A-Fa-f0-9]{3}|[A-Fa-f0-9]{6})$/';
    public function execute(CategoryCreateInputDto $input): CategoryCreateOutputDto
    {
        $user = Auth::user();

        if (!$this->isValidHexColor($input->color)) {
            throw new EntityValidationException('Color is not valid!');
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


    private function isValidHexColor(string $color): bool
    {
        return preg_match(self::VALID_HEX_COLOR_PATTERN, $color);
    }
}
