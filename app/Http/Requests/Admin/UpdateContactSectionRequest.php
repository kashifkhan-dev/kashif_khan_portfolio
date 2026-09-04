<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateContactSectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'contact_headline_title' => 'nullable|string|max:255',
            'contact_subtitle' => 'nullable|string|max:1000',
            'contact_email' => 'nullable|string|max:255',
            'contact_location' => 'nullable|string|max:255',
            'contact_response_time' => 'nullable|string|max:255',
            'contact_form_title' => 'nullable|string|max:255',
            'contact_submit_btn_text' => 'nullable|string|max:255',
        ];
    }
}
