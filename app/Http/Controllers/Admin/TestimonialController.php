<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;
use Symfony\Component\HtmlSanitizer\HtmlSanitizer;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::latest()->paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'text.ar' => 'required|string',
            'text.en' => 'required|string',
        ]);

        $sanitizerConfig = (new HtmlSanitizerConfig())
            ->allowSafeElements()
            ->allowElement('img', ['src', 'alt', 'title', 'width', 'height', 'style'])
            ->allowElement('a', ['href', 'title', 'target', 'rel'])
            ->allowAttribute('style', '*');

        $sanitizer = new HtmlSanitizer($sanitizerConfig);

        Testimonial::create([
            'text' => [
                'ar' => $sanitizer->sanitize($request->input('text.ar')),
                'en' => $sanitizer->sanitize($request->input('text.en')),
            ]
        ]);

        return back()->with('success', 'تم إضافة الاستشهاد بنجاح!');
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $request->validate([
            'text.ar' => 'required|string',
            'text.en' => 'required|string',
        ]);

        $sanitizerConfig = (new HtmlSanitizerConfig())
            ->allowSafeElements()
            ->allowElement('img', ['src', 'alt', 'title', 'width', 'height', 'style'])
            ->allowElement('a', ['href', 'title', 'target', 'rel'])
            ->allowAttribute('style', '*');

        $sanitizer = new HtmlSanitizer($sanitizerConfig);

        $testimonial->update([
            'text' => [
                'ar' => $sanitizer->sanitize($request->input('text.ar')),
                'en' => $sanitizer->sanitize($request->input('text.en')),
            ]
        ]);

        return back()->with('success', 'تم تعديل الاستشهاد بنجاح!');
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return back()->with('success', 'تم حذف الاستشهاد بنجاح!');
    }
}
