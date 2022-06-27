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
                    Cập nhật thương hiệu
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.brand.update', $brand->id) }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên thương hiệu</label>
                            <input type="text" name="name" id="name" class="form-control <?php if(!empty($errors->first('name'))) echo " is-invalid" ?>" value="{{ $brand -> name }}">
                            @error('title')
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