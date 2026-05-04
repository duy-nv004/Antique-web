@extends('layout.admin')

@section('title', 'Thêm sản phẩm')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.products.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-vintage-200 text-stone-400 hover:text-amber-700 transition-all shadow-sm">
            <i data-lucide="chevron-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="font-playfair text-3xl font-bold text-vintage-900">Thêm Tuyệt Phẩm Mới</h1>
            <p class="text-stone-500 text-sm">Ghi danh một món đồ cổ quý hiếm vào bộ sưu tập</p>
        </div>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        @csrf
        
        <!-- Left Column: Details -->
        <div class="lg:col-span-8 space-y-8">
            <div class="bg-white rounded-3xl p-8 shadow-sm border border-vintage-200 space-y-6">
                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Tên tuyệt phẩm <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" required onkeyup="ChangeToSlug();"
                        class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none"
                        placeholder="Ví dụ: Đồng hồ Odo 54/8 bính bong">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Slug (URL)</label>
                        <input type="text" name="slug" id="slug" readonly
                            class="w-full bg-stone-50 border border-vintage-100 rounded-xl px-5 py-4 text-stone-400 cursor-not-allowed outline-none">
                    </div>
                    <div class="space-y-2">
                        <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Mã định danh (SKU)</label>
                        <input type="text" name="sku" value="{{ 'DC-' . strtoupper(Str::random(6)) }}"
                            class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-mono">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Lịch sử & Câu chuyện</label>
                    <textarea name="content" rows="10"
                        class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none resize-none"
                        placeholder="Kể về nguồn gốc, niên đại và giá trị của món đồ..."></textarea>
                </div>
            </div>

            <!-- Images Section -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-sm border border-vintage-200">
                <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1 block mb-4">Hình ảnh minh họa</label>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-3 xl:grid-cols-4 gap-4" id="image-preview-container">
                    <label class="aspect-square flex flex-col items-center justify-center border-2 border-dashed border-vintage-200 rounded-2xl cursor-pointer hover:border-amber-700 hover:bg-amber-50 transition-all text-stone-400 hover:text-amber-700">
                        <i data-lucide="plus" class="w-8 h-8 mb-2"></i>
                        <span class="text-[10px] font-bold uppercase tracking-widest text-center px-1">Tải ảnh</span>
                        <input type="file" name="images[]" multiple accept="image/*" class="hidden" onchange="previewImages(this)">
                    </label>
                </div>
                <p class="text-[10px] text-stone-400 mt-4 italic">* Bạn có thể chọn nhiều ảnh cùng lúc. Ảnh đầu tiên sẽ là ảnh đại diện.</p>
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
                            <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Giá trị niêm yết (VNĐ)</label>
                    <div class="relative">
                        <input type="number" name="price" required
                            class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none font-bold text-amber-800"
                            placeholder="0">
                        <span class="absolute right-5 top-1/2 -translate-y-1/2 text-stone-400 font-bold">₫</span>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Số lượng tồn kho</label>
                    <input type="number" name="stock" value="1" min="1"
                        class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none">
                </div>

                <hr class="border-vintage-100">

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Niên đại</label>
                    <input type="text" name="period" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-3 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none text-sm" placeholder="Vd: Thế kỷ 19">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Chất liệu</label>
                    <input type="text" name="material" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-3 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none text-sm" placeholder="Vd: Gỗ trắc, đồng">
                </div>

                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Tình trạng vật phẩm</label>
                    <select name="availability_status" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none appearance-none">
                        <option value="in_stock" selected>Còn hàng</option>
                        <option value="sold">Đã giao dịch</option>
                        <option value="display">Chỉ trưng bày</option>
                    </select>
                </div>
            </div>

            <div class="bg-amber-900 rounded-3xl p-6 sm:p-8 shadow-xl shadow-amber-900/20 text-white space-y-6">
                <h3 class="font-playfair text-xl font-bold italic border-b border-white/10 pb-4">Xác nhận lưu trữ</h3>
                <p class="text-xs text-amber-200 leading-relaxed">Sau khi lưu, tuyệt phẩm sẽ được hiển thị công khai trên website. Hãy đảm bảo thông tin lịch sử và hình ảnh là chính xác.</p>
                <button type="submit" class="w-full bg-white text-amber-900 hover:bg-amber-100 font-bold py-4 rounded-xl transition-all flex items-center justify-center gap-2">
                    <i data-lucide="upload-cloud" class="w-5 h-5"></i>
                    Lưu trữ tuyệt phẩm
                </button>
            </div>
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