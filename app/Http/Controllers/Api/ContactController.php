<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactType;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    use ApiResponseTrait;

    public function getContactTypes(): JsonResponse
    {
        $contactTypes = ContactType::all();
        return $this->responseMessage(200, true, 'ContactTypes', $contactTypes);
    }

    public function storeApi(Request $request): JsonResponse
    {
        if ($request->filled('extra_key')) {
            return $this->responseMessage(403, false, 'تم اكتشاف محاولة سبام (Spam Detected)!');
        }

        $request->validate([
            'contact_type_id' => 'required|exists:contact_types,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:5120',
        ]);

        $data = $request->except('attachment');

        if ($request->hasFile('attachment')) {
            $data['attachment'] = upload_file($request->file('attachment'), 'contacts_attachments');
        }

        Contact::create($data);

        return $this->responseMessage(201, true, 'تم إرسال رسالتك بنجاح، سنتواصل معك قريباً.');

    }
}
