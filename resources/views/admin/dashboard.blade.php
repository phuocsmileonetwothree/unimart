@extends('layouts.admin')


@section('wp-content')
@if (session('warning') !== null)
<div class="alert alert-warning">{{ session('warning') }}</div>
@endif
<div class="container-fluid py-5">
    <div class="row">
        <div class="col">
            <div class="card text-white bg-primary mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG THÀNH CÔNG</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $count['successful'] }}</h5>
                    <p class="card-text">Đơn hàng giao dịch thành công</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-danger mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐANG XỬ LÝ</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $count['processing'] }}</h5>
                    <p class="card-text">Số lượng đơn hàng đang xử lý</p>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="card text-white bg-success mb-3" style="max-width: 18rem;">
                <div class="card-header">DOANH SỐ</div>
                <div class="card-body">
                    <h5 class="card-title">{{ current_format($count['sales'][0]->total_sales) }}</h5>
                    <p class="card-text">Doanh số hiện tại trong hệ thống</p>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="card text-white bg-dark mb-3" style="max-width: 18rem;">
                <div class="card-header">ĐƠN HÀNG HỦY</div>
                <div class="card-body">
                    <h5 class="card-title">{{ $count['cancelled'] }}</h5>
                    <p class="card-text">Số đơn bị hủy trong hệ thống</p>
                </div>
            </div>
        </div>
    </div>
    <!-- end analytic  -->
    <div class="card">
        <div class="card-header font-weight-bold">
            ĐƠN HÀNG MỚI
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
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
                    <?php $index = 1; ?>
                    @foreach ($orders as $order)
                    <tr>
                        <td>{{ $index }}</td>
                        <td><a href="{{ route('admin.order.detail', ['id' => $order->id]) }}">{{ $order->order_code }}</a></td>
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
        </div>
    </div>

</div>
@endsection