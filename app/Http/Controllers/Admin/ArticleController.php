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
        $request->validate($this->validationRules());

        $data = $request->except(['image', 'meta_image', 'infographic_design_file', 'interactive_infographic_file', 'publish_type']);

        $data = $this->sanitizeTextFields($data, $request);

        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_old'] = $request->has('is_old');
        $data['social_platforms'] = $request->input('social_platforms', []);
        $data['auto_publish'] = count($data['social_platforms']) > 0;

        $data['slug'] = [
            'ar' => preg_replace('/\s+/u', '-', trim($request->input('title.ar'))),
            'en' => Str::slug($request->input('title.en'))
        ];

        $data['published_at'] = $request->publish_type == 'now' ? now() : $request->published_at;

        if ($request->hasFile('image')) $data['image'] = upload_file($request->file('image'), 'articles/images');
        if ($request->hasFile('meta_image')) $data['meta_image'] = upload_file($request->file('meta_image'), 'articles/images/meta');

        if ($request->hasFile('infographic_design_file')) {
            $data['infographic_design_file'] = upload_file($request->file('infographic_design_file'), 'articles/files');
        }
        if ($request->hasFile('interactive_infographic_file')) {
            $data['interactive_infographic_file'] = upload_file($request->file('interactive_infographic_file'), 'articles/files');
        }

        $article = Article::create($data);

        $this->triggerWebhook($article);

        return redirect()->route('admin.articles.index')->with('success', 'تم إضافة التحليل بنجاح!');
    }

    public function edit(Article $article)
    {
        $types = ArticleType::all();
        return view('admin.articles.edit', compact('article', 'types'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate($this->validationRules());

        $data = $request->except(['image', 'meta_image', 'infographic_design_file', 'interactive_infographic_file', 'publish_type']);

        $data = $this->sanitizeTextFields($data, $request);

        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_old'] = $request->has('is_old');
        $data['social_platforms'] = $request->input('social_platforms', []);
        $data['auto_publish'] = count($data['social_platforms']) > 0;

        $data['slug'] = [
            'ar' => preg_replace('/\s+/u', '-', trim($request->input('title.ar'))),
            'en' => Str::slug($request->input('title.en'))
        ];

        $data['published_at'] = $request->publish_type == 'now' ? now() : $request->published_at;

        $files = ['image', 'meta_image', 'infographic_design_file', 'interactive_infographic_file'];

        foreach ($files as $fileKey) {
            if ($request->hasFile($fileKey)) {
                if ($article->$fileKey) delete_file($article->$fileKey);
                $path = in_array($fileKey, ['image', 'meta_image']) ? 'articles/images' : 'articles/files';
                if ($fileKey == 'meta_image') $path = 'articles/images/meta';

                $data[$fileKey] = upload_file($request->file($fileKey), $path);
            }
        }

        $article->update($data);

        $this->triggerWebhook($article);

        return redirect()->route('admin.articles.index')->with('success', 'تم تعديل التحليل بنجاح!');
    }

    public function destroy(Article $article)
    {
        $files = ['image', 'meta_image', 'infographic_design_file', 'interactive_infographic_file'];
        foreach ($files as $fileKey) {
            if ($article->$fileKey) delete_file($article->$fileKey);
        }

        $article->delete();
        return back()->with('success', 'تم الحذف بنجاح!');
    }

    public function toggleStatus(Request $request, Article $article)
    {
        $request->validate([
            'field' => 'required|in:is_active,is_featured,is_old',
            'state' => 'required|boolean'
        ]);

        $article->update([$request->field => $request->state]);
        return response()->json(['success' => true, 'message' => 'تم التحديث بنجاح']);
    }

    private function validationRules()
    {
        return [
            'article_type_id' => 'required|exists:article_types,id',
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'subtitle.ar' => 'nullable|string|max:255',
            'subtitle.en' => 'nullable|string|max:255',
            'description.ar' => 'required|string',
            'description.en' => 'required|string',
            'article_body.ar' => 'nullable|string',
            'article_body.en' => 'nullable|string',
            'central_concepts.ar' => 'nullable|string',
            'central_concepts.en' => 'nullable|string',
            'analytical_mechanism.ar' => 'nullable|string',
            'analytical_mechanism.en' => 'nullable|string',
            'why_it_matters.ar' => 'nullable|string',
            'why_it_matters.en' => 'nullable|string',
            'related_materials.ar' => 'nullable|string',
            'related_materials.en' => 'nullable|string',
            'talat_ai_questions.ar' => 'nullable|string',
            'talat_ai_questions.en' => 'nullable|string',
            'sovereign_summary.ar' => 'nullable|string',
            'sovereign_summary.en' => 'nullable|string',
            'publishing_data_tags.ar' => 'nullable|string',
            'publishing_data_tags.en' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'infographic_design_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'interactive_infographic_file' => 'nullable|file|mimes:pdf,doc,docx|max:10240',
            'meta_title.ar' => 'nullable|string|max:255',
            'meta_title.en' => 'nullable|string|max:255',
            'meta_description.ar' => 'nullable|string',
            'meta_description.en' => 'nullable|string',
            'meta_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'publish_type' => 'required|in:now,schedule',
            'published_at' => 'nullable|required_if:publish_type,schedule|date',
            'social_platforms' => 'nullable|array',
            'social_platforms.*' => 'in:facebook,twitter,instagram,linkedin',
        ];
    }

    private function sanitizeTextFields($data, $request)
    {
        $sanitizerConfig = (new HtmlSanitizerConfig())
            ->allowSafeElements()
            ->allowElement('img', ['src', 'alt', 'title', 'width', 'height', 'style'])
            ->allowElement('a', ['href', 'title', 'target', 'rel'])
            ->allowAttribute('style', '*');

        $sanitizer = new HtmlSanitizer($sanitizerConfig);
        $fields = [
            'description', 'article_body', 'central_concepts', 'analytical_mechanism',
            'why_it_matters', 'related_materials', 'talat_ai_questions',
            'sovereign_summary', 'publishing_data_tags'
        ];

        foreach ($fields as $field) {
            $data[$field] = [
                'ar' => $sanitizer->sanitize($request->input("$field.ar") ?? ''),
                'en' => $sanitizer->sanitize($request->input("$field.en") ?? ''),
            ];
        }

        return $data;
    }

    private function triggerWebhook($article)
    {
        if ($article->auto_publish && $article->published_at <= now() && !$article->social_published) {
            try {
                $articleUrl = config('app.web_site_url') . '/articles/' . $article->slug['ar'];
                $imageUrl = app()->environment('local') ? 'https://picsum.photos/800/600' : ($article->image ? asset($article->image) : null);

                Http::timeout(5)->post(config('app.webhook_url'), [
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
    }
}
