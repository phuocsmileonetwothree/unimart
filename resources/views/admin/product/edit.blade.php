@extends('layouts.admin')

@section('wp-content')
<div id="content" class="container-fluid">
    <div class="message">
        @if (session('success') !== null)
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error') !== null)
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('warning') !== null)
        <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
    </div>
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật sản phẩm
        </div>
        <div class="card-body">
            {!! Form::open(['url' => route('admin.product.update', $product->id), 'method' => 'POST', 'files' => true])
            !!}

            <div class="row">
                {{-- Name - Price - Old Price --}}
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Tên sản phẩm</label>
                        <input class="form-control <?php if($errors->has('name')) echo " is-invalid" ?>" type="text"
                        name="name" id="name" value="{{ $product->name }}">
                        @error('name')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">Đường dẫn thân thiện</label>
                        <input class="form-control <?php if($errors->has('slug')) echo " is-invalid" ?>" type="text"
                        name="slug" id="slug" value="{{ $product->slug }}">
                        @error('slug')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input class="form-control <?php if($errors->has('price')) echo " is-invalid" ?>" type="text"
                        name="price" id="price" value="{{ $product->price }}">
                        @error('price')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="old-price">Giá cũ</label>
                        <input class="form-control <?php if($errors->has('old_price')) echo " is-invalid" ?>"
                        type="text" name="old_price" id="old-price" value="{{ $product->old_price }}">
                        @error('old_price')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                {{-- Desc --}}
                <div class="col-6">
                    <div class="form-group">
                        <script>
                            tinymce.init({
                              selector: 'textarea#desc',  
                              height: 300
                            });
                        </script>
                        <label for="desc">Mô tả ngắn</label>
                        <textarea name="desc" class="form-control" id="desc" cols="30"
                            rows="5">{{ $product->desc }}</textarea>
                        @error('desc')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            {{-- Content --}}
            <div class="form-group">
                <label for="content">Chi tiết sản phẩm</label>
                <textarea name="content" class="form-control" id="content" cols="30"
                    rows="15">{{ $product->content }}</textarea>
                @error('content')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            {{-- Image --}}
            <div class="form-group">
                <label>Hình ảnh</label>
                <div id="uploadFile">
                    <ul id="list-thumb" data-url="{{ route('admin.product.swap_order_image_ajax') }}">
                        @foreach ($product->images as $item)
                        <li>
                            <img data-image="{{ $item->id }}" width="150px" height="150px" src="{{ url($item->url) }}"
                                alt="">
                            <ul class="list-update-thumb" data-url="{{ route('admin.product.delete_image_ajax') }}">
                                <li>
                                    <a class="delete" href="" data-image="{{ $item->id }}" data-id="{{ $product->id }}"
                                        title="Xóa hình ảnh" class="edit">
                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endforeach
                    </ul>
                    <div id="input-upload-image">
                        <div class="add-image">
                            <div class="plus">
                                <span>+</span>
                                <input data-url="{{ route('admin.product.upload_image_ajax') }}"
                                    title="Thêm 1 hoặc nhiều ảnh" data-id="{{ $product->id }}" multiple type="file"
                                    name="files[]" class="add-list-image" id="files">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            {{-- Cat_id --}}
            <div class="form-group">
                <label for="cat">Danh mục</label>
                <select class="form-control event-load-brand-ajax<?php if($errors->has('cat_id')) echo " is-invalid" ?>"
                    id="cat" name="cat_id" data-url="{{ route('admin.product.load_brand_ajax') }}">
                    <option value="">Chọn danh mục</option>
                    @if (!empty($list_category))
                    @foreach ($list_category as $item)
                    <option {{ $product->cat_id == $item['id'] ? "selected" : "" }} {{ $item['parent_id']==0 ?
                        "disabled" : "" }} value="{{ $item['id'] }}">{{ str_repeat('— ', $item['level']) .
                        $item['title'] }}</option>
                    @endforeach
                    @endif
                </select>
                @error('cat_id')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                <label for="brand">Thuộc thương hiệu : <small class="text-note">Chọn thương hiệu cho sản phẩm , giúp
                        khách hàng phân loại dễ dàng trong quá trình tìm kiếm sản phẩm</small></label>
                <select class="form-control load-brand-ajax <?php if($errors->has('brand_id')) echo " is-invalid" ?>"
                    id="brand" name="brand_id">
                    <option value="">Chọn thương hiệu</option>
                    @if (!empty($list_brand))
                    @foreach ($list_brand as $key => $value)
                    <option {{ $product->brand_id==$key ? "selected" : "" }} value="{{ $key }}">{{ $value }}</option>
                    @endforeach
                    @endif
                </select>
                @error('brand_id')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            {{-- Memory&&Ram&&Color&&Group --}}
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="ram">Dung lượng ram</label>
                        <select class="form-control <?php if($errors->has('ram_id')) echo " is-invalid" ?>" name="ram_id" id="ram">
                            <option value="">Chọn dung lượng ram</option>
                            @if (!empty($list_ram))
                            @foreach ($list_ram as $ram)
                            <option {{ $product->ram_id==$ram['id'] ? 'selected' : '' }} value="{{ $ram['id'] }}">{{ $ram['title'] }}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('ram_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="memory">Dung lượng bộ nhớ trong</label>
                        <select class="form-control <?php if($errors->has('memory_id')) echo " is-invalid" ?>" name="memory_id" id="memory">
                            <option value="">Chọn bộ nhớ trong</option>
                            @if (!empty($list_memory))
                            @foreach ($list_memory as $memory)
                            <option {{ $product->memory_id==$memory['id'] ? 'selected' : '' }}  value="{{ $memory['id'] }}">{{ $memory['title'] }}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('memory_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="color">Màu sắc</label>
                        <select style="height: 250px; padding-left: 25px;" multiple class="form-control <?php if($errors->has('color_id')) echo " is-invalid" ?>"
                            name="color_id[]" id="color">
                            <option disabled value="" >Chọn màu sắc</option>
                            @if (!empty($list_color))
                            @foreach ($list_color as $color)
                            <option <?php echo "style='background: {$color['code']}'"; ?> <?php if(!empty($colors_of_product) and in_array($color['id'], $colors_of_product)) echo "selected" ?> value="{{ $color['id'] }}"><i class="far fa-check"></i>{{ $color['title'] }}</option>
                            @endforeach
                            @endif
                        </select>
                        @error('color_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                </div>
            </div>
            {{-- Status , Stocking, ... --}}
            <div class="row">
                <div class="col-4">
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="on" value="on" checked {{
                                $product->status=='on' ? "checked" : "" }}>
                            <label class="form-check-label" for="on">Công khai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="off" value="off" {{
                                $product->status=='off' ? "checked" : "" }}>
                            <label class="form-check-label" for="off">Ẩn - Chờ duyệt</label>
                        </div>
                    </div>
                </div>


                <div class="col-4">
                    <div class="form-group">
                        <label for="">Tồn kho</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stocking" id="still" value="still"
                                checked {{ $product->stocking=='still' ? "checked" : "" }}>
                            <label class="form-check-label" for="still">Còn hàng</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stocking" id="out" value="out" {{
                                $product->stocking=='out' ? "checked" : "" }}>
                            <label class="form-check-label" for="out">Tạm hết hàng</label>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection