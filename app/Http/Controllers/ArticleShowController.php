<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Setting;
use App\Services\ArticleService;
use Inertia\Inertia;
use Inertia\Response;

class ArticleShowController extends Controller
{
    public function __construct(
        protected ArticleService $articleService
    ) {}

    public function index(): Response
    {
        $articles = $this->articleService->getPublishedArticles();
        $settings = Setting::pluck('value', 'key')->all();

        // Collect unique tags
        $allTags = $articles->pluck('tags')->flatten()->filter()->unique()->values()->all();

        return Inertia::render('Articles/Index', [
            'articles' => $articles,
            'allTags' => $allTags,
            'settings' => $settings,
        ]);
    }

    public function show(string $slug): Response
    {
        // Allow logged in admin to preview draft articles
        if (auth()->check()) {
            $article = Article::where('slug', $slug)->orWhere('id', $slug)->firstOrFail();
        } else {
            $article = Article::where('slug', $slug)->where('is_published', true)->firstOrFail();
            $this->articleService->incrementViews($article);
        }

        $relatedArticles = Article::where('id', '!=', $article->id)
            ->where('is_published', true)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        $settings = Setting::pluck('value', 'key')->all();

        return Inertia::render('Articles/Show', [
            'article' => $article,
            'relatedArticles' => $relatedArticles,
            'settings' => $settings,
        ]);
    }
}
