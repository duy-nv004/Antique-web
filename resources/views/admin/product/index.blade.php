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
    <div id="filter-form" class="w-full mb-4">
        <form action="{{ route('admin.products.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <div class="md:col-span-4 space-y-2">
                <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Tìm kiếm</label>
                <div class="relative">
                    <i data-lucide="search" class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400 w-4 h-4"></i>
                    <input type="text" name="keyword" value="{{ request('keyword') }}" 
                        class="w-full bg-white border border-vintage-200 rounded-xl py-3 pl-10 pr-4 text-sm focus:ring-2 focus:ring-amber-700 transition-all outline-none shadow-sm"
                        placeholder="Tên sản phẩm hoặc mã SKU...">
                </div>
            </div>

            <!-- Custom Searchable Category Dropdown -->
            <div class="md:col-span-3 space-y-2 relative" id="category-dropdown-wrapper">
                <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Danh mục</label>
                <div class="relative">
                    <input type="text" id="category-search" 
                        placeholder="Tất cả danh mục" 
                        value="{{ request('category_id') ? ($categories->firstWhere('id', request('category_id'))->name ?? '') : '' }}"
                        class="w-full bg-white border border-vintage-200 rounded-xl py-3 pl-4 pr-10 text-sm focus:ring-2 focus:ring-amber-700 transition-all outline-none cursor-pointer shadow-sm"
                        autocomplete="off">
                    
                    <input type="hidden" name="category_id" id="category-id-hidden" value="{{ request('category_id') }}">

                    <!-- Clear button -->
                    <button type="button" id="category-clear-btn" class="absolute right-3 top-1/2 -translate-y-1/2 text-stone-400 hover:text-stone-600 p-1 hover:bg-stone-100 rounded-full transition-all {{ request('category_id') ? '' : 'hidden' }}">
                        <i data-lucide="x" class="w-3.5 h-3.5"></i>
                    </button>
                    
                    <!-- Dropdown arrow -->
                    <div id="category-arrow-icon" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-stone-400 pointer-events-none {{ request('category_id') ? 'hidden' : '' }}">
                        <i data-lucide="chevron-down" class="w-4 h-4"></i>
                    </div>
                </div>

                <!-- Dropdown List -->
                <div id="category-dropdown-list" class="absolute left-0 right-0 mt-2 bg-white border border-vintage-200 rounded-xl shadow-xl z-50 p-2 hidden animate-in fade-in slide-in-from-top-2 duration-150">
                    <div class="overflow-y-auto max-h-[200px] flex flex-col gap-0.5" style="scrollbar-width: thin; scrollbar-color: #d6d3d1 transparent;">
                        <button type="button" data-id="" class="category-item-btn w-full text-left px-3 py-2 rounded-lg text-xs font-semibold flex items-center justify-between transition-colors {{ !request('category_id') ? 'bg-amber-50 text-amber-900' : 'text-stone-600 hover:bg-stone-50' }}">
                            <span>Tất cả danh mục</span>
                            @if(!request('category_id'))
                                <i data-lucide="check" class="w-3.5 h-3.5 text-amber-700"></i>
                            @endif
                        </button>

                        @foreach($categories as $cate)
                            @php $isActive = request('category_id') == $cate->id; @endphp
                            <button type="button" data-id="{{ $cate->id }}" data-name="{{ $cate->name }}" class="category-item-btn w-full text-left px-3 py-2 rounded-lg text-xs font-semibold flex items-center justify-between transition-colors {{ $isActive ? 'bg-amber-50 text-amber-900' : 'text-stone-600 hover:bg-stone-50' }}">
                                <span class="truncate">{{ $cate->name }}</span>
                                @if($isActive)
                                    <i data-lucide="check" class="w-3.5 h-3.5 text-amber-700"></i>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 space-y-2">
                <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Trạng thái hàng</label>
                <select name="status" class="w-full bg-white border border-vintage-200 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-amber-700 transition-all outline-none appearance-none shadow-sm cursor-pointer">
                    <option value="">Tất cả</option>
                    <option value="in_stock" {{ request('status') == 'in_stock' ? 'selected' : '' }}>Còn hàng</option>
                    <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Đã bán</option>
                </select>
            </div>

            <div class="md:col-span-2 space-y-2">
                <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Hiển thị</label>
                <select name="is_active" class="w-full bg-white border border-vintage-200 rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-amber-700 transition-all outline-none appearance-none shadow-sm cursor-pointer">
                    <option value="">Tất cả</option>
                    <option value="1" {{ request('is_active') == '1' ? 'selected' : '' }}>Đang hiện</option>
                    <option value="0" {{ request('is_active') == '0' ? 'selected' : '' }}>Đang ẩn</option>
                </select>
            </div>

            <div class="md:col-span-1">
                <button type="submit" class="w-full bg-vintage-900 text-white h-[46px] rounded-xl flex items-center justify-center hover:bg-black transition-all shadow-lg shadow-stone-900/10 cursor-pointer">
                    <i data-lucide="filter" class="w-5 h-5"></i>
                </button>
            </div>
        </form>
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
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400 text-center">Nổi bật</th>
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
                                    <img src="{{ str_starts_with($mainImage->image_path, 'http') ? $mainImage->image_path : asset('storage/' . $mainImage->image_path) }}" class="w-full h-full object-cover">
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
                            @if($product->discount_price)
                                <div class="flex flex-col">
                                    <span class="font-bold text-amber-700">{{ number_format($product->discount_price) }} ₫</span>
                                    <span class="text-xs text-stone-450 line-through">{{ $product->price ? number_format($product->price) . ' ₫' : '' }}</span>
                                </div>
                            @elseif($product->price)
                                <span class="font-bold text-vintage-900">{{ number_format($product->price) }}</span>
                                <span class="text-[10px] text-stone-400 font-bold ml-0.5">₫</span>
                            @else
                                <span class="text-xs font-bold text-stone-400">Liên hệ</span>
                            @endif
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
                                    @default
                                        <span class="text-[9px] font-bold uppercase text-emerald-500">🟢 Sẵn có</span>
                                @endswitch
                            </div>
                        </td>
                        <td class="px-8 py-6 text-center">
                            <label class="relative inline-flex items-center cursor-pointer select-none">
                                <input type="checkbox" 
                                       data-product-id="{{ $product->id }}" 
                                       class="toggle-featured-checkbox w-5 h-5 text-amber-700 bg-vintage-50 border-vintage-200 rounded focus:ring-2 focus:ring-amber-700 focus:ring-offset-2" 
                                       {{ $product->is_featured ? 'checked' : '' }}>
                            </label>
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
            {{ $products->links('partials.pagination') }}
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

    // Custom Category Dropdown Handler
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('category-dropdown-wrapper');
        if (!wrapper) return;

        const input = document.getElementById('category-search');
        const hiddenInput = document.getElementById('category-id-hidden');
        const clearBtn = document.getElementById('category-clear-btn');
        const arrowIcon = document.getElementById('category-arrow-icon');
        const dropdownList = document.getElementById('category-dropdown-list');
        const itemButtons = wrapper.querySelectorAll('.category-item-btn');

        // Toggle dropdown on click / focus
        input.addEventListener('click', function(e) {
            dropdownList.classList.remove('hidden');
        });
        
        input.addEventListener('focus', function(e) {
            dropdownList.classList.remove('hidden');
        });

        // Filter categories while typing
        input.addEventListener('input', function() {
            dropdownList.classList.remove('hidden');
            const query = input.value.toLowerCase().trim();

            itemButtons.forEach(btn => {
                const name = btn.getAttribute('data-name');
                if (!name) return; // Skip "Tất cả danh mục" button
                if (name.toLowerCase().includes(query)) {
                    btn.classList.remove('hidden');
                } else {
                    btn.classList.add('hidden');
                }
            });
        });

        // Handle category selection
        itemButtons.forEach(btn => {
            btn.addEventListener('click', function() {
                const id = btn.getAttribute('data-id');
                const name = btn.getAttribute('data-name') || '';

                hiddenInput.value = id;
                input.value = id ? name : '';

                // Active styling toggle
                itemButtons.forEach(b => {
                    b.className = b.className.replace('bg-amber-50 text-amber-900', 'text-stone-600 hover:bg-stone-50');
                    // Remove check icons
                    const checkIcon = b.querySelector('.lucide-check');
                    if (checkIcon) checkIcon.remove();
                });

                btn.className = btn.className.replace('text-stone-600 hover:bg-stone-50', 'bg-amber-50 text-amber-900');
                // Re-add check icon if selected
                if (!btn.querySelector('.lucide-check')) {
                    const check = document.createElement('i');
                    check.setAttribute('data-lucide', 'check');
                    check.className = 'w-3.5 h-3.5 text-amber-700';
                    btn.appendChild(check);
                    if (window.lucide) window.lucide.createIcons();
                }

                // Show/hide icons
                if (id) {
                    clearBtn.classList.remove('hidden');
                    arrowIcon.classList.add('hidden');
                } else {
                    clearBtn.classList.add('hidden');
                    arrowIcon.classList.remove('hidden');
                }

                dropdownList.classList.add('hidden');
            });
        });

        // Handle clear button
        clearBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            hiddenInput.value = '';
            input.value = '';
            clearBtn.classList.add('hidden');
            arrowIcon.classList.remove('hidden');
            dropdownList.classList.add('hidden');

            // Reset active styles to "Tất cả"
            itemButtons.forEach(b => {
                b.className = b.className.replace('bg-amber-50 text-amber-900', 'text-stone-600 hover:bg-stone-50');
                const checkIcon = b.querySelector('.lucide-check');
                if (checkIcon) checkIcon.remove();
            });
            const allBtn = wrapper.querySelector('.category-item-btn[data-id=""]');
            if (allBtn) {
                allBtn.className = allBtn.className.replace('text-stone-600 hover:bg-stone-50', 'bg-amber-50 text-amber-900');
                const check = document.createElement('i');
                check.setAttribute('data-lucide', 'check');
                check.className = 'w-3.5 h-3.5 text-amber-700';
                allBtn.appendChild(check);
                if (window.lucide) window.lucide.createIcons();
            }
        });

        // Click outside to close dropdown
        document.addEventListener('click', function(e) {
            if (!wrapper.contains(e.target)) {
                dropdownList.classList.add('hidden');
                
                // Restore search input text based on current hidden ID value
                const currentId = hiddenInput.value;
                if (currentId) {
                    const activeBtn = wrapper.querySelector(`.category-item-btn[data-id="${currentId}"]`);
                    input.value = activeBtn ? activeBtn.getAttribute('data-name') : '';
                } else {
                    input.value = '';
                }

                // Restore items visibility
                itemButtons.forEach(btn => btn.classList.remove('hidden'));
            }
        });
        // AJAX toggle product featured status
        document.querySelectorAll('.toggle-featured-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function() {
                const productId = this.getAttribute('data-product-id');
                const isChecked = this.checked;
                
                fetch(`/admin/products/${productId}/toggle-featured`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.checked = data.is_featured;
                        showToast(data.is_featured ? 'Đã thiết lập sản phẩm nổi bật thành công!' : 'Đã hủy kích hoạt sản phẩm nổi bật.', 'success');
                    } else {
                        showToast(data.message || 'Không thể cập nhật trạng thái nổi bật', 'error');
                        this.checked = !isChecked;
                    }
                })
                .catch(error => {
                    console.error('Error toggling featured status:', error);
                    showToast('Có lỗi mạng xảy ra khi cập nhật trạng thái.', 'error');
                    this.checked = !isChecked;
                });
            });
        });
    });
</script>
@endsection