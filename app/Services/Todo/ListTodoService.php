<?php

namespace App\Services\Todo;

use App\Services\DTO\Todo\TodoInputDto;
use App\Services\DTO\Todo\TodoOutputDto;
use App\Services\Exception\NotFoundException;
use Illuminate\Support\Facades\Auth;

class ListTodoService
{
    /**
     * @throws NotFoundException
     */
    public function execute(TodoInputDto $input): TodoOutputDto
    {
        if (!$todo = Auth::user()->todos()->find($input->id)) {
            throw new NotFoundException(sprintf('Todo with id %s not found', $input->id));
        }

        return new TodoOutputDto(
            id: $todo->id,
            name: $todo->name,
            description: $todo->description,
            status: $todo->status,
            created_at: $todo->created_at,
            updated_at: $todo->updated_at
        );

    }

}
