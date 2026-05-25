<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $defaults = [
            [
                'key'   => 'zalo_phone',
                'value' => '0985408685',
                'label' => 'Số điện thoại Zalo',
            ],
            [
                'key'   => 'facebook_url',
                'value' => 'https://m.me/yourpage',
                'label' => 'Link Facebook Messenger',
            ],
            [
                'key'   => 'facebook_fanpage',
                'value' => 'https://facebook.com/yourpage',
                'label' => 'Link Facebook Fanpage',
            ],
            [
                'key'   => 'tiktok_url',
                'value' => 'https://tiktok.com/@yourpage',
                'label' => 'Link TikTok',
            ],
            [
                'key'   => 'instagram_url',
                'value' => 'https://instagram.com/yourpage',
                'label' => 'Link Instagram',
            ],
            [
                'key'   => 'hotline',
                'value' => '0985408685',
                'label' => 'Số Hotline',
            ],
            [
                'key'   => 'shop_name',
                'value' => 'Đồ Cổ Antique',
                'label' => 'Tên cửa hàng',
            ],
            [
                'key'   => 'shop_address',
                'value' => '123 Đường ABC, Hà Nội',
                'label' => 'Địa chỉ cửa hàng',
            ],
            [
                'key'   => 'shop_email',
                'value' => 'antique_shop@gmail.com',
                'label' => 'Email cửa hàng',
            ],
        ];

        foreach ($defaults as $setting) {
            Setting::firstOrCreate(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'label' => $setting['label']]
            );
        }
    }
}
