<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $data = [
            'title'   => ['ar' => $request->input('title.ar'), 'en' => $request->input('title.en')],
            'slug'    => Str::slug($request->slug),
            'content' => ['ar' => $request->input('content.ar'), 'en' => $request->input('content.en')],
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

        $data['images'] = $imagePaths;

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

        $data = [
            'title'   => ['ar' => $request->input('title.ar'), 'en' => $request->input('title.en')],
            'slug'    => Str::slug($request->slug),
            'content' => ['ar' => $request->input('content.ar'), 'en' => $request->input('content.en')],
        ];

        if ($request->hasFile('pdf_file')) {
            if ($page->pdf_file) delete_file($page->pdf_file);
            $data['pdf_file'] = upload_file($request->file('pdf_file'), 'pages/files');
        }

        $imagePaths = $page->images ?? [];
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

        if ($page->images) {
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
        $images = $page->images ?? [];

        if (($key = array_search($imagePath, $images)) !== false) {
            delete_file($imagePath);
            unset($images[$key]);
            $page->update(['images' => array_values($images)]);
        }

        return back()->with('success', 'تم حذف الصورة بنجاح!');
    }

}
