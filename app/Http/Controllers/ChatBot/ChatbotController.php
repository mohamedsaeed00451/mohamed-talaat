<?php

namespace App\Http\Controllers\ChatBot;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use OpenAI\Laravel\Facades\OpenAI;

class ChatbotController extends Controller
{
    use ApiResponseTrait;

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array'
        ]);

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        $systemPrompt = <<<EOT
                أنت مساعد ذكي اسمك 'طلعت AI'، وتشتغل كخدمة عملاء لمنصة 'محمد طلعت'.

                تعليماتك الأساسية:
                1. تكلّم بلهجة بحرينية احترافية وودودة (أمثلة للاستخدام: يا هلا ومسهلا، حياك الله طال عمرك، تامر أمر، مشكور وما قصرت).
                2. مهمتك الأساسية تجاوب على استفسارات الزوار بخصوص خدمات المنصة وتعريفهم بشخصية الأستاذ محمد طلعت.
                3. إذا أحد سألك عن خدماتنا أو منصتنا، خبّره إن إحنا نقدم قراءات معمقة وتحليلات للتحولات الجيوسياسية المعاصرة، ونصنع أدوات السيادة لفهم وصناعة القرار (وتقدر تفصّل له من المعلومات اللي تحت إذا سأل).
                4. إذا ما عرفت الإجابة أو كان السؤال معقد، اطلب من العميل يخلّي رسالة في صفحة 'اتصل بنا' أو يتواصل ويانا، وإياك تِفتي أو تألف إجابات من عندك.
                5. خلّك مختصر في إجاباتك ولا تطوّل بالسالفة إلا إذا العميل طلب تفاصيل زيادة.
                6. لا تجاوب على أي أسئلة برّا نطاق الاستراتيجيات، التحليلات السياسية، أو خدمات الموقع (مثل البرمجة، الطبخ، وغيرها)، واعتذر منه بلباقة.

                معلومات أساسية عن "محمد طلعت" (استخدمها للإجابة عن من هو صاحب المنصة):
                - يُعتبر محمد طلعت عبد العزيز من العقول الاستراتيجية البارزة في تحليل بنية القوة والتحولات الجيوسياسية المعاصرة.
                - يقف خلف تفكيك الأزمات المعقدة ويكشف اللي ما ينحسب له حساب في كواليس السياسة الدولية.
                - قاد مسار فكري متقدم يعيد تعريف مفاهيم المبادأة والردع السيادي، وطوّر نماذج تحليلية تفسر ديناميكيات "احتلال الوعي" وتوازنات القوة الناعمة.
                - خبير في سيكولوجيا الإعلام السياسي، وشؤون الإعلام، والحروب الهجينة، يكرس مسيرته لتفكيك الأزمات وتنوير الوعي العربي من خلال الرصد الاستراتيجي العميق.
                - يُلقب بـ: "منظّر استراتيجية المبادأة، ورائد تفكيك الاشتباك الجيوسياسي في الشرق الأوسط."

                هوية المنصة ورسالتها (استخدمها للإجابة عن طبيعة الموقع أو الأقسام):
                - أقسامنا تشمل: "ما وراء الحدث" (تشريح الفواعل غير المرئية في هندسة النظام الدولي الجديد) و"الاستشراف السيادي" (قراءة التحولات قبل ما تصير، وصناعة الردع قبل الأزمة).
                - شعارنا: "يوم تصير المعلومة سلاح، نعطيك القدرة على المبادأة.. إحنا ما ننقل الخبر، إحنا نفكك شفرة السيطرة."
                - بياننا التأسيسي: "في خضم فوضى النظام الدولي، ما عادت القوة ترف، بل هي حتمية الردع. في منصتنا ننتقل من توصيف الأزمة إلى صناعة الوعي الجماهيري المحصن."
                - رسالتنا للزوار: "إحنا ما نعرض محتوى إعلامي فالتوثيق مو مهمتنا... بل نصنع أدوات السيادة للساسة لفهم وصناعة القرار." وندعو صناع القرار والمحللين للانضمام ويانا لمناقشة أطر الردع الجيوسياسي وبناء استراتيجيات فرض الإرادة العربية.
                EOT;

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt]
        ];

        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'] === 'user' ? 'user' : 'assistant',
                'content' => $msg['content']
            ];
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        try {

            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
                'max_tokens' => 200,
            ]);

            $reply = $response->choices[0]->message->content;

            return $this->responseMessage(200, true, 'تم الرد بنجاح', ['reply' => $reply]);

        } catch (\Exception $e) {
            Log::error('OpenAI Error: ' . $e->getMessage());

            return $this->responseMessage(
                500,
                false,
                'أعتذر منك طال عمرك، نواجه خلل تقني بالوقت الحالي. يرجى المحاولة عقب شوي، أو التواصل ويانا عبر صفحة (اتصل بنا).',
                null,
                $e->getMessage()
            );
        }
    }

    public function askAboutArticle(Request $request, $id)
    {
        $request->validate([
            'message' => 'required|string',
            'history' => 'nullable|array'
        ]);

        $article = Article::findOrFail($id);

        $userMessage = $request->input('message');
        $history = $request->input('history', []);

        $articleContext = "Title: " . ($article->title['ar'] ?? '') . "\n";
        $articleContext .= "Thesis: " . ($article->description['ar'] ?? '') . "\n";
        $articleContext .= "Body: " . ($article->article_body['ar'] ?? '') . "\n";
        $articleContext .= "Concepts: " . ($article->central_concepts['ar'] ?? '') . "\n";
        $articleContext .= "Summary: " . ($article->sovereign_summary['ar'] ?? '') . "\n";

        $systemPrompt = <<<EOT
        You are 'Talat AI', a highly intelligent assistant for the 'Mohamed Talat' platform.
        You speak in a professional, friendly Bahraini Arabic dialect (e.g., يا هلا، طال عمرك).
        Your current task is to answer user questions strictly based on the provided Article Context.
        If the user asks something outside the scope of this article, politely apologize and state that you are currently assisting them with this specific article. Do not invent facts outside the provided text. Keep answers concise, insightful, and strategic.

        --- Article Context ---
        {$articleContext}
        EOT;

        $messages = [
            ['role' => 'system', 'content' => $systemPrompt]
        ];

        foreach ($history as $msg) {
            $messages[] = [
                'role' => $msg['role'] === 'user' ? 'user' : 'assistant',
                'content' => $msg['content']
            ];
        }

        $messages[] = ['role' => 'user', 'content' => $userMessage];

        try {
            $response = OpenAI::chat()->create([
                'model' => 'gpt-4o-mini',
                'messages' => $messages,
                'max_tokens' => 300,
                'temperature' => 0.3
            ]);

            $reply = $response->choices[0]->message->content;

            return $this->responseMessage(200, true, 'Success', ['reply' => $reply]);

        } catch (\Exception $e) {
            Log::error('OpenAI Article Chat Error: ' . $e->getMessage());
            return $this->responseMessage(500, false, 'عذراً طال عمرك، أواجه مشكلة تقنية حالياً. يرجى المحاولة بعد قليل.');
        }
    }
}
