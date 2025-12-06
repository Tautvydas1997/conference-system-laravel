<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateConferenceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'lecturers' => ['required', 'string', 'max:255'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'address' => ['required', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => __('validation.required', ['attribute' => __('validation.name')]),
            'description.required' => __('validation.required', ['attribute' => __('validation.description')]),
            'lecturers.required' => __('validation.required', ['attribute' => __('validation.lecturers')]),
            'date.required' => __('validation.required', ['attribute' => __('validation.date')]),
            'date.date' => __('validation.date', ['attribute' => __('validation.date')]),
            'time.required' => __('validation.required', ['attribute' => __('validation.time')]),
            'address.required' => __('validation.required', ['attribute' => __('validation.address')]),
        ];
    }
}

