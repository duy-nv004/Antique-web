<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('login');
    }

    /**
     * Handle login request.
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();
        $remember = (bool) $request->remember;

        if ($this->authService->login($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput($request->only('email'));
    }

    /**
     * Logout.
     */
    public function logout(Request $request)
    {
        $this->authService->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    /**
     * Show change password form.
     */
    public function showChangePasswordForm()
    {
        return view('admin.change-password');
    }

    /**
     * Handle change password request.
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();

        try {
            $this->authService->changePassword($user, $data['current_password'], $data['new_password']);
            return back()->with('success', 'Đổi mật khẩu thành công!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors());
        }
    }
}
