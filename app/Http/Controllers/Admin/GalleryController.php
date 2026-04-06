<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(10);
        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $imagePaths[] = upload_file($img, 'galleries');
            }
        }

        Gallery::create([
            'title' => ['ar' => $request->input('title.ar'), 'en' => $request->input('title.en')],
            'images' => $imagePaths,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'تم إنشاء الألبوم بنجاح!');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galleries.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $request->validate([
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ]);

        $imagePaths = $gallery->images ?? [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $img) {
                $imagePaths[] = upload_file($img, 'galleries');
            }
        }

        $gallery->update([
            'title' => ['ar' => $request->input('title.ar'), 'en' => $request->input('title.en')],
            'images' => $imagePaths,
        ]);

        return redirect()->route('admin.galleries.index')->with('success', 'تم تعديل الألبوم بنجاح!');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->images) {
            foreach ($gallery->images as $img) {
                delete_file($img);
            }
        }
        $gallery->delete();
        return back()->with('success', 'تم حذف الألبوم بنجاح!');
    }

    public function deleteImage(Request $request, Gallery $gallery)
    {
        $imagePath = $request->input('image_path');
        $images = $gallery->images ?? [];

        if (($key = array_search($imagePath, $images)) !== false) {
            delete_file($imagePath);
            unset($images[$key]);
            $gallery->update(['images' => array_values($images)]);
        }

        return back()->with('success', 'تم حذف الصورة بنجاح!');
    }
}
