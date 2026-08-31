<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;
use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Create Default Admin User
        User::updateOrCreate(
            ['email' => 'admin@kashifkhan.com'],
            [
                'name' => 'Kashif Khan',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // 2. Default Profile Settings
        $settings = [
            'hero_title' => 'Senior Full-Stack Architect & AI Developer',
            'hero_subtitle' => 'Building scalable web applications, modern interactive platforms, and robust enterprise solutions with Laravel, Vue 3, and Cloud Infrastructures.',
            'bio' => 'Passionate Software Engineer with 5+ years of experience architecting high-performance web applications, API integrations, and intuitive dashboards. Specialized in Laravel, Vue.js, Tailwind CSS, Inertia.js, and AI automation.',
            'availability_status' => 'Available for Full-time Roles & Contracts',
            'contact_email' => 'kashif.khan@example.com',
            'github_url' => 'https://github.com/KashifKhan456',
            'linkedin_url' => 'https://linkedin.com/in/kashifkhan',
            'twitter_url' => 'https://x.com/kashifkhan',
            'resume_url' => '#',
            'years_experience' => '5+',
            'completed_projects' => '24+',
            'satisfied_clients' => '18+',
        ];

        foreach ($settings as $key => $value) {
            Setting::setByKey($key, $value);
        }

        // 3. Initial Projects
        $projects = [
            [
                'title' => 'Nexus SaaS Telemetry Dashboard',
                'slug' => 'nexus-saas-telemetry-dashboard',
                'category' => 'Laravel & Vue',
                'summary' => 'Real-time telemetry and cloud analytics dashboard powered by Laravel 11, Vue 3, and SVG Heatmaps.',
                'description' => 'A comprehensive analytics platform built to monitor distributed servers, user activity metrics, and API latency in real time. Features dynamic hourly heatmaps, custom date filtering, and responsive data tables.',
                'image_path' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80',
                'tech_stack' => ['Laravel 11', 'Vue 3', 'Inertia.js', 'Tailwind CSS', 'MySQL', 'Recharts'],
                'demo_url' => 'https://nexus-demo.kashifkhan.dev',
                'github_url' => 'https://github.com/KashifKhan456/nexus-telemetry',
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'title' => 'AeroSwift 3D Product Customizer',
                'slug' => 'aeroswift-3d-product-customizer',
                'category' => 'Frontend',
                'summary' => 'Scroll-driven interactive 3D product visualizer for modern footwear branding.',
                'description' => 'Immersive web application utilizing Three.js and WebGL shaders for dynamic color customization, scroll-triggered camera angles, and particle aerodynamics rendering.',
                'image_path' => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?auto=format&fit=crop&w=1200&q=80',
                'tech_stack' => ['Three.js', 'Vue 3', 'Tailwind CSS', 'WebGL', 'GSAP'],
                'demo_url' => 'https://aeroswift.kashifkhan.dev',
                'github_url' => 'https://github.com/KashifKhan456/aeroswift-3d',
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'title' => 'Healthcare Patient Portal & Booking Engine',
                'slug' => 'healthcare-patient-portal',
                'category' => 'Fullstack',
                'summary' => 'Enterprise appointment booking engine with restriction modals and real-time chat bot.',
                'description' => 'HIPAA-compliant healthcare web application allowing patients to schedule consultations, review diagnostic logs, and receive instant AI assistance.',
                'image_path' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=1200&q=80',
                'tech_stack' => ['Laravel', 'Vue 3', 'Pinia', 'Tailwind CSS', 'Sanctum', 'MySQL'],
                'demo_url' => 'https://health-portal.kashifkhan.dev',
                'github_url' => 'https://github.com/KashifKhan456/health-portal',
                'is_featured' => true,
                'order' => 3,
            ],
            [
                'title' => 'AI Code Review & Security Assistant',
                'slug' => 'ai-code-review-assistant',
                'category' => 'AI',
                'summary' => 'Automated code review bot integrating Gemini 2.5 API for pull request vulnerability analysis.',
                'description' => 'A developer workflow tool that automatically inspects GitHub pull requests for potential security flaws, memory leaks, and style inconsistencies.',
                'image_path' => 'https://images.unsplash.com/photo-1618401471353-b98afee0b2eb?auto=format&fit=crop&w=1200&q=80',
                'tech_stack' => ['PHP', 'Laravel', 'Gemini API', 'Node.js', 'Docker'],
                'demo_url' => 'https://ai-reviewer.kashifkhan.dev',
                'github_url' => 'https://github.com/KashifKhan456/ai-code-reviewer',
                'is_featured' => false,
                'order' => 4,
            ],
        ];

        foreach ($projects as $projectData) {
            Project::updateOrCreate(
                ['slug' => $projectData['slug']],
                $projectData
            );
        }

        // 4. Initial Skills
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

        // 5. Initial Career Experiences
        $experiences = [
            [
                'company' => 'Apex Cloud Systems',
                'role' => 'Lead Full-Stack Engineer',
                'period' => '2024 - Present',
                'location' => 'Remote',
                'description' => 'Architected enterprise SaaS solutions using Laravel 11, Vue 3, and Tailwind CSS. Supervised microservices migration and optimized MySQL queries reducing response times by 40%.',
                'highlights' => ['Led a team of 6 engineers', 'Implemented automated CI/CD deployment pipelines', 'Built real-time telemetry dashboard'],
                'type' => 'work',
                'order' => 1,
            ],
            [
                'company' => 'Digital Innovations Hub',
                'role' => 'Senior Frontend & Laravel Specialist',
                'period' => '2022 - 2024',
                'location' => 'On-site',
                'description' => 'Developed custom web portals, customer management systems, and interactive client dashboards using Laravel Breeze, Inertia.js, and Pinia.',
                'highlights' => ['Designed responsive glassmorphism themes', 'Integrated payment gateways and OAuth services', 'Reduced bundle sizes by 35% using Vite'],
                'type' => 'work',
                'order' => 2,
            ],
            [
                'company' => 'University of Computer Science',
                'role' => 'B.S. in Software Engineering',
                'period' => '2018 - 2022',
                'location' => 'Honor Graduate',
                'description' => 'Focused on Data Structures, Object-Oriented Design, Relational Database Systems, and Distributed Computing.',
                'highlights' => ['Graduated with First Class Honors', 'President of Student Developers Club'],
                'type' => 'education',
                'order' => 3,
            ],
        ];

        foreach ($experiences as $expData) {
            Experience::updateOrCreate(
                ['company' => $expData['company'], 'role' => $expData['role']],
                $expData
            );
        }
    }
}
