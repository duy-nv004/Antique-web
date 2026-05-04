<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Hiển thị trang cài đặt liên hệ.
     */
    public function index()
    {
        $settings = Setting::all()->keyBy('key');
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Lưu tất cả cài đặt.
     */
    public function update(Request $request)
    {
        $request->validate([
            'zalo_phone'   => 'nullable|string|max:20',
            'facebook_url' => 'nullable|url|max:500',
            'hotline'      => 'nullable|string|max:20',
            'shop_name'    => 'nullable|string|max:255',
            'shop_address' => 'nullable|string|max:500',
            'shop_email'   => 'nullable|email|max:255',
        ]);

        $fields = ['zalo_phone', 'facebook_url', 'hotline', 'shop_name', 'shop_address', 'shop_email'];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                Setting::set($field, $request->input($field));
            }
        }

        return redirect()->route('admin.settings.index')
                         ->with('success', 'Cập nhật cài đặt thành công!');
    }
}
