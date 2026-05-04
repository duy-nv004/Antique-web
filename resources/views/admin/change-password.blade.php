@extends('layout.admin')

@section('title', 'Đổi mật khẩu')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-10 text-center">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-vintage-900 rounded-2xl shadow-xl mb-6">
            <i data-lucide="shield-check" class="text-amber-700 w-8 h-8"></i>
        </div>
        <h1 class="font-playfair text-3xl font-bold text-vintage-900">Bảo mật Tài khoản</h1>
        <p class="text-stone-500 text-sm mt-2">Cập nhật mật khẩu để bảo vệ quyền quản trị viên</p>
    </div>

    @if($errors->any())
        <div class="mb-8 bg-red-50 border border-red-100 text-red-700 p-6 rounded-2xl flex items-start gap-4">
            <i data-lucide="alert-circle" class="w-6 h-6 shrink-0"></i>
            <ul class="list-none m-0 p-0 text-sm font-medium">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="bg-white rounded-3xl p-10 shadow-sm border border-vintage-200">
        <form action="{{ route('admin.change-password.post') }}" method="POST" class="space-y-6">
            @csrf
            
            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Mật khẩu hiện tại</label>
                <div class="relative">
                    <i data-lucide="key" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-300 w-5 h-5"></i>
                    <input type="password" name="current_password" required
                        class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-medium"
                        placeholder="Nhập mật khẩu đang sử dụng">
                </div>
            </div>

            <hr class="border-vintage-100 my-8">

            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Mật khẩu mới</label>
                <div class="relative">
                    <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-300 w-5 h-5"></i>
                    <input type="password" name="new_password" required
                        class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-medium"
                        placeholder="Tối thiểu 8 ký tự">
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Xác nhận mật khẩu mới</label>
                <div class="relative">
                    <i data-lucide="check-circle-2" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-300 w-5 h-5"></i>
                    <input type="password" name="new_password_confirmation" required
                        class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-4 pl-12 pr-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-medium"
                        placeholder="Nhập lại mật khẩu mới">
                </div>
            </div>

            <button type="submit" class="w-full bg-vintage-900 hover:bg-black text-white font-bold py-4 rounded-xl shadow-xl shadow-stone-900/10 transition-all flex items-center justify-center gap-3 mt-4">
                <i data-lucide="save" class="w-5 h-5 text-amber-700"></i>
                Cập nhật mật khẩu ngay
            </button>
        </form>
    </div>
    
    <div class="mt-8 text-center">
        <a href="{{ route('admin.dashboard') }}" class="text-stone-400 hover:text-stone-600 text-xs font-bold uppercase tracking-widest transition-colors">Quay lại trang chính</a>
    </div>
</div>
@endsection
