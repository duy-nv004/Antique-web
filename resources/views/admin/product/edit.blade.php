@extends('layout.admin')

@section('title', 'Chỉnh sửa sản phẩm')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.products.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-vintage-200 text-stone-400 hover:text-amber-700 transition-all shadow-sm">
            <i data-lucide="chevron-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="font-playfair text-3xl font-bold text-vintage-900">Chỉnh Sửa Tuyệt Phẩm</h1>
            <p class="text-stone-500 text-sm">Cập nhật thông tin cho món đồ: <span class="text-amber-700 font-bold">{{ $product->name }}</span></p>
        </div>
    </div>

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf
        @method('PUT')
        
        <!-- Left Column: Details -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-vintage-200 space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Tên tuyệt phẩm <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required onkeyup="ChangeToSlug();"
                        class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none"
                        placeholder="Ví dụ: Đồng hồ Odo 54/8 bính bong">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Slug (URL)</label>
                        <input type="text" name="slug" id="slug" value="{{ old('slug', $product->slug) }}" readonly
                            class="w-full bg-stone-50 border border-vintage-100 rounded-xl px-5 py-4 text-stone-400 cursor-not-allowed outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Mã định danh (SKU)</label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" readonly
                            class="w-full bg-stone-50 border border-vintage-100 rounded-xl px-5 py-4 text-stone-400 cursor-not-allowed outline-none font-mono">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Lịch sử & Câu chuyện</label>
                    <textarea name="content" rows="10"
                        class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none resize-none"
                        placeholder="Kể về nguồn gốc, niên đại và giá trị của món đồ...">{{ old('content', $product->content) }}</textarea>
                </div>
            </div>

            <!-- Images Section -->
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-vintage-200">
                <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1 block mb-4">Hình ảnh vật phẩm</label>
                
                <!-- Current Images -->
                @if($product->images && $product->images->count() > 0)
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 gap-4 mb-8 pb-8 border-b border-vintage-100">
                        @foreach($product->images as $img)
                            <div class="aspect-square rounded-2xl overflow-hidden border border-vintage-200 relative group shadow-sm">
                                <img src="{{ asset('storage/' . $img->image_path) }}" class="w-full h-full object-cover">
                                @if($img->is_main)
                                    <div class="absolute inset-0 bg-amber-700/60 flex items-center justify-center">
                                        <span class="text-white text-[10px] font-bold uppercase tracking-widest">Ảnh chính</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endif

                <!-- Upload New -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="image-preview-container">
                    <label class="aspect-square flex flex-col items-center justify-center border-2 border-dashed border-vintage-200 rounded-2xl cursor-pointer hover:border-amber-700 hover:bg-amber-50 transition-all text-stone-400 hover:text-amber-700">
                        <i data-lucide="plus" class="w-8 h-8 mb-2"></i>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-center px-1">Thêm ảnh</span>
                        <input type="file" name="images[]" multiple accept="image/*" class="hidden" onchange="previewImages(this)">
                    </label>
                </div>
                <p class="text-[10px] text-stone-400 mt-4 italic">* Các ảnh mới sẽ được bổ sung vào bộ sưu tập hiện tại.</p>
            </div>
        </div>

        <!-- Right Column: Stats & Meta -->
        <div class="lg:col-span-4 space-y-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-vintage-200 space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Danh mục bộ sưu tập</label>
                    <select name="category_id" required class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none appearance-none">
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cate)
                            <option value="{{ $cate->id }}" {{ $product->category_id == $cate->id ? 'selected' : '' }}>{{ $cate->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Giá trị niêm yết (VNĐ)</label>
                    <div class="relative">
                        <input type="number" name="price" value="{{ old('price', $product->price) }}" required
                            class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-bold text-amber-800"
                            placeholder="0">
                        <span class="absolute right-5 top-1/2 -translate-y-1/2 text-stone-400 font-bold">₫</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Số lượng tồn kho</label>
                    <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                        class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none">
                </div>

                <hr class="border-vintage-100">

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Niên đại</label>
                    <input type="text" name="period" value="{{ old('period', $product->period) }}" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-3 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none text-sm" placeholder="Vd: Thế kỷ 19">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Chất liệu</label>
                    <input type="text" name="material" value="{{ old('material', $product->material) }}" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-3 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none text-sm" placeholder="Vd: Gỗ trắc, đồng">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Trạng thái hiển thị</label>
                    <select name="is_active" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none appearance-none">
                        <option value="1" {{ $product->is_active ? 'selected' : '' }}>Công khai trên web</option>
                        <option value="0" {{ !$product->is_active ? 'selected' : '' }}>Ẩn khỏi hệ thống</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Tình trạng vật phẩm</label>
                    <select name="availability_status" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none appearance-none">
                        <option value="in_stock" {{ $product->availability_status == 'in_stock' ? 'selected' : '' }}>Còn hàng</option>
                        <option value="sold" {{ $product->availability_status == 'sold' ? 'selected' : '' }}>Đã giao dịch</option>
                        <option value="display" {{ $product->availability_status == 'display' ? 'selected' : '' }}>Chỉ trưng bày</option>
                    </select>
                </div>
            </div>

            <div class="flex flex-col gap-4">
                <button type="submit" class="w-full bg-amber-700 hover:bg-amber-800 text-white font-bold py-4 rounded-xl shadow-xl shadow-amber-900/20 transition-all flex items-center justify-center gap-2">
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                    Cập nhật thay đổi
                </button>
                <a href="{{ route('admin.products.index') }}" class="w-full bg-white text-stone-400 hover:text-stone-600 font-bold py-4 rounded-xl border border-vintage-200 transition-all flex items-center justify-center gap-2">
                    Hủy bỏ & Quay lại
                </a>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImages(input) {
        const container = document.getElementById('image-preview-container');
        const previews = container.querySelectorAll('.preview-item');
        previews.forEach(p => p.remove());

        if (input.files) {
            Array.from(input.files).forEach((file) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'preview-item aspect-square rounded-2xl overflow-hidden border border-vintage-200 relative group shadow-sm';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                            <span class="text-white text-[10px] font-bold uppercase tracking-widest text-center px-2">Ảnh mới bổ sung</span>
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