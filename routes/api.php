<?php

use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\ArticleTypeController;
use App\Http\Controllers\Api\ConferenceController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Controllers\Api\TestimonialController;
use App\Http\Controllers\Api\VaultFileController;
use App\Http\Controllers\ChatBot\ChatbotController;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Middleware\ForceJsonResponseMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingController;

Route::middleware([ApiKeyMiddleware::class, ForceJsonResponseMiddleware::class])->group(function () {

    Route::get('/settings', [SettingController::class, 'index']);

    Route::get('/contact-types', [ContactController::class, 'getContactTypes']);
    Route::post('/contact-us', [ContactController::class, 'storeApi']);

    Route::post('/subscribe', [SubscriberController::class, 'storeApi']);

    Route::get('/testimonials', [TestimonialController::class, 'index']);

    Route::get('/pages', [PageController::class, 'index']);

    Route::post('/chat', [ChatbotController::class, 'chat']);

    Route::post('/vault/access', [VaultFileController::class, 'index']);

    Route::get('/conferences', [ConferenceController::class, 'index']);

    Route::get('/article-types', [ArticleTypeController::class, 'index']);

    Route::get('/articles', [ArticleController::class, 'index']);
    Route::get('articles/{slug}', [ArticleController::class, 'show']);

});

