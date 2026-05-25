<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Collection;

class SettingService
{
    /**
     * Get all settings keyed by key.
     */
    public function getAllSettings(): Collection
    {
        return Setting::all()->keyBy('key');
    }

    /**
     * Update settings.
     */
    public function updateSettings(array $data): void
    {
        $fields = [
            'zalo_phone',
            'facebook_url',
            'facebook_fanpage',
            'tiktok_url',
            'instagram_url',
            'hotline',
            'shop_name',
            'shop_address',
            'shop_email'
        ];

        foreach ($fields as $field) {
            if (array_key_exists($field, $data)) {
                Setting::set($field, $data[$field]);
            }
        }
    }
}
