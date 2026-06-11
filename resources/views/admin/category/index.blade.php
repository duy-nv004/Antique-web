@extends('layout.admin')

@section('title', 'Danh sách danh mục')

@section('content')
<div class="flex flex-col gap-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="font-playfair text-3xl font-bold text-vintage-900">Quản lý Danh mục</h1>
            <p class="text-stone-500 text-sm mt-1">Phân loại các tuyệt phẩm theo bộ sưu tập</p>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="flex items-center gap-2 bg-amber-700 hover:bg-amber-800 text-white px-6 py-3 rounded-xl font-bold shadow-lg shadow-amber-900/20 transition-all">
            <i data-lucide="plus" class="w-5 h-5"></i>
            Thêm danh mục mới
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-vintage-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-vintage-50/50 border-b border-vintage-200">
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400">ID</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400">Tên danh mục</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400">Mô tả</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400">Cấp độ</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400 text-center">Trạng thái</th>
                        <th class="px-8 py-5 text-[10px] uppercase tracking-widest font-bold text-stone-400 text-right">Hành động</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-vintage-100">
                    @foreach($categories as $category)
                    <tr class="hover:bg-vintage-50/30 transition-colors">
                        <td class="px-8 py-6 font-mono text-xs text-stone-400">#{{ $category->id }}</td>
                        <td class="px-8 py-6">
                            <span class="font-bold text-vintage-900">{{ $category->name }}</span>
                        </td>
                        <td class="px-8 py-6 text-sm text-stone-500 max-w-xs truncate">
                            {{ $category->description ?? '---' }}
                        </td>
                        <td class="px-8 py-6">
                            @if($category->parent)
                                <div class="flex items-center gap-2 text-xs text-amber-700 bg-amber-50 px-3 py-1 rounded-full border border-amber-100 inline-flex">
                                    <i data-lucide="corner-down-right" class="w-3 h-3"></i>
                                    {{ $category->parent->name }}
                                </div>
                            @else
                                <span class="text-xs text-stone-400 bg-stone-100 px-3 py-1 rounded-full border border-stone-200">Gốc</span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-center">
                            @if($category->is_active)
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-emerald-600">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-600 animate-pulse"></span>
                                    Hoạt động
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1.5 text-[10px] font-bold uppercase tracking-wider text-stone-400">
                                    <span class="w-1.5 h-1.5 rounded-full bg-stone-400"></span>
                                    Tạm ẩn
                                </span>
                            @endif
                        </td>
                        <td class="px-8 py-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2 text-amber-700 hover:bg-amber-50 rounded-lg transition-all" title="Chỉnh sửa">
                                    <i data-lucide="edit-3" class="w-5 h-5"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Xóa danh mục này?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-red-400 hover:bg-red-50 rounded-lg transition-all" title="Xóa">
                                        <i data-lucide="trash-2" class="w-5 h-5"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <div class="p-8 border-t border-vintage-100 bg-vintage-50/50">
            {{ $categories->links('partials.pagination') }}
        </div>
    </div>
</div>
@endsection