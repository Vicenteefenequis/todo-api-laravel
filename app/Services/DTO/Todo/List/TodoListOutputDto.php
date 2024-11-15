<?php

namespace App\Services\DTO\Todo\List;

class TodoListOutputDto
{
    public function __construct(
        public readonly array $items
    )
    {

    }

}
