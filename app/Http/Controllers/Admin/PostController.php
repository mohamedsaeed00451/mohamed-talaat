<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('category')->latest()->paginate(10);
        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $categories = PostCategory::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'post_category_id' => 'required|exists:post_categories,id',
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'description.en' => 'required|string',
            'strategic_brief.ar' => 'nullable|string',
            'strategic_brief.en' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'attachment_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'meta_title.ar' => 'nullable|string|max:255',
            'meta_title.en' => 'nullable|string|max:255',
            'meta_description.ar' => 'nullable|string',
            'meta_description.en' => 'nullable|string',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'publish_type' => 'required|in:now,schedule',
            'published_at' => 'nullable|required_if:publish_type,schedule|date',
            'social_platforms' => 'nullable|array',
            'social_platforms.*' => 'in:facebook,twitter,instagram,linkedin',
        ]);

        $data = $request->except(['image', 'meta_image', 'attachment_file', 'publish_type']);
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_old'] = $request->has('is_old');
        $data['social_platforms'] = $request->input('social_platforms', []);
        $data['auto_publish'] = count($data['social_platforms']) > 0;
        $data['slug'] = [
            'ar' => preg_replace('/\s+/u', '-', trim($request->input('title.ar'))),
            'en' => Str::slug($request->input('title.en'))
        ];
        if ($request->publish_type == 'now') {
            $data['published_at'] = now();
        } else {
            $data['published_at'] = $request->published_at;
        }
        if ($request->hasFile('image')) $data['image'] = upload_file($request->file('image'), 'posts/images');
        if ($request->hasFile('meta_image')) $data['meta_image'] = upload_file($request->file('meta_image'), 'posts/images/meta');
        if ($request->hasFile('attachment_file')) {
            $data['attachment_file'] = upload_file($request->file('attachment_file'), 'posts/files');
        }

        $post = Post::create($data);

        if ($post->auto_publish && $post->published_at <= now()) {
            try {

                $postUrl = config('app.web_site_url') . '/' . $post->slug['ar'];

                if (app()->environment('local')) {
                    $imageUrl = 'https://picsum.photos/800/600';
                } else {
                    $imageUrl = $post->image ? asset($post->image) : null;
                }

                $webhookUrl = config('app.webhook_url');

                Http::timeout(5)->post($webhookUrl, [
                    'title' => $post->title['ar'],
                    'content' => strip_tags($post->description['ar']),
                    'url' => $postUrl,
                    'image_url' => $imageUrl,
                    'platforms' => $post->social_platforms,
                ]);

                $post->update(['social_published' => true]);

            } catch (\Exception $e) {
                Log::error('Webhook Error: ' . $e->getMessage());
            }
        }


        return redirect()->route('admin.posts.index')->with('success', 'تم إضافة المقال بنجاح!');
    }

    public function edit(Post $post)
    {
        $categories = PostCategory::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post)
    {
        $request->validate([
            'post_category_id' => 'required|exists:post_categories,id',
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'description.en' => 'required|string',
            'strategic_brief.ar' => 'nullable|string',
            'strategic_brief.en' => 'nullable|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'attachment_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'meta_title.ar' => 'nullable|string|max:255',
            'meta_title.en' => 'nullable|string|max:255',
            'meta_description.ar' => 'nullable|string',
            'meta_description.en' => 'nullable|string',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'publish_type' => 'required|in:now,schedule',
            'published_at' => 'nullable|required_if:publish_type,schedule|date',
            'social_platforms' => 'nullable|array',
            'social_platforms.*' => 'in:facebook,twitter,instagram,linkedin',
        ]);

        $data = $request->except(['image', 'meta_image', 'attachment_file', 'publish_type']);
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_old'] = $request->has('is_old');
        $data['social_platforms'] = $request->input('social_platforms', []);
        $data['auto_publish'] = count($data['social_platforms']) > 0;
        $data['slug'] = [
            'ar' => preg_replace('/\s+/u', '-', trim($request->input('title.ar'))),
            'en' => Str::slug($request->input('title.en'))
        ];
        if ($request->publish_type == 'now') {
            $data['published_at'] = now();
        } else {
            $data['published_at'] = $request->published_at;
        }
        $files = ['image', 'meta_image', 'attachment_file'];
        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                if ($post->$fileKey) delete_file($post->$fileKey);
                $path = 'posts/files';
                if ($fileKey == 'image') $path = 'posts/images';
                if ($fileKey == 'meta_image') $path = 'posts/images/meta';

                $data[$fileKey] = upload_file($request->file($fileKey), $path);
            }
        }

        $post->update($data);

        if ($post->auto_publish && $post->published_at <= now()) {
            try {

                $postUrl = config('app.web_site_url') . '/' . $post->slug['ar'];

                if (app()->environment('local')) {
                    $imageUrl = 'https://picsum.photos/800/600';
                } else {
                    $imageUrl = $post->image ? asset($post->image) : null;
                }

                $webhookUrl = config('app.webhook_url');

                Http::timeout(5)->post($webhookUrl, [
                    'title' => $post->title['ar'],
                    'content' => strip_tags($post->description['ar']),
                    'url' => $postUrl,
                    'image_url' => $imageUrl,
                    'platforms' => $post->social_platforms,
                ]);

                $post->update(['social_published' => true]);

            } catch (\Exception $e) {
                Log::error('Webhook Error: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.posts.index')->with('success', 'تم تعديل المقال بنجاح!');
    }

    public function destroy(Post $post)
    {
        if ($post->image) delete_file($post->image);
        if ($post->meta_image) delete_file($post->meta_image);
        if ($post->attachment_file) delete_file($post->attachment_file);

        $post->delete();
        return back()->with('success', 'تم الحذف بنجاح!');
    }

    public function toggleStatus(Request $request, Post $post)
    {
        $request->validate([
            'field' => 'required|in:is_active,is_featured,is_old',
            'state' => 'required|boolean'
        ]);

        $post->update([
            $request->field => $request->state
        ]);

        return response()->json(['success' => true, 'message' => 'تم التحديث بنجاح']);
    }
}
