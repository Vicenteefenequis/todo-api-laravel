<?php

namespace App\Services\DTO\Todo\Create;

use App\Enums\Status;

class TodoCreateInputDto
{
    public function __construct(
        public string  $name,
        public string  $description,
        public string  $category_id,
        public ?Status $status = null,
    )
    {
        $this->status = $this->status ?? Status::PENDING;
    }
}
