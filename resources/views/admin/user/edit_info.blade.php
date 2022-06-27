@extends('layouts.admin')

@section('wp-content')
<div id="content" class="container-fluid">
    @if (session('success') !== null)
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error') !== null)
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (session('warning') !== null)
    <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Cập nhật thông tin</h5>
        </div>
        <div class="card-body">
            {!! Form::open(['url' => route('admin.user.update_info', Auth::id()), 'method' => "POST"]) !!}
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="name">Tên</label>
                        <input type="text" name="name" id="name" class="form-control <?php if($errors->has('name')) echo " is-invalid" ?>" value="{{ $user->name }}">
                        @error('name')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email" class="form-control" disabled value="{{ $user->email }}">
                    </div>

                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="old-password">Mật khẩu cũ</label>
                        <input type="text" name="old_password" id="old-password" class="form-control <?php if($errors->has('old_password')) echo " is-invalid" ?>">
                        @error('old_password')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">Mật khẩu mới</label>
                        <input type="text" name="password" id="password" class="form-control <?php if($errors->has('password')) echo " is-invalid" ?>">
                        @error('password')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="re-password">Xác nhận mật khẩu mới</label>
                        <input type="text" name="password_confirm" id="re-password" class="form-control <?php if($errors->has('password_confirm')) echo " is-invalid" ?>">
                        @error('password_confirm')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::submit('Cập nhật', ['class' => 'btn btn-primary', 'name' => 'btn_edit']) !!}
                        <a href="{{ route('admin.user.profile') }}" class="btn btn-danger"
                            title="Hủy sẽ không lưu những thay đổi">Hủy</a>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}

        </div>
    </div>
</div>


@endsection
