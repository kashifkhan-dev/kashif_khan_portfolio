<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateExperienceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'company' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'period' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'work_type' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'highlights' => 'nullable|array',
            'technologies' => 'nullable|array',
            'type' => 'required|string|in:work,education',
            'order' => 'integer',
        ];
    }
}
