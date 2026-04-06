<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Podcast;
use Illuminate\Http\Request;

class PodcastController extends Controller
{
    public function index()
    {
        $podcasts = Podcast::latest()->paginate(10);
        return view('admin.podcasts.index', compact('podcasts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'description.en' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video_url' => 'required|url',
            'platform' => 'required|string|in:youtube,facebook,instagram,tiktok,other',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            $data['image'] = upload_file($request->file('image'), 'podcasts');
        }

        Podcast::create($data);

        return back()->with('success', 'تم إضافة البودكاست بنجاح!');
    }

    public function update(Request $request, Podcast $podcast)
    {
        $request->validate([
            'title.ar' => 'required|string|max:255',
            'title.en' => 'required|string|max:255',
            'description.ar' => 'required|string',
            'description.en' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'video_url' => 'required|url',
            'platform' => 'required|string|in:youtube,facebook,instagram,tiktok,other',
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            if ($podcast->image) delete_file($podcast->image);
            $data['image'] = upload_file($request->file('image'), 'podcasts');
        }

        $podcast->update($data);

        return back()->with('success', 'تم تعديل البودكاست بنجاح!');
    }

    public function destroy(Podcast $podcast)
    {
        if ($podcast->image) delete_file($podcast->image);
        $podcast->delete();

        return back()->with('success', 'تم الحذف بنجاح!');
    }
}
