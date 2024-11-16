<?php

namespace App\Services\Todo;

use App\Services\DTO\Todo\List\TodoListOutputDto;
use Illuminate\Support\Facades\Auth;

class ListTodosService
{
    public function execute(): TodoListOutputDto
    {
        $todos = Auth::user()->todos()->get();

        $items = array_map(function ($item) {
            return [
                'id' => $item['id'],
                'name' => $item['name'],
                'description' => $item['description'],
                'status' => $item['status'],
                'created_at' => $item['created_at'],
                'updated_at' => $item['updated_at'],
            ];
        }, $todos->toArray());


        return new TodoListOutputDto(
            items: $items
        );
    }

}
