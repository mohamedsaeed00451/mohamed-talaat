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
        ]);

        Page::create([
            'title'   => ['ar' => $request->input('title.ar'), 'en' => $request->input('title.en')],
            'slug'    => Str::slug($request->slug),
            'content' => ['ar' => $request->input('content.ar'), 'en' => $request->input('content.en')],
        ]);

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
        ]);

        $page->update([
            'title'   => ['ar' => $request->input('title.ar'), 'en' => $request->input('title.en')],
            'slug'    => Str::slug($request->slug),
            'content' => ['ar' => $request->input('content.ar'), 'en' => $request->input('content.en')],
        ]);

        return redirect()->route('admin.pages.index')->with('success', 'تم تعديل الصفحة بنجاح!');
    }

    public function destroy(Page $page)
    {
        $page->delete();
        return back()->with('success', 'تم حذف الصفحة بنجاح!');
    }
}
