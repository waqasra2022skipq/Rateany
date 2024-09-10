<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BusinessCreateRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:100'],
            'userId' => ['required', 'exists:users,id'],
            'categoryId' => ['required', 'exists:categories,id'],
            'location' => ['nullable', 'string'],
            'description' => ['nullable', 'string'],
            'business_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
