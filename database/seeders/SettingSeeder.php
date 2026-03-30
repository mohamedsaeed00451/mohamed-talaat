<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [

            ['key' => 'site_name', 'value' => ['ar' => 'متجر القائد', 'en' => 'Al-Qaed Store']],
            ['key' => 'address', 'value' => ['ar' => 'القاهرة، مدينة نصر', 'en' => 'Cairo, Nasr City']],
            ['key' => 'footer_text', 'value' => ['ar' => 'جميع الحقوق محفوظة © 2026', 'en' => 'All Rights Reserved © 2026']],

            ['key' => 'logo', 'value' => 'uploads/settings/default-logo.png'],
            ['key' => 'footer_logo', 'value' => 'uploads/settings/default-footer.png'],
            ['key' => 'favicon', 'value' => 'uploads/settings/default-favicon.png'],

            ['key' => 'whatsapp', 'value' => '+201000000000'],
            ['key' => 'phone', 'value' => '+201000000000'],

            ['key' => 'social_links', 'value' => [
                'facebook'  => 'https://facebook.com/yourpage',
                'twitter'   => 'https://twitter.com/yourpage',
                'instagram' => 'https://instagram.com/yourpage',
                'linkedin'  => 'https://linkedin.com/in/yourpage',
            ]],

            ['key' => 'slider_1_order', 'value' => '1'],
            ['key' => 'slider_1_title', 'value' => ['ar' => 'أقوى عروض الموسم', 'en' => 'Best Season Offers']],
            ['key' => 'slider_1_desc', 'value' => ['ar' => 'خصومات تصل إلى 50% على جميع المنتجات الإلكترونية', 'en' => 'Up to 50% off on all electronic products']],
            ['key' => 'slider_1_banner', 'value' => 'uploads/settings/slider-1.jpg'],

            ['key' => 'slider_2_order', 'value' => '2'],
            ['key' => 'slider_2_title', 'value' => ['ar' => 'تشكيلة الصيف الجديدة', 'en' => 'New Summer Collection']],
            ['key' => 'slider_2_desc', 'value' => ['ar' => 'اكتشف أحدث الموديلات التي تناسب ذوقك الرفيع', 'en' => 'Discover the latest models that suit your fine taste']],
            ['key' => 'slider_2_banner', 'value' => 'uploads/settings/slider-2.jpg'],

            ['key' => 'slider_3_order', 'value' => '3'],
            ['key' => 'slider_3_title', 'value' => ['ar' => 'شحن مجاني وسريع', 'en' => 'Free & Fast Shipping']],
            ['key' => 'slider_3_desc', 'value' => ['ar' => 'استمتع بشحن مجاني للطلبات التي تزيد عن 100 دولار', 'en' => 'Enjoy free shipping for orders over $100']],
            ['key' => 'slider_3_banner', 'value' => 'uploads/settings/slider-3.jpg'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value']]
            );
        }
    }
}
