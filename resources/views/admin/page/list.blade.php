@extends('layouts.admin')

@section('wp-content')
<div id="content" class="container-fluid">
    <div id="message">
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
            <h5 class="m-0 ">Danh sách trang</h5>
            <div class="form-search form-inline">
                {!! Form::open(['method' => 'GET']) !!}
                {!! Form::text('key', $key, ['class' => 'form-control form-search', 'placeholder' => 'Tìm kiếm']) !!}
                {!! Form::submit('Tìm kiếm', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>
        <div class="card-body">
            <div class="analytic">
                @if (!empty($count))
                @foreach ($count as $k => $v)
                <a href="{{ route('admin.page.list', ['status' => $k]) }}" class="text-primary">{{ convert_filter($k) }}<span class="text-muted">({{ $v }})</span></a>
                @endforeach
                @endif

            </div>
            {!! Form::open(['url' => route('admin.page.action'), 'method' => 'POST']) !!}
            <div class="form-action form-inline py-3">
                <select name="action" class="form-control mr-1">
                    <option value="">Chọn</option>
                    @if (!empty($pages->list_action))
                    @foreach ($pages->list_action as $item)
                        <option value="{{ $item }}">{{ convert_action($item) }}</option>
                    @endforeach
                    @endif
                </select>
                <input type="submit" value="Áp dụng" name="btn_action" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th scope="col">
                            <input name="checkall" type="checkbox">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Tiêu đề</th>
                        <th scope="col">Tác giả</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($pages -> total() > 0)
                    @foreach ($pages as $page)
                    <tr>
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{ $page -> id }}">
                        </td>
                        <td scope="row">{{ $index }}</td>
                        <td><a href="">{{ $page -> title }}</a></td>
                        <td>{{ !empty($page -> user -> name) ? $page -> user -> name : 'Không rõ tác giả' }}</td>
                        <td>{{ $page -> created_at }}</td>
                        <td>
                            <a href="{{ route('admin.page.edit', $page -> id) }}"
                                class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip"
                                data-placement="top" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>

                            <a href="{{ route("admin.page.destroy", $page -> id) }}"
                                onclick="return confirm('{{ $pages->confirm }}')" class="btn btn-danger btn-sm rounded-0
                                text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>
                        </td>

                    </tr>
                    @php
                    $index++;
                    @endphp
                    @endforeach
                    @else
                    <tr class="bg-white">
                        <td colspan="7">Không tồn tại trang</td>
                    </tr>
                    @endif


                </tbody>
            </table>
            {!! Form::close() !!}
            @if ($pages -> total() > 0)
            {{ $pages->appends(request()->input())->links() }}
            @endif
        </div>
    </div>
</div>
@endsection