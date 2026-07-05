<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antique Admin | Tuyệt Phẩm Thời Gian</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        playfair: ['Playfair Display', 'serif'],
                        inter: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        vintage: {
                            50: '#f5f5f4',
                            100: '#e7e5e4',
                            200: '#d6d3d1',
                            700: '#44403c',
                            800: '#292524',
                            900: '#1c1917',
                        },
                        amber: {
                            700: '#b45309',
                            800: '#92400e',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-active { background-color: rgba(180, 83, 9, 0.1); color: #b45309; border-right: 4px solid #b45309; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #d6d3d1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #a8a29e; }

        @keyframes slideIn {
            from { transform: translateX(120%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }
        @keyframes slideOut {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(120%); opacity: 0; }
        }
        .toast-animate-in {
            animation: slideIn 0.3s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
        .toast-animate-out {
            animation: slideOut 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }
    </style>
</head>
<body class="bg-vintage-50 text-vintage-700">
    <!-- Toast Notification Container -->
    <div id="toast-container" class="fixed top-5 right-5 z-[9999] flex flex-col gap-3"></div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-vintage-900 text-stone-300 flex flex-col transform -translate-x-full lg:translate-x-0 lg:sticky lg:top-0 lg:h-screen transition-transform duration-300 ease-in-out shadow-2xl">
            <div class="p-8 border-b border-vintage-800 flex items-center justify-between">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-amber-700 rounded-lg flex items-center justify-center shadow-lg group-hover:bg-amber-600 transition-all">
                        <i data-lucide="crown" class="text-white w-6 h-6"></i>
                    </div>
                    <span class="font-playfair text-xl font-bold text-white tracking-wider">ANTIQUE</span>
                </a>
                <button onclick="toggleSidebar()" class="lg:hidden text-stone-400 hover:text-white">
                    <i data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>

            <nav class="flex-grow p-6 space-y-2 overflow-y-auto">
                <p class="text-[10px] uppercase tracking-[0.2em] text-stone-500 font-bold mb-4 px-4">Menu Chính</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/5 transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-active text-amber-700 font-bold' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    <span>Tổng quan</span>
                </a>

                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-stone-500 font-bold mt-6 mb-2 px-4">Quản lý kho</p>
                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/5 transition-all {{ request()->routeIs('admin.products.*') ? 'sidebar-active text-amber-700 font-bold' : '' }}">
                        <i data-lucide="box" class="w-5 h-5"></i>
                        <span>Sản phẩm</span>
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/5 transition-all {{ request()->routeIs('admin.categories.*') ? 'sidebar-active text-amber-700 font-bold' : '' }}">
                        <i data-lucide="layers" class="w-5 h-5"></i>
                        <span>Danh mục</span>
                    </a>
                </div>

                <div class="space-y-1">
                    <p class="text-[10px] uppercase tracking-[0.2em] text-stone-500 font-bold mt-6 mb-2 px-4">Cấu hình</p>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-4 px-4 py-3 rounded-xl hover:bg-white/5 transition-all {{ request()->routeIs('admin.settings.*') ? 'sidebar-active text-amber-700 font-bold' : '' }}">
                        <i data-lucide="settings" class="w-5 h-5"></i>
                        <span>Cài đặt hệ thống</span>
                    </a>
                </div>
            </nav>

            <div class="p-6 border-t border-vintage-800 space-y-4">
                <div class="flex items-center gap-3 px-4 py-2 rounded-xl bg-vintage-800/50 border border-white/5">
                    <div class="w-10 h-10 rounded-full bg-amber-700/20 border border-amber-700/50 flex items-center justify-center text-amber-700 font-bold">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div class="flex flex-col min-w-0">
                        <span class="text-sm font-bold text-white truncate">{{ Auth::user()->name }}</span>
                        <span class="text-[10px] text-stone-500 truncate">Quản trị viên</span>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.change-password') }}" class="flex-grow flex items-center justify-center gap-2 py-2.5 rounded-lg bg-vintage-800 hover:bg-vintage-700 text-xs transition-all text-white border border-white/5">
                        <i data-lucide="key" class="w-3.5 h-3.5"></i>
                        Mật khẩu
                    </a>
                    <form action="{{ route('admin.logout') }}" method="POST" class="contents">
                        @csrf
                        <button type="submit" class="p-2.5 rounded-lg bg-red-900/20 hover:bg-red-900/40 text-red-400 transition-all border border-red-900/30">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow flex flex-col min-w-0">
            <!-- Header -->
            <header class="h-20 bg-white border-b border-vintage-200 flex items-center justify-between px-6 lg:px-10 sticky top-0 z-30 shadow-sm">
                <div class="flex items-center gap-4">
                    <button onclick="toggleSidebar()" class="lg:hidden p-2 rounded-lg bg-vintage-50 text-vintage-900 hover:bg-vintage-100 transition-all">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                    <div class="hidden sm:flex items-center gap-4 text-stone-400 text-sm">
                        <i data-lucide="home" class="w-4 h-4"></i>
                        <i data-lucide="chevron-right" class="w-4 h-4"></i>
                        <span class="text-vintage-700 font-bold uppercase tracking-widest text-[10px]">@yield('title', 'Dashboard')</span>
                    </div>
                </div>
                <div class="flex items-center gap-6">
                    <a href="/" target="_blank" class="flex items-center gap-2 text-stone-500 hover:text-amber-700 transition-all text-sm font-medium">
                        <i data-lucide="external-link" class="w-4 h-4"></i>
                        <span class="hidden sm:inline">Xem trang chủ</span>
                    </a>
                </div>
            </header>

            <div class="p-4 sm:p-6 lg:p-10">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Sidebar Overlay -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 z-40 hidden lg:hidden"></div>

    <script>
        lucide.createIcons();

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }

        // Global Toast notification helper
        function showToast(message, type = 'success') {
            const container = document.getElementById('toast-container');
            if (!container) return;

            const toast = document.createElement('div');
            
            let bgColor = 'bg-stone-900/95 border-stone-800';
            let iconName = 'info';
            let iconColor = 'text-amber-500';
            let textColor = 'text-stone-300';
            
            if (type === 'success') {
                bgColor = 'bg-emerald-900/95 border-emerald-800';
                iconName = 'check-circle';
                iconColor = 'text-emerald-400';
                textColor = 'text-emerald-50';
            } else if (type === 'error') {
                bgColor = 'bg-red-950/95 border-red-900';
                iconName = 'alert-circle';
                iconColor = 'text-red-400';
                textColor = 'text-red-50';
            }

            toast.className = `flex items-center gap-3 px-4.5 py-3.5 rounded-xl border shadow-xl ${bgColor} text-xs font-semibold max-w-sm toast-animate-in`;
            
            toast.innerHTML = `
                <i data-lucide="${iconName}" class="w-5 h-5 ${iconColor} flex-shrink-0"></i>
                <span class="${textColor} flex-grow">${message}</span>
                <button onclick="this.parentElement.remove()" class="text-stone-400 hover:text-white transition-colors ml-2">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            `;

            container.appendChild(toast);

            if (window.lucide) {
                window.lucide.createIcons({
                    node: toast
                });
            }

            setTimeout(() => {
                toast.classList.remove('toast-animate-in');
                toast.classList.add('toast-animate-out');
                setTimeout(() => {
                    toast.remove();
                }, 500);
            }, 4000);
        }

        // Session toasts trigger on load
        @if(session('success'))
            showToast("{{ session('success') }}", 'success');
        @endif

        @if(session('error'))
            showToast("{{ session('error') }}", 'error');
        @endif
    </script>
    @yield('scripts')
</body>
</html>