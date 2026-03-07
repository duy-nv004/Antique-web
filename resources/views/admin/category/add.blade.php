@extends('layout.admin')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0 text-uppercase">Thêm Danh Mục Đồ Cổ</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('categories.store') }}" method="POST">
                            @csrf
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Tên danh mục</label>
                                <input type="text" name="name" id="name" class="form-control" 
                                       placeholder="Ví dụ: Đồng Hồ Cổ & Hộp Nhạc" required 
                                       onkeyup="ChangeToSlug();">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Slug (URL)</label>
                                <input type="text" name="slug" id="slug" class="form-control bg-light" 
                                       readonly placeholder="dong-ho-co-va-hop-nhac">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Thuộc danh mục cha</label>
                                <select name="parent_id" class="form-select">
                                    <option value="">-- Danh mục gốc --</option>
                                    @foreach($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Trạng thái quản lý</label>
                                <select name="is_active" class="form-select">
                                    <option value="1" selected>Hoạt động</option>
                                    <option value="0">Tạm ngưng</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Mô tả ngắn</label>
                                <textarea name="description" class="form-control" rows="3" 
                                          placeholder="Viết vài dòng giới thiệu..."></textarea>
                            </div>

                            <div class="mt-4 border-top pt-3 d-flex justify-content-between">
                                <a href="{{ route('categories.index') }}" class="btn btn-outline-secondary px-4">Quay lại</a>
                                <button type="submit" class="btn btn-primary px-5">Lưu danh mục</button>
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
        }
    </script>
@endsection