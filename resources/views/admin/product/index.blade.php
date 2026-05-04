@extends('layout.admin')

@section('title', 'Danh sách sản phẩm')

@section('content')
<div class="flex flex-col gap-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <h1 class="font-playfair text-3xl font-bold text-vintage-900">Quản lý Kho đồ cổ</h1>
            <p class="text-stone-500 text-sm mt-1">Lưu giữ và trưng bày các tuyệt phẩm vượt thời gian</p>
        </div>
        <a href="{{ route('admin.products.create') }}" class="flex items-center justify-center gap-2 bg-amber-700 hover:bg-amber-800 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-amber-900/20 transition-all">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Thêm sản phẩm mới
        </a>
    </div>

    <!-- Filters & Search -->
    <div class="bg-white rounded-3xl shadow-sm border border-vintage-200 overflow-hidden">
        <!-- Mobile Toggle Header -->
        <div class="md:hidden flex items-center justify-between p-6 border-b border-vintage-100">
            <span class="text-sm font-bold text-vintage-900 flex items-center gap-2">
                <i data-lucide="search" class="w-4 h-4 text-amber-700"></i>
                Tìm kiếm & Lọc
            </span>
            <button onclick="toggleFilters()" class="p-2 bg-vintage-50 rounded-lg text-amber-700 hover:bg-vintage-100 transition-all">
                <i data-lucide="sliders-horizontal" class="w-5 h-5"></i>
            </button>
        </div>

        <div id="filter-form" class="hidden md:block p-6">
            <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-4 space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Tìm kiếm</label>
                    <div class="relative">
                        <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 w-4 h-4"></i>
                        <input type="text" name="keyword" value="{{ request('keyword') }}" 
                            class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-3 pl-10 pr-4 text-sm focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none"
                            placeholder="Tên sản phẩm hoặc mã SKU...">
                    </div>
                </div>

                <div class="md:col-span-3 space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Danh mục</label>
                    <select name="category_id" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none appearance-none">
                        <option value="">Tất cả danh mục</option>
                        @foreach($categories as $cate)
                            <option value="{{ $cate->id }}" {{ request('category_id') == $cate->id ? 'selected' : '' }}>{{ $cate->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Trạng thái hàng</label>
                    <select name="status" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none appearance-none">
                        <option value="">Tất cả</option>
                        <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>Còn hàng</option>
                        <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Đã bán</option>
                        <option value="display" {{ request('status') == 'display' ? 'selected' : '' }}>Trưng bày</option>
                    </select>
                </div>

                <div class="md:col-span-2 space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Hiển thị</label>
                    <select name="is_active" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none appearance-none">
                        <option value="">Tất cả</option>
                        <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Đang hiện</option>
                        <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Đang ẩn</option>
                    </select>
                </div>

                <div class="md:col-span-1">
                    <button type="submit" class="w-full bg-vintage-900 text-white h-[46px] rounded-xl flex items-center justify-center hover:bg-black transition-all shadow-lg shadow-stone-900/10">
                        <i data-lucide="filter" class="w-5 h-5"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-3xl shadow-sm border border-vintage-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-vintage-50/50 border-b border-vintage-200">
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400">Ảnh</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400">Thông tin tuyệt phẩm</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400">Giá trị (VNĐ)</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400 text-center">Tồn kho</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400">Trạng thái</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-vintage-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-vintage-50/30 transition-colors">
                        <td class="px-8 py-6">
                            @php $mainImage = $product->images->where('is_main', 1)->first(); @endphp
                            <div class="w-16 h-16 rounded-xl overflow-hidden bg-stone-100 border border-vintage-200 shadow-sm">
                                @if($mainImage)
                                    <img src="{{ asset('storage/' . $mainImage->image_path) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-stone-300">
                                        <i data-lucide="image" class="w-6 h-6"></i>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="font-bold text-vintage-900">{{ $product->name }}</span>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] bg-stone-100 text-stone-500 px-2 py-0.5 rounded border border-stone-200 font-mono">{{ $product->sku }}</span>
                                    <span class="text-xs text-amber-700 font-medium">{{ $product->category->name ?? 'Không phân loại' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <span class="font-bold text-vintage-900">{{ number_format($product->price) }}</span>
                            <span class="text-[10px] text-stone-400 font-bold ml-0.5">₫</span>
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($product->stock <= 0)
                                <span class="text-xs font-bold text-red-500 bg-red-50 px-3 py-1 rounded-full border border-red-100">Hết hàng</span>
                            @else
                                <span class="text-sm font-bold text-vintage-700">{{ $product->stock }}</span>
                            @endif
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex flex-col gap-1.5">
                                @if($product->is_active)
                                    <span class="inline-flex items-center gap-1.5 text-[9px] font-bold uppercase tracking-wider text-emerald-600">
                                        <span class="w-1 h-1 rounded-full bg-emerald-600"></span>
                                        Đang hiển thị
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-[9px] font-bold uppercase tracking-wider text-stone-400">
                                        <span class="w-1 h-1 rounded-full bg-stone-400"></span>
                                        Đang ẩn
                                    </span>
                                @endif

                                @switch($product->availability_status)
                                    @case('sold')
                                        <span class="text-[9px] font-bold uppercase text-red-400">🔴 Đã bán</span>
                                        @break
                                    @case('display')
                                        <span class="text-[9px] font-bold uppercase text-amber-600">🟡 Trưng bày</span>
                                        @break
                                    @default
                                        <span class="text-[9px] font-bold uppercase text-emerald-500">🟢 Sẵn có</span>
                                @endswitch
                            </div>
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="p-2 text-amber-700 hover:bg-amber-50 rounded-lg transition-all" title="Chỉnh sửa">
                                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Xóa sản phẩm này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-400 hover:bg-red-50 rounded-lg transition-all" title="Xóa">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-8 py-12 text-center text-stone-400 italic">
                            Không tìm thấy tuyệt phẩm nào phù hợp với bộ lọc.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="p-8 border-t border-vintage-100 bg-vintage-50/50">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function toggleFilters() {
        const form = document.getElementById('filter-form');
        form.classList.toggle('hidden');
    }
</script>
@endsection