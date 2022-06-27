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
            Cập nhật bài viết
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('admin.post.update', $post->id) }}" enctype="multipart/form-data">
                @csrf
                {{-- Title --}}
                <div class="form-group">
                    <label for="title">Tiêu đề bài viết</label>
                    <input class="form-control<?php if($errors->has('title')) echo " is-invalid" ?>" type="text" name="title" id="title" value="{{ $post->title }}">
                    @error('title')
                    <small class="text-form text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- Slug --}}
                <div class="form-group">
                    <label for="slug">Đường dẫn</label>
                    <input class="form-control<?php if($errors->has('slug')) echo " is-invalid" ?>" type="text" name="slug" id="slug" value="{{ $post->slug }}">
                    @error('slug')
                    <small class="text-form text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- Desc --}}
                <div class="form-group">
                    <label for="desc">Mô tả</label>
                    <textarea name="desc" id="desc" rows="4" class="form-control">{{ $post->desc }}</textarea>
                    @error('desc')
                    <small class="text-form text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- Content --}}
                <div class="form-group">
                    <label for="content">Nội dung</label>
                    <textarea name="content" id="content" rows="10" class="form-control">{{ $post->content }}</textarea>
                    @error('content')
                    <small class="text-form text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- Thumb_old --}}
                <div class="form-group">
                    <label for="">Ảnh đại diện bài viết</label>
                    <img src="{{ url($post->thumb) }}" class="preview-image" style="display:block;width: 35%; height: auto;">
                    @error('thumb')
                    <small class="text-form text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="preview-file">Chọn ảnh đại diện mới</label>
                    <input type="file" name="file" id="preview-file" class="form-control<?php if($errors->has('file')) echo " is-invalid" ?>">
                    @error('thumb')
                    <small class="text-form text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- Catid --}}
                <div class="form-group">
                    <label for="cat_id">Danh mục</label>
                    <select class="form-control<?php if($errors->has('cat_id')) echo " is-invalid" ?>" id="cat_id" name="cat_id">
                        <option value="">Chọn danh mục</option>
                        @if (!empty($categories))
                        @foreach ($categories as $item)
                        <option {{ $post->cat_id == $item['id'] ? "selected" : "" }} value="{{ $item['id'] }}">{{ str_repeat('— ', $item['level']) . $item['title'] }}
                        </option>
                        @endforeach
                        @endif
                    </select>
                    @error('cat_id')
                    <small class="text-form text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- Status --}}
                <div class="form-group">
                    <label for="status">Trạng thái</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="on" value="on" {{ $post->status == 'on' ? "checked" : "" }}>
                        <label class="form-check-label" for="on">
                            Hoạt động
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="status" id="off" value="off" {{ $post->status == 'off' ? "checked" : "" }}>
                        <label class="form-check-label" for="off">
                            Chờ duyệt
                        </label>
                    </div>
                    @error('status')
                    <small class="text-form text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Thêm mới</button>
            </form>
        </div>
    </div>
</div>
@endsection