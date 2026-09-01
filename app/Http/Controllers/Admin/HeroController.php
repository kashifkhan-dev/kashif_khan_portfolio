<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateHeroRequest;
use App\Services\SettingService;
use Inertia\Inertia;
use Inertia\Response;

class HeroController extends Controller
{
    public function __construct(
        protected SettingService $settingService
    ) {}

    public function index(): Response
    {
        return Inertia::render('Admin/Hero', [
            'settings' => $this->settingService->getAllSettings(),
        ]);
    }

    public function update(UpdateHeroRequest $request)
    {
        $this->settingService->updateSettings($request->validated());

        return redirect()->back()->with('success', 'Hero section content updated successfully!');
    }
}
