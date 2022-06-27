@extends('layouts.admin')

@section('wp-content')
<div id="content" class="container-fluid">
    <div class="message">
        @if (session('success') !== null)
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error') !== null)
        <div class="alert alert-danger">{!! session('error') !!}</div>
        @endif
        @if (session('warning') !== null)
        <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
    </div>
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật banner
        </div>
        <div class="card-body">

            <form method="POST" action="{{ route('admin.banner.update', $banner->id) }}" enctype="multipart/form-data">
                @csrf
                {{-- Title --}}
                <div class="form-group">
                    <label for="title">Tên banner</label>
                    <input class="form-control <?php if($errors->has('title')) echo " is-invalid" ?>" type="text" name="title" id="title" value="{{ $banner->title }}">
                    @error('title')
                    <small class="text-form text-danger">{{ $message }}</small>
                    @enderror
                </div>
                {{-- Thumb_old --}}
                <div class="form-group">
                    <label for="banner-old">Banner</label>
                    <img src="{{ url($banner->image->url) }}" class="fit-image preview-image">
                </div>
                <div class="form-group">
                    <label for="preview-file">Chọn ảnh banner mới</label>
                    <input type="file" name="file" class="form-control <?php if($errors->has('file')) echo " is-invalid" ?>" id="preview-file">
                    @error('file')
                    <small class="text-form text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary">Cập nhật</button>
            </form>
        </div>
    </div>
</div>
@endsection