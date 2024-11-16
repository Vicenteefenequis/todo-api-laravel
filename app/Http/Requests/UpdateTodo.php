<?php

namespace App\Http\Requests;

use App\Enums\Status;
use App\Services\DTO\Todo\Update\TodoUpdateInputDto;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class UpdateTodo extends FormRequest
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
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:3',
                'max:25',
            ],
            'description' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'status' => [
                'nullable',
                new Enum(Status::class),
            ],
            'category_id' => [
                'required',
                'string',
                'exists:categories,id'
            ]
        ];
    }


    public function toDTO(): TodoUpdateInputDto
    {
        return new TodoUpdateInputDto(
            id: (string)$this->route('todo'),
            name: $this->input('name'),
            description: $this->input('description'),
            category_id: $this->input('category_id'),
            status: Status::tryFrom($this->input('status')),
        );
    }
}
