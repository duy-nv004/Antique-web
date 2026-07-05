@extends('layout.admin')

@section('title', 'Bảng điều khiển')

@section('content')
<div class="flex flex-col gap-10">
    <!-- Welcome Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="font-playfair text-4xl font-bold text-vintage-900">Xin chào, {{ Auth::user()->name }}</h1>
            <p class="text-stone-500 mt-2">Chào mừng bạn trở lại không gian quản trị tuyệt phẩm Antique.</p>
        </div>
        <div class="flex items-center gap-4 bg-white p-4 rounded-2xl border border-vintage-200 shadow-sm">
            <div class="w-12 h-12 bg-amber-50 rounded-xl flex items-center justify-center text-amber-700">
                <i data-lucide="calendar" class="w-6 h-6"></i>
            </div>
            <div>
                <p class="text-[10px] uppercase tracking-widest font-bold text-stone-400">Ngày hôm nay</p>
                <p class="font-bold text-vintage-900">{{ date('d/m/Y') }}</p>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white p-8 rounded-3xl border border-vintage-200 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-start justify-between mb-6">
                <div class="w-14 h-14 bg-amber-50 text-amber-700 rounded-2xl flex items-center justify-center group-hover:bg-amber-700 group-hover:text-white transition-all">
                    <i data-lucide="box" class="w-7 h-7"></i>
                </div>
                <div class="text-right">
                    <p class="text-stone-500 text-sm font-medium mb-1">Tổng sản phẩm</p>
                    <h3 class="font-playfair text-4xl font-bold text-vintage-900">{{ \App\Models\Product::count() }}</h3>
                </div>
            </div>
            <div class="pt-4 border-t border-vintage-100 flex items-center justify-between text-xs text-stone-400">
                <span>Kho vật phẩm hiện tại</span>
                <a href="{{ route('admin.products.index') }}" class="text-amber-700 font-bold hover:underline">Quản lý kho</a>
            </div>
        </div>

        <div class="bg-white p-8 rounded-3xl border border-vintage-200 shadow-sm hover:shadow-md transition-all group">
            <div class="flex items-start justify-between mb-6">
                <div class="w-14 h-14 bg-stone-100 text-vintage-700 rounded-2xl flex items-center justify-center group-hover:bg-vintage-900 group-hover:text-white transition-all">
                    <i data-lucide="layers" class="w-7 h-7"></i>
                </div>
                <div class="text-right">
                    <p class="text-stone-500 text-sm font-medium mb-1">Danh mục bộ sưu tập</p>
                    <h3 class="font-playfair text-4xl font-bold text-vintage-900">{{ \App\Models\Category::count() }}</h3>
                </div>
            </div>
            <div class="pt-4 border-t border-vintage-100 flex items-center justify-between text-xs text-stone-400">
                <span>Phân loại tuyệt phẩm</span>
                <a href="{{ route('admin.categories.index') }}" class="text-amber-700 font-bold hover:underline">Xem danh sách</a>
            </div>
        </div>
    </div>

    <!-- Recent Activity & Chart Placeholder -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <div class="lg:col-span-8 bg-white p-10 rounded-3xl border border-vintage-200 shadow-sm">
            <div class="flex items-center justify-between mb-10">
                <h3 class="font-playfair text-2xl font-bold text-vintage-900 italic">Sản phẩm mới thêm gần đây</h3>
                <a href="{{ route('admin.products.index') }}" class="text-amber-700 font-bold text-xs uppercase tracking-widest hover:text-amber-800">Xem tất cả</a>
            </div>
            
            <div class="space-y-6">
                @foreach(\App\Models\Product::latest()->take(5)->get() as $p)
                <div class="flex items-center justify-between p-4 rounded-2xl hover:bg-vintage-50 transition-all border border-transparent hover:border-vintage-100">
                    <div class="flex items-center gap-4">
                        <div class="w-14 h-14 rounded-xl overflow-hidden bg-stone-100 border border-vintage-100">
                            @php $img = $p->images->where('is_main', 1)->first(); @endphp
                            @if($img)
                                <img src="{{ str_starts_with($img->image_path, 'http') ? $img->image_path : asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-stone-300">
                                    <i data-lucide="image" class="w-5 h-5"></i>
                                </div>
                            @endif
                        </div>
                        <div>
                            <p class="font-bold text-vintage-900">{{ $p->name }}</p>
                            <p class="text-xs text-stone-400">{{ $p->created_at->diffForHumans() }} • {{ $p->category->name ?? 'Uncategorized' }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="font-bold text-vintage-900">{{ $p->price ? number_format($p->price) . ' ₫' : 'Liên hệ' }}</p>
                        <span class="text-[9px] font-bold uppercase tracking-widest text-emerald-500">Active</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="lg:col-span-4 space-y-8">
            <div class="bg-vintage-900 p-8 rounded-3xl shadow-xl shadow-stone-900/10 text-white">
                <div class="flex items-center gap-3 text-amber-700 mb-6">
                    <i data-lucide="zap" class="w-6 h-6"></i>
                    <h3 class="font-playfair text-xl font-bold italic">Thao tác nhanh</h3>
                </div>
                <div class="space-y-3">
                    <a href="{{ route('admin.products.create') }}" class="flex items-center gap-3 w-full bg-white/5 hover:bg-white/10 p-4 rounded-xl border border-white/5 transition-all group">
                        <div class="w-8 h-8 rounded-lg bg-amber-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="plus" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="text-sm font-medium">Thêm sản phẩm mới</span>
                    </a>
                    <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-3 w-full bg-white/5 hover:bg-white/10 p-4 rounded-xl border border-white/5 transition-all group">
                        <div class="w-8 h-8 rounded-lg bg-vintage-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="folder-plus" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="text-sm font-medium">Tạo danh mục mới</span>
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="flex items-center gap-3 w-full bg-white/5 hover:bg-white/10 p-4 rounded-xl border border-white/5 transition-all group">
                        <div class="w-8 h-8 rounded-lg bg-stone-700 flex items-center justify-center group-hover:scale-110 transition-transform">
                            <i data-lucide="settings" class="w-4 h-4 text-white"></i>
                        </div>
                        <span class="text-sm font-medium">Cấu hình liên hệ</span>
                    </a>
                </div>
            </div>

            <div class="bg-amber-50 p-8 rounded-3xl border border-amber-100 relative overflow-hidden group">
                <i data-lucide="quote" class="absolute -right-4 -bottom-4 w-32 h-32 text-amber-200/50 -rotate-12"></i>
                <h4 class="font-playfair text-lg font-bold text-amber-900 italic mb-4 relative z-10">Mẹo quản trị</h4>
                <p class="text-amber-800 text-sm leading-relaxed relative z-10">
                    "Hình ảnh chất lượng cao và câu chuyện lịch sử sâu sắc là chìa khóa để thu hút những nhà sưu tập thực thụ."
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
