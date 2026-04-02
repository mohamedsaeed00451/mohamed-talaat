<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ArticleType;
use Illuminate\Http\Request;

class ArticleTypeController extends Controller
{
    public function index()
    {
        $types = ArticleType::latest()->paginate(10);
        return view('admin.article-types.index', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
        ]);

        ArticleType::create([
            'name' => [
                'ar' => $request->input('name.ar'),
                'en' => $request->input('name.en')
            ]
        ]);

        return back()->with('success', 'تم إضافة النوع بنجاح!');
    }

    public function update(Request $request, ArticleType $articleType)
    {
        $request->validate([
            'name.ar' => 'required|string|max:255',
            'name.en' => 'required|string|max:255',
        ]);

        $articleType->update([
            'name' => [
                'ar' => $request->input('name.ar'),
                'en' => $request->input('name.en')
            ]
        ]);

        return back()->with('success', 'تم تعديل النوع بنجاح!');
    }

    public function destroy(ArticleType $articleType)
    {
        $articleType->delete();
        return back()->with('success', 'تم حذف النوع بنجاح!');
    }
}
