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
            <h5 class="m-0 ">Danh sách đơn hàng</h5>
            <div class="form-search form-inline" style="flex-wrap: nowrap; flex-basis: 40%">
                {{-- Search --}}
                <form action="" method="GET" style="flex-basis: 100%">
                    <input type="" class="form-control form-search" name="key" value="{{ $key }}" placeholder="Nhập mã đơn hàng,tên khách hàng" style="width: 300px!important;" data-tip="This is the text of the tooltip2">
                    <input type="submit" class="btn btn-primary">
                </form>
            </div>
        </div>
        <div class="card-body">
            {{-- Filter --}}
            <div class="analytic">
                @foreach ($count as $k => $v)
                <a href="{{ route('admin.order.list', ['status' => $k]) }}" class="text-primary">{{ convert_filter($k) }}<span class="text-muted">({{ $v }})</span></a>
                @endforeach
            </div>
            {{-- Action --}}
            {!! Form::open(['url' => route('admin.order.action'), 'method' => 'POST']) !!}
            <div class="form-action form-inline py-3">
                <select class="form-control mr-1" name="action">
                    <option value="">Chọn</option>
                    @foreach ($orders->list_action as $item)
                    <option value="{{ $item }}">{{ convert_action($item) }}</option>
                    @endforeach
                </select>
                <input type="submit" name="btn-search" value="Áp dụng" class="btn btn-primary">
            </div>
            <table class="table table-striped table-checkall">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" name="checkall">
                        </th>
                        <th scope="col">#</th>
                        <th scope="col">Mã đơn hàng</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Số sản phẩm</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Thời gian</th>
                        <th scope="col">Tác vụ</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($orders -> total() > 0)
                    @foreach ($orders as $order)
                    <tr>
                        <td>
                            <input type="checkbox" name="list_check[]" value="{{ $order->id }}">
                        </td>
                        <td>{{ $index }}</td>
                        <td>{{ $order->order_code }}</td>
                        <td>{{ $order->fullname }}</td>
                        <?php $total_qty = 0; $total_price = 0; ?>
                        <td>{{ $order->total_qty }}</td>
                        <td>{{ current_format($order->total_price) }}</td>
                        <td><span class="badge badge-{{ convert_class_status($order->status) }}">{{ convert_action($order->status) }}</span></td>
                        <td>{{ $order->created_at->format('d-m-Y') }} lúc {{ $order->created_at->format('H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.order.detail', ['id' => $order->id]) }}" class="btn btn-success btn-sm rounded-0 text-white" type="button"
                                data-toggle="tooltip" data-placement="top" title="Chi tiết"><i class="fa fa-edit"></i></a>
                        </td>
                    </tr>
                    <?php $index++ ?>
                    @endforeach
                    @else
                    <tr class="bg-white">
                        <td>Không tồn tại đơn hàng</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            {!! Form::close() !!}
            @if ($orders -> total() > 0)
            {{ $orders->appends(request()->input())->links() }}
            @endif
        </div>
    </div>
</div>
@endsection