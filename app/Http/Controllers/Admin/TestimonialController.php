<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

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

        Testimonial::create([
            'text' => [
                'ar' => $request->input('text.ar'),
                'en' => $request->input('text.en'),
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

        $testimonial->update([
            'text' => [
                'ar' => $request->input('text.ar'),
                'en' => $request->input('text.en'),
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
