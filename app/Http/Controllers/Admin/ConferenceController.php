<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conference;
use Illuminate\Http\Request;

class ConferenceController extends Controller
{
    public function index()
    {
        $conferences = Conference::latest()->paginate(10);
        return view('admin.conferences.index', compact('conferences'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'video_url' => 'required|url',
            'platform' => 'required|string|in:youtube,facebook,instagram,tiktok,other',
        ]);

        Conference::create([
            'title' => [
                'ar' => $request->input('title.ar'),
                'en' => $request->input('title.en')
            ],
            'video_url' => $request->video_url,
            'platform' => $request->platform,
        ]);

        return back()->with('success', 'تم إضافة المقابلة/المؤتمر بنجاح!');
    }

    public function update(Request $request, Conference $conference)
    {
        $request->validate([
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'video_url' => 'required|url',
            'platform' => 'required|string|in:youtube,facebook,instagram,tiktok,other',
        ]);

        $conference->update([
            'title' => [
                'ar' => $request->input('title.ar'),
                'en' => $request->input('title.en')
            ],
            'video_url' => $request->video_url,
            'platform' => $request->platform,
        ]);

        return back()->with('success', 'تم تعديل اللقاء بنجاح!');
    }

    public function destroy(Conference $conference)
    {
        $conference->delete();
        return back()->with('success', 'تم الحذف بنجاح!');
    }
}
