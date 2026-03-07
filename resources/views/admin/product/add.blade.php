@extends('layout.admin')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark py-3">
                        <h5 class="mb-0 text-white"><i class="fas fa-plus-circle me-2"></i>Thêm Món Đồ Cổ Mới</h5>
                    </div>
                    <div class="card-body p-4">

                        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tên sản phẩm <span class="text-danger">*</span></label>
                                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}"
                                            placeholder="Ví dụ: Đồng hồ treo tường Odo 54" required onkeyup="ChangeToSlug();">
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Slug (URL)</label>
                                        <input type="text" name="slug" id="slug" class="form-control bg-light" value="{{ old('slug') }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Lịch sử & Mô tả món đồ</label>
                                        <textarea name="content" class="form-control" rows="8"
                                            placeholder="Kể về nguồn gốc, giá trị lịch sử của món đồ này...">{{ old('content') }}</textarea>
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Niên đại (Thời gian)</label>
                                            <input type="text" name="period" class="form-control" value="{{ old('period') }}" placeholder="Ví dụ: Thế kỷ 19, Đời Minh...">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label fw-bold">Chất liệu</label>
                                            <input type="text" name="material" class="form-control" value="{{ old('material') }}" placeholder="Ví dụ: Gỗ trắc, Đồng hun...">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card bg-light border-0 p-3">
                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Danh mục</label>
                                            <select name="category_id" class="form-select" required>
                                                <option value="">-- Chọn danh mục --</option>
                                                @foreach($categories as $cate)
                                                    <option value="{{ $cate->id }}" {{ old('category_id') == $cate->id ? 'selected' : '' }}>
                                                        {{ $cate->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Mã SKU (Mã định danh)</label>
                                            <input type="text" name="sku" class="form-control" value="{{ old('sku', 'DC-'.strtoupper(Str::random(6))) }}">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Giá bán (VNĐ) <span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <input type="number" name="price" class="form-control" value="{{ old('price') }}" required>
                                                <span class="input-group-text">₫</span>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Số lượng (Stock) <span class="text-danger">*</span></label>
                                            <input type="number" name="stock" class="form-control" value="{{ old('stock', 1) }}" min="1" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Tình trạng món đồ</label>
                                            <input type="text" name="condition" class="form-control" value="{{ old('condition') }}" placeholder="Vd: Còn tốt 90%...">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Xuất xứ</label>
                                            <input type="text" name="origin" class="form-control" value="{{ old('origin') }}" placeholder="Vd: Pháp, Việt Nam...">
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label fw-bold">Trạng thái quản lý</label>
                                            <select name="is_active" class="form-select">
                                                <option value="1" selected>1 - Đang hoạt động</option>
                                                <option value="0">0 - Tạm ngưng (Ẩn)</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <hr class="my-4">

                            <div class="row">
                                <!-- <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-primary"><i class="fas fa-images me-2"></i>Tải lên hình ảnh</label>
                                    <input type="file" name="image" class="form-control" accept="image/*">
                                    <small class="text-muted">Chọn ảnh sắc nét từ nhiều góc độ của món đồ.</small>
                                </div> -->
                                <div class="mb-3">
    <label class="form-label fw-bold text-primary">
        <i class="fas fa-images me-2"></i>Tải lên hình ảnh sản phẩm
    </label>
    <input type="file" name="images[]" id="image-input" class="form-control" accept="image/*" multiple onchange="handleFileSelect(event)">
    
    <div id="hidden-inputs"></div>

    <div id="image-preview-container" class="d-flex flex-wrap gap-2 mt-3 p-2 border rounded bg-light" style="min-height: 100px; display: none;">
        </div>
    
    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="clearAllImages()" id="btn-clear" style="display:none;">Xóa tất cả ảnh đã chọn</button>
</div>
                            </div>

                            <div class="d-flex justify-content-between mt-4">
                                <a href="{{ route('products.index') }}" class="btn btn-outline-secondary px-4">Quay lại</a>
                                <button type="submit" class="btn btn-success px-5">
                                    <i class="fas fa-save me-2"></i>Lưu Món Đồ
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
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
        }let allFiles = []; // Mảng chứa tất cả file ảnh Duy đã chọn

    function handleFileSelect(event) {
        const files = event.target.files;
        const container = document.getElementById('image-preview-container');
        const btnClear = document.getElementById('btn-clear');

        // Thêm các file mới vào mảng tổng
        for (let i = 0; i < files.length; i++) {
            allFiles.push(files[i]);
        }

        renderPreviews();
        updateHiddenInputs();

        // Hiện khung và nút xóa
        if (allFiles.length > 0) {
            container.style.display = 'flex';
            btnClear.style.display = 'block';
        }
    }

    function renderPreviews() {
        const container = document.getElementById('image-preview-container');
        container.innerHTML = ''; // Reset hiển thị

        allFiles.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const wrapper = document.createElement('div');
                wrapper.className = 'position-relative';
                wrapper.style.cssText = 'width: 100px; height: 100px;';

                wrapper.innerHTML = `
                    <img src="${e.target.result}" class="img-thumbnail w-100 h-100" style="object-fit: cover;">
                    <span class="position-absolute top-0 start-0 badge bg-dark opacity-75">${index + 1}</span>
                    <button type="button" onclick="removeSingleImage(${index})" 
                            class="position-absolute top-0 end-0 btn btn-danger btn-sm p-0" 
                            style="width:20px; height:20px; line-height:10px;">&times;</button>
                `;
                container.appendChild(wrapper);
            }
            reader.readAsDataURL(file);
        });
    }

    // Quan trọng: Vì DataTransfer khó can thiệp, ta tạo các input file ảo để gửi về Laravel
    function updateHiddenInputs() {
        const hiddenContainer = document.getElementById('hidden-inputs');
        hiddenContainer.innerHTML = ''; 
        
        // Tạo một DataTransfer object để đóng gói lại mảng allFiles thành FileList cho Laravel
        const dataTransfer = new DataTransfer();
        allFiles.forEach(file => dataTransfer.items.add(file));
        
        // Gán ngược lại mảng file đã gộp vào input chính
        document.getElementById('image-input').files = dataTransfer.files;
    }

    function removeSingleImage(index) {
        allFiles.splice(index, 1); // Xóa 1 ảnh tại vị trí index
        renderPreviews();
        updateHiddenInputs();
        if (allFiles.length === 0) clearAllImages();
    }

    function clearAllImages() {
        allFiles = [];
        document.getElementById('image-input').value = '';
        document.getElementById('image-preview-container').innerHTML = '';
        document.getElementById('image-preview-container').style.display = 'none';
        document.getElementById('btn-clear').style.display = 'none';
    }
    </script>
@endsection