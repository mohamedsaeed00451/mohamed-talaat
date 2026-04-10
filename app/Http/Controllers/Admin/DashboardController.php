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

        $articlesStats = [
            'total' => Article::count(),
            'published' => Article::where('is_active', true)->where('published_at', '<=', now())->count(),
            'scheduled' => Article::where('is_active', true)->where('published_at', '>', now())->count(),
            'featured' => Article::where('is_featured', true)->count(),
            'old' => Article::where('is_old', true)->count(),
        ];

        $socialStats = [
            'facebook' =>
                Post::where('is_active', true)->where('social_published', true)->whereJsonContains('social_platforms', 'facebook')->count() +
                Article::where('is_active', true)->where('social_published', true)->whereJsonContains('social_platforms', 'facebook')->count(),

            'twitter' =>
                Post::where('is_active', true)->where('social_published', true)->whereJsonContains('social_platforms', 'twitter')->count() +
                Article::where('is_active', true)->where('social_published', true)->whereJsonContains('social_platforms', 'twitter')->count(),

            'linkedin' =>
                Post::where('is_active', true)->where('social_published', true)->whereJsonContains('social_platforms', 'linkedin')->count() +
                Article::where('is_active', true)->where('social_published', true)->whereJsonContains('social_platforms', 'linkedin')->count(),

            'instagram' =>
                Post::where('is_active', true)->where('social_published', true)->whereJsonContains('social_platforms', 'instagram')->count() +
                Article::where('is_active', true)->where('social_published', true)->whereJsonContains('social_platforms', 'instagram')->count(),
        ];

        return view('admin.dashboard', compact(
            'postsStats',
            'articlesStats',
            'socialStats',
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
