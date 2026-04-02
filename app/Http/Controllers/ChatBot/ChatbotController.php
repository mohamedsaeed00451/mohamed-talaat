<?php

namespace App\Http\Controllers\ChatBot;

use App\Http\Controllers\Controller;
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

        $systemPrompt = "
        أنت مساعد ذكي اسمك 'طلعت AI'، وتعمل كخدمة عملاء لمنصة 'محمد طلعت'.

        تعليماتك الأساسية:
        1. تحدث بلهجة مصرية احترافية وودودة (مثال: أهلاً بيك يا فندم، تحت أمرك، متشكر جداً).
        2. مهمتك الأساسية هي الإجابة على استفسارات العملاء بخصوص خدمات المنصة.
        3. إذا سألك أحد عن خدماتنا، أخبره أننا نقدم خدمات قانونية واستشارية متكاملة (ويمكنك تفصيلها إذا سأل).
        4. إذا لم تعرف الإجابة أو كان السؤال معقداً، اطلب من العميل ترك رسالة في 'تواصل معنا' أو الاتصال بنا، ولا تؤلف إجابات.
        5. كن مختصراً في إجاباتك ولا تطيل إلا إذا طلب العميل تفاصيل.
        6. لا تجب على أي أسئلة خارج نطاق الاستشارات القانونية أو خدمات الموقع (مثل البرمجة، الطبخ، إلخ)، واعتذر بلطف.
        ";

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
                'بعتذر لحضرتك، في مشكلة تقنية عندي حالياً. يرجى المحاولة بعد قليل أو التواصل معانا من خلال صفحة اتصل بنا.',
                null,
                $e->getMessage()
            );
        }
    }
}
