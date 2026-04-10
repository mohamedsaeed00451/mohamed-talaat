<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class PostController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $query = Post::with('category')
            ->where('is_active', 1)
            ->orderBy('id', 'desc');

        if ($request->filled('category_slug')) {
            $slug = $request->category_slug;
            $query->whereHas('category', function ($q) use ($slug) {
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

        $posts = $query->paginate(10);

        $posts->through(function ($post) {
            return $this->formatPost($post);
        });

        return $this->responseMessage(200, true, 'تم جلب المقالات والأعمدة بنجاح', $posts);
    }

    public function show($slug)
    {
        $post = Post::with('category')
            ->where('is_active', 1)
            ->where('published_at', '<=', now())
            ->where(function ($query) use ($slug) {
                $query->where('slug->ar', $slug)
                    ->orWhere('slug->en', $slug);
            })
            ->first();

        if (!$post) {
            return $this->responseMessage(404, false, 'المقال غير موجود أو لم يتم نشره بعد');
        }

        return $this->responseMessage(200, true, 'تفاصيل المقال', $this->formatPost($post));
    }

    private function formatPost($post)
    {
        return [
            'id' => $post->id,
            'category' => [
                'id' => $post->category->id ?? null,
                'name' => $post->category->name ?? null,
                'slug' => $post->category->slug ?? null,
            ],
            'title' => $post->title,
            'slug' => $post->slug,
            'description' => $post->description,
            'strategic_brief' => $post->strategic_brief,
            'url' => $post->url,

            'is_featured' => (bool)$post->is_featured,
            'is_old' => (bool)$post->is_old,

            'social_platforms' => $post->social_platforms ?? [],

            'published_at' => $post->published_at ? $post->published_at->format('Y-m-d h:i A') : null,
            'created_at' => $post->created_at->format('Y-m-d'),

            'image_url' => $post->image ? asset($post->image) : null,
            'attachment_url' => $post->attachment_file ? asset($post->attachment_file) : null,
            'meta_image_url' => $post->meta_image ? asset($post->meta_image) : null,

            'meta_title' => $post->meta_title,
            'meta_description' => $post->meta_description,
        ];
    }
}
