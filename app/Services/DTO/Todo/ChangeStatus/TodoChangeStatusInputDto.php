<?php


namespace App\Services\DTO\Todo\ChangeStatus;

use App\Enums\Status;

class TodoChangeStatusInputDto
{
    public function __construct(
        public string $id,
        public Status $status,
    )
    {
    }
}
