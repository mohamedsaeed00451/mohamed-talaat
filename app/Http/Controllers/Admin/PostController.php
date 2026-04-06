<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
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
        ]);

        $data = $request->except(['image', 'meta_image', 'attachment_file']);

        $data['slug'] = [
            'ar' => preg_replace('/\s+/u', '-', trim($request->input('title.ar'))),
            'en' => Str::slug($request->input('title.en'))
        ];

        if ($request->hasFile('image')) $data['image'] = upload_file($request->file('image'), 'posts/images');
        if ($request->hasFile('meta_image')) $data['meta_image'] = upload_file($request->file('meta_image'), 'posts/images/meta');
        if ($request->hasFile('attachment_file')) {
            $data['attachment_file'] = upload_file($request->file('attachment_file'), 'posts/files');
        }

        Post::create($data);

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
        ]);

        $data = $request->except(['image', 'meta_image', 'attachment_file']);

        $data['slug'] = [
            'ar' => preg_replace('/\s+/u', '-', trim($request->input('title.ar'))),
            'en' => Str::slug($request->input('title.en'))
        ];

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
}
