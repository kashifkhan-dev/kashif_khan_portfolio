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

        if (isset($data['image_file']) && $data['image_file'] instanceof \Illuminate\Http\UploadedFile) {
            $path = $data['image_file']->store('projects', 'public');
            $data['image_path'] = '/storage/' . $path;
        }
        unset($data['image_file']);

        return Project::create($data);
    }

    public function updateProject(Project $project, array $data): bool
    {
        if (isset($data['image_file']) && $data['image_file'] instanceof \Illuminate\Http\UploadedFile) {
            if ($project->image_path && Str::startsWith($project->image_path, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $project->image_path);
                \Illuminate\Support\Facades\Storage::disk('public')->delete($oldPath);
            }
            $path = $data['image_file']->store('projects', 'public');
            $data['image_path'] = '/storage/' . $path;
        }
        unset($data['image_file']);

        return $project->update($data);
    }

    public function deleteProject(Project $project): bool
    {
        return $project->delete();
    }
}
