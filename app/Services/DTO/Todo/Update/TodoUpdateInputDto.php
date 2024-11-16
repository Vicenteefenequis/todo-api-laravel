<?php

namespace App\Services\DTO\Todo\Update;

use App\Enums\Status;

class TodoUpdateInputDto
{

    public function __construct(
        public string  $id,
        public string  $name,
        public string  $description,
        public string  $category_id,
        public ?Status $status = null,
    )
    {
        $this->status = $this->status ?? Status::PENDING;
    }

}
