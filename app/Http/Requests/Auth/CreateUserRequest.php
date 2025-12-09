<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class CreateUserRequest extends FormRequest
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
        return [
            "first_name"=> "required|string|min:2|max:255",
            "last_name"=> "required|string|min:2|max:255",
            "patronymic"=> "nullable|string|min:2|max:255",
            "email"=> "required|email|unique:users,email|max:255",
            "birth_date"=> "required|date|before:today|max:255",
            "password"=> ["required", Password::min(8)->letters()->numbers()->mixedCase()],
        ];
    }
}
