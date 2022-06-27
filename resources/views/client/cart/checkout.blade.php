@extends('layouts.client')

@section('wp-content')
<!--order tracking start-->
<section class="order-tracking section-big-my-space  ">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div id="msform">
                    <!-- progressbar -->
                    <ul id="progressbar">
                        <li class="active" data-index="1"
                            data-next="{{ !empty(session('info.fullname')) ? 'true' : '' }}">
                            <div class="icon">
                                <svg viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                                    <g id="_01-home" data-name="01-home">
                                        <g id="glyph">
                                            <path
                                                d="m256 4c-108.075 0-196 87.925-196 196 0 52.5 31.807 119.92 94.537 200.378a1065.816 1065.816 0 0 0 93.169 104.294 12 12 0 0 0 16.588 0 1065.816 1065.816 0 0 0 93.169-104.294c62.73-80.458 94.537-147.878 94.537-200.378 0-108.075-87.925-196-196-196zm0 336c-77.2 0-140-62.8-140-140s62.8-140 140-140 140 62.8 140 140-62.8 140-140 140z" />
                                            <path
                                                d="m352.072 183.121-88-80a12 12 0 0 0 -16.144 0l-88 80a12.006 12.006 0 0 0 -2.23 15.039 12.331 12.331 0 0 0 10.66 5.84h11.642v76a12 12 0 0 0 12 12h28a12 12 0 0 0 12-12v-44a12 12 0 0 1 12-12h24a12 12 0 0 1 12 12v44a12 12 0 0 0 12 12h28a12 12 0 0 0 12-12v-76h11.642a12.331 12.331 0 0 0 10.66-5.84 12.006 12.006 0 0 0 -2.23-15.039z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span>Địa chỉ</span>
                        </li>
                        <li data-index="2">
                            <div class="icon">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                    style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path
                                                d="M482,181h-31v-45c0-37.026-27.039-67.672-62.366-73.722C382.791,44.2,365.999,31,346,31H166 c-19.999,0-36.791,13.2-42.634,31.278C88.039,68.328,61,98.974,61,136v45H30c-16.569,0-30,13.431-30,30c0,16.567,13.431,30,30,30 h452c16.569,0,30-13.433,30-30C512,194.431,498.569,181,482,181z M421,181H91v-45c0-20.744,14.178-38.077,33.303-43.264 C130.965,109.268,147.109,121,166,121h180c18.891,0,35.035-11.732,41.697-28.264C406.822,97.923,421,115.256,421,136V181z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M33.027,271l24.809,170.596C60.648,464.066,79.838,481,102.484,481h307.031c22.647,0,41.837-16.934,44.605-39.111 L478.973,271H33.027z M151,406c0,8.291-6.709,15-15,15s-15-6.709-15-15v-90c0-8.291,6.709-15,15-15s15,6.709,15,15V406z M211,406 c0,8.291-6.709,15-15,15s-15-6.709-15-15v-90c0-8.291,6.709-15,15-15s15,6.709,15,15V406z M271,406c0,8.291-6.709,15-15,15 c-8.291,0-15-6.709-15-15v-90c0-8.291,6.709-15,15-15s15,6.709,15,15V406z M331,406c0,8.291-6.709,15-15,15 c-8.291,0-15-6.709-15-15v-90c0-8.291,6.709-15,15-15c8.291,0,15,6.709,15,15V406z M391,406c0,8.291-6.709,15-15,15 c-8.291,0-15-6.709-15-15v-90c0-8.291,6.709-15,15-15c8.291,0,15,6.709,15,15V406z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span>Giao hàng</span>
                        </li>
                        <li data-index="3">
                            <div class="icon">
                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                    style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                    <g>
                                        <g>
                                            <path
                                                d="M224,159.992v-32H32c-17.632,0-32,14.368-32,32v64h230.752C226.304,204.44,224,183.384,224,159.992z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M510.688,287.992c-21.824,33.632-55.104,62.24-102.784,89.632c-7.328,4.192-15.584,6.368-23.904,6.368 s-16.576-2.176-23.808-6.304c-47.68-27.456-80.96-56.096-102.816-89.696H0v160c0,17.664,14.368,32,32,32h448 c17.664,0,32-14.336,32-32v-160H510.688z M144,383.992H80c-8.832,0-16-7.168-16-16c0-8.832,7.168-16,16-16h64 c8.832,0,16,7.168,16,16C160,376.824,152.832,383.992,144,383.992z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path
                                                d="M502.304,81.304l-112-48c-4.064-1.728-8.576-1.728-12.64,0l-112,48C259.808,83.8,256,89.592,256,95.992v64 c0,88.032,32.544,139.488,120.032,189.888c2.464,1.408,5.216,2.112,7.968,2.112s5.504-0.704,7.968-2.112 C479.456,299.608,512,248.152,512,159.992v-64C512,89.592,508.192,83.8,502.304,81.304z M444.512,154.008l-64,80 c-3.072,3.776-7.68,5.984-12.512,5.984c-0.224,0-0.48,0-0.672,0c-5.088-0.224-9.792-2.848-12.64-7.104l-32-48 c-4.896-7.36-2.912-17.28,4.448-22.176c7.296-4.864,17.248-2.944,22.176,4.448l19.872,29.792l50.304-62.912 c5.536-6.88,15.616-7.968,22.496-2.496C448.896,137.016,449.984,147.096,444.512,154.008z" />
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <span>Thanh toán</span>
                        </li>
                    </ul>
                    <!-- fieldsets -->
                    <fieldset data-index="1" class="custom-checkout-ajax">
                        <div class="container p-0">
                            <div class="checkout-page contact-page">
                                <div class="checkout-form">
                                    <form method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                                <div class="checkout-title">
                                                    <h3>Thông tin giao hàng</h3>
                                                </div>
                                                <div class="theme-form">
                                                    <div class="row check-out">
                                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                            <label for="fullname">Họ và tên</label>
                                                            <input type="text" name="fullname" id="fullname"
                                                                value="{{ !empty(session('info.fullname')) ? session('info.fullname') : '' }}">
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                            <label for="phone">Số điện thoại</label>
                                                            <input type="text" name="phone" id="phone"
                                                                value="{{ !empty(session('info.phone')) ? session('info.phone') : '' }}">
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                            <label for="email">Email</label>
                                                            <input type="text" name="email" id="email"
                                                                value="{{ !empty(session('info.email')) ? session('info.email') : '' }}">
                                                        </div>
                                                        <div class="form-group col-md-6 col-sm-6 col-xs-12">
                                                            <label for="address">Địa chỉ</label>
                                                            <input type="text" name="address" id="address"
                                                                value="{{ !empty(session('info.address')) ? session('info.address') : '' }}">
                                                        </div>
                                                        <div class="form-group col-md-12 col-sm-12 col-xs-12">
                                                            <label for="note" style="margin-bottom: 10px!important;">Ghi chú</label>
                                                            <textarea name="note" id="note"
                                                                style="height: 100px;padding-top: 10px"
                                                                placeholder="VD: Giao hàng trước 5h , địa chỉ chính xác ,...">{{ !empty(session('info.note')) ? session('info.note') : '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6 col-sm-12 col-xs-12">
                                                <div class="checkout-details theme-form  section-big-mt-space">
                                                    <div class="order-box">
                                                        <div class="title-box">
                                                            <div>Sản phẩm <span>Tổng</span></div>
                                                        </div>
                                                        <ul class="qty">
                                                            @foreach ($cart as $item)
                                                            <li>{{ $item->name }} × <span class="text-danger">{{ $item->qty }}</span> <span>{{ current_format($item->subtotal) }}</span></li>
                                                            @endforeach
                                                        </ul>
                                                        <ul class="sub-total">
                                                            <li>Subtotal <span class="count">{{ current_format($cart_total) }}</span></li>
                                                            <li>Shipping
                                                                <div class="shipping">
                                                                    <div class="shopping-option">
                                                                        <input type="checkbox" name="free-shipping"
                                                                            checked disabled id="free-shipping">
                                                                        <label for="free-shipping">Miễn phí ship</label>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <ul class="total">
                                                            <li>Total <span class="count">{{
                                                                    current_format($cart_total) }}</span></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <a href="" data-url="{{ route('client.cart.set_info') }}" class="btn btn-solid btn-sm action-button custom-checkout-ajax">Tiếp theo</a>
                    </fieldset>
                    <fieldset data-index="2">
                        <div class="container p-0">
                            <div class="row shpping-block">
                                <div class="col-lg-8">
                                    <div class="order-tracking-contain order-tracking-box">
                                        <div class="tracking-group">
                                            <div class="delevery-code">
                                                <h4>Giao hàng đến : <span>{{ !empty(session('info.address')) ? session('info.address') : '' }}</span></h4>
                                                <a href="javascript:void(0)" class="btn btn-solid btn-sm previous action-button-previous">Đổi địa chỉ nhận hàng</a>
                                            </div>
                                        </div>
                                        {{-- <div class="tracking-group">
                                            <div class="product-offer">
                                                <h6 class="product-title"><i class="fa fa-tags"></i>5 offers Available
                                                </h6>
                                                <div class="offer-contain">
                                                    <ul>
                                                        <li>
                                                            <div>
                                                                <h5>Get extra $40 off on first Orders</h5>
                                                                <p>Use code "OFFER40" Min. Cart Value $99 | Max.
                                                                    Discount $40</p>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <ul class="offer-sider">
                                                        <li>
                                                            <div>
                                                                <h5>Get extra $25 off on second Orders</h5>
                                                                <p>Use code "OFFER25" Min. Cart Value $99 | Max.
                                                                    Discount $25</p>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <h5>Bank Offer40% Unlimited Cashback on bideal Axis Bank
                                                                    Credit Card</h5>
                                                                <p>Use code "OFFER40" Min. Cart Value $99 | Max.
                                                                    Discount $40</p>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <h5>Bank Offer10% off* with Axis Bank Buzz Credit Card
                                                                </h5>
                                                                <p>Use code "OFFER10" Min. Cart Value $99 | Max.
                                                                    Discount $10</p>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <h5>Bank Offer5% Unlimited Cashback on bideal sbi banck
                                                                    Credit Card</h5>
                                                                <p>Use code "OFFER5" Min. Cart Value $99 | Max. Discount
                                                                    $5</p>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                    <h5 class="show-offer"><span class="more-offer">show more
                                                            offer</span><span class="less-offer">less offer</span></h5>
                                                </div>
                                            </div>
                                        </div> --}}
                                        <div class="tracking-group pb-0">
                                            <h4 class="tracking-title"></h4>
                                            <ul class="may-product">
                                                @foreach ($cart as $item)
                                                <li>
                                                    <div class="media">
                                                        @if (isset($item->rowId))
                                                        <img src="{{ url($item->options->url) }}" class="img-fluid">
                                                        @else
                                                        <img src="{{ url($item->url) }}" class="img-fluid">
                                                        @endif
                                                        <div class="media-body">
                                                            <h3>{{ $item->name }}</h3>
                                                            <h4>
                                                                {{ current_format($item->price) }}
                                                                @if (isset($item->rowId))
                                                                <span>{{ current_format($item->options->old_price) }}</span>
                                                                @else
                                                                <span>{{ current_format($item->old_price) }}</span>
                                                                @endif
                                                            </h4>


                                                            <h6>Số lượng</h6>
                                                            @if (isset($item->rowId))
                                                            <input min="1" type="number" name="num-order-{{ $item->rowId }}" value="{{ $item->qty }}" class="num-order" data-id="{{ $item->rowId }}" data-url="{{ route('client.cart.update') }}">
                                                            @else
                                                            <input min="1" type="number" name="num_buy_now" value="{{ $item->qty }}" class="num-buy-now" data-id="{{ $item->id }}" data-url="{{ route('client.cart.update_buy_now') }}">
                                                            @endif


                                                            <?php if(isset($item->rowId)){
                                                            ?>
                                                            <h6>Màu sản phẩm : <?php echo $item->options->color_title!=null ? $item->options->color_title : "Sản phẩm chỉ có 1 màu"; ?></h6>
                                                            <?php if($item->options->color_code!=null){
                                                            ?>
                                                            <input type="color" disabled value="<?php echo $item->options->color_code ?>">
                                                            <?php
                                                            } ?>
                                                            <?php
                                                            }else{
                                                            ?>
                                                            <h6>Màu sản phẩm : <?php echo $item->color_title!=null ? $item->color_title : "Sản phẩm chỉ có 1 màu"; ?></h6>
                                                            <?php if($item->color_code!=null){
                                                            ?>
                                                            <input type="color" disabled value="{{ $item->color_code }}">
                                                            <?php
                                                            } ?>
                                                            <?php
                                                            } ?>


                                                        </div>
                                                        <div class="pro-add">
                                                            @if (isset($item->rowId))
                                                            <a href="{{ route('client.cart.remove', ['row_id' => $item->rowId]) }}" class="tooltip-top"
                                                                data-tippy-content="Xóa khỏi giỏ hàng">
                                                                <i data-feather="trash-2"></i>
                                                            </a>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </li>
                                                @endforeach

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="order-tracking-sidebar order-tracking-box">
                                        <!--<div class="coupan-block">-->
                                        <!--    <h5><i data-feather="tag"></i>Apply Coupons</h5>-->
                                        <!--    <a href="#" class="btn btn-solid btn-outline btn-sm">apply</a>-->
                                        <!--</div>-->
                                        <ul class="cart_total">
                                            <li>
                                                Tạm tính : <span class="total-price">{{ current_format($cart_total) }}</span>
                                            </li>
                                            <li>
                                                Giảm giá <span>0</span>
                                            </li>
                                            <li>
                                                Phí ship <span>Miễn phí</span>
                                            </li>
                                            <!--<li>-->
                                            <!--    Phiếu giảm giá<span>Đã áp dụng</span>-->
                                            <!--</li>-->
                                            <li>
                                                <div class="total">
                                                    Tổng tiền<span class="total-price">{{ current_format($cart_total) }}</span>
                                                </div>
                                            </li>
                                            {{-- <li class="pt-0">
                                                <div class="buttons">
                                                    <a href="cart.html" class="btn btn-solid btn-sm btn-block">
                                                        order</a>
                                                </div>
                                            </li> --}}
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-solid btn-sm previous action-button-previous">Quay
                            lại</a>
                        <a href="javascript:void(0)" class="next action-button btn btn-solid btn-sm">Tiếp theo</a>
                    </fieldset>
                    <fieldset data-index="3">
                        <div class="container p-0">
                            <div class="row">
                                <div class="col-12">
                                    <div class="order-payment order-tracking-box">
                                        <h4 class="tracking-title">Chi tiết thanh toán</h4>
                                        <div class="accordion theme-accordion" id="accordionExample">
                                            <!--<div class="card">-->
                                            <!--    <div class="card-header" id="headingOne">-->
                                            <!--        <button class="btn btn-link collapsed payment-toggle" type="button"-->
                                            <!--            data-bs-toggle="collapse" data-bs-target="#collapseOne">debit-->
                                            <!--            card / credit card</button>-->
                                            <!--    </div>-->
                                            <!--    <div id="collapseOne" class="collapse paymant-collapce"-->
                                            <!--        data-parent="#accordionExample" style="">-->
                                            <!--        <div class="form-group">-->
                                            <!--            <input type="text" class="form-control"-->
                                            <!--                placeholder="Card holder name">-->
                                            <!--        </div>-->
                                            <!--        <div class="form-group">-->
                                            <!--            <input type="text" class="form-control"-->
                                            <!--                placeholder="Card number">-->
                                            <!--            <input type="password" class="form-control" placeholder="Cvv">-->
                                            <!--        </div>-->
                                            <!--        <div class="form-group">-->
                                            <!--            <select class="form-control">-->
                                            <!--                <option value="">expiry month</option>-->
                                            <!--                <option value="01">01</option>-->
                                            <!--                <option value="02">02</option>-->
                                            <!--                <option value="03">03</option>-->
                                            <!--                <option value="04">04</option>-->
                                            <!--                <option value="05">05</option>-->
                                            <!--                <option value="06">06</option>-->
                                            <!--                <option value="07">07</option>-->
                                            <!--                <option value="08">08</option>-->
                                            <!--                <option value="09">09</option>-->
                                            <!--                <option value="10">10</option>-->
                                            <!--                <option value="11">11</option>-->
                                            <!--                <option value="12">12</option>-->
                                            <!--            </select>-->
                                            <!--            <select class="form-control">-->
                                            <!--                <option value="">expiry year</option>-->
                                            <!--                <option value="">2021</option>-->
                                            <!--                <option value="">2022</option>-->
                                            <!--                <option value="">2023</option>-->
                                            <!--                <option value="">2024</option>-->
                                            <!--                <option value="">2025</option>-->
                                            <!--                <option value="">2026</option>-->
                                            <!--                <option value="">2027</option>-->
                                            <!--                <option value="">2028</option>-->
                                            <!--                <option value="">2029</option>-->
                                            <!--                <option value="">2030</option>-->
                                            <!--            </select>-->
                                            <!--        </div>-->
                                            <!--        <div class="form-group">-->
                                            <!--            <div class="custom-control custom-checkbox  form-check">-->
                                            <!--                <input type="checkbox"-->
                                            <!--                    class="custom-control-input form-check-input"-->
                                            <!--                    id="debitpay" name="example1">-->
                                            <!--                <label class="custom-control-label form-check-label mb-0"-->
                                            <!--                    for="debitpay">Save this card-->
                                            <!--                    for faster payments</label>-->
                                            <!--            </div>-->
                                            <!--        </div>-->
                                            <!--        <div class="form-group mb-0">-->
                                            <!--            <a href="#" class="btn btn-solid btn-sm">pay now</a>-->
                                            <!--        </div>-->
                                            <!--    </div>-->
                                            <!--</div>-->
                                            {{-- <div class="card">
                                                <div class="card-header" id="headingTwo">
                                                    <button class="btn btn-link collapsed payment-toggle" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                                                        aria-expanded="false" aria-controls="collapseTwo">phone pay,
                                                        google pay, paytm, bhim upi</button>
                                                </div>
                                                <div id="collapseTwo" class="collapse paymant-collapce "
                                                    aria-labelledby="headingTwo" data-parent="#accordionExample"
                                                    style="">
                                                    <ul class="upi-pay">
                                                        <li>
                                                            <div>
                                                                <img src="../assets/images/order-track/payment/1.png"
                                                                    class="img-fluid" alt="">
                                                                <span>bhim upi</span>
                                                            </div>
                                                            <div>
                                                                <input type="text" class="form-control"
                                                                    placeholder="enter upi id">
                                                                <a href="#" class="btn btn-solid btn-sm ">pay now</a>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <img src="../assets/images/order-track/payment/2.png"
                                                                    class="img-fluid" alt="">
                                                                <span>paytm</span>
                                                            </div>
                                                            <div>
                                                                <input type="text" class="form-control"
                                                                    placeholder="enter upi id">
                                                                <a href="#" class="btn btn-solid btn-sm ">pay now</a>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <img src="../assets/images/order-track/payment/3.png"
                                                                    class="img-fluid" alt="">
                                                                <span>google pay</span>
                                                            </div>
                                                            <div>
                                                                <input type="text" class="form-control"
                                                                    placeholder="enter upi id">
                                                                <a href="#" class="btn btn-solid btn-sm ">pay now</a>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <img src="../assets/images/order-track/payment/4.png"
                                                                    class="img-fluid" alt="">
                                                                <span>phone pay</span>
                                                            </div>
                                                            <div>
                                                                <input type="text" class="form-control"
                                                                    placeholder="enter upi id">
                                                                <a href="#" class="btn btn-solid btn-sm ">pay now</a>
                                                            </div>
                                                        </li>
                                                        <li>
                                                            <div>
                                                                <img src="../assets/images/order-track/payment/5.png"
                                                                    class="img-fluid" alt="">
                                                                <span>amazon pay</span>
                                                            </div>
                                                            <div>
                                                                <input type="text" class="form-control"
                                                                    placeholder="enter upi id">
                                                                <a href="#" class="btn btn-solid btn-sm ">pay now</a>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card">
                                                <div class="card-header" id="headingThree">
                                                    <button class="btn btn-link collapsed payment-toggle" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                        aria-expanded="false" aria-controls="collapseThree">net
                                                        banking</button>
                                                </div>
                                                <div id="collapseThree" class="collapse paymant-collapce "
                                                    aria-labelledby="headingThree" data-parent="#accordionExample"
                                                    style="">
                                                    <ul class="bank-pay">
                                                        <li>
                                                            <a href="#">
                                                                <img src="../assets/images/order-track/banck-logo/1.png"
                                                                    alt="" class="img-fluid">
                                                                <span>sbi</span>
                                                            </a>

                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <img src="../assets/images/order-track/banck-logo/2.png"
                                                                    alt="" class="img-fluid">
                                                                <span>HDFC</span>
                                                            </a>

                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <img src="../assets/images/order-track/banck-logo/3.png"
                                                                    alt="" class="img-fluid">
                                                                <span>ICICI</span>
                                                            </a>

                                                        </li>
                                                        <li>
                                                            <a href="#">
                                                                <img src="../assets/images/order-track/banck-logo/4.png"
                                                                    alt="" class="img-fluid">
                                                                <span>kotak</span>
                                                            </a>

                                                        </li>
                                                    </ul>
                                                    <select class="form-control">
                                                        <option value="">other bank</option>
                                                        <option value="1">ALLAHABAD BANK </option>
                                                        <option value="2">ANDHRA BANK</option>
                                                        <option value="3">AXIS BANK</option>
                                                        <option value="29">STATE BANK OF INDIA</option>
                                                        <option value="4">BANK OF BARODA</option>
                                                        <option value="29">UCO BANK</option>
                                                        <option value="29">UNION BANK OF INDIA</option>
                                                        <option value="5">BANK OF INDIA</option>
                                                        <option value="20">BANDHAN BANK LIMITED</option>
                                                        <option value="7">CANARA BANK</option>
                                                        <option value="32">GRAMIN VIKASH BANK</option>
                                                        <option value="8">CORPORATION BANK</option>
                                                        <option value="9">INDIAN BANK</option>
                                                        <option value="10">INDIAN OVERSEAS BANK</option>
                                                        <option value="11">ORIENTAL BANK OF COMMERCE</option>
                                                        <option value="12">PUNJAB AND SIND BANK</option>
                                                        <option value="13">PUNJAB NATIONAL BANK</option>
                                                        <option value="14">RESERVE BANK OF INDIA</option>
                                                        <option value="15">SOUTH INDIAN BANK</option>
                                                        <option value="16">UNITED BANK OF INDIA</option>
                                                        <option value="17">CENTRAL BANK OF INDIA</option>
                                                        <option value="18">VIJAYA BANK</option>
                                                        <option value="19">DENA BANK</option>
                                                        <option value="21">BHARATIYA MAHILA BANK LIMITED</option>
                                                        <option value="22">FEDERAL BANK LTD </option>
                                                        <option value="23">HDFC BANK LTD</option>
                                                        <option value="24">ICICI BANK LTD</option>
                                                        <option value="25">IDBI BANK LTD</option>
                                                        <option value="66">PAYTM BANK</option>
                                                        <option value="29">FINO PAYMENT BANK</option>
                                                        <option value="26">INDUSIND BANK LTD</option>
                                                        <option value="27">KARNATAKA BANK LTD</option>
                                                        <option value="28">KOTAK MAHINDRA BANK</option>
                                                        <option value="30">YES BANK LTD</option>
                                                        <option value="31">SYNDICATE BANK</option>
                                                        <option value="5">BANK OF INDIA</option>
                                                        <option value="6">BANK OF MAHARASHTRA</option>
                                                    </select>
                                                </div>
                                            </div> --}}
                                            <div class="card">
                                                <div class="card-header" id="headingFour">
                                                    <button class="btn btn-link collapsed payment-toggle" type="button"
                                                        data-bs-toggle="collapse" data-bs-target="#collapseFour"
                                                        aria-expanded="false" aria-controls="collapseFour">
                                                        Thanh toán khi nhận hàng
                                                    </button>
                                                </div>
                                                <div id="collapseFour" class="collapse paymant-collapce show"
                                                    aria-labelledby="headingFour" data-parent="#accordionExample"
                                                    style="">
                                                    <div class="cash-pay">
                                                        <span class="successmessage">Đã xác nhận mã captcha . Bạn có thể đặt hàng</span>
                                                        <input type="text" class="form-control entercaptcha"
                                                            placeholder="Enter Captcha">
                                                        <span class="errorcaptcha"></span>
                                                        <div class="captchabox">
                                                            <div class="captchaimagecode"><canvas id="CapCode"
                                                                    class="capcode" width="300" height="80"></canvas>
                                                            </div>
                                                            <a href="javascript:void(0)" class="reloadbtncapcha"
                                                                onclick="CreateCaptcha();">
                                                                <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                                                                    y="0px" viewBox="0 0 512 512"
                                                                    style="enable-background:new 0 0 512 512;"
                                                                    xml:space="preserve">
                                                                    <g>
                                                                        <g>
                                                                            <path
                                                                                d="M446.709,166.059c-4.698-7.51-14.73-9.243-21.724-4.043l-48.677,36.519c-6.094,4.585-7.793,13.023-3.926,19.6
                                                  C384.73,239.156,391,261.656,391,285.02C391,359.464,330.443,422,256,422s-135-62.536-135-136.98
                                                  c0-69.375,52.588-126.68,120-134.165v44.165c0,12.434,14.266,19.357,23.994,11.997l120-90c8.006-5.989,7.994-18.014,0-23.994
                                                  l-120-90C255.231-4.37,241,2.626,241,15.02v45.498C123.9,68.267,31,166.001,31,285.02C31,409.093,131.928,512,256,512
                                                  s225-102.907,225-226.98C481,243.038,469.135,201.905,446.709,166.059z">
                                                                            </path>
                                                                        </g>
                                                                    </g>
                                                                </svg>
                                                            </a>
                                                        </div>
                                                        <a href="javascript:void(0)"
                                                            class="btn btn-solid btn-sm btnSubmit"
                                                            onclick="CheckCaptcha();">Kiểm tra</a>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form action="" method="get" style="display: inline-block!important; margin-top: 20px">
                            <input min="1" type="number" name="num_buy_now" value="{{ $item->qty }}" class="num-buy-now" style="display: none">
                            <input type="hidden" name="color_id" value="">
                            <a href="javascript:void(0)" class="btn btn-solid btn-sm previous action-button-previous">Quay lại</a>
                            @csrf
                            <input type="submit" class="btn btn-solid btn-sm" name="btn_order" value="Đặt hàng ngay" style="background: #e62a16;display: none;" />
                        </form>
                    </fieldset>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection