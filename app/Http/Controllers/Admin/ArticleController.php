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
            'sovereign_meta_bar.ar' => 'nullable|string',
            'sovereign_meta_bar.en' => 'nullable|string',
            'institutional_alignment.ar' => 'nullable|string',
            'institutional_alignment.en' => 'nullable|string',
            'central_hypothesis.ar' => 'nullable|string',
            'central_hypothesis.en' => 'nullable|string',
            'description.ar' => 'required|string',
            'description.en' => 'required|string',
            'article_body.ar' => 'required|string',
            'article_body.en' => 'required|string',
            'strategic_quotations.ar' => 'nullable|string',
            'strategic_quotations.en' => 'nullable|string',
            'actor_deconstruction.ar' => 'nullable|string',
            'actor_deconstruction.en' => 'nullable|string',
            'mechanisms_of_influence.ar' => 'nullable|string',
            'mechanisms_of_influence.en' => 'nullable|string',
            'structural_context.ar' => 'nullable|string',
            'structural_context.en' => 'nullable|string',
            'implications_consequences.ar' => 'nullable|string',
            'implications_consequences.en' => 'nullable|string',
            'strategic_foresight.ar' => 'nullable|string',
            'strategic_foresight.en' => 'nullable|string',
            'central_concepts.ar' => 'required|string',
            'central_concepts.en' => 'required|string',
            'analytical_mechanism.ar' => 'nullable|string',
            'analytical_mechanism.en' => 'nullable|string',
            'references_evidence.ar' => 'nullable|string',
            'references_evidence.en' => 'nullable|string',
            'risk_index_color' => 'nullable|string|max:20',
            'analytical_positioning' => 'nullable|string|max:255',

            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'infographic_design_file' => 'nullable|file|mimes:jpeg,png,jpg,svg,webp|max:10240',
            'interactive_infographic_file' => 'nullable|file|mimes:json,svg,zip,html,mp4,webm,gif|max:20480',
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
            'description', 'article_body', 'strategic_quotations', 'sovereign_meta_bar',
            'institutional_alignment', 'central_hypothesis', 'actor_deconstruction',
            'mechanisms_of_influence', 'structural_context', 'implications_consequences',
            'strategic_foresight', 'central_concepts', 'analytical_mechanism', 'references_evidence'
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
        return view('admin.articles.bulk-ai');
    }

    private function getAiPromptSchema($categoriesListText)
    {
        return [
            "system_role" => "You are an elite strategic content analyzer and senior academic editor. You process articles and elevate them into highly structured, professional analytical reports.",

            "target_subject_directive" => "CRITICAL INSTRUCTION: Analyze the provided text accurately. If the text relates to or mentions 'محمد طلعت عبد العزيز', highlight his vision. IF NOT MENTIONED, DO NOT force his name. Simply analyze the actual events objectively.",

            "available_sub_categories" => $categoriesListText,

            "strict_rules" => "1. Fully bilingual (Arabic + English). 2. CRITICAL: The 'article_body' field MUST contain the FULL, COMPLETE, and COMPREHENSIVE text of the article. STRICTLY NO SUMMARIZATION. You must expand it to 600-650 words per language. 3. To prevent token limits, focus your word count heavily on 'article_body' and keep the remaining fields highly precise and concise.",

            "expected_json_format" => [
                "article_type_id" => "<Select the single most appropriate ID from 'available_sub_categories'. Return ONLY the integer>",
                "title" => ["ar" => "العنوان الرئيسي", "en" => "Main Title"],
                "subtitle" => ["ar" => "العنوان التحليلي", "en" => "Analytical Title"],
                "sovereign_meta_bar" => ["ar" => "القسم – الوحدة – التاريخ – زمن القراءة", "en" => "Section - Unit - Date - Read Time"],
                "institutional_alignment" => ["ar" => "المجال أو التوجه المؤسسي", "en" => "Alignment or Field"],
                "central_hypothesis" => ["ar" => "الفرضية المركزية", "en" => "Central Hypothesis"],
                "description" => ["ar" => "الأطروحة الاستراتيجية (وصف شامل للحالة)", "en" => "Strategic Thesis"],

                "article_body" => [
                    "ar" => "النص الكامل للمقال (ممنوع التلخيص نهائياً! اكتب المحتوى كاملاً بتفصيل دقيق ومطول ليعكس النص الأصلي بكل أفكاره)",
                    "en" => "Full Article Content (STRICTLY NO SUMMARIZATION! Write the complete, detailed, and long content reflecting the original text entirely)"
                ],

                "strategic_quotations" => ["ar" => "المقولات المأثورة (اقتباسات نصية)", "en" => "Direct Quotations"],
                "actor_deconstruction" => ["ar" => "تحليل الفاعلين باختصار", "en" => "Actor Deconstruction"],
                "mechanisms_of_influence" => ["ar" => "آليات التأثير باختصار", "en" => "Mechanisms of Influence"],
                "structural_context" => ["ar" => "السياق البنيوي", "en" => "Structural Context"],
                "implications_consequences" => ["ar" => "النتائج والتداعيات", "en" => "Implications & Consequences"],
                "strategic_foresight" => ["ar" => "الاستشراف المستقبلي", "en" => "Future Foresight"],
                "central_concepts" => ["ar" => "قاموس المصطلحات الأساسية", "en" => "Key Concepts Dictionary"],
                "analytical_mechanism" => ["ar" => "الآلية التحليلية", "en" => "Analytical Mechanism"],
                "why_it_matters" => ["ar" => "الأهمية (لماذا هذا الحدث مهم)", "en" => "Why it matters"],
                "talat_ai_questions" => ["ar" => "س وج حول الموضوع", "en" => "Q&A about the topic"],
                "sovereign_summary" => ["ar" => "خلاصة تحليلية دقيقة", "en" => "Analytical Summary"],
                "references_evidence" => ["ar" => "المصادر أو الأدلة", "en" => "Sources or Evidence"],
                "related_materials" => ["ar" => "الكلمات المفتاحية", "en" => "Keywords"],
                "publishing_data_tags" => ["ar" => "اقتراحات تصميم الإنفوجرافيك", "en" => "Infographic Design Suggestions"],
                "risk_index_color" => "<Pick ONE hex color: #dc2626, #f59e0b, #16a34a>",
                "analytical_positioning" => "<Choose EXACTLY ONE Arabic word: تحذيري OR نقدي OR استباقي OR دفاعي OR إيجابي>",
                "meta_title" => ["ar" => "SEO Title", "en" => "SEO Title"],
                "meta_description" => ["ar" => "SEO Description", "en" => "SEO Description"]
            ]
        ];
    }
    public function bulkProcessSingle(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx,png,jpg,jpeg|max:10240',
        ]);

        $file = $request->file('file');
        $extension = strtolower($file->getClientOriginalExtension());
        $originalFileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $extractedText = '';
        $aiData = null;

        $subCategories = ArticleType::whereNotNull('parent_id')->get();
        if ($subCategories->isEmpty()) {
            $subCategories = ArticleType::all();
        }

        $categoriesListText = $subCategories->map(function ($cat) {
            return "ID: {$cat->id} (Name: {$cat->name['ar']})";
        })->implode(' | ');

        $promptSchema = $this->getAiPromptSchema($categoriesListText);

        try {
            if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
                $base64Image = base64_encode(file_get_contents($file->getRealPath()));
                $imageUrl = "data:image/" . $extension . ";base64," . $base64Image;

                $messages = [
                    ["role" => "system", "content" =>
                        "You are a professional multilingual content editor.
                         Extract text from the provided file and convert it into structured article JSON.
                         Do not add fictional facts.
                         If content is unclear, return null for missing fields.
                         Return ONLY valid JSON."
                    ],
                    ["role" => "user", "content" => [
                        ["type" => "text", "text" => json_encode($promptSchema)],
                        ["type" => "image_url", "image_url" => ["url" => $imageUrl]]
                    ]]
                ];
                $aiData = $this->executeOpenAICall($messages);

            } elseif ($extension === 'pdf') {
                $pdf = new \Spatie\PdfToImage\Pdf($file->getRealPath());
                $totalPages = method_exists($pdf, 'pageCount') ? $pdf->pageCount() : $pdf->getNumberOfPages();
                $maxPagesToProcess = min($totalPages, 1);

                $visionContent = [
                    ["type" => "text", "text" => json_encode($promptSchema)]
                ];

                for ($i = 1; $i <= $maxPagesToProcess; $i++) {
                    $tempPath = sys_get_temp_dir() . '/' . uniqid('pdf_page_') . '.jpg';
                    if (method_exists($pdf, 'selectPage')) {
                        $pdf->selectPage($i)->save($tempPath);
                    } else {
                        $pdf->setPage($i)->saveImage($tempPath);
                    }

                    $base64Image = base64_encode(file_get_contents($tempPath));
                    $visionContent[] = ["type" => "image_url", "image_url" => ["url" => "data:image/jpeg;base64," . $base64Image]];
                    if (file_exists($tempPath)) unlink($tempPath);
                }

                $messages = [
                    ["role" => "system", "content" =>
                        "You are a professional multilingual content editor.
                         Extract text from the provided file and convert it into structured article JSON.
                         Do not add fictional facts.
                         If content is unclear, return null for missing fields.
                         Return ONLY valid JSON."
                    ],
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
                $messages = [
                    ["role" => "system", "content" =>
                        "You are a professional multilingual content editor.
                         Extract text from the provided file and convert it into structured article JSON.
                         Do not add fictional facts.
                         If content is unclear, return null for missing fields.
                         Return ONLY valid JSON."
                    ],
                    ["role" => "user", "content" => json_encode($promptSchema) . "\n\n" . substr($extractedText, 0, 15000)]
                ];
                $aiData = $this->executeOpenAICall($messages);
            }

            if (!$aiData || isset($aiData['error'])) {
                $errorMsg = $aiData['error'] ?? 'فشل في تحليل الرد.';
                if (!empty($aiData['raw_content'])) {
                    $snippet = mb_substr($aiData['raw_content'], -400);
                    $errorMsg .= "\n[التفاصيل المقطوعة من الـ AI]:\n" . $snippet;
                }
                return response()->json(['success' => false, 'error' => $errorMsg], 500);
            }

            $aiCategoryId = $aiData['article_type_id'] ?? null;
            if (!$aiCategoryId || !$subCategories->contains('id', $aiCategoryId)) {
                $aiCategoryId = $subCategories->first()->id;
            }

            $titleAr = trim($aiData['title']['ar'] ?? '');
            $slugAr = preg_replace('/\s+/u', '-', $titleAr) . '-' . uniqid();
            $slugEn = Str::slug($aiData['title']['en'] ?? 'article') . '-' . uniqid();

            Article::create([
                'article_type_id' => $aiCategoryId,
                'title' => ['ar' => $titleAr, 'en' => $aiData['title']['en'] ?? ''],
                'subtitle' => $aiData['subtitle'] ?? null,
                'slug' => ['ar' => $slugAr, 'en' => $slugEn],
                'sovereign_meta_bar' => $aiData['sovereign_meta_bar'] ?? null,
                'institutional_alignment' => $aiData['institutional_alignment'] ?? null,
                'central_hypothesis' => $aiData['central_hypothesis'] ?? null,
                'description' => $aiData['description'] ?? null,
                'article_body' => $aiData['article_body'] ?? null,
                'strategic_quotations' => $aiData['strategic_quotations'] ?? null,
                'actor_deconstruction' => $aiData['actor_deconstruction'] ?? null,
                'mechanisms_of_influence' => $aiData['mechanisms_of_influence'] ?? null,
                'structural_context' => $aiData['structural_context'] ?? null,
                'implications_consequences' => $aiData['implications_consequences'] ?? null,
                'strategic_foresight' => $aiData['strategic_foresight'] ?? null,
                'central_concepts' => $aiData['central_concepts'] ?? null,
                'analytical_mechanism' => $aiData['analytical_mechanism'] ?? null,
                'why_it_matters' => $aiData['why_it_matters'] ?? null,
                'talat_ai_questions' => $aiData['talat_ai_questions'] ?? null,
                'sovereign_summary' => $aiData['sovereign_summary'] ?? null,
                'references_evidence' => $aiData['references_evidence'] ?? null,
                'related_materials' => $aiData['related_materials'] ?? null,
                'publishing_data_tags' => $aiData['publishing_data_tags'] ?? null,
                'risk_index_color' => $aiData['risk_index_color'] ?? null,
                'analytical_positioning' => $aiData['analytical_positioning'] ?? null,
                'meta_title' => $aiData['meta_title'] ?? null,
                'meta_description' => $aiData['meta_description'] ?? null,
                'is_active' => false,
                'is_featured' => false,
                'is_old' => false,
                'auto_publish' => false,
            ]);

            return response()->json(['success' => true, 'title' => $titleAr]);

        } catch (\Exception $e) {
            Log::error('System Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'خطأ داخلي في النظام: ' . $e->getMessage()
            ], 500);
        }
    }

    private function executeOpenAICall($messages)
    {
        $response = Http::withToken(env('OPENAI_API_KEY', ''))
            ->timeout(240)
            ->post('https://api.openai.com/v1/chat/completions', [
                "model" => "gpt-4o",
                "messages" => $messages,
                "response_format" => ["type" => "json_object"],
                "temperature" => 0.5,
                "max_tokens" => 16384
            ]);

        if ($response->successful()) {
            $refusal = $response->json('choices.0.message.refusal');
            if (!empty($refusal)) {
                Log::warning('First attempt refused, retrying with simplified prompt');
                $retryResponse = Http::withToken(env('OPENAI_API_KEY'))
                    ->timeout(240)
                    ->post('https://api.openai.com/v1/chat/completions', [
                        "model" => "gpt-4o",
                        "messages" => [
                            [
                                "role"=>"system",
                                "content"=>"Extract article information and return valid JSON only."
                            ],
                            [
                                "role"=>"user",
                                "content"=>"Analyze this content objectively."
                            ]
                        ],
                        "response_format"=>[
                            "type"=>"json_object"
                        ]
                    ]);

                if($retryResponse->successful()){
                    return json_decode(
                        $retryResponse->json('choices.0.message.content'),
                        true
                    );
                }
            }

            $content = $response->json('choices.0.message.content');

            if (empty($content)) {
                return [
                    'error' => 'الذكاء الاصطناعي أرجع رداً فارغاً.',
                    'raw_content' => $response->body()
                ];
            }

//            Log::info('OpenAI Complete Response Body: ' . $response->body());

            if (preg_match('/\{[\s\S]*\}/', $content, $matches)) {
                $content = $matches[0];
            }
            $decoded = json_decode($content, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                return $decoded;
            }

            Log::error('AI Output Truncated: ' . $content);
            return [
                'error' => 'الـ JSON مقطوع.',
                'raw_content' => $content
            ];
        }

        Log::error('OpenAI Request Failed: ' . $response->body());
        return [
            'error' => 'سيرفر OpenAI رفض الطلب (كود ' . $response->status() . ').',
            'raw_content' => $response->body()
        ];
    }
}
