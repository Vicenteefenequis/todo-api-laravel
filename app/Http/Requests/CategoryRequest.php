<?php

namespace App\Http\Requests;

use App\Services\DTO\Category\Create\CategoryCreateInputDto;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'name' => 'required|min:3|max:25',
            'color' => 'required|min:3|max:25'
        ];
    }

    public function toDTO(): CategoryCreateInputDto
    {
        return new CategoryCreateInputDto(
            name: $this->input('name'),
            color: $this->input('color')
        );
    }
}
