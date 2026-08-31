<?php

namespace App\Services;

use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Message;

class DashboardService
{
    public function getDashboardMetrics(): array
    {
        return [
            'stats' => [
                'total_projects' => Project::count(),
                'total_skills' => Skill::count(),
                'total_experiences' => Experience::count(),
                'total_messages' => Message::count(),
                'unread_messages' => Message::where('is_read', false)->count(),
            ],
            'recent_messages' => Message::latest()->take(5)->get(),
            'recent_projects' => Project::latest()->take(4)->get(),
        ];
    }
}
