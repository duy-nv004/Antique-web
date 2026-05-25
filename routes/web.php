<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AuthController;

// =====================================================================
// AUTH ADMIN
// =====================================================================
Route::get('admin/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('admin/login', [AuthController::class, 'login'])->name('login.post');

// =====================================================================
// ADMIN ROUTES — Quản trị (cần auth admin)
// =====================================================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

    // Cài đặt liên hệ (Settings)
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

    // Đổi mật khẩu
    Route::get('change-password', [AuthController::class, 'showChangePasswordForm'])->name('change-password');
    Route::post('change-password', [AuthController::class, 'changePassword'])->name('change-password.post');

    // Logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', function () {
        return view('admin.dashboard');
    })->name('dashboard');
});

// =====================================================================
// API ROUTES — Dùng cho React Frontend
// =====================================================================
Route::prefix('api')->group(function () {
    // Products
    Route::get('/products', [App\Http\Controllers\Api\ProductController::class, 'index']);
    Route::get('/products/{id}', [App\Http\Controllers\Api\ProductController::class, 'show']);
    Route::post('/contact-click', [App\Http\Controllers\Api\ProductController::class, 'recordClick']);

    // Categories
    Route::get('/categories', function () {
        return response()->json(\App\Models\Category::where('is_active', 1)->get());
    });

    // Settings
    Route::get('/settings', function () {
        return response()->json(\App\Models\Setting::allAsArray());
    });
});

// =====================================================================
// CLIENT ROUTES — Tất cả điều hướng cho React SPA
// =====================================================================
Route::get('/{any}', function () {
    return view('layout.react');
})->where('any', '^(?!api|admin).*$');

Route::get('/', function () {
    return view('layout.react');
});
