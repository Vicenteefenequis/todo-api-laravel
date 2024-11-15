<?php

namespace App\Services\Todo;

use App\Enums\Status;
use App\Models\Category;
use App\Services\DTO\Todo\Create\TodoCreateInputDto;
use App\Services\DTO\Todo\Create\TodoCreateOutputDto;
use App\Services\Exception\EntityValidationException;
use Illuminate\Support\Facades\Auth;

class CreateTodoService
{
    /**
     * @throws EntityValidationException
     */
    public function execute(TodoCreateInputDto $input): TodoCreateOutputDto {

        $this->validateCategoryId($input->category_id);

        $todo = Auth::user()->todos()->create([
            'name' => $input->name,
            'description' => $input->description,
            'status' => $input->status,
            'category_id' => $input->category_id,
        ]);

        return new TodoCreateOutputDto(
            id: $todo->id,
            name: $todo->name,
            description: $todo->description,
            status: $todo->status,
            created_at: $todo->created_at,
            updated_at: $todo->updated_at
        );
    }

    /**
     * @throws EntityValidationException
     */
    private function validateCategoryId(string $categoryId): void {

        if(!Auth::user()->categories()->where('id', $categoryId)->exists()) {
            throw new EntityValidationException(sprintf("Category with id %s is not valid", $categoryId));
        }
    }

}
