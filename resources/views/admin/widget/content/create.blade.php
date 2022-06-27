@extends('layouts.admin')
@section('wp-content')
<style>
    .active {
        display: block !important;
    }

    .preview {
        padding: 20px;
        background: #e3dede;
        border-radius: 5px;
    }

    fieldset {
        border: 1px solid whitesmoke !important;
    }

    ul.list-icon {
        display: flex;
        flex-wrap: wrap;
    }

    ul.list-icon li {
        cursor: pointer;
        flex-basis: 25%;
        display: flex;
        padding: 10px;
        justify-content: center;

    }

    ul.list-slider-banner {
        display: flex;
        flex-wrap: wrap;
    }

    ul.list-slider-banner li {
        padding: 10px;
        flex-basis: 50%;
        cursor: pointer;
    }

    ul.list-slider-banner li img,
    .preview-content img {
        width: 100%;
        height: auto;
    }

    ul.list-slider-banner h1 {
        flex-basis: 100%;
    }
</style>
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm nội dung cho khối <strong>{{ $widget->title }}</strong>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.widget.content.store') }}" method="post">
                @csrf
                {{-------- Nội dung 1 -------}}
                <div class="card-header font-weight-bold">Thông tin cơ bản</div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="widget-id">Phụ thuộc khối giao diện</label>
                            <select class="form-control" name="widget_id" id="widget-id">
                                <option value="{{ $widget->id }}">{{ $widget->title }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type-content">Loại nội dung</label>
                            <select class="form-control <?php if($errors->has('type_content')) echo " is-invalid" ?>" name="type_content" id="type-content">
                                <option value="">Chọn</option>
                                <option value="plaintext-basic">Plaintext basic</option>
                                <option value="plaintext-icon">Plaintext kèm icon Font-awesome</option>
                                <option value="plaintext-slider-banner-group">Slider hoặc Banner với danh sách nội dung
                                    nổi ở trên
                                </option>
                            </select>
                            @error('type_content')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="order">Thứ tự xuất hiện (Từ trái sang phải và từ trên xuống dưới)</label>
                            <input class="form-control" type="text" name="order" id="order" value="{{ $last_order }}"
                                readonly>

                        </div>

                    </div>
                </div>

                <div class="row plaintext" style="display: none">
                    <div class="col-6">

                        <div class="form-group">
                            <label for="content">Nội dung</label>
                            <input class="form-control <?php if($errors->has('content')) echo " is-invalid" ?>" type="text" name="content" id="content">
                            @error('content')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="type-heading">Loại text</label>
                            <select class="form-control type-heading" id="type-heading" name="type_heading">
                                <option value="">Mặc định (Khuyên chọn)</option>
                                <option value="h1">Heading 1</option>
                                <option value="h2">Heading 2</option>
                                <option value="h3">Heading 3</option>
                                <option value="h4">Heading 4</option>
                                <option value="h5">Heading 5</option>
                                <option value="h6">Heading 6</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="type-color">Màu sắc</label>
                            <select class="form-control type-color" id="type-color" name="type_color">
                                <option value="">Mặc định (Khuyên chọn)</option>
                                <option value="#fff">#ffffff Trắng</option>
                                <option value="#0d6efd">#0d6efd Xanh</option>
                                <option value="#e62a16">#e62a16 Đỏ</option>
                                <option value="#000">#000000 Đen</option>
                                <option value="#4150b5">#4150b5 Tím</option>
                            </select>
                        </div>

                    </div>
                    <div class="col-6 plaintext-child-slider-banner" style="display: none">

                        <div class="form-group">
                            <label for="detail-id">Các plaintext con phụ thuộc vào slider hoặc banner</label>
                            <select class="form-control" name="detail_id[]" id="detail-id" multiple>
                                <option value="" disabled>Chọn</option>
                                @if (!empty($widget->widget_details))
                                @foreach ($widget->widget_details as $detail)
                                <option value="{{ $detail->id }}">{{ $detail->content }}</option>
                                @endforeach

                                @endif
                            </select>
                        </div>

                    </div>
                    <div class="col-6">
                        <input type="hidden" name="type_icon">
                        {{-- Icon --}}
                        <div class="form-group plaintext-icon" style="display: none">
                            {{-- Modal --}}
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target=".bd-example-modal-lg">Duyệt icon</button>
                            <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog"
                                aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myLargeModalLabel">Danh sách icon</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                                                <span aria-hidden="true">×</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="list-icon">
                                                @foreach (get_fontawesome() as $item)
                                                <li><i class="{{ $item }}"></i></li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Modal --}}
                        </div>
                        {{-- Slider Banner --}}
                        <input type="hidden" name="image_id">
                        <div class="form-group plaintext-slider-banner" style="display: none">
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                data-target="#exampleModalCenter">
                                Duyệt slider và banner
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered" role="document"
                                    style="max-width: 1000px!important">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLongTitle">Danh sách</h5>
                                            <button type="button" id="close-model" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <ul class="list-slider-banner">
                                                <h1>SLIDER</h1>
                                                @foreach ($sliders as $slider)
                                                <li><img data-image-id="{{ $slider->image->id }}"
                                                        src="{{ url($slider->image->url) }}"></li>
                                                @endforeach
                                                <h1>Banner</h1>
                                                @foreach ($banners as $banner)
                                                <li><img data-image-id="{{ $banner->image->id }}"
                                                        src="{{ url($banner->image->url) }}"></li>
                                                @endforeach
                                            </ul>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Preview Content --}}
                        <div class="form-group">
                            <label for="preview">Preview</label>
                            <div class="preview preview-content"></div>
                        </div>
                    </div>
                </div>

                {{-------- Nội dung 2 -------}}
                <div class="card-header font-weight-bold">Cài đặt liên kết nội dung</div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="page">Liên kết đến trang</label>
                            <select class="form-control choose-only-one" name="page" id="page">
                                <option value="">Chọn</option>
                                <option value="{{ route('client.home') }}" style="font-weight: bold">Trang chủ</option>
                                @if (!empty($pages))
                                @foreach ($pages as $page)
                                <option value="{{ route('client.page.detail', ['slug' => $page['slug']]) }}">{{
                                    $page['title'] }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category-product">Liên kết đến danh mục sản phẩm</label>
                            <select class="form-control choose-only-one" name="category_product" id="category-product">
                                <option value="">Chọn</option>
                                <option value="{{ route('client.product.category.index', ['slug' => 'all']) }}"
                                    style="font-weight: bold">Liên kết đến tất cả danh mục sản phẩm</option>
                                @if (!empty($categories_product))
                                @foreach ($categories_product as $category_product)
                                <option
                                    value="{{ route('client.product.category.index', ['slug' => $category_product['slug']]) }}">
                                    {{ str_repeat('— ', $category_product['level']) . $category_product['title'] }}
                                </option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="category-post">Liên kết đến danh mục bài viết</label>
                            <select class="form-control choose-only-one" name="category_post" id="category-post">
                                <option value="">Chọn</option>
                                <option value="{{ route('client.post.category.index', ['slug' => 'all']) }}"
                                    style="font-weight: bold">Liên kết đến tất cả danh mục bài viết</option>
                                @if (!empty($categories_post))
                                @foreach ($categories_post as $category_post)
                                <option
                                    value="{{ route('client.post.category.index', ['slug' => $category_post['slug']]) }}">
                                    {{ str_repeat('— ', $category_post['level']) . $category_post['title'] }}</option>
                                @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="external-link">Liên kết đến địa chỉ bên ngoài hệ thống</label>
                            <input type="text" class="form-control choose-only-one" name="external_link"
                                id="external-link">
                        </div>
                        <input type="hidden" name="url">
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="preview-url">Preview</label>
                            <div id="preview-url" class="preview"></div>
                        </div>
                        <div class="form-group">
                            <label for="">Trạng thái</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="on" value="on"
                                    checked="">
                                <label class="form-check-label" for="on">Công khai</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status" id="off" value="off">
                                <label class="form-check-label" for="off">Tạm ẩn</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="btn_create" class="btn btn-primary">Thêm mới</button>
            </form>

        </div>
    </div>
</div>
@endsection