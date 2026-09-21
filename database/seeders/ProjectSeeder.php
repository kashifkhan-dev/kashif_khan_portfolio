<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
