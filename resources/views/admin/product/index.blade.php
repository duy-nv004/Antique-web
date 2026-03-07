@extends('layout.admin')

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold text-dark">Quản lý kho đồ cổ</h2>
            <a href="{{ route('products.create') }}" class="btn btn-success px-4">
                <i class="fas fa-plus"></i> Thêm sản phẩm mới
            </a>
        </div>

        <div class="card shadow border-0">
            <div class="card-body p-0">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-dark">
                        <tr>
                            <th class="text-center">ID</th>
                            <th>Ảnh</th>
                            <th>Thông tin sản phẩm</th>
                            <th>Giá bán</th>
                            <th class="text-center">Kho</th>
                            <th>Trạng thái</th>
                            <th class="text-center">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td class="text-center fw-bold">{{ $product->id }}</td>
                                <td>
                                    {{-- Lấy ảnh chính từ bảng product_images --}}
                                    @php
                                        $mainImage = $product->images->where('is_main', 1)->first();
                                    @endphp
                                    @if($mainImage)
                                        <img src="{{ asset('storage/' . $mainImage->image_path) }}" 
                                             class="rounded shadow-sm" width="70" height="70" style="object-fit: cover;">
                                    @else
                                        <div class="bg-light rounded text-center d-flex align-items-center justify-content-center" 
                                             style="width: 70px; height: 70px; font-size: 10px; color: #ccc;">
                                            No Image
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-primary">{{ $product->name }}</div>
                                    <div class="small text-muted">
                                        <span class="badge bg-info-subtle text-info border border-info">{{ $product->category->name ?? 'Không rõ' }}</span>
                                        <span class="ms-2">SĐ: {{ $product->sku }}</span>
                                    </div>
                                    <div class="small mt-1">
                                        <i class="fas fa-history me-1"></i>{{ $product->period ?? 'Không rõ niên đại' }} 
                                        | <i class="fas fa-gem me-1"></i>{{ $product->material ?? 'Chất liệu' }}
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-danger">{{ number_format($product->price) }}đ</div>
                                </td>
                                <td class="text-center">
                                    @if($product->stock <= 0)
                                        <span class="badge bg-danger">Hết hàng</span>
                                    @else
                                        <span class="fw-bold">{{ $product->stock }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        @if($product->is_active)
                                            <span class="badge bg-success-subtle text-success border border-success">Đang hiển thị</span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary border border-secondary">Đang ẩn</span>
                                        @endif

                                        @if($product->is_sold)
                                            <span class="badge bg-warning text-dark">Đã bán</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-sm btn-outline-info" title="Sửa">
                                            Sửa
                                        </a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST"
                                              onsubmit="return confirm('Bạn có chắc chắn muốn xóa món đồ này vào thùng rác?')">
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
            {{ $products->links() }}
        </div>
    </div>
@endsection