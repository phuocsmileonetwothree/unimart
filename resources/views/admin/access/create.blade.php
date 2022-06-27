@extends('layouts.admin')

@section('wp-content')

<div id="content" class="container-fluid">
    {!! Form::open(['method' => 'POST', 'url' => route('admin.access.store')]) !!}
    <div class="row only-create">


        <div class="col-4">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm người dùng
                </div>
                <div class="card-body">
                    <div class="form-group">
                        {!! Form::label('name', 'Họ và tên', ['class' => 'form-control-label']) !!}
                        {!! Form::text('name', '', ['class' => 'form-control' . ($errors->has('name') ? ' is-invalid' : null), 'id' => 'name']) !!}
                        @error('name')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('email', 'Email', ['class' => 'form-control-label']) !!}
                        {!! Form::text('email', '', ['class' => 'form-control' . ($errors->has('email') ? ' is-invalid' : null), 'id' => 'email']) !!}
                        @error('email')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('password', 'Mật khẩu', ['class' => 'form-control-label']) !!}
                        {!! Form::password('password', ['class' => 'form-control' . ($errors->has('password') ? ' is-invalid' : null), 'id' => 'password']) !!}
                        @error('password')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('password-confirm', 'Xác nhận mật khẩu', ['class' => 'form-control-label']) !!}
                        {!! Form::password('password_confirm', ['class' => 'form-control' . ($errors->has('password_confirm') ? ' is-invalid' : null), 'id' => 'password-confirm'])
                        !!}
                        @error('password_confirm')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        {!! Form::label('role', 'Vai trò', ['class' => 'form-control-label']) !!}
                        <small class="text-success">: Cộng tác viên chỉ được đăng ký quyền CREATE</small>
                        <select name="role_id" id="role" class="form-control only-check-create<?php if($errors->has('role_id')) {echo " is-invalid";} ?>">
                            <option value="">Chọn</option>
                            @foreach ($roles as $key => $value)
                            <option {{ old('role_id')==$key ? "selected" : "" }} <?php if($key==2 or $value=='Quản trị hệ thống' ) echo "disabled" ?> value="{{ $key }}">{{ $value }}<?php if($key == 2 or $value == 'Quản trị hệ thống') echo " - Liên hệ quản lý để biết thêm chi tiết" ?></option>
                            @endforeach
                        </select>
                        @error('role_id')
                        <small class="form-text text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    {!! Form::submit('Thêm mới', ['class' => 'btn btn-primary', 'name' => 'btn_create']) !!}
                </div>
            </div>
        </div>

        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách quyền trên từng module
                </div>
                <div class="card-body">
                    <table class="table table-striped index-js">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Module</th>
                                <th scope="col">Tất cả quyền</th>
                                <th scope="col">Create</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Destroy</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $index = 1; ?>
                            @foreach ($modules as $module)
                            <tr>
                                <td scope ="col">{{ $index }}</td>
                                <td class="text-primary">{{ $module->title }}</td>
                                <td><input type="checkbox" name="check_permission[{{ $module->id }}]" class="check-all"></td>
                                @foreach ($permissions as $item)
                                <td><input type="checkbox" name="check_permission[{{ $module->id }}][]" value="{{ $item->id }}" class="check-item<?php if($item->id==2 or $item->title=="Create") echo " create-permission" ?>"></td>
                                @endforeach
                            </tr>  
                            <?php $index++; ?>
                            @endforeach
                            
                        </tbody>
                    </table>
                    @error('role_id')
                    <small class="form-text text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}

</div>
@endsection