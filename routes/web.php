<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\ArticleTypeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ConferenceController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ContactTypeController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PodcastController;
use App\Http\Controllers\Admin\PostCategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\VaultFileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('admin.login');
});
Route::get('/admin', function () {
    return redirect()->route('admin.login');
});

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AuthController::class, 'login']);
    });

    Route::middleware('auth')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

        Route::resource('contact-types', ContactTypeController::class)->except(['show']);

        Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
        Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
        Route::post('contacts/{contact}/toggle-read', [ContactController::class, 'toggleRead'])->name('contacts.toggle-read');

        Route::resource('subscribers', SubscriberController::class)->only(['index', 'destroy']);

        Route::resource('testimonials', TestimonialController::class)->except(['create', 'show', 'edit']);

        Route::resource('pages', PageController::class)->except(['show']);
        Route::delete('pages/{page}/delete-image', [PageController::class, 'deleteImage'])->name('pages.deleteImage');

        Route::resource('vault', VaultFileController::class)->only(['index', 'store', 'destroy']);

        Route::resource('conferences', ConferenceController::class)->except(['create', 'show', 'edit']);

        Route::resource('article-types', ArticleTypeController::class)->except(['create', 'show', 'edit']);

        Route::get('/articles/bulk-ai', [ArticleController::class, 'bulkAiCreate'])->name('articles.bulk-ai');
        Route::post('/articles/bulk-process', [ArticleController::class, 'bulkProcessSingle'])->name('articles.bulk-process');
        Route::post('/articles/{article}/toggle', [ArticleController::class, 'toggleStatus'])->name('articles.toggle');
        Route::resource('articles', ArticleController::class)->except(['show']);

        Route::resource('galleries', GalleryController::class)->except(['show']);
        Route::delete('galleries/{gallery}/delete-image', [GalleryController::class, 'deleteImage'])->name('galleries.deleteImage');

        Route::resource('post-categories', PostCategoryController::class)->except(['create', 'show', 'edit']);

        Route::resource('posts', PostController::class);
        Route::post('posts/{post}/toggle', [PostController::class, 'toggleStatus'])->name('posts.toggle');

        Route::resource('podcasts', PodcastController::class)->except(['create', 'show', 'edit']);

    });

});
