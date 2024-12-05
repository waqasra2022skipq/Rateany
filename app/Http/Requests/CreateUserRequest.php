<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users'],
            'profession_slug' => ['nullable', 'string'],
            'password' => ['required', 'string', 'min:6'],
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'bio' => 'nullable|string|max:1000',
            'location' => ['nullable', 'string'],
            'contact_phone' => ['nullable', 'string', 'max:20'],
            'contact_website' => ['nullable', 'url', 'max:255'],
        ];
    }
}
