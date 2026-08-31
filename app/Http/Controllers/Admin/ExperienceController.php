<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreExperienceRequest;
use App\Http\Requests\Admin\UpdateExperienceRequest;
use App\Models\Experience;
use App\Services\ExperienceService;
use Inertia\Inertia;
use Inertia\Response;

class ExperienceController extends Controller
{
    public function __construct(
        protected ExperienceService $experienceService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Experiences/Index', [
            'experiences' => $this->experienceService->getAllExperiences(),
        ]);
    }

    public function store(StoreExperienceRequest $request)
    {
        $this->experienceService->createExperience($request->validated());

        return redirect()->back()->with('success', 'Experience record created successfully!');
    }

    public function update(UpdateExperienceRequest $request, Experience $experience)
    {
        $this->experienceService->updateExperience($experience, $request->validated());

        return redirect()->back()->with('success', 'Experience record updated successfully!');
    }

    public function destroy(Experience $experience)
    {
        $this->experienceService->deleteExperience($experience);

        return redirect()->back()->with('success', 'Experience record deleted successfully!');
    }
}
