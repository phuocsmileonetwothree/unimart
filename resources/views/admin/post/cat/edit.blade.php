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
    <div class="row">

        <div class="col-12" style="padding-right: 0!important">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Cập nhật danh mục
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.post.cat.update', $category -> id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Tên danh mục</label>
                            <input type="text" name="title" id="title"
                                class="form-control <?php if(!empty($errors->first('title'))) echo " is-invalid" ?>"
                            value="{{ $category -> title }}">
                            @error('title')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="slug">Đường dẫn</label>
                            <input type="text" name="slug" id="slug"
                                class="form-control <?php if(!empty($errors->first('slug'))) echo " is-invalid" ?>"
                            value="{{ $category -> slug }}">
                            @error('slug')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="description">Mô tả</label>
                            <textarea name="description" id="description"
                                class="form-control <?php if(!empty($errors->first('description'))) echo " is-invalid"
                                ?>" rows="5">{{ $category -> description }}</textarea>
                            @error('description')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="parent_id">Danh mục cha</label>
                            <select name="parent_id" id="parent_id" class="form-control <?php if(!empty($errors->first('parent_id'))) echo " is-invalid" ?>">
                                <option value="">Chọn</option>
                                <option value="0" style="font-weight: bold" <?php if($category -> parent_id == 0) echo
                                    "selected" ?>>(Trống) Không có danh mục cha</option>
                                @if (!empty($list_category))
                                @foreach ($list_category as $item)
                                <option <?php if($item['id']==$category -> id) echo 'disabled' ?>
                                    <?php if($item['id'] == $category -> parent_id) echo 'selected' ?> value="{{
                                    $item['id'] }}">{{ str_repeat('— ', $item['level']) . $item['title']}}
                                </option>
                                @endforeach
                                @endif
                            </select>
                            @error('parent_id')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <button type="submit" name="btn_edit" value="Edit" class="btn btn-primary">Cập nhật</button>
                    </form>
                </div>
            </div>
        </div>





    </div>

</div>
@endsection