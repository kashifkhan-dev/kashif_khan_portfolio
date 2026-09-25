<?php

namespace App\Services;

use App\Models\Experience;
use App\Models\Project;
use App\Models\Skill;

class DashboardService
{
    public function getDashboardMetrics(): array
    {
        return [
            'stats' => [
                'total_projects' => Project::count(),
                'total_skills' => Skill::count(),
                'total_experiences' => Experience::count(),
            ],
            'recent_projects' => Project::latest()->take(4)->get(),
        ];
    }
}
