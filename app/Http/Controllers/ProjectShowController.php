<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Setting;
use Inertia\Inertia;
use Inertia\Response;

class ProjectShowController extends Controller
{
    public function index(): Response
    {
        $projects = Project::orderBy('order', 'asc')->get();

        $settings = Setting::pluck('value', 'key')->all();

        return Inertia::render('Projects/Index', [
            'projects' => $projects,
            'settings' => $settings,
        ]);
    }

    public function show($idOrSlug): Response
    {
        $project = Project::where('slug', $idOrSlug)
            ->orWhere('id', $idOrSlug)
            ->firstOrFail();

        $relatedProjects = Project::where('id', '!=', $project->id)
            ->where('category', $project->category)
            ->take(3)
            ->get();

        if ($relatedProjects->isEmpty()) {
            $relatedProjects = Project::where('id', '!=', $project->id)
                ->take(3)
                ->get();
        }

        $settings = Setting::pluck('value', 'key')->all();

        return Inertia::render('Projects/Show', [
            'project' => $project,
            'relatedProjects' => $relatedProjects,
            'settings' => $settings,
        ]);
    }
}
