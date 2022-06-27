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
                    Cập nhật màu sắc
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.color.update', $color->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Tên màu sắc</label>
                            <input type="text" name="title" id="title" class="form-control <?php if(!empty($errors->first('title'))) echo " is-invalid" ?>" value="{{ $color->title }}">
                            @error('title')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="color-picker">Mã màu : {{ !empty($color->code) ? $color->code : "#333333" }}</label>
                            <input type="color" name="code" id="color-picker" value="{{ !empty($color->code) ? $color->code : "#333333" }}" class="form-control">
                            @error('code')
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