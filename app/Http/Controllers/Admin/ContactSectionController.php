<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateContactSectionRequest;
use App\Services\SettingService;
use Inertia\Inertia;
use Inertia\Response;

class ContactSectionController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Contact', [
            'settings' => $this->settingService->getAllSettings(),
        ]);
    }

    public function update(UpdateContactSectionRequest $request)
    {
        $this->settingService->updateSettings($request->validated());

        return redirect()->back()->with('success', 'Contact section updated successfully!');
    }
}
