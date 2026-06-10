<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập | Antique Admin</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        playfair: ['Playfair Display', 'serif'],
                        inter: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="bg-[#1c1917] font-inter min-h-screen flex items-center justify-center p-6 overflow-hidden relative">
    
    <!-- Background Decor -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-amber-700/10 rounded-full blur-[120px] -translate-y-1/2 translate-x-1/2"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-amber-700/10 rounded-full blur-[120px] translate-y-1/2 -translate-x-1/2"></div>

    <div class="max-w-md w-full relative">
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-amber-700 rounded-2xl shadow-2xl mb-6">
                <i data-lucide="crown" class="text-white w-8 h-8"></i>
            </div>
            <h1 class="font-playfair text-4xl font-bold text-white tracking-wider mb-2">ANTIQUE ADMIN</h1>
            <p class="text-stone-500 text-sm tracking-widest uppercase">Quản lý tuyệt phẩm thời gian</p>
        </div>

        <div class="bg-stone-900 border border-white/5 p-8 rounded-3xl shadow-2xl">
            @if($errors->any())
                <div class="mb-6 bg-red-900/20 border border-red-900/50 text-red-400 p-4 rounded-xl text-sm flex items-start gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                    <ul class="list-none m-0 p-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                @csrf
                <div>
                    <label class="block text-stone-400 text-xs font-bold uppercase tracking-widest mb-2 px-1">Email quản trị</label>
                    <div class="relative">
                        <i data-lucide="mail" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-600 w-5 h-5"></i>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-stone-950 border border-white/5 rounded-xl py-4 pl-12 pr-4 text-white focus:ring-2 focus:ring-amber-700 focus:border-transparent transition-all outline-none"
                            placeholder="admin@gmail.com">
                    </div>
                </div>

                <div>
                    <label class="block text-stone-400 text-xs font-bold uppercase tracking-widest mb-2 px-1">Mật khẩu</label>
                    <div class="relative">
                        <i data-lucide="lock" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-600 w-5 h-5"></i>
                        <input type="password" name="password" required
                            class="w-full bg-stone-950 border border-white/5 rounded-xl py-4 pl-12 pr-4 text-white focus:ring-2 focus:ring-amber-700 focus:border-transparent transition-all outline-none"
                            placeholder="••••••••">
                    </div>
                </div>

                <div class="flex items-center justify-between px-1">
                    <label class="flex items-center gap-3 cursor-pointer group">
                        <input type="checkbox" name="remember" class="w-4 h-4 rounded border-white/10 bg-stone-950 text-amber-700 focus:ring-0 focus:ring-offset-0">
                        <span class="text-stone-500 text-sm group-hover:text-stone-300 transition-colors">Ghi nhớ đăng nhập</span>
                    </label>
                </div>

                <button type="submit" class="w-full bg-amber-700 hover:bg-amber-600 text-white font-bold py-4 rounded-xl shadow-xl shadow-amber-900/20 transition-all active:scale-[0.98]">
                    Đăng nhập hệ thống
                </button>
            </form>
        </div>

        <p class="mt-8 text-center text-stone-600 text-xs">
            &copy; {{ date('Y') }} Antique Shop. All rights reserved.
        </p>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>