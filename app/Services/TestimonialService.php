<?php

namespace App\Services;

use App\Models\Testimonial;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TestimonialService
{
    public function getAllTestimonials(): Collection
    {
        return Testimonial::orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getActiveTestimonials(): Collection
    {
        return Testimonial::where('is_active', true)
            ->orderBy('order', 'asc')
            ->get();
    }

    public function createTestimonial(array $data): Testimonial
    {
        if (isset($data['avatar_file']) && $data['avatar_file'] instanceof UploadedFile) {
            $path = $data['avatar_file']->store('testimonials', 'public');
            $data['client_avatar'] = '/storage/' . $path;
        }
        unset($data['avatar_file']);

        return Testimonial::create($data);
    }

    public function updateTestimonial(Testimonial $testimonial, array $data): bool
    {
        if (isset($data['avatar_file']) && $data['avatar_file'] instanceof UploadedFile) {
            if ($testimonial->client_avatar && Str::startsWith($testimonial->client_avatar, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $testimonial->client_avatar);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $data['avatar_file']->store('testimonials', 'public');
            $data['client_avatar'] = '/storage/' . $path;
        }
        unset($data['avatar_file']);

        return $testimonial->update($data);
    }

    public function deleteTestimonial(Testimonial $testimonial): bool
    {
        if ($testimonial->client_avatar && Str::startsWith($testimonial->client_avatar, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $testimonial->client_avatar);
            Storage::disk('public')->delete($oldPath);
        }

        return $testimonial->delete();
    }

    public function toggleActive(Testimonial $testimonial): bool
    {
        return $testimonial->update(['is_active' => !$testimonial->is_active]);
    }
}
