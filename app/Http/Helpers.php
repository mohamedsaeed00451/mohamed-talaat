<?php

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

if (!function_exists('upload_file')) {
    function upload_file($file, $folder = 'uploads'): ?string
    {
        if ($file) {
            $fileName = Str::random(20) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/' . $folder), $fileName);
            return 'uploads/' . $folder . '/' . $fileName;
        }
        return null;
    }
}

if (!function_exists('delete_file')) {
    function delete_file($path): bool
    {
        if ($path && file_exists(public_path($path))) {
            return unlink(public_path($path));
        }
        return false;
    }
}

if (!function_exists('get_setting')) {
    function get_setting($key, $default = null)
    {
        $value = Cache::rememberForever("setting.{$key}", function () use ($key) {
            $setting = Setting::where('key', $key)->first();
            return $setting ? $setting->value : null;
        });

        if (is_null($value)) {
            return $default;
        }

        if (is_array($value)) {
            $locale = app()->getLocale();
            return $value[$locale] ?? ($value['en'] ?? $default);
        }

        return $value;
    }
}
