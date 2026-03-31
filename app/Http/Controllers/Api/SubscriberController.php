<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriberController extends Controller
{
    use ApiResponseTrait;

    public function storeApi(Request $request): JsonResponse
    {
        if ($request->filled('extra_key')) {
            return $this->responseMessage(403, false, 'تم اكتشاف محاولة سبام (Spam Detected)!');
        }

        $request->validate([
            'email' => 'required|email|unique:subscribers,email|max:255',
        ], [
            'email.unique' => 'هذا البريد الإلكتروني مسجل لدينا بالفعل.'
        ]);

        Subscriber::create(['email' => $request->email]);

        return $this->responseMessage(201, true, 'تم الاشتراك في القائمة البريدية بنجاح!');

    }
}
