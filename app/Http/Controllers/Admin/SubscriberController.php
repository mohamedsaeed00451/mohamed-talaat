<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubscriberController extends Controller
{
    public function index(): View
    {
        $subscribers = Subscriber::latest()->paginate(10);
        return view('admin.subscribers.index', compact('subscribers'));
    }

    public function destroy(Subscriber $subscriber): RedirectResponse
    {
        $subscriber->delete();
        return back()->with('success', 'تم حذف المشترك بنجاح.');
    }
}
