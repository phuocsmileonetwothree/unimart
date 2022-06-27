<?php
use App\Image;

?>
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
    <div class="card">
        <div class="card-header font-weight-bold d-flex justify-content-between align-items-center">
            <h5 class="m-0 ">Danh sách nội dung của khối giao diện <strong>{{ $widget->title }}</strong></h5>
        </div>
        <div class="card-body">
            <div class="analytic">
                <a href="" class="text-primary">Trạng thái 1<span class="text-muted">(10)</span></a>
                <a href="" class="text-primary">Trạng thái 2<span class="text-muted">(5)</span></a>
                <a href="" class="text-primary">Trạng thái 3<span class="text-muted">(20)</span></a>
            </div>
            {{-- <div class="form-action form-inline py-3">
                <select class="form-control mr-1" id="">
                    <option>Chọn</option>
                    <option>Tác vụ 1</option>
                    <option>Tác vụ 2</option>
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div> --}}
            <a href="{{ route('admin.widget.content.create', ['id' => $widget->id]) }}" class="btn btn-primary">Thêm mới
                nội dung</a>
            <style>
                table td>a {
                    word-break: break-word;
                }
            </style>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Thứ tự</th>
                        <th scope="col">Đường dẫn liên kết với nội dung</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $index = 1; ?>
                    @if (!empty($widget_details))
                    @foreach ($widget_details as $item)
                    <tr>
                        <td scope="row">{{ $index }}</td>
                        <td><a class="text-primary" target="_blank" href="{{ $item['content'] }}">{{ str_repeat("— ", $item['level']) . $item['content'] }}</a></td>
                        <td>{!! !empty($item['image_id']) ? "<img width='120px'; height='80px'; src='" . url(Image::find($item['image_id'])->url) . "'>" : "—" !!}</td>
                        <td><strong>{{ $item['order'] }}</strong></td>
                        <td><a class="text-primary" target="_blank" href="{{ !empty($item['url']) ? $item['url'] : " —" }}">{{ !empty($item['url']) ? $item['url'] : "—" }}</a></td>
                        <td>{{ date('d-m-Y', strtotime($item['created_at'])) }}</td>
                        <td>                            
                            <a href="{{ route('admin.widget.content.destroy', $item['id']) }}" onclick="return confirm('Bạn chắc chắn xóa và không thể hoàn tác . Nội dung này và các nội dung con phụ thuộc sẽ bị xóa vĩnh viễn ở hệ thống và trang cho khách hàng')"
                                 class="btn btn-danger btn-sm rounded-0
                                text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    <?php $index++ ?>
                    @endforeach
                    @else
                    <tr class="bg-white">
                        <td>Không tồn tại nội dung</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection