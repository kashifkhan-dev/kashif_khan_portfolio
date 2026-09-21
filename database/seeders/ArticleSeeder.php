<?php

namespace Database\Seeders;

use App\Models\Article;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
            Article::updateOrCreate(
                ['slug' => $articleData['slug']],
                $articleData
            );
        }
    }
}
