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

        // 6. Initial Technical Articles
        $articles = [
            [
                'title' => 'Architecting High-Throughput Inertia.js SPAs with Vue 3 & Laravel 12',
                'slug' => 'architecting-high-throughput-inertiajs-spas-vue-3-laravel-12',
                'excerpt' => 'A deep dive into partial reloads, lazy evaluation props, deferred state hydration, and optimistic UI updates for enterprise-grade monoliths.',
                'content' => '<h2>Introduction</h2><p>Modern monoliths built on top of Laravel 12 and Inertia.js provide the developer velocity of traditional server-driven templates alongside the buttery fluidity of client-side Single Page Applications. However, as applications scale in data complexity and concurrent user traffic, default prop serialization patterns can introduce payload bloat.</p><h3>1. Leveraging Deferred & Lazy Props</h3><p>In traditional controllers, returning extensive datasets inside <code>Inertia::render()</code> can block initial TTFB (Time to First Byte). By wrapping secondary metrics in closures or using Inertia’s deferred evaluation helper, we allow the view framework to render instantly:</p><pre><code>return Inertia::render(\'Dashboard\', [
    \'user\' => $request->user(),
    \'analytics\' => Inertia::defer(fn () => $telemetryService->getComplexMetrics()),
]);</code></pre><h3>2. Optimistic UI Updates with Pinia</h3><p>Inertia router visits can feel instantaneous when combined with optimistic local state. By updating Pinia store state ahead of the server roundtrip and reverting only on network fault, users experience zero perceptible latency.</p><h3>Conclusion</h3><p>Treating Inertia.js as a structured protocol rather than a simple glue layer enables sub-100ms transitions and rock-solid architectural boundaries.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1555066931-4365d14bab8c?auto=format&fit=crop&w=1200&q=80',
                'read_time' => 6,
                'tags' => ['Laravel 12', 'Vue 3', 'Inertia.js', 'Architecture', 'Performance'],
                'is_published' => true,
                'published_at' => now()->subDays(3),
                'views_count' => 142,
                'order' => 1,
            ],
            [
                'title' => 'Scaling Real-time MySQL Telemetry with Redis Caching and SVG Heatmaps',
                'slug' => 'scaling-realtime-mysql-telemetry-redis-caching-svg-heatmaps',
                'excerpt' => 'How we achieved sub-25ms dashboard query times handling 50k events/minute using Redis sliding windows and procedural SVG canvas generation.',
                'content' => '<h2>The Challenge</h2><p>When telemetry tables grow past millions of records, executing aggregation queries like <code>COUNT(*) GROUP BY HOUR(created_at)</code> on every page reload quickly saturates database CPU cores. In building the Nexus SaaS Telemetry platform, we re-architected our ingestion and presentation pipeline.</p><h3>Redis Sliding Log Window</h3><p>Instead of direct writes, incoming events hit Redis sorted sets. Time-bucketed metrics are rolled up in memory:</p><pre><code>Redis::zadd("telemetry:events:{$serverUuid}", $timestamp, $payload);
Redis::zremrangebyscore("telemetry:events:{$serverUuid}", \'-inf\', $twentyFourHoursAgo);</code></pre><h3>Procedural SVG Canvas Generation</h3><p>Instead of shipping heavy JavaScript canvas libraries, the backend computes an optimized SVG matrix and streams lightweight XML paths directly to Vue 3 for rendering. This slashed bundle size by 45KB while providing crisp vector clarity on 4K displays.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&w=1200&q=80',
                'read_time' => 8,
                'tags' => ['MySQL', 'Redis', 'WebSockets', 'Telemetry', 'SVG'],
                'is_published' => true,
                'published_at' => now()->subDays(7),
                'views_count' => 289,
                'order' => 2,
            ],
            [
                'title' => 'Designing Resilient Background Job Pipelines in Distributed Laravel Systems',
                'slug' => 'designing-resilient-background-job-pipelines-distributed-laravel',
                'excerpt' => 'Best practices for idempotency keys, exponential backoffs, dead-letter queues, and memory leak mitigation in long-running queue workers.',
                'content' => '<h2>Why Queue Reliability Matters</h2><p>As applications process high volumes of outgoing emails, third-party webhook dispatches, and heavy PDF generations, queue worker failures can silently stall operations if not safeguarded.</p><h3>1. Ensuring Idempotency</h3><p>Every critical job should guarantee idempotency by maintaining a unique deduplication token. If a worker process terminates unexpectedly mid-execution, re-running the job must never duplicate financial transactions or double-dispatch messages.</p><h3>2. Tuning Worker Supervisor & Memory Limits</h3><p>Always run PHP queue listeners with explicit memory limits and auto-restart flags:</p><pre><code>php artisan queue:work redis --sleep=3 --tries=3 --max-time=3600 --memory=256</code></pre><p>This prevents subtle memory accumulation and ensures long-term process stability.</p>',
                'cover_image' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=1200&q=80',
                'read_time' => 5,
                'tags' => ['Laravel', 'Queue', 'Redis', 'DevOps', 'Microservices'],
                'is_published' => true,
                'published_at' => now()->subDays(12),
                'views_count' => 195,
                'order' => 3,
            ],
        ];

        foreach ($articles as $articleData) {
            \App\Models\Article::updateOrCreate(
                ['slug' => $articleData['slug']],
                $articleData
            );
        }

        // 7. Initial Client Testimonials & Endorsements
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
            \App\Models\Testimonial::updateOrCreate(
                ['client_name' => $testimonialData['client_name'], 'company' => $testimonialData['company']],
                $testimonialData
            );
        }
    }
}
