<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VaultFile;
use Illuminate\Http\Request;

class VaultFileController extends Controller
{
    public function index()
    {
        $files = VaultFile::latest()->paginate(10);
        return view('admin.vault.index', compact('files'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,rar,txt|max:20480',
        ]);

        $file = $request->file('file');

        $bytes = $file->getSize();
        $size = number_format($bytes / 1048576, 2) . ' MB';

        $path = upload_file($file, 'vault_files');

        VaultFile::create([
            'title' => [
                'ar' => $request->input('title.ar'),
                'en' => $request->input('title.en')
            ],
            'file_path' => $path,
            'file_type' => $file->getClientOriginalExtension(),
            'file_size' => $size,
        ]);

        return back()->with('success', 'تم رفع الملف للخزنة بنجاح!');
    }

    public function destroy(VaultFile $vault)
    {
        if ($vault->file_path) {
            delete_file($vault->file_path);
        }
        $vault->delete();
        return back()->with('success', 'تم حذف الملف من الخزنة بنجاح!');
    }
}
