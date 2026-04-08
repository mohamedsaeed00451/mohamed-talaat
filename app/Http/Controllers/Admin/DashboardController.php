<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Post;
use App\Models\Gallery;
use App\Models\Podcast;
use App\Models\Conference;
use App\Models\Contact;
use App\Models\Subscriber;
use App\Models\VaultFile;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $articlesCount = Article::count();
        $vaultFilesCount = VaultFile::count();
        $galleriesCount = Gallery::count();
        $podcastsCount = Podcast::count();
        $conferencesCount = Conference::count();
        $contactsCount = Contact::count();
        $subscribersCount = Subscriber::count();
        $latestContacts = Contact::latest()->take(4)->get();

        $postsStats = [
            'total' => Post::count(),
            'published' => Post::where('is_active', true)->where('published_at', '<=', now())->count(),
            'scheduled' => Post::where('is_active', true)->where('published_at', '>', now())->count(),
            'featured' => Post::where('is_featured', true)->count(),
            'old' => Post::where('is_old', true)->count(),
        ];

        return view('admin.dashboard', compact(
            'articlesCount',
            'postsStats',
            'vaultFilesCount',
            'galleriesCount',
            'podcastsCount',
            'conferencesCount',
            'contactsCount',
            'subscribersCount',
            'latestContacts'
        ));
    }
}
