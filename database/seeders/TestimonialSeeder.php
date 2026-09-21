<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $testimonials = [
            [
                'client_name' => 'Sarah Jenkins',
                'client_role' => 'VP of Engineering',
                'company' => 'CloudScale Networks',
                'company_logo' => 'https://images.unsplash.com/photo-1618005182384-a83a8bd57fbe?auto=format&fit=crop&w=120&q=80',
                'client_avatar' => 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&w=200&q=80',
                'linkedin_url' => 'https://linkedin.com',
                'quote' => 'Kashif transformed our legacy admin portal into a lightning-fast Inertia + Vue 3 architecture. His attention to design systems, UX subtleties, and backend query optimization reduced our page load times by over 60%. An exceptional full-stack engineer who communicates proactively.',
                'rating' => 5,
                'project_reference' => 'Nexus SaaS Telemetry Dashboard',
                'order' => 1,
                'is_active' => true,
            ],
            [
                'client_name' => 'David Sterling',
                'client_role' => 'Founder & CEO',
                'company' => 'AeroSwift Digital',
                'company_logo' => 'https://images.unsplash.com/photo-1599305445671-ac291c95aaa9?auto=format&fit=crop&w=120&q=80',
                'client_avatar' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=200&q=80',
                'linkedin_url' => 'https://linkedin.com',
                'quote' => 'Working with Kashif on the 3D product visualizer was a breath of fresh air. He merged Three.js WebGL rendering with a buttery-smooth Tailwind UI that blew our executive board away. Delivered ahead of schedule with zero friction.',
                'rating' => 5,
                'project_reference' => 'AeroSwift 3D Product Customizer',
                'order' => 2,
                'is_active' => true,
            ],
            [
                'client_name' => 'Elena Rostova',
                'client_role' => 'Lead Technical Product Manager',
                'company' => 'HealthPulse Global',
                'company_logo' => 'https://images.unsplash.com/photo-1516321318423-f06f85e504b3?auto=format&fit=crop&w=120&q=80',
                'client_avatar' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=200&q=80',
                'linkedin_url' => 'https://linkedin.com',
                'quote' => 'Kashif\'s backend precision in Laravel is world-class. He architected our HIPAA-compliant consultation scheduler and integrated AI triage bots with flawless unit and integration test coverage. He takes full ownership of every sprint.',
                'rating' => 5,
                'project_reference' => 'Healthcare Patient Portal',
                'order' => 3,
                'is_active' => true,
            ],
            [
                'client_name' => 'Marcus Vance',
                'client_role' => 'Head of AI Solutions',
                'company' => 'DevMatrix Labs',
                'company_logo' => 'https://images.unsplash.com/photo-1572021335469-31706a17aaef?auto=format&fit=crop&w=120&q=80',
                'client_avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=200&q=80',
                'linkedin_url' => 'https://linkedin.com',
                'quote' => 'Rarely do you find an engineer who excels equally at responsive frontend aesthetic execution and complex backend asynchronous workers. Kashif is reliable, creative, and pushes code that is clean, secure, and modern.',
                'rating' => 5,
                'project_reference' => 'AI Code Review Assistant',
                'order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($testimonials as $testimonialData) {
            Testimonial::updateOrCreate(
                ['client_name' => $testimonialData['client_name'], 'company' => $testimonialData['company']],
                $testimonialData
            );
        }
    }
}
