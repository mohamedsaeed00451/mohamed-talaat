<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostCategoryController extends Controller
{
    public function index()
    {
        $categories = PostCategory::latest()->paginate(10);
        return view('admin.post-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
        ]);

        $slugAr = preg_replace('/\s+/u', '-', trim($request->input('name.ar')));
        $slugEn = Str::slug($request->input('name.en'));

        PostCategory::create([
            'name' => [
                'ar' => $request->input('name.ar'),
                'en' => $request->input('name.en')
            ],
            'slug' => [
                'ar' => $slugAr,
                'en' => $slugEn
            ]
        ]);

        return back()->with('success', 'تم إضافة التصنيف بنجاح!');
    }

    public function update(Request $request, PostCategory $postCategory)
    {
        $request->validate([
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
        ]);

        $slugAr = preg_replace('/\s+/u', '-', trim($request->input('name.ar')));
        $slugEn = Str::slug($request->input('name.en'));

        $postCategory->update([
            'name' => [
                'ar' => $request->input('name.ar'),
                'en' => $request->input('name.en')
            ],
            'slug' => [
                'ar' => $slugAr,
                'en' => $slugEn
            ]
        ]);

        return back()->with('success', 'تم تعديل التصنيف بنجاح!');
    }

    public function destroy(PostCategory $postCategory)
    {
        $postCategory->delete();
        return back()->with('success', 'تم حذف التصنيف بنجاح!');
    }
}
