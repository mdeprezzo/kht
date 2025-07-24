<?php

namespace App\Http\Requests\Books;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {   
        $rules = [
            'description' => 'required',
            'price' => 'required|numeric',
            'cover' => 'nullable|image'
        ];

        return match ($this->method() === 'POST') {
            true => [
                'title' => 'required|unique:books',
                ...$rules
            ],
            default => [
                'title' => ['required', Rule::unique('books')->ignore($this->route('book')->id)],
                ...$rules
            ]
        };

    }
}
