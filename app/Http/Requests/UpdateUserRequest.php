<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => __('validation.required', ['attribute' => __('validation.first_name')]),
            'last_name.required' => __('validation.required', ['attribute' => __('validation.last_name')]),
            'email.required' => __('validation.required', ['attribute' => __('validation.email')]),
            'email.email' => __('validation.email', ['attribute' => __('validation.email')]),
        ];
    }
}

