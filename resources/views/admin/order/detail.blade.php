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
            <h5 class="m-0 ">Chi tiết đơn hàng</h5>
        </div>
        <div class="card-body">
            <div id="content" class="detail-exhibition fl-right">

                <!-- Thông tin khách hàng -->
                <div class="section" id="info">
                    <div class="section-head">
                        <h3 class="section-title">Thông tin khách hàng</h3>
                    </div>
                    <ul class="list-item">
                        <li>
                            <h3 class="title"><i class="fas fa-barcode"></i>Mã đơn hàng</h3>
                            <span class="detail">{{ $order->order_code }}</span>
                        </li>
                        <li>
                            <h3 class="title"><i class="fas fa-map-marker-alt"></i>Địa chỉ nhận hàng</h3>
                            <span class="detail">
                                {{ $order->address }}
                            </span>
                        </li>
                        <li>
                            <h3 class="title"><i class="fas fa-phone-square"></i>Số điện thoại người nhận</h3>
                            <a class="detail" href="tel:{{ $order->phone }}">
                                {{ $order->phone }}
                            </a>
                        </li>
                        <li>
                            <h3 class="title"><i class="fas fa-credit-card"></i>Phương thức thanh toán</h3>
                            <span class="detail">
                                {{ $order->payment }}
                            </span>
                        </li>
                        {!! Form::open(['url' => route('admin.order.update', $order->id), 'method' => 'POST']) !!}
                            <li>
                                <h3 class="title"><i class="fas fa-dolly"></i>Tình trạng đơn hàng</h3>
                                <select name="status" class="form-control mr-1"
                                    style="width: 30%; display: inline-block; margin-right: 5px">
                                    <option value="processing" {{ $order->status=="processing" ? "selected" : "" }}>Đang
                                        xử lý</option>
                                    <option value="cancelled" {{ $order->status=="cancelled" ? "selected" : "" }}>Đã hủy
                                    </option>
                                    <option value="transported" {{ $order->status=="transported" ? "selected" : ""
                                        }}>Đang vận chuyển</option>
                                    <option value="successful" {{ $order->status=="successful" ? "selected" : "" }}>Giao
                                        hàng thành công</option>
                                </select>
                                <input type="submit" name="btn_update" class="btn btn-primary" value="Cập nhật đơn hàng">
                            </li>
                        {!! Form::close() !!}
                    </ul>
                </div>


                <!-- Thông tin chi tiết đơn hàng -->
                <div class="section">
                    <div class="section-head">
                        <h3 class="section-title">Sản phẩm đơn hàng</h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-checkall">
                            <thead>
                                <tr>
                                    <th scope="col">STT</th>
                                    <th scope="col">Ảnh sản phẩm</th>
                                    <th scope="col">Tên sản phẩm</th>
                                    <th scope="col">Đơn giá</th>
                                    <th scope="col">Số lượng</th>
                                    <th scope="col">Màu sắc</th>
                                    <th scope="col">Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $index = 1; ?>
                                @foreach ($order->order_details as $item)
                                <tr>
                                    <td class="thead-text">{{ $index }}</td>
                                    <td class="thead-text">
                                        <div class="thumb">
                                            <img width="80px" height="80px"
                                                src="{{ url($item->product->images[0]->url) }}">
                                        </div>
                                    </td>
                                    <td class="thead-text">{{ $item->product->name }}</td>
                                    <td class="thead-text">{{ current_format($item->price) }}</td>
                                    <td class="thead-text">{{ $item->qty }}</td>
                                    <td class="thead-text">{!! !empty($item->color_title) ? $item->color_title . "<br><input type='color' value='{$item->color_code}' disabled>" : "Không có"  !!}<br></td>
                                    <td class="thead-text">{{ current_format($item->qty * $item->price) }}</td>
                                </tr>
                                <?php $index++ ?>
                                @endforeach

                            </tbody>
                        </table>
                    </div>

                </div>

                <!-- Thông tin tổng đơn hàng -->
                <div class="section">
                    <h3 class="section-title">Giá trị đơn hàng</h3>
                    <div class="section-detail">
                        <ul class="list-item clearfix">
                            <li>
                                <span class="total-fee">Tổng số lượng</span>
                                <span class="total">Tổng đơn hàng</span>
                            </li>
                            <li>
                                <span class="total-fee">{{ $order->total_qty }} sản phẩm</span>
                                <span class="total">{{ current_format($order->total_price) }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection