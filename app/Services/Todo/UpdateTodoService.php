<?php

namespace App\Services\Todo;

use App\Enums\Status;
use App\Services\DTO\Todo\Update\TodoUpdateInputDto;
use App\Services\DTO\Todo\Update\TodoUpdateOutputDto;
use App\Services\Exception\NotFoundException;
use Illuminate\Support\Facades\Auth;

class UpdateTodoService
{

    public function execute(TodoUpdateInputDto $input): TodoUpdateOutputDto
    {

        if (!$todo = Auth::user()->todos()->find($input->id)) {
            throw new NotFoundException(sprintf('Todo with id %s not found', $input->id));
        }

        $todo->update([
            'name' => $input->name,
            'description' => $input->description,
            'category_id' => $input->category_id,
            'status' => $input->status,
        ]);

        return new TodoUpdateOutputDto(
            id: $todo->id,
            name: $todo->name,
            description: $todo->description,
            status: $todo->status,
            created_at: $todo->created_at,
            updated_at: $todo->updated_at
        );

    }

}
