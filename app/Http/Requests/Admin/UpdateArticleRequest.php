<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $articleId = $this->route('article') instanceof \App\Models\Article 
            ? $this->route('article')->id 
            : $this->route('article');

        return [
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:articles,slug,' . $articleId,
            'excerpt' => 'nullable|string|max:1000',
            'content' => 'required|string',
            'cover_image' => 'nullable|string',
            'cover_image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:5120',
            'read_time' => 'nullable|integer|min:1',
            'tags' => 'nullable|array',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'order' => 'nullable|integer',
        ];
    }
}
