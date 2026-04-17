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
        if ($request->hasFile('infographic_design_file')) $data['infographic_design_file'] = upload_file($request->file('infographic_design_file'), 'articles/files');
        if ($request->hasFile('interactive_infographic_file')) $data['interactive_infographic_file'] = upload_file($request->file('interactive_infographic_file'), 'articles/files');

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

    public function bulkAiCreate()
    {
        $types = ArticleType::all();
        return view('admin.articles.bulk-ai', compact('types'));
    }

    private function getAiPromptSchema()
    {
        return [
            "task" => "You are an expert strategic content analyzer. Extract data STRICTLY from the provided content.",
            "CRITICAL_INSTRUCTION" => "If the provided content is garbled, unreadable, mostly random symbols, or empty (which happens with scanned PDFs), DO NOT invent, guess, or hallucinate any data. You MUST set the title to 'الملف غير مقروء - يرجى رفعه كصورة' and leave ALL other fields empty or null.",
            "expected_json_format" => [
                "title" => [
                    "ar" => "<استخرج العنوان الرئيسي هنا بالعربية>",
                    "en" => "<Extract the main title here in English>"
                ],
                "subtitle" => [
                    "ar" => "<استخرج العنوان الفرعي هنا بالعربية>",
                    "en" => "<Extract the subtitle here in English>"
                ],
                "description" => [
                    "ar" => "<اكتب الأطروحة المركزية للمقال هنا بالعربية>",
                    "en" => "<Write the central thesis here in English>"
                ],
                "article_body" => [
                    "ar" => "<اكتب متن المقال أو ملخص شامل هنا بالعربية>",
                    "en" => "<Write the coherent body text or summary here in English>"
                ],
                "central_concepts" => [
                    "ar" => "<اذكر المفاهيم المركزية المذكورة في النص هنا بالعربية>",
                    "en" => "<List the main concepts discussed here in English>"
                ],
                "analytical_mechanism" => [
                    "ar" => "<اشرح الآلية التحليلية المستخدمة هنا بالعربية>",
                    "en" => "<Explain the analytical approach used here in English>"
                ],
                "why_it_matters" => [
                    "ar" => "<اشرح لماذا يهم هذا المقال هنا بالعربية>",
                    "en" => "<Explain why this article matters here in English>"
                ],
                "talat_ai_questions" => [
                    "ar" => "س: [اكتب سؤال استراتيجي 1]؟\nج: [اكتب الإجابة]\n\nس: [سؤال 2]؟\nج: [إجابة 2]",
                    "en" => "Q: [Write strategic question 1]?\nA: [Write answer]\n\nQ: [Question 2]?\nA: [Answer 2]"
                ],
                "sovereign_summary" => [
                    "ar" => "<اكتب الخلاصة السيادية هنا بالعربية>",
                    "en" => "<Write the strong concluding summary here in English>"
                ],
                "related_materials" => [
                    "ar" => "<اكتب كلمات مفتاحية مرتبطة بالنص بالعربية>",
                    "en" => "<Write keywords related to the text in English>"
                ],
                "publishing_data_tags" => [
                    "ar" => "<استخرج أي بيانات نشر أو وسوم موجودة في النص بالعربية>",
                    "en" => "<Extract any publication data or tags in English>"
                ],
                "meta_title" => [
                    "ar" => "<عنوان جذاب لمحركات البحث (SEO) لا يتجاوز 60 حرفاً بالعربية>",
                    "en" => "<SEO friendly meta title max 60 characters in English>"
                ],
                "meta_description" => [
                    "ar" => "<وصف جذاب لمحركات البحث (SEO) لا يتجاوز 160 حرفاً بالعربية>",
                    "en" => "<SEO friendly meta description max 160 characters in English>"
                ]
            ]
        ];
    }

    public function bulkProcessSingle(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240',
            'article_type_id' => 'required|exists:article_types,id',
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extractedText = '';
        $aiData = null;

        try {
            if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
                $base64Image = base64_encode(file_get_contents($file->getRealPath()));
                $imageUrl = "data:image/" . $extension . ";base64," . $base64Image;

                $messages = [
                    ["role" => "system", "content" => "You are an expert strategic content analyzer. Return ONLY pure JSON matching the schema."],
                    ["role" => "user", "content" => [
                        ["type" => "text", "text" => json_encode($this->getAiPromptSchema()) . "\n\n--- Original File Name ---\n" . $originalFileName],
                        ["type" => "image_url", "image_url" => ["url" => $imageUrl]]
                    ]]
                ];
                $aiData = $this->executeOpenAICall($messages);

            } elseif ($extension === 'pdf') {
                $pdf = new \Spatie\PdfToImage\Pdf($file->getRealPath());

                $totalPages = method_exists($pdf, 'pageCount') ? $pdf->pageCount() : $pdf->getNumberOfPages();
                $maxPagesToProcess = min($totalPages, 4);

                $visionContent = [
                    ["type" => "text", "text" => json_encode($this->getAiPromptSchema()) . "\n\n--- Original File Name ---\n" . $originalFileName]
                ];

                for ($i = 1; $i <= $maxPagesToProcess; $i++) {
                    $tempPath = sys_get_temp_dir() . '/' . uniqid('pdf_page_') . '.jpg';

                    if (method_exists($pdf, 'selectPage')) {
                        $pdf->selectPage($i)->save($tempPath);
                    } else {
                        $pdf->setPage($i)->saveImage($tempPath);
                    }

                    $base64Image = base64_encode(file_get_contents($tempPath));
                    $visionContent[] = [
                        "type" => "image_url",
                        "image_url" => ["url" => "data:image/jpeg;base64," . $base64Image]
                    ];

                    if (file_exists($tempPath)) {
                        unlink($tempPath);
                    }
                }

                $messages = [
                    ["role" => "system", "content" => "You are an expert strategic content analyzer. Return ONLY pure JSON matching the schema."],
                    ["role" => "user", "content" => $visionContent]
                ];
                $aiData = $this->executeOpenAICall($messages);

            } else {
                if (in_array($extension, ['doc', 'docx'])) {
                    $phpWord = \PhpOffice\PhpWord\IOFactory::load($file->getRealPath());
                    foreach ($phpWord->getSections() as $section) {
                        foreach ($section->getElements() as $element) {
                            if (method_exists($element, 'getText')) {
                                $extractedText .= $element->getText() . " ";
                            }
                        }
                    }
                }

                if (empty(trim($extractedText))) {
                    $extractedText = "[النص غير مقروء. الرجاء الاعتماد على 'اسم الملف الأصلي' وتوليد مسودة مبدئية]";
                }

                $messages = [
                    ["role" => "system", "content" => "You are an expert strategic content analyzer. Return ONLY pure JSON matching the schema."],
                    ["role" => "user", "content" => json_encode($this->getAiPromptSchema()) . "\n\n--- Original File Name ---\n" . $originalFileName . "\n\n--- Content ---\n" . substr($extractedText, 0, 15000)]
                ];
                $aiData = $this->executeOpenAICall($messages);
            }

            if (!$aiData || isset($aiData['error'])) {
                return response()->json(['success' => false, 'error' => $aiData['error'] ?? 'Failed to parse AI response.'], 500);
            }

            $titleAr = trim($aiData['title']['ar'] ?? '');
            $titleEn = trim($aiData['title']['en'] ?? '');

            if (empty($titleAr) || str_contains($titleAr, 'عنوان رئيسي') || str_contains($titleAr, 'غير مقروء')) {
                $titleAr = $originalFileName;
            }
            if (empty($titleEn) || str_contains($titleEn, 'Main Title')) {
                $titleEn = $originalFileName;
            }

            $slugAr = preg_replace('/\s+/u', '-', $titleAr) . '-' . uniqid();
            $slugEn = Str::slug($titleEn) . '-' . uniqid();

            Article::create([
                'article_type_id' => $request->article_type_id,
                'title' => ['ar' => $titleAr, 'en' => $titleEn],
                'subtitle' => $aiData['subtitle'] ?? null,
                'slug' => ['ar' => $slugAr, 'en' => $slugEn],
                'description' => $aiData['description'] ?? null,
                'article_body' => $aiData['article_body'] ?? null,
                'central_concepts' => $aiData['central_concepts'] ?? null,
                'analytical_mechanism' => $aiData['analytical_mechanism'] ?? null,
                'why_it_matters' => $aiData['why_it_matters'] ?? null,
                'talat_ai_questions' => $aiData['talat_ai_questions'] ?? null,
                'sovereign_summary' => $aiData['sovereign_summary'] ?? null,
                'related_materials' => $aiData['related_materials'] ?? null,
                'publishing_data_tags' => $aiData['publishing_data_tags'] ?? null,
                'meta_title' => $aiData['meta_title'] ?? null,
                'meta_description' => $aiData['meta_description'] ?? null,
                'is_active' => false,
                'is_featured' => false,
                'is_old' => false,
                'auto_publish' => false,
            ]);

            return response()->json(['success' => true, 'title' => $titleAr]);

        } catch (\Exception $e) {
            Article::create([
                'article_type_id' => $request->article_type_id,
                'title' => ['ar' => $originalFileName . ' (فشل التحليل)', 'en' => $originalFileName . ' (Failed)'],
                'slug' => ['ar' => uniqid(), 'en' => uniqid()],
                'description' => ['ar' => 'حدث خطأ فني أثناء قراءة هذا الملف.', 'en' => 'Technical error occurred.'],
                'is_active' => false,
            ]);
            return response()->json(['success' => true, 'title' => $originalFileName . ' (تم الحفظ ببيانات ناقصة)']);
        }
    }

    private function executeOpenAICall($messages)
    {
        $response = Http::withToken(env('OPENAI_API_KEY',''))
            ->timeout(120)
            ->post('https://api.openai.com/v1/chat/completions', [
                "model" => "gpt-4o",
                "messages" => $messages,
                "response_format" => ["type" => "json_object"],
                "temperature" => 0.5
            ]);

        if ($response->successful()) {
            $content = $response->json('choices.0.message.content');
            $content = preg_replace('/```json\s*/', '', $content);
            $content = preg_replace('/```/', '', $content);

            $decoded = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }
        }
        return [];
    }
}
