<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
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
            'policy_paper_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'strategic_fact_sheets_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'strategic_brief_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'analytical_infographic_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'analytical_article_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
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

        $data = $request->except(['image', 'meta_image', 'policy_paper_file', 'strategic_fact_sheets_file', 'strategic_brief_file', 'analytical_infographic_file', 'analytical_article_file', 'publish_type']);

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

        if ($request->hasFile('policy_paper_file')) {
            $data['policy_paper_file'] = upload_file($request->file('policy_paper_file'), 'articles/files');
        }
        if ($request->hasFile('strategic_fact_sheets_file')) {
            $data['strategic_fact_sheets_file'] = upload_file($request->file('strategic_fact_sheets_file'), 'articles/files');
        }
        if ($request->hasFile('strategic_brief_file')) {
            $data['strategic_brief_file'] = upload_file($request->file('strategic_brief_file'), 'articles/files');
        }
        if ($request->hasFile('analytical_infographic_file')) {
            $data['analytical_infographic_file'] = upload_file($request->file('analytical_infographic_file'), 'articles/files');
        }
        if ($request->hasFile('analytical_article_file')) {
            $data['analytical_article_file'] = upload_file($request->file('analytical_article_file'), 'articles/files');
        }

        $article = Article::create($data);

        if ($article->auto_publish && $article->published_at <= now()) {
            try {
                $articleUrl = config('app.web_site_url') . '/articles/' . $article->slug['ar'];

                if (app()->environment('local')) {
                    $imageUrl = 'https://picsum.photos/800/600';
                } else {
                    $imageUrl = $article->image ? asset($article->image) : null;
                }

                $webhookUrl = config('app.webhook_url');

                Http::timeout(5)->post($webhookUrl, [
                    'title' => $article->title['ar'],
                    'content' => strip_tags($article->description['ar']),
                    'url' => $articleUrl,
                    'image_url' => $imageUrl,
                    'platforms' => $article->social_platforms,
                ]);

                $article->update(['social_published' => true]);

            } catch (\Exception $e) {
                Log::error('Webhook Error: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'تم إضافة التحليل بنجاح!');
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
            'policy_paper_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'strategic_fact_sheets_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'strategic_brief_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'analytical_infographic_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'analytical_article_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
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

        $data = $request->except(['image', 'meta_image', 'policy_paper_file', 'strategic_fact_sheets_file', 'strategic_brief_file', 'analytical_infographic_file', 'analytical_article_file', 'publish_type']);

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

        $data['meta_title'] = [
            'ar' => $request->input('meta_title.ar'),
            'en' => $request->input('meta_title.en')
        ];

        $data['meta_description'] = [
            'ar' => $request->input('meta_description.ar'),
            'en' => $request->input('meta_description.en')
        ];

        $files = ['image', 'meta_image', 'policy_paper_file', 'strategic_fact_sheets_file', 'strategic_brief_file', 'analytical_infographic_file', 'analytical_article_file'];

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

        if ($article->auto_publish && $article->published_at <= now()) {
            try {
                $articleUrl = config('app.web_site_url') . '/articles/' . $article->slug['ar'];

                if (app()->environment('local')) {
                    $imageUrl = 'https://picsum.photos/800/600';
                } else {
                    $imageUrl = $article->image ? asset($article->image) : null;
                }

                $webhookUrl = config('app.webhook_url');

                Http::timeout(5)->post($webhookUrl, [
                    'title' => $article->title['ar'],
                    'content' => strip_tags($article->description['ar']),
                    'url' => $articleUrl,
                    'image_url' => $imageUrl,
                    'platforms' => $article->social_platforms,
                ]);

                $article->update(['social_published' => true]);

            } catch (\Exception $e) {
                Log::error('Webhook Error: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.articles.index')->with('success', 'تم تعديل التحليل بنجاح!');
    }

    public function destroy(Article $article)
    {
        if ($article->image) delete_file($article->image);
        if ($article->meta_image) delete_file($article->meta_image);
        if ($article->policy_paper_file) delete_file($article->policy_paper_file);
        if ($article->strategic_fact_sheets_file) delete_file($article->strategic_fact_sheets_file);
        if ($article->strategic_brief_file) delete_file($article->strategic_brief_file);
        if ($article->analytical_infographic_file) delete_file($article->analytical_infographic_file);
        if ($article->analytical_article_file) delete_file($article->analytical_article_file);

        $article->delete();

        return back()->with('success', 'تم الحذف بنجاح!');
    }

    public function toggleStatus(Request $request, Article $article)
    {
        $request->validate([
            'field' => 'required|in:is_active,is_featured,is_old',
            'state' => 'required|boolean'
        ]);

        $article->update([
            $request->field => $request->state
        ]);

        return response()->json(['success' => true, 'message' => 'تم التحديث بنجاح']);
    }
}
