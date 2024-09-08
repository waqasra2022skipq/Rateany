<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WriteReviewRequest extends FormRequest
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
            'type' => ['required', 'in:user,business'],
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
            'user_id' => 'required_if:type,user|exists:users,id',
            'business_id' => 'required_if:type,business|exists:businesses,id',
        ];
    }
}
