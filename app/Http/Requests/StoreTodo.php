<?php

namespace App\Http\Requests;

use App\Enums\Status;
use App\Services\DTO\Todo\Create\TodoCreateInputDto;
use Illuminate\Foundation\Http\FormRequest;

class StoreTodo extends FormRequest
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
                'string',
                'in:pending,completed'
            ],
            'category_id' => [
                'required',
                'string',
                'exists:categories,id'
            ]
        ];
    }

    public function toDTO(): TodoCreateInputDto
    {
        return new TodoCreateInputDto(
            name: $this->input('name'),
            description: $this->input('description'),
            status: Status::tryFrom($this->input('status')),
            category_id: $this->input('category_id'),
        );
    }
}
