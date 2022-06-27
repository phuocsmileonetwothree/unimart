@extends('layouts.admin')

@section('wp-content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm sản phẩm
        </div>
        <div class="card-body">
            {!! Form::open(['url' => route('admin.product.store'), 'method' => 'POST', 'files' => true]) !!}
            <div class="row">
                {{-- Name - Price - Old Price --}}
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Tên sản phẩm</label>
                        <input class="form-control <?php if($errors->has('name')) echo " is-invalid" ?>" type="text"
                        name="name" id="name" value="{{ old('name') }}">
                        @error('name')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slug">Đường dẫn thân thiện</label>
                        <input class="form-control <?php if($errors->has('slug')) echo " is-invalid" ?>" type="text"
                        name="slug" id="slug" value="{{ old('slug') }}">
                        @error('slug')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input class="form-control <?php if($errors->has('price')) echo " is-invalid" ?>" type="text"
                        name="price" id="price" value="{{ old('price') }}">
                        @error('price')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="old-price">Giá cũ</label>
                        <input class="form-control <?php if($errors->has('old_price')) echo " is-invalid" ?>"
                        type="text" name="old_price" id="old-price"
                        value="{{ old('old_price') }}">
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
                            rows="1">{{ old('desc') }}</textarea>
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
                    rows="15">{{ old('content') }}</textarea>
                @error('content')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            {{-- Image --}}
            <div class="form-group">
                <label for="file">Hình ảnh sản phẩm</label>
                <input type="file" name="file[]" id="file" class="form-control <?php if($errors->has('file')) echo "
                    is-invalid" ?>" multiple="multiple">
                @error('file')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
                @if (count($errors->get('file.*')) > 0)
                <small class="form-text text-danger">{{ "Ảnh phải có định dạng jpeg, jpg, png, gif và không được lớn hơn
                    20MB" }}</small>
                @endif
            </div>
            {{-- Cat_id --}}
            <div class="form-group">
                <label for="cat">Thuộc danh mục</label>
                <select class="form-control event-load-brand-ajax <?php if($errors->has('cat_id')) echo " is-invalid"
                    ?>" id="cat" name="cat_id" data-url="{{ route('admin.product.load_brand_ajax') }}">
                    <option value="">Chọn danh mục</option>
                    @if (!empty($list_category))
                    @foreach ($list_category as $item)
                    <option {{ old('cat_id')==$item['id'] ? "selected" : "" }} {{ $item['parent_id']==0 ? "disabled"
                        : "" }} value="{{ $item['id'] }}">{{ str_repeat('— ', $item['level']) . $item['title'] }}
                    </option>
                    @endforeach
                    @endif
                </select>
                @error('cat_id')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            {{-- Brand_id --}}
            <div class="form-group">
                <label for="brand">Thuộc thương hiệu</label>
                <select class="form-control load-brand-ajax <?php if($errors->has('brand_id')) echo " is-invalid" ?>"
                    id="brand" name="brand_id" disabled>
                    <option value="">Chọn thương hiệu</option>
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
                            <option {{ old('ram_id')==$ram['id'] ? "selected" : '' }} value="{{ $ram['id'] }}">{{ $ram['title'] }}</option>
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
                            <option {{ old('memory_id')==$memory['id'] ? "selected" : '' }}  value="{{ $memory['id'] }}">{{ $memory['title'] }}</option>
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
                        
                        <select  multiple class="form-control <?php if($errors->has('color_id')) echo " is-invalid" ?>" name="color_id[]" id="color" style="height:250px; padding-left: 25px;">
                            <option value="" disabled>Chọn màu sắc</option>
                            @if (!empty($list_color))
                            @foreach ($list_color as $color)
                            <option <?php echo "style='background: {$color['code']}'"; ?> <?php if(!empty(old('color_id')) and in_array($color['id'], old('color_id'))) echo "selected" ?> value="{{ $color['id'] }}">{{ $color['title'] }}</option>
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
                <div class="col-6">
                    <div class="form-group">
                        <label for="">Trạng thái</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="on" value="on" checked {{
                                old('status')=='on' ? "checked" : "" }}>
                            <label class="form-check-label" for="on">Công khai</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="status" id="off" value="off" {{
                                old('status')=='off' ? "checked" : "" }}>
                            <label class="form-check-label" for="off">Ẩn - Chờ duyệt</label>
                        </div>
                    </div>
                </div>


                <div class="col-6">
                    <div class="form-group">
                        <label for="">Tồn kho</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stocking" id="still" value="still"
                                checked {{ old('stocking')=='still' ? "checked" : "" }}>
                            <label class="form-check-label" for="still">Còn hàng</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="stocking" id="out" value="out" {{
                                old('stocking')=='out' ? "checked" : "" }}>
                            <label class="form-check-label" for="out">Tạm hết hàng</label>
                        </div>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Thêm mới</button>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection