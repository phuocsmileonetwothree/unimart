@extends('layouts.admin')

@section('wp-content')
<div id="content" class="container-fluid">
    <div class="card">
        <div class="card-header font-weight-bold">
            Thêm trang
        </div>
        <div class="card-body">
            {!! Form::open(['url' => route('admin.page.store'), 'method' => 'POST']) !!}
            <div class="form-group">
                {!! Form::label('title', 'Tiêu đề trang') !!}
                {!! Form::text('title', old('title'), ['class' => 'form-control' . ($errors->has('title') ? ' is-invalid' : null), 'id' => 'title']) !!}
                @error('title')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('slug', 'Đường dẫn') !!}
                {!! Form::text('slug', old('slug'), ['class' => 'form-control' . ($errors->has('slug') ? ' is-invalid' : null), 'id' => 'slug']) !!}
                @error('slug')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="form-group">
                {!! Form::label('content', 'Nội dung trang') !!}
                {!! Form::textarea('content', old('content'), ['class' => 'form-control' . ($errors->has('content') ? ' is-invalid' : null), 'id' => 'content']) !!}
                @error('content')
                <small class="form-text text-danger">{{ $message }}</small>
                @enderror
            </div>
            {!! Form::submit('Thêm mới', ['class' => 'btn btn-primary', 'name' => 'btn_create']) !!}
            {!! Form::close() !!}
            </form>
        </div>
    </div>
</div>
@endsection