<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'github_url' => 'nullable|string|max:500',
            'linkedin_url' => 'nullable|string|max:500',
            'twitter_url' => 'nullable|string|max:500',
            'resume_url' => 'nullable|string|max:500',
            'resume_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ];
    }
}
