<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\VaultFile;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\Request;

class VaultFileController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $request->validate([
            'password' => 'required|string'
        ]);

        $realPassword = get_setting('vault_password');

        if (!$realPassword || $request->password !== $realPassword) {
            return $this->responseMessage(403, false, 'الرقم السري غير صحيح أو الخزنة مغلقة حالياً.');
        }

        $files = VaultFile::latest()->paginate(10);

        $files->through(function ($file) {
            return [
                'id' => $file->id,
                'title' => $file->title,
                'type' => strtoupper($file->file_type),
                'size' => $file->file_size,
                'download_url' => asset($file->file_path),
                'created_at' => $file->created_at->format('Y-m-d')
            ];
        });

        return $this->responseMessage(200, true, 'تم الدخول للخزنة بنجاح', $files);
    }
}
