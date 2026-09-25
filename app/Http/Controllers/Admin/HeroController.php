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
        $data = $request->validated();

        if ($request->hasFile('avatar_file')) {
            $file = $request->file('avatar_file');
            $path = $file->store('avatars', 'public');
            $data['avatar_url'] = '/storage/' . $path;
        }
        unset($data['avatar_file']);

        $this->settingService->updateSettings($data);

        return redirect()->route('admin.hero.index')->with('success', 'Hero section content updated successfully!');
    }
}
