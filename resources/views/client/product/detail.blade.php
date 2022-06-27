@extends('layouts.client')

@section('wp-content')
<!-- breadcrumb start -->
@include('layouts.breadcrumb')
<!-- breadcrumb End -->
<!-- section start -->
<section class="section-big-pt-space b-g-light">
    <div class="collection-wrapper">
        <div class="custom-container">
            <div class="row">
                {{-- Hình ảnh --}}
                <div class="col-lg-5">
                    <div class="product-slick no-arrow">
                        <?php $index_slick = 0 ?>
                        @foreach ($product->images as $item)
                        <div>
                            <img src="{{ url($item->url) }}" class="img-fluid  image_zoom_cls-<?php echo $index_slick; ?>">
                        </div>
                        <?php $index_slick++ ?>
                        @endforeach
                    </div>
                    <div class="row">
                        <div class="col-12 p-0">
                            <div class="slider-nav">
                                <?php $index_nav = 0 ?>
                                @foreach ($product->images as $item)
                                <div>
                                    <img src="{{ url($item->url) }}" class="img-fluid  image_zoom_cls-<?php echo $index_nav; ?>">
                                </div>
                                <?php $index_nav++ ?>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
                {{-- Thông tin --}}
                <div class="col-lg-7 rtl-text">
                    <div class="product-right">
                        <div class="pro-group">
                            @if ($product->stocking == 'out')
                            <span class="stocking"
                                style="background: #e62a16; color: #fff; padding: 4px; border-radius: 4px; margin-bottom: 10px;display: inline-block;">Hết
                                hàng</span>
                            @endif
                            <h2>{{ $product->name }}</h2>
                            <ul class="pro-price">
                                <li class="text-danger">{{ current_format($product->price) }}</li>
                                @if (!empty($product->old_price))
                                <li><span>{{ current_format($product->old_price) }}</span></li>
                                <li class="text-danger">{{ percent_discount($product->price, $product->old_price) }}
                                </li>
                                @endif
                            </ul>
                        </div>

                        <div id="selectSize" class="pro-group addeffect-section product-description border-product mb-0">
                            @if (!$product->colors->isEmpty())
                            <div class="product-color">
                                <h6 class="product-title">Lựa chọn màu</h6>
                                <div class="color-select-detail inline">
                                    <ul>
                                        @foreach ($product->colors as $color)
                                        <li style="background-color: <?php echo $color->code ?>">
                                            <i class="fas fa-check" data-color="{{ $color->id }}"></i>
                                        </li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>

                            @endif
                            <h6 class="product-title">Số lượng</h6>
                            <div class="qty-box">
                                <div class="input-group">
                                    <button class="custom-minus"></button>
                                    <input type="number" class="form-control qty-custom-add-cart-detail" value="1">
                                    <button class="custom-plus"></button>
                                </div>
                            </div>
                            <div class="product-buttons">
                                <a href="javascript:void(0)" data-id="{{ $product->id }}"
                                    data-url-add-cart="{{ route('client.cart.add') }}" id="cartEffect"
                                    class="btn cart-btn btn-normal tooltip-top add-cartnoty custom-add-cart-detail"
                                    data-tippy-content="Thêm vào giỏ hàng">
                                    <i class="fa fa-shopping-cart"></i>
                                    Thêm giỏ hàng
                                </a>
                            </div>
                        </div>
                        {{-- <div class="pro-group">
                            <h6 class="product-title">Địa chỉ giao hàng</h6>
                            <div class="delivery-detail">
                                <div class="delivery-detail-contian">
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti-location-pin"></i></span>
                                        <input type="text" class="form-control"
                                            placeholder="Enter Pincode for delivery">
                                    </div>
                                    <a href="javascript:void(0)" class="btn btn-solid btn-md ">check</a>
                                </div>
                                <div class="delivery-lable">
                                    <svg enable-background="new 0 0 512 512" viewBox="0 0 512 512"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <g>
                                            <g>
                                                <path d="m412.65 107.667h-80.65v148.333l180-21.056v-.108z"
                                                    fill="#cce6ff" />
                                                <path d="m332 234.944h180v158.722h-180z" fill="#cc295f" />
                                            </g>
                                            <g>
                                                <path d="m356.333 65h-170.065l-15.601 159 15.601 169.667h170.065z"
                                                    fill="#fdae02" />
                                                <path d="m0 393.667h186.268v-148.334l-186.267 20.334z" fill="#fdcb02" />
                                                <path d="m0 65 .001 96 186.267 20.333v-116.333z" fill="#fdcb02" />
                                                <path
                                                    d="m235.314 265.667 29.905-104.667h-78.951l-15.601 52.333 15.601 52.334z"
                                                    fill="#cc295f" />
                                                <path d="m.001 161h186.267v104.666h-186.267z" fill="#ff4d4d" />
                                            </g>
                                            <g>
                                                <circle cx="122.667" cy="384" fill="#f9f9f9" r="48" />
                                                <path
                                                    d="m122.667 447c-34.738 0-63-28.262-63-63s28.262-63 63-63 63 28.262 63 63-28.262 63-63 63zm0-96c-18.196 0-33 14.804-33 33s14.804 33 33 33 33-14.804 33-33-14.804-33-33-33z"
                                                    fill="#29376d" />
                                            </g>
                                            <g>
                                                <circle cx="389.333" cy="384" fill="#eaf1ff" r="48" />
                                                <path
                                                    d="m389.333 447c-34.738 0-63-28.262-63-63s28.262-63 63-63 63 28.262 63 63-28.261 63-63 63zm0-96c-18.196 0-33 14.804-33 33s14.804 33 33 33 33-14.804 33-33-14.803-33-33-33z"
                                                    fill="#23305b" />
                                            </g>
                                        </g>
                                    </svg>
                                    Order within 12 hrs
                                </div>
                            </div>
                        </div> --}}

                        <div class="pro-group desc-product product-desc">
                            <h6 class="product-title">Mô tả sản phẩm</h6>
                            <div class="desc">{!! $product->desc !!}</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<!-- Section ends -->


<!-- product-tab starts -->
<section class="section-big-py-space  ratio_asos b-g-light" id="content-scroll">
    <div class="custom-container">
        <div class="row">
            <div class="col-12 product-related">
                <h2>Chi tiết sản phẩm</h2>
            </div>
        </div>
        <style>
            .fit-product-content h2,
            p {
                margin-bottom: 20px
            }

            @media (max-width: 1199px) {
                .fit-product-content {
                    padding: 10px !important;
                }

                .fit-product-content img {
                    width: 100%;
                    height: auto;
                }
            }
        </style>
        <div class="section-detail product-content">
            <div class="fit-product-content">
                {!! $product->content !!}
                <a class="extend-content" href="">Xem thêm <span>&#8595;</span></a>
                <a class="collapse-content" href="">Thu gọn <span>&#8593;</span></a>
                <div class="opacity"></div>
            </div>
        </div>
    </div>
</section>
<!-- product-tab ends -->

<!-- related products -->
<section class="section-big-py-space  ratio_asos b-g-light">
    <div class="custom-container">
        <div class="row">
            <div class="col-12 product-related">
                <h2>Sản phẩm liên quan</h2>
            </div>
        </div>
    </div>
</section>
<section class="section-big-mb-space ratio_square product">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 pr-0">
                <div class="product-slide-4 product-m no-arrow">

                    @if (!$related_products -> isEmpty())
                    @foreach ($related_products as $re_product)
                    <div>
                        <div class="product-box product-box2 product-new-custom">
                            <div class="product-imgbox">
                                <div class="product-front">
                                    <a href="{{ route('client.product.detail', ['slug' => $re_product->slug]) }}">
                                        <img src="{{ url($re_product->images[0]->url) }}" class="img-fluid">
                                    </a>
                                </div>
                                <div class="product-back">
                                    <a href="{{ route('client.product.detail', ['slug' => $re_product->slug]) }}">
                                        <img src="{{ url($re_product->images[0]->url) }}" class="img-fluid">
                                    </a>
                                </div>
                                <div class="product-icon icon-inline">
                                    <a href="javascript:void(0)"
                                        data-url="{{ route('client.home.quickview') }}" data-id="{{ $re_product->id }}"
                                        class="tooltip-top load-info-product add-cart" data-tippy-content="Thêm vào giỏ hàng">
                                        <i data-feather="shopping-cart"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-detail product-detail2 ">
                                <a href="product-page(no-sidebar).html">
                                    <h3>{{ $re_product->name }}</h3>
                                </a>
                                <h5>
                                    {{ current_format($re_product->price) }}
                                </h5>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endif


                </div>
            </div>
        </div>
    </div>
</section>
<!-- related products -->
@endsection