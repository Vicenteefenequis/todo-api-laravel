<?php

namespace App\Http\Requests;

use App\Enums\Status;
use App\Services\DTO\Todo\ChangeStatus\TodoChangeStatusInputDto;
use Illuminate\Foundation\Http\FormRequest;

class ChangeStatusTodo extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'status' => [
                'required',
                'string',
                'in:completed,pending'
            ]
        ];
    }

    public function toDTO(): TodoChangeStatusInputDto
    {
        return new TodoChangeStatusInputDto(
            id: (string)$this->route('id'),
            status: Status::tryFrom($this->input('status'))
        );
    }
}
