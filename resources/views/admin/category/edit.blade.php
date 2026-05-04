@extends('layout.admin')

@section('title', 'Chỉnh sửa danh mục')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-4 mb-8">
        <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 flex items-center justify-center rounded-xl bg-white border border-vintage-200 text-stone-400 hover:text-amber-700 transition-all shadow-sm">
            <i data-lucide="chevron-left" class="w-5 h-5"></i>
        </a>
        <div>
            <h1 class="font-playfair text-3xl font-bold text-vintage-900">Chỉnh Sửa Danh Mục</h1>
            <p class="text-stone-500 text-sm">Cập nhật thông tin cho bộ sưu tập: <span class="text-amber-700 font-bold">{{ $category->name }}</span></p>
        </div>
    </div>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="space-y-8">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-3xl p-8 shadow-sm border border-vintage-200 space-y-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Tên danh mục <span class="text-red-500">*</span></label>
                    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required onkeyup="ChangeToSlug();"
                        class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none"
                        placeholder="Ví dụ: Gốm sứ Triều Nguyễn">
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Slug (URL)</label>
                    <input type="text" name="slug" id="slug" value="{{ old('slug', $category->slug) }}" readonly
                        class="w-full bg-stone-50 border border-vintage-100 rounded-xl px-5 py-4 text-stone-400 cursor-not-allowed outline-none">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Danh mục cha</label>
                    <select name="parent_id" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none appearance-none">
                        <option value="">-- Danh mục gốc --</option>
                        @foreach($categories as $item)
                            <option value="{{ $item->id }}" {{ $category->parent_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Trạng thái</label>
                    <select name="is_active" class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none appearance-none">
                        <option value="1" {{ $category->is_active ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ !$category->is_active ? 'selected' : '' }}>Tạm ngưng</option>
                    </select>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] uppercase tracking-widest font-bold text-stone-400 px-1">Mô tả bộ sưu tập</label>
                <textarea name="description" rows="4"
                    class="w-full bg-vintage-50 border border-vintage-100 rounded-xl px-5 py-4 focus:ring-2 focus:ring-amber-700 focus:bg-white transition-all outline-none resize-none"
                    placeholder="Giới thiệu đôi nét về những tuyệt phẩm trong danh mục này...">{{ old('description', $category->description) }}</textarea>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row items-center justify-end gap-4">
            <a href="{{ route('admin.categories.index') }}" class="w-full sm:w-auto text-center px-8 py-4 text-stone-400 font-bold hover:text-stone-600 transition-all uppercase tracking-widest text-[10px]">Quay lại</a>
            <button type="submit" class="w-full sm:w-auto bg-amber-700 hover:bg-amber-800 text-white px-10 py-4 rounded-xl font-bold shadow-lg shadow-amber-900/20 transition-all flex items-center justify-center gap-2">
                <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                Cập nhật danh mục
            </button>
        </div>
    </form>
</div>

<script>
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