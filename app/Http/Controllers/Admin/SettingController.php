<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSettingRequest;
use App\Services\SettingService;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Settings', [
            'settings' => $this->settingService->getAllSettings(),
        ]);
    }

    public function update(UpdateSettingRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('resume_file')) {
            $file = $request->file('resume_file');
            $path = $file->store('resumes', 'public');
            $data['resume_url'] = '/storage/' . $path;
        }
        unset($data['resume_file']);

        $this->settingService->updateSettings($data);

        return redirect()->back()->with('success', 'Profile and site settings saved successfully!');
    }
}
