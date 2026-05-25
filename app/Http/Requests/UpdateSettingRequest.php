<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'zalo_phone'        => 'nullable|string|max:20',
            'facebook_url'      => 'nullable|url|max:500',
            'facebook_fanpage'  => 'nullable|url|max:500',
            'tiktok_url'        => 'nullable|url|max:500',
            'instagram_url'     => 'nullable|url|max:500',
            'hotline'           => 'nullable|string|max:20',
            'shop_name'         => 'nullable|string|max:255',
            'shop_address'      => 'nullable|string|max:500',
            'shop_email'        => 'nullable|email|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'facebook_url.url' => 'Link Facebook Messenger phải đúng định dạng URL',
            'facebook_fanpage.url' => 'Link Facebook Fanpage phải đúng định dạng URL',
            'tiktok_url.url' => 'Link TikTok phải đúng định dạng URL',
            'instagram_url.url' => 'Link Instagram phải đúng định dạng URL',
            'shop_email.email' => 'Địa chỉ email cửa hàng không đúng định dạng',
        ];
    }
}
