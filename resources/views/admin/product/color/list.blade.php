@extends('layouts.admin')
@section('wp-content')
<style>
    .input-group-addon {
        border: 1px solid silver;
        border-radius: 2px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: rgba(0, 0, 0, .03);
    }

    .preview-color {
        --custom-color: #333;
    }

    .preview-color::placeholder {
        background: var(--custom-color);
        color: var(--custom-color);
    }

    input#preview {
        padding: 10px
    }
</style>
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
                    Thêm màu sắc
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.product.color.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="title">Tên màu sắc</label>
                            <input type="text" name="title" id="title" class="form-control <?php if(!empty($errors->first('title'))) echo " is-invalid" ?>" value="{{ old('title') }}">
                            @error('title')
                            <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="color-picker">Mã màu : #333333</label>
                            <input type="color" name="code" id="color-picker" value="#333333" class="form-control">
                            @error('code')
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
                    Danh sách màu sắc
                </div>
                <div class="card-body">
                    <table class="table table-striped index-js">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tên màu</th>
                                <th scope="col">Mã màu</th>
                                <th scope="col">Preview</th>
                                <th scope="col">Tác vụ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(!empty($colors))
                            <?php $index = 1 ?>
                            @foreach ($colors as $color)
                            <tr>
                                <td scope="col">{{ $index }}</td>
                                <td>{{ $color->title }}</td>
                                <td class="text-primary">{{ $color->title }}</td>
                                <td><input type="color" disabled value="{{ !empty($color->code) ? $color->code : "#333" }}"></td>

                                <td>
                                    <a href="{{ route('admin.product.color.edit', $color->id) }}"
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
                    @if (!empty($colors))
                    {{ $colors->links() }}
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>
@endsection