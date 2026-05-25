<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateSettingRequest;
use App\Services\SettingService;

class SettingController extends Controller
{
    protected $settingService;

    public function __construct(SettingService $settingService)
    {
        $this->settingService = $settingService;
    }

    /**
     * Hiển thị trang cài đặt liên hệ.
     */
    public function index()
    {
        $settings = $this->settingService->getAllSettings();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Lưu tất cả cài đặt.
     */
    public function update(UpdateSettingRequest $request)
    {
        $this->settingService->updateSettings($request->validated());

        return redirect()->route('admin.settings.index')
                         ->with('success', 'Cập nhật cài đặt thành công!');
    }
}

