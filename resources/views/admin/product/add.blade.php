@extends('layout.admin')

@section('title', 'Thêm sản phẩm')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.products.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-vintage-200 text-stone-400 hover:text-amber-700 transition-all shadow-sm">
            <i data-lucide="chevron-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="font-playfair text-3xl font-bold text-vintage-900">Thêm Tuyệt Phẩm Mới</h1>
            <p class="text-stone-500 text-sm">Ghi danh một món đồ cổ quý hiếm vào bộ sưu tập</p>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        
        <!-- Khung quản lý duy nhất -->
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-vintage-200 space-y-8 font-sans">
            
            <!-- 1. Nhóm Thông tin chính -->
            <div>
                <h2 class="text-xs uppercase tracking-wider font-bold text-amber-800 mb-6 pb-2 border-b border-vintage-100 flex items-center gap-2">
                    <i data-lucide="info" class="w-4 h-4"></i> Thông tin chính
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Tên tuyệt phẩm (50% - col 6) -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Tên tuyệt phẩm <span class="text-red-500">*</span></label>
                        <input type="text" name="name" id="name" required onkeyup="ChangeToSlug();"
                            class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none"
                            placeholder="Ví dụ: Đồng hồ Odo 54/8 bính bong">
                    </div>

                    <!-- Danh mục bộ sưu tập (50% - col 6) -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Danh mục bộ sưu tập</label>
                        <select name="category_id" required class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none appearance-none">
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cate)
                                <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- SKU (50% - col 6) -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Mã định danh (SKU)</label>
                        <input type="text" name="sku" value="{{ 'DC-' . strtoupper(Str::random(6)) }}"
                            class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-mono">
                    </div>

                    <!-- Số lượng tồn kho (50% - col 6) -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Số lượng tồn kho</label>
                        <input type="number" name="stock" value="1" min="1"
                            class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none">
                    </div>

                    <!-- Giá trị niêm yết (50% - col 6) -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Giá trị niêm yết (VNĐ) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <input type="number" name="price" value="{{ old('price') }}" required
                                class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-bold text-amber-800"
                                placeholder="0">
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-stone-400 font-bold">₫</span>
                        </div>
                    </div>

                    <!-- Giá khuyến mãi (50% - col 6) -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Giá khuyến mãi (VNĐ) <span class="text-stone-400 lowercase italic">(không bắt buộc)</span></label>
                        <div class="relative">
                            <input type="number" name="discount_price" value="{{ old('discount_price') }}"
                                class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-bold text-amber-800"
                                placeholder="0">
                            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-stone-400 font-bold">₫</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Nhóm Thông tin chi tiết -->
            <div>
                <h2 class="text-xs uppercase tracking-wider font-bold text-amber-800 mb-6 pb-2 border-b border-vintage-100 flex items-center gap-2">
                    <i data-lucide="sliders" class="w-4 h-4"></i> Thông tin chi tiết
                </h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Niên đại (50%) -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Niên đại</label>
                        <input type="text" name="period" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-3 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none text-sm" placeholder="Vd: Thế kỷ 19">
                    </div>

                    <!-- Chất liệu (50%) -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Chất liệu</label>
                        <input type="text" name="material" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-3 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none text-sm" placeholder="Vd: Gỗ trắc, đồng">
                    </div>

                    <!-- Trạng thái hiển thị (50%) -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Trạng thái hiển thị</label>
                        <select name="is_active" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none appearance-none">
                            <option value="1" selected>Công khai trên web</option>
                            <option value="0">Ẩn khỏi hệ thống</option>
                        </select>
                    </div>

                    <!-- Tình trạng vật phẩm (50%) -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Tình trạng vật phẩm</label>
                        <select name="availability_status" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none appearance-none">
                            <option value="in_stock" selected>Còn hàng</option>
                            <option value="sold">Đã giao dịch</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- 3. Nhóm Nội dung & Hình ảnh -->
            <div>
                <h2 class="text-xs uppercase tracking-wider font-bold text-amber-800 mb-6 pb-2 border-b border-vintage-100 flex items-center gap-2">
                    <i data-lucide="image" class="w-4 h-4"></i> Nội dung & Hình ảnh
                </h2>
                <div class="space-y-6">
                    <!-- Slug (URL) - Ẩn đi để tối giản -->
                    <input type="hidden" name="slug" id="slug">

                    <!-- Lịch sử & Câu chuyện -->
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Lịch sử & Câu chuyện</label>
                        <textarea name="content" rows="10"
                            class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none resize-none"
                            placeholder="Kể về nguồn gốc, niên đại và giá trị của món đồ..."></textarea>
                    </div>

                    <!-- Quản lý hình ảnh -->
                    <div class="space-y-4 pt-6 border-t border-vintage-100">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1 block">Hình ảnh minh họa</label>
                        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4" id="image-preview-container">
                            <label class="aspect-square flex flex-col items-center justify-center border-2 border-dashed border-vintage-200 rounded-2xl cursor-pointer hover:border-amber-700 hover:bg-amber-50 transition-all text-stone-400 hover:text-amber-700">
                                <i data-lucide="plus" class="w-8 h-8 mb-2"></i>
                                <span class="text-[10px] font-bold uppercase tracking-widest text-center px-1">Tải ảnh</span>
                                <input type="file" name="images[]" multiple accept="image/*" class="hidden" onchange="previewImages(this)">
                            </label>
                        </div>
                        <p class="text-[10px] text-stone-400 mt-4 italic">* Bạn có thể chọn nhiều ảnh cùng lúc. Ảnh đầu tiên sẽ là ảnh đại diện.</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Hàng nút tác vụ (CTA) -->
        <div class="flex flex-col sm:flex-row items-center justify-end gap-4 mt-6">
            <a href="{{ route('admin.products.index') }}" class="w-full sm:w-auto px-8 py-4 bg-white text-stone-500 hover:text-stone-700 font-bold rounded-xl border border-vintage-200 transition-all text-center">
                Hủy bỏ & Quay lại
            </a>
            <button type="submit" class="w-full sm:w-auto px-8 py-4 bg-amber-700 hover:bg-amber-800 text-white font-bold rounded-xl shadow-xl shadow-amber-900/20 transition-all flex items-center justify-center gap-2">
                <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                Lưu trữ tuyệt phẩm
            </button>
        </div>
    </form>
</div>

<script>
    function previewImages(input) {
        const container = document.getElementById('image-preview-container');
        // Clear existing previews except the label
        const previews = container.querySelectorAll('.preview-item');
        previews.forEach(p => p.remove());

        if (input.files) {
            Array.from(input.files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'preview-item aspect-square rounded-2xl overflow-hidden border border-vintage-200 relative group shadow-sm';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="text-white text-[10px] font-bold uppercase tracking-widest">${index === 0 ? 'Ảnh chính' : 'Ảnh phụ'}</span>
                        </div>
                    `;
                    container.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    }

    function ChangeToSlug() {
        var name, slug;
        name = document.getElementById("name").value;
        slug = name.toLowerCase();
        slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
        slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
        slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
        slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
        slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
        slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
        slug = slug.replace(/đ/gi, 'd');
        slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
        slug = slug.replace(/ /gi, "-");
        slug = slug.replace(/\-\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-\-/gi, '-');
        slug = slug.replace(/\-\-\-/gi, '-');
        slug = slug.replace(/\-\-/gi, '-');
        slug = '@' + slug + '@';
        slug = slug.replace(/\@\-|\-\@|\@/gi, '');
        document.getElementById('slug').value = slug;
    }
</script>
@endsection