<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleType;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleTypeController extends Controller
{
    public function index()
    {
        $types = ArticleType::with('parent')->latest()->paginate(10);
        $parentTypes = ArticleType::whereNull('parent_id')->get();
        return view('admin.article-types.index', compact('types', 'parentTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:article_types,id',
        ]);

        $slugAr = preg_replace('/\s+/u', '-', trim($request->input('name.ar')));
        $slugEn = Str::slug($request->input('name.en'));

        ArticleType::create([
            'name' => [
                'ar' => $request->input('name.ar'),
                'en' => $request->input('name.en')
            ],
            'slug' => [
                'ar' => $slugAr,
                'en' => $slugEn
            ],
            'parent_id' => $request->input('parent_id'),
        ]);

        return back()->with('success', 'تم إضافة التصنيف بنجاح!');
    }

    public function update(Request $request, ArticleType $articleType)
    {
        $request->validate([
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:article_types,id|not_in:' . $articleType->id,
        ]);

        $slugAr = preg_replace('/\s+/u', '-', trim($request->input('name.ar')));
        $slugEn = Str::slug($request->input('name.en'));

        $articleType->update([
            'name' => [
                'ar' => $request->input('name.ar'),
                'en' => $request->input('name.en')
            ],
            'slug' => [
                'ar' => $slugAr,
                'en' => $slugEn
            ],
            'parent_id' => $request->input('parent_id'),
        ]);

        return back()->with('success', 'تم تعديل التصنيف بنجاح!');
    }

    public function destroy(ArticleType $articleType)
    {
        $articleType->delete();
        return back()->with('success', 'تم حذف التصنيف بنجاح!');
    }
}
