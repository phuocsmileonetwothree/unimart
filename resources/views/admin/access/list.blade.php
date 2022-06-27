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

            <h5 class="m-0 ">Danh sách thành viên</h5>
            <div class="form-search form-inline">
                {!! Form::open(['method' => 'GET']) !!}
                {!! Form::text('key', $key, ['class' => 'form-control form-search', 'placeholder' => 'Thành viên hoạt động']) !!}
                {!! Form::submit('Tìm kiếm', ['class' => 'btn btn-primary']) !!}
                {!! Form::close() !!}
            </div>
        </div>

        <div class="card-body">
            <div class="analytic">
                <a href="{{ url('admin/access/list?') . \Illuminate\Support\Arr::query(['status' => 'active']) }}" class="text-primary">Hoạt động<span class="text-muted">({{ $count['active'] }})</span></a>
                <a href="{{ url('admin/access/list?') . \Illuminate\Support\Arr::query(['status' => 'trash']) }}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{ $count['trash'] }})</span></a>
                {{-- <a href="{{ request()->fullUrlWithQuery(['status' => 'active']) }}" class="text-primary">Hoạt động<span class="text-muted">({{ $count['active'] }})</span></a> --}}
                {{-- <a href="{{ request()->fullUrlWithQuery(['status' => 'trash']) }}" class="text-primary">Vô hiệu hóa<span class="text-muted">({{ $count['trash'] }})</span></a> --}}
            </div>

            {!! Form::open(['url' =>  route('admin.access.action'), 'method' => 'POST']) !!}
            <div class="form-action form-inline py-3">
                {!! Form::select('action', $users -> list_action, '', ['class' => 'form-control mr-1']) !!}
                {!! Form::submit('Áp dụng', ['name' => 'btn_action', 'class' => 'btn btn-primary']) !!}
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="checkall">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Họ tên</th>
                        <th scope="col">Email</th>
                        <th scope="col">Quyền</th>
                        <th scope="col">Ngày tạo</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($users -> total() > 0)
                    @foreach ($users as $user)
                    <tr>
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{ $user -> id }}">
                        </td>
                        <th scope="row">{{ $index }}</th>
                        <td>{{ $user -> name }}</td>
                        <td>{{ $user -> email }}</td>
                        <td>Admintrator</td>
                        <td>{{ $user -> created_at }}</td>
                        <td>
                            <a href="{{ route('admin.access.edit', $user -> id) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Edit">
                                <i class="fa fa-edit"></i>
                            </a>
                            @if (Auth::id() != $user -> id)
                            <a href="{{ route("admin.access.{$users -> destroy_or_forceDelete}", $user -> id) }}" onclick="return confirm('{{ $users->confirm }}')" class="btn btn-danger btn-sm rounded-0 text-white" type="button" data-toggle="tooltip" data-placement="top" title="Delete">
                                <i class="fa fa-trash"></i>
                            </a>
                            @endif

                        </td>
                    </tr>
                    @php
                        $index++;
                    @endphp
                    @endforeach
                    @else
                    <tr class="bg-white">
                        <td colspan="7">Không tồn tại thành viên</td>
                    </tr>
                    @endif


                </tbody>
            </table>
            {!! Form::close() !!}
            @if ($users->total() > 0)
            {{ $users->appends(request()->input())->links() }}
            @endif
        </div>
    </div>
</div>
@endsection