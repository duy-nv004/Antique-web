@extends('layout.admin')

@section('content')
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="fw-bold text-dark">Quản lý danh mục</h1>
            <a href="{{ route('categories.create') }}" class="btn btn-success">
                <i class="fas fa-plus"></i> Thêm danh mục mới
            </a>
        </div>

        <div class="card shadow border-0">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Tên danh mục</th>
                            <th>Mô tả</th>
                            <th>Danh mục cha</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                            <tr>
                                <td class="ps-4">{{ $category->id }}</td>
                                <td><strong>{{ $category->name }}</strong></td>
                                <td class="text-muted">{{ Str::limit($category->description, 50) }}</td>
                                <td>
                                    {{ $category->parent ? $category->parent->name : 'Gốc' }}
                                </td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success-subtle text-success border border-success">Đang hiện</span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary">Đang ẩn</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-outline-info" title="Sửa">
                                            Sửa
                                        </a>

                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn xóa danh mục này vào thùng rác?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger ms-1" title="Xóa">
                                                Xóa
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $categories->links() }}
        </div>
    </div>
@endsection