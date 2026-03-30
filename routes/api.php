<?php

use App\Http\Middleware\ApiKeyMiddleware;
use App\Http\Middleware\ForceJsonResponseMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SettingController;

Route::middleware([ApiKeyMiddleware::class, ForceJsonResponseMiddleware::class])->group(function () {

    Route::get('/settings', [SettingController::class, 'index']);

});

