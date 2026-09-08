<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleService
{
    public function getAllArticles(): Collection
    {
        return Article::orderBy('order', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getPublishedArticles(): Collection
    {
        return Article::where('is_published', true)
            ->orderBy('order', 'asc')
            ->orderBy('published_at', 'desc')
            ->get();
    }

    public function getLatestPublished(int $limit = 3): Collection
    {
        return Article::where('is_published', true)
            ->orderBy('order', 'asc')
            ->orderBy('published_at', 'desc')
            ->limit($limit)
            ->get();
    }

    public function getArticleBySlug(string $slug): Article
    {
        return Article::where('slug', $slug)->firstOrFail();
    }

    public function createArticle(array $data): Article
    {
        if (empty($data['slug'])) {
            $baseSlug = Str::slug($data['title']);
            $count = Article::where('slug', 'like', "{$baseSlug}%")->count();
            $data['slug'] = $count > 0 ? "{$baseSlug}-" . ($count + 1) : $baseSlug;
        } else {
            $data['slug'] = Str::slug($data['slug']);
        }

        if (empty($data['read_time']) && !empty($data['content'])) {
            $wordCount = str_word_count(strip_tags($data['content']));
            $data['read_time'] = max(1, (int) ceil($wordCount / 200));
        }

        if (!empty($data['is_published']) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if (isset($data['cover_image_file']) && $data['cover_image_file'] instanceof UploadedFile) {
            $path = $data['cover_image_file']->store('articles', 'public');
            $data['cover_image'] = '/storage/' . $path;
        }
        unset($data['cover_image_file']);

        return Article::create($data);
    }

    public function updateArticle(Article $article, array $data): bool
    {
        if (!empty($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        }

        if (empty($data['read_time']) && !empty($data['content'])) {
            $wordCount = str_word_count(strip_tags($data['content']));
            $data['read_time'] = max(1, (int) ceil($wordCount / 200));
        }

        if (!empty($data['is_published']) && empty($article->published_at) && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if (isset($data['cover_image_file']) && $data['cover_image_file'] instanceof UploadedFile) {
            if ($article->cover_image && Str::startsWith($article->cover_image, '/storage/')) {
                $oldPath = str_replace('/storage/', '', $article->cover_image);
                Storage::disk('public')->delete($oldPath);
            }
            $path = $data['cover_image_file']->store('articles', 'public');
            $data['cover_image'] = '/storage/' . $path;
        }
        unset($data['cover_image_file']);

        return $article->update($data);
    }

    public function deleteArticle(Article $article): bool
    {
        if ($article->cover_image && Str::startsWith($article->cover_image, '/storage/')) {
            $oldPath = str_replace('/storage/', '', $article->cover_image);
            Storage::disk('public')->delete($oldPath);
        }

        return $article->delete();
    }

    public function togglePublish(Article $article): bool
    {
        $newStatus = !$article->is_published;
        $publishedAt = $newStatus && !$article->published_at ? now() : $article->published_at;

        return $article->update([
            'is_published' => $newStatus,
            'published_at' => $publishedAt,
        ]);
    }

    public function incrementViews(Article $article): void
    {
        $article->increment('views_count');
    }
}
