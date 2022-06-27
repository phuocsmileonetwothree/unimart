@extends('layouts.client')

@section('wp-content')
<!-- thank-you section start -->
<section class="section-big-py-space light-layout">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="success-text"><i class="fa fa-check-circle" aria-hidden="true"></i>
                    <h2>Thanks you</h2>
                    <p>Unimart đã tiếp nhận đơn hàng của bạn</p>
                    <p>Mã tra cứu đơn hàng : {{ $order->order_code }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Section ends -->


<!-- order-detail section start -->
<section class="section-big-py-space mt--5 b-g-light">
    <div class="custom-container">
        <div class="row">
            <div class="col-lg-6">
                <div class="product-order">
                    <h3>Chi tiết đơn hàng của {{ $order->fullname }}</h3>
                    @foreach ($order->order_details as $item)
                    <div class="row product-order-detail" style="align-items: flex-start;">
                        <div class="col-3"><img src="{{ url($item->product->images[0]->url) }}"  class="img-fluid ">
                        </div>
                        <div class="col-3 order_detail" style="word-break: break-word;">
                            <div>
                                <h4>Tên sản phẩm</h4>
                                <h5>{{ $item->product->name }}</h5>
                            </div>
                        </div>
                        <div class="col-3 order_detail" style="flex-wrap: wrap">
                            <div class="row">
                                <div class="col-12">
                                    <h4 style="display: inline-block">Số lượng</h4>
                                    <h5 style="display: inline-block">{{ $item->qty }}</h5>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h4 style="display: inline-block">Màu sắc : <h5 style="display: inline-block">{{ !empty($item->color_title) ? $item->color_title : "Sản phẩm chỉ có 1 màu" }}</h5></h4>
                                    @if (!empty($item->color_code))
                                    <input disabled type="color" value="{{ $item->color_code }}">
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-3 order_detail">
                            <div>
                                <h4>Giá</h4>
                                <h5>{{ current_format($item->product->price *  $item->qty) }}</h5>
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="final-total">
                        <h3>Tổng <span class="text-danger">{{ current_format($total_order) }}</span></h3>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="row order-success-sec">
                    <div class="col-sm-6">
                        <h4>Thông tin đơn hàng</h4>
                        <ul class="order-detail">
                            <li style="justify-content: space-between">Mã đơn hàng : <small class="text-danger">{{ " " . $order->order_code }}</small></li>
                            <li style="justify-content: space-between">Ngày đặt hàng : <small class="text-danger">{{ " " . $order->created_at }}</small></li>
                            <li style="justify-content: space-between">Tổng tiền đơn hàng : <small class="text-danger">{{ " " . current_format($total_order) }}</small></li>
                        </ul>
                    </div>
                    <div class="col-sm-6">
                        <h4>Thông tin khách hàng</h4>
                        <ul class="order-detail">
                            <li style="justify-content: space-between">Địa chỉ nhận hàng : <small class="text-danger">{{ " " . $order->address }}</small></li>
                            <li style="justify-content: space-between">Số điện thoại liên hệ : <small class="text-danger">{{ " " . $order->phone }}</small></li>
                        </ul>
                    </div>
                    <div class="col-sm-12 payment-mode">
                        <h4>Phương thức thanh toán</h4>
                        <p class="text-danger">COD - Thanh toán khi nhận hàng được khách hàng lựa chọn</p>
                    </div>
                    <div class="col-md-12">
                        <div class="delivery-sec">
                            <h3>Ngày dự kiến nhận hàng</h3>
                            <h2 class="text-danger">{{ date("d-m-Y", strtotime($order->created_at->format('d-m-Y')) + ((24*60*60) * 2)) }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection