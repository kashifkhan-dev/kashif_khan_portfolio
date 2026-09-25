<?php

namespace App\Services;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ExperienceService
{
    public function getAllExperiences(): Collection
    {
        return Experience::orderBy('order', 'asc')->get();
    }

    public function createExperience(array $data): Experience
    {
        if (isset($data['logo_file']) && $data['logo_file'] instanceof UploadedFile) {
            $path = $data['logo_file']->store('experiences', 'public');
            $data['logo'] = '/storage/'.$path;
        }
        unset($data['logo_file']);

        return Experience::create($data);
    }

    public function updateExperience(Experience $experience, array $data): bool
    {
        if (isset($data['logo_file']) && $data['logo_file'] instanceof UploadedFile) {
            if ($experience->logo && Str::startsWith($experience->logo, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $experience->logo);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $data['logo_file']->store('experiences', 'public');
            $data['logo'] = '/storage/'.$path;
        }
        unset($data['logo_file']);

        return $experience->update($data);
    }

    public function deleteExperience(Experience $experience): bool
    {
        if ($experience->logo && Str::startsWith($experience->logo, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $experience->logo);
            Storage::disk('public')->delete($oldPath);
        }

        return $experience->delete();
    }
}
