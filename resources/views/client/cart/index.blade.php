@extends('layouts.client')

@section('wp-content')
<!-- breadcrumb start -->
<div class="breadcrumb-main ">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="breadcrumb-contain">
                    <div>
                        <h2>cart</h2>
                        <ul>
                            <li><a href="javascript:void(0)">home</a></li>
                            <li><i class="fa fa-angle-double-right"></i></li>
                            <li><a href="javascript:void(0)">cart</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb End -->


<!-- Giỏ hàng -->
<section class="cart-section section-big-py-space b-g-light">
    <div class="custom-container">
        @if (!empty(Cart::count()))
        {{-- Danh sách sản phẩm --}}
        <div class="row">
            <div class="col-sm-12">
                <table class="table cart-table table-responsive-xs">
                    <thead>
                        <tr class="table-head">
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col" class="cart-product-color">Màu sắc</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Xóa</th>
                            <th scope="col">Tổng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <style>
                            @media (max-width: 767px){
                                    .cart-section tbody tr td.cart-product-color {
                                    display: none;
                                }
                                .cart-section .cart-table thead th.cart-product-color{
                                    display: none;
                                }
                            }
                            
                        </style>
                        @foreach (Cart::content() as $item)
                        <tr>
                            <td>
                                <a href="{{ route('client.product.detail', ['slug' => $item->options->slug]) }}"><img
                                        src="{{ $item->options->url }}"></a>
                            </td>
                            <td>
                                <a href="{{ route('client.product.detail', ['slug' => $item->options->slug]) }}">{{
                                    $item->name }}</a>
                                {{-- Mobile --}}
                                <div class="mobile-cart-content">
                                    <div class="row">
                                        <div class="col-xs-3">
                                            <a href="javascript:void(0)">{{ $item->options->color_title!=null ? $item->options->color_title : "Sản phẩm chỉ có 1 màu" }}</a>
                                        </div>
                                        <div class="col-xs-3">
                                            <div class="qty-box">
                                                <div class="input-group">
                                                    <input min="1" type="number" name="num-order-{{ $item->rowId }}"
                                                        value="{{ $item->qty }}" class="num-order"
                                                        data-id="{{ $item->rowId }}"
                                                        data-url="{{ route('client.cart.update') }}">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-xs-3">
                                            <h2 class="td-color">{{ current_format($item->price) }}</h2>
                                        </div>
                                        <div class="col-xs-3">
                                            <h2 class="td-color"><a href="{{ route('client.cart.remove', $item->rowId) }}"
                                                    class="icon"><i class="ti-close"></i></a></h2>
                                        </div>
                                    </div>
                                        
                                        
                                    
                                </div>
                                {{-- Mobile --}}
                            </td>
                            <td class="cart-product-color">
                                <a href="javascript:void(0)">{{ $item->options->color_title!=null ? $item->options->color_title : "Sản phẩm chỉ có 1 màu" }}</a>
                            </td>
                            <td>
                                <h2>{{ current_format($item->price) }}</h2>
                            </td>
                            <td>
                                <input min="1" type="number" name="num-order-{{ $item->rowId }}"
                                    value="{{ $item->qty }}" class="num-order" data-id="{{ $item->rowId }}"
                                    data-url="{{ route('client.cart.update') }}">
                            </td>
                            <td><a href="{{ route('client.cart.remove', $item->rowId) }}" class="icon"><i
                                        class="ti-close"></i></a></td>
                            <td>
                                <h2 class="td-color sub-total-{{ $item->rowId }}">{{ current_format($item->subtotal) }}
                                </h2>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                <table class="table cart-table table-responsive-md">
                    <tfoot>
                        <tr>
                            <td>Tổng tiền giỏ hàng</td>
                            <td>
                                <h2 class="total-price">{{ current_format(Cart::subtotal()) }}</h2>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        {{-- Thanh toán --}}
        <div class="row cart-buttons">
            <div class="col-12">
                <a href="{{ route('client.home') }}" class="btn btn-normal">Tiếp tục mua hàng</a>
                <a href="{{ route('client.cart.checkout') }}" class="btn btn-normal ms-3">Thanh toán</a>
            </div>
        </div>
        @else
        <div class="row justify-content-center" style="flex-wrap: wrap">
            <div style="flex-basis: 51%"><img style="width: 100%; height: auto;"
                    src="{{ url('public/images/empty-cart.png') }}" alt=""></div>


            <a href="{{ route('client.home') }}" class="btn btn-normal" style="flex-basis: 50%">Tiếp tục mua sắm</a>
        </div>
        @endif

    </div>
</section>


@endsection