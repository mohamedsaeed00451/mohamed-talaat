<?php

use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\SubscriberController;
use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Middleware\ForceJsonResponseMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingController;

Route::middleware([ApiKeyMiddleware::class, ForceJsonResponseMiddleware::class])->group(function () {

    Route::get('/settings', [SettingController::class, 'index']);

    Route::get('/contact-types', [ContactController::class, 'getContactTypes']);
    Route::post('/contact-us', [ContactController::class, 'storeApi']);

    Route::post('/subscribe', [SubscriberController::class, 'storeApi']);

});

