<?php

namespace Database\Seeders;

use App\Models\Skill;
use Illuminate\Database\Seeder;

class SkillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $skills = [
            // Backend
            ['name' => 'Laravel 11 / PHP 8.2+', 'category' => 'Backend', 'proficiency' => 95, 'icon' => 'Server', 'order' => 1],
            ['name' => 'MySQL / PostgreSQL / Redis', 'category' => 'Backend', 'proficiency' => 90, 'icon' => 'Database', 'order' => 2],
            ['name' => 'REST & GraphQL APIs', 'category' => 'Backend', 'proficiency' => 92, 'icon' => 'Workflow', 'order' => 3],
            // Frontend
            ['name' => 'Vue.js 3 / Composition API', 'category' => 'Frontend', 'proficiency' => 95, 'icon' => 'Code', 'order' => 4],
            ['name' => 'Inertia.js Monolith Stack', 'category' => 'Frontend', 'proficiency' => 92, 'icon' => 'Layers', 'order' => 5],
            ['name' => 'Tailwind CSS / Shadcn UI', 'category' => 'Frontend', 'proficiency' => 98, 'icon' => 'Palette', 'order' => 6],
            ['name' => 'Pinia State Management', 'category' => 'Frontend', 'proficiency' => 90, 'icon' => 'Cpu', 'order' => 7],
            // DevOps & Tools
            ['name' => 'Docker / CI/CD Pipelines', 'category' => 'Database/DevOps', 'proficiency' => 85, 'icon' => 'Container', 'order' => 8],
            ['name' => 'Git / GitHub Workflows', 'category' => 'Tools', 'proficiency' => 95, 'icon' => 'GitBranch', 'order' => 9],
            ['name' => 'Vite / Webpack / NPM', 'category' => 'Tools', 'proficiency' => 90, 'icon' => 'Zap', 'order' => 10],
        ];

        foreach ($skills as $skillData) {
            Skill::updateOrCreate(
                ['name' => $skillData['name']],
                $skillData
            );
        }
    }
}
