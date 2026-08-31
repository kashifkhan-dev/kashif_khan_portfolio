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
            'hero_title' => 'nullable|string',
            'hero_subtitle' => 'nullable|string',
            'bio' => 'nullable|string',
            'availability_status' => 'nullable|string',
            'github_url' => 'nullable|string',
            'linkedin_url' => 'nullable|string',
            'twitter_url' => 'nullable|string',
            'resume_url' => 'nullable|string',
            'years_experience' => 'nullable|string',
            'completed_projects' => 'nullable|string',
            'satisfied_clients' => 'nullable|string',
        ];
    }
}
