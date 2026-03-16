<?php

use App\Http\Middleware\CheckTimeAccess;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\testController;
use App\Http\Controllers\CategoryController;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', function () {
    return redirect()->route('home.index');
});
Route::get('/test', function () {
    // return view('home');
    return response()->json(['message' => 'This is a test route']);
});

Route::prefix('admin')->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('products', ProductController::class);

});
Route::get('login', [AuthController::class, 'showLoginForm'])->name("login");
Route::post('login', [AuthController::class, 'login'])->name("login.post");
Route::get('register', [AuthController::class, 'showRegisterForm'])->name("register");
Route::post('register', [AuthController::class, 'register'])->name("register.post");
Route::fallback(function () {
    return view('errors.404error');
    // return "404 Not Found. The requested route does not exist.";
});
Route::resource('tests', testController::class);
Route::post('session', function (Request $request) {
    // $request->session()->put('key', 'value');
    $name = session()->all();
    return response()->json($name);
})->name('session');
Route::get('age', [AuthController::class, 'showAgeForm'])->name('age');
Route::post('age', [AuthController::class, 'checkAge'])->name('checkAge.post');

Route::get('/admin', function () {
    return view('layout.admin');
});

Route::resource('home', App\Http\Controllers\Client\HomeController::class);
// Route::resource('shop', App\Http\Controllers\Client\ShopController::class);
Route::get('/shop', [App\Http\Controllers\Client\ShopController::class, 'index'])->name('shop.index');



