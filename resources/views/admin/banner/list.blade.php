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

        <div class="col-4" style="padding-right: 0!important">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Thêm banner
                </div>
                <div class="card-body">
                    {!! Form::open(['url' => route('admin.banner.store'), 'method' => 'POST', 'files' => true]) !!}
                    <div class="form-group">
                        <label for="title">Tên banner (có thể là mô tả)</label>
                        <input class="form-control <?php if($errors->has('title')) echo " is-invalid" ?>" type="text" name="title" id="title">
                        @error('title')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="file">Hình ảnh</label>
                        <input class="form-control <?php if($errors->has('file')) echo " is-invalid" ?>" type="file" name="file" id="file">
                        @error('file')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Thêm mới</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>



        <div class="col-8">
            <div class="card">
                <div class="card-header font-weight-bold">
                    Danh sách banner
                </div>
                <div class="card-body">
                    <table class="table table-striped index-js">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Ảnh</th>
                                <th scope="col">Tên banner</th>
                                <th scope="col">Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (!$banners->isEmpty())
                            @foreach ($banners as $banner)
                            <tr>
                                <td>{{ $index }}</td>
                                <td><img width="120px" height="80px" src="{{ url($banner->image->url) }}" alt=""></td>
                                <td class="text-primary">{{ $banner->title }}</td>
                                <td>
                                    <a href="{{ route('admin.banner.edit', $banner->id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Edit">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="{{ route('admin.banner.destroy', $banner->id) }}" class="btn btn-danger btn-sm rounded-0 text-white" type="button"
                                        data-toggle="tooltip" data-placement="top" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php $index++ ?>
                            @endforeach
                            @else
                            <tr class="bg-white">
                                <td>Không tồn tại banner</td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
                    @if (!$banners->isEmpty())
                    {{ $banners->links() }}
                    @endif
                </div>
            </div>
        </div>

    </div>

</div>
@endsection