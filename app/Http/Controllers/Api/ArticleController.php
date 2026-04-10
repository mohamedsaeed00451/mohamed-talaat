<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $query = Article::with('type')
            ->where('is_active', 1)
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc');

        if ($request->filled('type_slug')) {
            $slug = $request->type_slug;
            $query->whereHas('type', function ($q) use ($slug) {
                $q->where('slug->ar', $slug)
                    ->orWhere('slug->en', $slug);
            });
        }

        if ($request->filled('is_featured')) {
            $query->where('is_featured', $request->boolean('is_featured'));
        }

        if ($request->filled('is_old')) {
            $query->where('is_old', $request->boolean('is_old'));
        }

        $articles = $query->paginate(10);

        $articles->through(function ($article) {
            return $this->formatArticle($article);
        });

        return $this->responseMessage(200, true, 'تم جلب التحليلات بنجاح', $articles);
    }

    public function show($slug)
    {
        $article = Article::with('type')
            ->where('is_active', 1)
            ->where('published_at', '<=', now())
            ->where(function ($query) use ($slug) {
                $query->where('slug->ar', $slug)
                    ->orWhere('slug->en', $slug);
            })
            ->first();

        if (!$article) {
            return $this->responseMessage(404, false, 'التحليل غير موجود أو لم يتم نشره بعد');
        }

        return $this->responseMessage(200, true, 'تفاصيل التحليل', $this->formatArticle($article));
    }

    private function formatArticle($article)
    {
        return [
            'id' => $article->id,
            'type' => [
                'id' => $article->type->id ?? null,
                'name' => $article->type->name ?? null,
                'slug' => $article->type->slug ?? null,
            ],
            'title' => $article->title,
            'slug' => $article->slug,
            'description' => $article->description,

            'is_featured' => (bool)$article->is_featured,
            'is_old' => (bool)$article->is_old,

            'social_platforms' => $article->social_platforms ?? [],

            'published_at' => $article->published_at ? $article->published_at->format('Y-m-d h:i A') : null,
            'created_at' => $article->created_at->format('Y-m-d'),

            'image_url' => $article->image ? asset($article->image) : null,
            'meta_image_url' => $article->meta_image ? asset($article->meta_image) : null,

            'meta_title' => $article->meta_title,
            'meta_description' => $article->meta_description,

            'attachments' => [
                'white_papers' => $article->white_papers_file ? asset($article->white_papers_file) : null,
                'published_researches' => $article->published_researches_file ? asset($article->published_researches_file) : null,
                'executive_briefs' => $article->executive_briefs_file ? asset($article->executive_briefs_file) : null,
                'chronological_archive' => $article->chronological_archive_file ? asset($article->chronological_archive_file) : null,
            ],
        ];
    }
}
