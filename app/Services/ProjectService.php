<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;

class ProjectService
{
    public function getAllProjects(): Collection
    {
        return Project::orderBy('order', 'asc')->get();
    }

    public function createProject(array $data): Project
    {
        $data['slug'] = Str::slug($data['title']) . '-' . rand(100, 999);
        return Project::create($data);
    }

    public function updateProject(Project $project, array $data): bool
    {
        return $project->update($data);
    }

    public function deleteProject(Project $project): bool
    {
        return $project->delete();
    }
}
