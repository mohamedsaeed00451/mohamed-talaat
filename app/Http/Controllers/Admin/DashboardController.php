<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Contact;
use App\Models\Subscriber;
use App\Models\VaultFile;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $articlesCount = Article::count();
        $subscribersCount = Subscriber::count();
        $contactsCount = Contact::count();
        $vaultFilesCount = VaultFile::count();
        $latestContacts = Contact::latest()->take(4)->get();
        return view('admin.dashboard', compact(
            'articlesCount',
            'subscribersCount',
            'contactsCount',
            'vaultFilesCount',
            'latestContacts'
        ));
    }
}
