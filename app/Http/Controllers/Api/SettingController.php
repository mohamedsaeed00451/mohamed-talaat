<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request): JsonResponse
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        $formattedSettings = [];
        $sliders = [];

        foreach ($settings as $key => $value) {

            if (preg_match('/^slider_(\d+)_(.+)$/', $key, $matches)) {
                $index = $matches[1];
                $attribute = $matches[2];

                if ($attribute === 'banner') {
                    $value = $value ? asset($value) : null;
                }

                $sliders[$index][$attribute] = $value;
            } elseif (in_array($key, ['logo', 'footer_logo', 'favicon'])) {
                $formattedSettings[$key] = $value ? asset($value) : null;
            } else {
                $formattedSettings[$key] = $value;
            }
        }

        if (!empty($sliders)) {
            usort($sliders, function ($a, $b) {
                return ($a['order'] ?? 0) <=> ($b['order'] ?? 0);
            });
            $formattedSettings['sliders'] = array_values($sliders);
        }

        return $this->responseMessage(200, true, 'Settings retrieved successfully', $formattedSettings);
    }
}
