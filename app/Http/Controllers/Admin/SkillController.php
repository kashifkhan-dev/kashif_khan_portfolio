<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreSkillRequest;
use App\Http\Requests\Admin\UpdateSkillRequest;
use App\Models\Skill;
use App\Services\SkillService;
use Inertia\Inertia;
use Inertia\Response;

class SkillController extends Controller
{
    public function __construct(
        protected SkillService $skillService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Skills/Index', [
            'skills' => $this->skillService->getAllSkills(),
        ]);
    }

    public function store(StoreSkillRequest $request)
    {
        $this->skillService->createSkill($request->validated());

        return redirect()->back()->with('success', 'Skill created successfully!');
    }

    public function update(UpdateSkillRequest $request, Skill $skill)
    {
        $this->skillService->updateSkill($skill, $request->validated());

        return redirect()->back()->with('success', 'Skill updated successfully!');
    }

    public function destroy(Skill $skill)
    {
        $this->skillService->deleteSkill($skill);

        return redirect()->back()->with('success', 'Skill deleted successfully!');
    }
}
