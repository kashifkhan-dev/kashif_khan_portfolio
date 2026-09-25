<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHeroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'availability_status' => 'nullable|string|max:255',
            'hero_title_1' => 'nullable|string|max:255',
            'hero_title_2' => 'nullable|string|max:255',
            'hero_subtitle' => 'nullable|string',
            'about_text' => 'nullable|string',
            'avatar_url' => 'nullable|string|max:1000',
            'avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif,svg|max:5120',
            'hero_cta_primary_text' => 'nullable|string|max:255',
            'hero_cta_primary_link' => 'nullable|string|max:255',
            'hero_cta_secondary_text' => 'nullable|string|max:255',
            'hero_cta_secondary_link' => 'nullable|string|max:255',
        ];
    }
}
