<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Setting;

class LandingService
{
    public function getLandingData(): array
    {
        return [
            'projects' => Project::orderBy('order', 'asc')->get(),
            'skills' => Skill::orderBy('order', 'asc')->get(),
            'experiences' => Experience::orderBy('order', 'asc')->get(),
            'settings' => Setting::pluck('value', 'key')->toArray(),
            'canLogin' => true,
        ];
    }
}
