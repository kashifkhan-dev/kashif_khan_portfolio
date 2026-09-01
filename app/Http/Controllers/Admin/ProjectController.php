<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreProjectRequest;
use App\Http\Requests\Admin\UpdateProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function __construct(
        protected ProjectService $projectService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Projects/Index', [
            'projects' => $this->projectService->getAllProjects(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Projects/Create');
    }

    public function store(StoreProjectRequest $request)
    {
        $this->projectService->createProject($request->validated());

        return redirect()->route('admin.projects.index')->with('success', 'Project created successfully!');
    }

    public function edit(Project $project): Response
    {
        return Inertia::render('Admin/Projects/Edit', [
            'project' => $project,
        ]);
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->projectService->updateProject($project, $request->validated());

        return redirect()->route('admin.projects.index')->with('success', 'Project updated successfully!');
    }

    public function destroy(Project $project)
    {
        $this->projectService->deleteProject($project);

        return redirect()->back()->with('success', 'Project deleted successfully!');
    }
}
