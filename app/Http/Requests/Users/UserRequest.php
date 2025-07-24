<?php

namespace App\Http\Requests\Users;

use App\Enums\RolesEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required',
            'role' => ['required', Rule::enum(RolesEnum::class)],            
        ];

        return match ($this->method() === 'POST') {
            true => [
                ...$rules,
                'password' => 'required|confirmed',
                'email' => 'required|email|unique:users,email',
            ],
            default => [
                'password' => 'nullable|confirmed',
                'email' => ['required', 'email', Rule::unique('users')->ignore($this->route('user')->id)],
                ...$rules
            ]
        };        
    }
}
