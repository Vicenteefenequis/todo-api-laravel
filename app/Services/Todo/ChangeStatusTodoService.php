<?php

namespace App\Services\Todo;

use App\Services\DTO\Todo\ChangeStatus\TodoChangeStatusInputDto;
use App\Services\Exception\NotFoundException;
use Illuminate\Support\Facades\Auth;

class ChangeStatusTodoService

{
    public function execute(TodoChangeStatusInputDto $input): void
    {
        if(!$todo = Auth::user()->todos()->find($input->id)) {
            throw new NotFoundException(sprintf('Todo with id %s not found', $input->id));
        }

        $todo->update([
            'status' => $input->status
        ]);
    }

}
