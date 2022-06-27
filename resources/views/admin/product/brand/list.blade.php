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

        <div class="col-5" style="padding-right: 0!important">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm thương hiệu
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.brand.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="name">Tên thương hiệu</label>
                            <input type="text" name="name" id="name" class="form-control <?php if(!empty($errors->first('name'))) echo " is-invalid" ?>" value="{{ old('name') }}">
                            @error('name')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button type="submit" name="btn_create" value="Create" class="btn btn-primary">Thêm mới</button>
                    </form>
                </div>
            </div>
        </div>



        <div class="col-7">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thương hiệu
                </div>
                <div class="card-body">
                    <table class="table table-striped index-js">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($brands))
                            <?php $index = 1 ?>
                            @foreach ($brands as $brand)
                            <tr>
                                <td scope="col">{{ $index }}</td>
                                <td class="text-primary">{{ $brand->name }}</td>
                                <td>
                                    <a href="{{ route('admin.product.brand.edit', $brand->id) }}"
                                        class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    {{-- <a href="{{ route('admin.product.cat.destroy', $brand->id) }}"
                                        onclick="return confirm('Bạn chắc chắn xóa')"
                                        class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a> --}}
                                </td>
                            </tr>  
                            <?php $index++ ?>
                            @endforeach

                            @endif
                        </tbody>
                    </table>
                    @if (!empty($brands))
                    {{ $brands->links() }}
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>
@endsection