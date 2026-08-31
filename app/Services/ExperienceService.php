<?php

namespace App\Services;

use App\Models\Experience;
use Illuminate\Database\Eloquent\Collection;

class ExperienceService
{
    public function getAllExperiences(): Collection
    {
        return Experience::orderBy('order', 'asc')->get();
    }

    public function createExperience(array $data): Experience
    {
        return Experience::create($data);
    }

    public function updateExperience(Experience $experience, array $data): bool
    {
        return $experience->update($data);
    }

    public function deleteExperience(Experience $experience): bool
    {
        return $experience->delete();
    }
}
