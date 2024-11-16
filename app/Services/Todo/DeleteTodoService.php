<?php

namespace App\Services\Todo;

use App\Services\DTO\Todo\Delete\TodoDeleteOutputDto;
use App\Services\DTO\Todo\TodoInputDto;
use App\Services\Exception\NotFoundException;
use Illuminate\Support\Facades\Auth;

class DeleteTodoService
{
    public function execute(TodoInputDto $input): TodoDeleteOutputDto
    {
        if(!$todo = Auth::user()->todos()->find($input->id)) {
            throw new NotFoundException(sprintf('Todo with id %s not found', $input->id));
        }
        return new TodoDeleteOutputDto(
            success: $todo->delete()
        );
    }

}
