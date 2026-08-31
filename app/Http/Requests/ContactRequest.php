<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'sender_name' => 'required|string|max:255',
            'sender_email' => 'required|email|max:255',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string|max:5000',
        ];
    }
}
