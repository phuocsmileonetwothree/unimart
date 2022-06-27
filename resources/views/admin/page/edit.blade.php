@extends('layouts.admin')

@section('wp-content')

<div id="content" class="container-fluid">
    @if (session('success') !== null)
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold">
            Cập nhật thông tin trang
        </div>
        <div class="card-body">
            {!! Form::open(['method' => 'POST', 'url' => route('admin.page.update', $page -> id)]) !!}
            <div class="form-group">
                {!! Form::label('title', 'Tiêu đề trang') !!}
                {!! Form::text('title', $page -> title, ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : null), 'id' => 'title']) !!}
                @error('name')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('slug', 'Đường dẫn') !!}
                {!! Form::text('slug', $page -> slug, ['class' => 'form-control' . ($errors->has('slug') ? ' is-invalid' : null), 'id' => 'slug']) !!}
                @error('name')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('content', 'Nội dung trang') !!}
                {!! Form::textarea('content', $page -> content, ['class' => 'form-control' . ($errors->has('content') ? ' is-invalid' : null), 'id' => 'content']) !!}
                @error('content')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            {!! Form::submit('Cập nhật', ['class' => 'btn btn-primary', 'name' => 'btn_edit']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection