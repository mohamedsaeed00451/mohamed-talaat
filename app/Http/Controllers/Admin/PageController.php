<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::latest()->paginate(10);
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        return view('admin.pages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'slug'     => 'required|string|max:255|unique:pages,slug',
            'content.ar' => 'required|string',
            'content.en' => 'required|string',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $sanitizerConfig = (new HtmlSanitizerConfig())
            ->allowSafeElements()
            ->allowElement('img', ['src', 'alt', 'title', 'width', 'height', 'style'])
            ->allowElement('a', ['href', 'title', 'target', 'rel'])
            ->allowAttribute('style', '*');

        $sanitizer = new HtmlSanitizer($sanitizerConfig);

        $data = [
            'title'   => [
                'ar' => $request->input('title.ar'),
                'en' => $request->input('title.en')
            ],
            'slug'    => Str::slug($request->slug),
            'content' => [
                'ar' => $sanitizer->sanitize($request->input('content.ar')),
                'en' => $sanitizer->sanitize($request->input('content.en'))
            ],
        ];

        if ($request->hasFile('pdf_file')) {
            $data['pdf_file'] = upload_file($request->file('pdf_file'), 'pages/files');
        }

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $imagePaths[] = upload_file($img, 'pages/images');
            }
        }

        if (!empty($imagePaths)) {
            $data['images'] = $imagePaths;
        }

        Page::create($data);

        return redirect()->route('admin.pages.index')->with('success', 'تم إنشاء الصفحة بنجاح!');
    }

    public function edit(Page $page)
    {
        return view('admin.pages.edit', compact('page'));
    }

    public function update(Request $request, Page $page)
    {
        $request->validate([
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'slug'     => 'required|string|max:255|unique:pages,slug,' . $page->id,
            'content.ar' => 'required|string',
            'content.en' => 'required|string',
            'pdf_file' => 'nullable|mimes:pdf|max:10240',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $sanitizerConfig = (new HtmlSanitizerConfig())
            ->allowSafeElements()
            ->allowElement('img', ['src', 'alt', 'title', 'width', 'height', 'style'])
            ->allowElement('a', ['href', 'title', 'target', 'rel'])
            ->allowAttribute('style', '*');

        $sanitizer = new HtmlSanitizer($sanitizerConfig);

        $data = [
            'title'   => [
                'ar' => $request->input('title.ar'),
                'en' => $request->input('title.en')
            ],
            'slug'    => Str::slug($request->slug),
            'content' => [
                'ar' => $sanitizer->sanitize($request->input('content.ar')),
                'en' => $sanitizer->sanitize($request->input('content.en'))
            ],
        ];

        if ($request->hasFile('pdf_file')) {
            if ($page->pdf_file) delete_file($page->pdf_file);
            $data['pdf_file'] = upload_file($request->file('pdf_file'), 'pages/files');
        }

        $imagePaths = is_array($page->images) ? $page->images : [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $imagePaths[] = upload_file($img, 'pages/images');
            }
        }

        $data['images'] = $imagePaths;

        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'تم تعديل الصفحة بنجاح!');
    }

    public function destroy(Page $page)
    {
        if ($page->pdf_file) delete_file($page->pdf_file);

        if (is_array($page->images)) {
            foreach ($page->images as $img) {
                delete_file($img);
            }
        }

        $page->delete();
        return back()->with('success', 'تم حذف الصفحة بنجاح!');
    }

    public function deleteImage(Request $request, Page $page)
    {
        $imagePath = $request->input('image_path');
        $images = is_array($page->images) ? $page->images : [];

        if (($key = array_search($imagePath, $images)) !== false) {
            delete_file($imagePath);
            unset($images[$key]);
            $page->update(['images' => array_values($images)]);
        }

        return back()->with('success', 'تم حذف الصورة بنجاح!');
    }
}
