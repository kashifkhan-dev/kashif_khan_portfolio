<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTestimonialRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'client_name' => 'required|string|max:255',
            'client_role' => 'nullable|string|max:255',
            'company' => 'nullable|string|max:255',
            'company_logo' => 'nullable|string',
            'client_avatar' => 'nullable|string',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'linkedin_url' => 'nullable|url',
            'quote' => 'required|string',
            'rating' => 'integer|min:1|max:5',
            'project_reference' => 'nullable|string|max:255',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ];
    }
}
