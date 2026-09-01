<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'summary' => 'nullable|string',
            'description' => 'nullable|string',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'image_path' => 'nullable|string',
            'tech_stack' => 'nullable|array',
            'demo_url' => 'nullable|url',
            'github_url' => 'nullable|url',
            'is_featured' => 'boolean',
            'order' => 'integer',
        ];
    }
}
