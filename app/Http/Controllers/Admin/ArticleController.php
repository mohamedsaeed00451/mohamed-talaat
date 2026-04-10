<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::with('type')->latest()->paginate(10);
        return view('admin.articles.index', compact('articles'));
    }

    public function create()
    {
        $types = ArticleType::all();
        return view('admin.articles.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'article_type_id' => 'required|exists:article_types,id',
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'description.en' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'white_papers_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'published_researches_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'executive_briefs_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'chronological_archive_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'meta_title.ar' => 'nullable|string|max:255',
            'meta_title.en' => 'nullable|string|max:255',
            'meta_description.ar' => 'nullable|string',
            'meta_description.en' => 'nullable|string',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['image', 'meta_image', 'white_papers_file', 'published_researches_file', 'executive_briefs_file', 'chronological_archive_file']);

        $sanitizerConfig = (new HtmlSanitizerConfig())
            ->allowSafeElements()
            ->allowElement('img', ['src', 'alt', 'title', 'width', 'height', 'style'])
            ->allowElement('a', ['href', 'title', 'target', 'rel'])
            ->allowAttribute('style', '*');

        $sanitizer = new HtmlSanitizer($sanitizerConfig);

        $data['description'] = [
            'ar' => $sanitizer->sanitize($request->input('description.ar')),
            'en' => $sanitizer->sanitize($request->input('description.en')),
        ];

        $data['slug'] = [
            'ar' => preg_replace('/\s+/u', '-', trim($request->input('title.ar'))),
            'en' => Str::slug($request->input('title.en'))
        ];

        $data['meta_title'] = [
            'ar' => $request->input('meta_title.ar'),
            'en' => $request->input('meta_title.en')
        ];

        $data['meta_description'] = [
            'ar' => $request->input('meta_description.ar'),
            'en' => $request->input('meta_description.en')
        ];

        if ($request->hasFile('image')) $data['image'] = upload_file($request->file('image'), 'articles/images');
        if ($request->hasFile('meta_image')) $data['meta_image'] = upload_file($request->file('meta_image'), 'articles/images/meta');

        if ($request->hasFile('white_papers_file')) {
            $data['white_papers_file'] = upload_file($request->file('white_papers_file'), 'articles/files');
        }
        if ($request->hasFile('published_researches_file')) {
            $data['published_researches_file'] = upload_file($request->file('published_researches_file'), 'articles/files');
        }
        if ($request->hasFile('executive_briefs_file')) {
            $data['executive_briefs_file'] = upload_file($request->file('executive_briefs_file'), 'articles/files');
        }
        if ($request->hasFile('chronological_archive_file')) {
            $data['chronological_archive_file'] = upload_file($request->file('chronological_archive_file'), 'articles/files');
        }

        Article::create($data);

        return redirect()->route('admin.articles.index')->with('success', 'تم إضافة المقال بنجاح!');
    }

    public function edit(Article $article)
    {
        $types = ArticleType::all();
        return view('admin.articles.edit', compact('article', 'types'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'article_type_id' => 'required|exists:article_types,id',
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'description.en' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'white_papers_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'published_researches_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'executive_briefs_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'chronological_archive_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'meta_title.ar' => 'nullable|string|max:255',
            'meta_title.en' => 'nullable|string|max:255',
            'meta_description.ar' => 'nullable|string',
            'meta_description.en' => 'nullable|string',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $data = $request->except(['image', 'meta_image', 'white_papers_file', 'published_researches_file', 'executive_briefs_file', 'chronological_archive_file']);

        $sanitizerConfig = (new HtmlSanitizerConfig())
            ->allowSafeElements()
            ->allowElement('img', ['src', 'alt', 'title', 'width', 'height', 'style'])
            ->allowElement('a', ['href', 'title', 'target', 'rel'])
            ->allowAttribute('style', '*');

        $sanitizer = new HtmlSanitizer($sanitizerConfig);

        $data['description'] = [
            'ar' => $sanitizer->sanitize($request->input('description.ar')),
            'en' => $sanitizer->sanitize($request->input('description.en')),
        ];

        $data['slug'] = [
            'ar' => preg_replace('/\s+/u', '-', trim($request->input('title.ar'))),
            'en' => Str::slug($request->input('title.en'))
        ];

        $data['meta_title'] = [
            'ar' => $request->input('meta_title.ar'),
            'en' => $request->input('meta_title.en')
        ];

        $data['meta_description'] = [
            'ar' => $request->input('meta_description.ar'),
            'en' => $request->input('meta_description.en')
        ];

        $files = ['image', 'meta_image', 'white_papers_file', 'published_researches_file', 'executive_briefs_file', 'chronological_archive_file'];

        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                if ($article->$fileKey) delete_file($article->$fileKey);

                $path = 'articles/files';
                if ($fileKey == 'image') $path = 'articles/images';
                if ($fileKey == 'meta_image') $path = 'articles/images/meta';

                $data[$fileKey] = upload_file($request->file($fileKey), $path);
            }
        }

        $article->update($data);

        return redirect()->route('admin.articles.index')->with('success', 'تم تعديل المقال بنجاح!');
    }

    public function destroy(Article $article)
    {
        if ($article->image) delete_file($article->image);
        if ($article->meta_image) delete_file($article->meta_image);
        if ($article->white_papers_file) delete_file($article->white_papers_file);
        if ($article->published_researches_file) delete_file($article->published_researches_file);
        if ($article->executive_briefs_file) delete_file($article->executive_briefs_file);
        if ($article->chronological_archive_file) delete_file($article->chronological_archive_file);

        $article->delete();

        return back()->with('success', 'تم الحذف بنجاح!');
    }
}
