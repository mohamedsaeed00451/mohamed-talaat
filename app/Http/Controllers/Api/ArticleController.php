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

        $query = Article::with('type')->latest();

        if ($request->has('article_type_id') && $request->article_type_id != null) {
            $query->where('article_type_id', $request->article_type_id);
        }

        $articles = $query->paginate(10);

        $articles->through(function ($article) {
            return [
                'id' => $article->id,
                'type' => [
                    'id' => $article->type->id ?? null,
                    'name' => $article->type->name ?? null,
                ],
                'title' => $article->title,
                'description' => $article->description,

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
                'created_at' => $article->created_at->format('Y-m-d'),
            ];
        });

        return $this->responseMessage(200, true, 'articles', $articles);
    }
}
