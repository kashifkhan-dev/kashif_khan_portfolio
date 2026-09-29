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
                'title' => 'EPOS System – Restaurant & Cafe (Multi-Platform)',
                'slug' => 'epos-restaurant-cafe-system',
                'category' => 'Laravel & Vue',
                'summary' => 'A multi-platform Electronic Point of Sale (EPOS) & Kitchen Display System engineered for high-volume hospitality with real-time WebSocket order sync, receipt printing, and role-based access.',
                'description' => '<p>A comprehensive, multi-platform Electronic Point of Sale (EPOS) system engineered specifically for restaurants and cafes. The system delivers unified synchronization between web management dashboards, Flutter-based mobile tablets for waitstaff, desktop POS terminals for cashiers, and real-time Kitchen Display Systems (KDS).</p><h3>Core Engineering Highlights</h3><ul><li><strong>Cross-Platform Synchronization:</strong> Real-time order dispatch and ticket updates across web, mobile, and desktop terminals via WebSockets and Laravel Echo.</li><li><strong>Multi-Channel Order Management:</strong> Streamlined processing for Dine-in, Takeaway, and Delivery workflows with automated kitchen routing and ticket timers.</li><li><strong>Hardware & Receipt Integration:</strong> ESC/POS thermal printer integration for kitchen chits, guest receipts, and cash drawer triggers.</li><li><strong>Inventory & Batch Tracking:</strong> Ingredient-level stock depletion, batch management, supplier tracking, and automated expiration/low-stock alerts.</li><li><strong>Fine-Grained RBAC:</strong> Comprehensive role-based access control (Admin, Manager, Cashier, Chef, Waiter, Inventory Staff) with fast PIN-code switching for high-tempo shifts.</li><li><strong>Table & Floor Plan Management:</strong> Visual table layout, reservation engine, and live table occupancy tracking.</li></ul><h3>Architecture & Tech Stack</h3><p>Built on <strong>Laravel 12</strong> and <strong>Vue 3</strong> with <strong>Inertia.js</strong>, paired with cross-platform <strong>Flutter</strong> clients for iOS, Android, and Windows desktop. Secure API communication is driven by <strong>Laravel Sanctum</strong>, with <strong>MySQL</strong> persistence and <strong>Stripe</strong> payment integration.</p>',
                'image_path' => '/images/epos-system.png',
                'tech_stack' => ['Laravel 12', 'Vue 3', 'Inertia.js', 'Flutter', 'MySQL', 'WebSockets', 'Tailwind CSS', 'Stripe'],
                'demo_url' => 'https://www.goritmi.co.uk',
                'github_url' => 'https://github.com/Goritmi-Global/epos-system',
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'title' => 'ShopAuto – Auto Parts & Off-Road E-Commerce Platform',
                'slug' => 'shopauto-auto-parts-ecommerce',
                'category' => 'Fullstack',
                'summary' => 'A high-performance automotive e-commerce and off-road parts marketplace in the UAE featuring dynamic vehicle fitment filtering, shipping calculations, and admin order fulfillment.',
                'description' => '<p>ShopAuto is a premier automotive spare parts and 4x4 off-road modifications e-commerce platform serving the UAE and GCC region. Engineered with a scalable Laravel and Inertia.js architecture, the application delivers lightning-fast part discovery, vehicle-specific fitment verification, and streamlined checkout flows.</p><h3>Key Features & Architectural Highlights</h3><ul><li><strong>Vehicle Fitment Filtering Engine:</strong> Interactive multi-tier part search filtering by vehicle manufacturer, model, year, and trim variant to ensure 100% component compatibility.</li><li><strong>Comprehensive E-Commerce Suite:</strong> Real-time cart management, dynamic location-based shipping calculation across Emirates, multi-currency support, and automated tax invoicing.</li><li><strong>Customer Account & Order Tracking:</strong> Real-time delivery timeline tracking, customer order history, wishlists, and verified buyer product reviews.</li><li><strong>Administrative Operations Suite:</strong> Full-featured back-office management for product catalog (SKU, brand, category, vehicle mapping), automated order processing, PDF invoice generation, and customer communication workflows.</li></ul><h3>Technology Stack</h3><p>Engineered using <strong>Laravel</strong>, <strong>Vue.js 3</strong> with <strong>Inertia.js</strong>, <strong>Ziggy</strong> routing, <strong>Tailwind CSS</strong>, and <strong>MySQL</strong> with Redis caching for rapid catalog querying and responsive performance.</p>',
                'image_path' => '/images/shopauto.png',
                'tech_stack' => ['Laravel', 'Vue 3', 'Inertia.js', 'Tailwind CSS', 'MySQL', 'Ziggy', 'Redis'],
                'demo_url' => 'https://shopauto.ae/',
                'github_url' => null,
                'is_featured' => true,
                'order' => 2,
            ],
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
                'order' => 3,
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
                'order' => 4,
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
                'order' => 5,
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
                'order' => 6,
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
