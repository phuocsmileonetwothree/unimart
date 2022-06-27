<?php 
use App\Widget;
use App\Widget_Detail;
use App\Image;
$widgets = Widget::where('editable', 1)->get();
$widgets = get_widget_not_childrent($widgets);
?>
@extends('layouts.client')


@section('wp-content')
<style>
    .banner-list>.banner-list:last-child .collection-img {
        height: 260px !important;
    }
</style>
<!-- Home slider and category -->
<section class="megastore-slide collection-banner section-py-space b-g-white">
    <div class="container-fluid">
        <div class="row mega-slide-block">
            <div class="col-xl-9 col-lg-12 " style="padding-left: calc(var(--bs-gutter-x) / 2)!important;">
                <div class="row">
                    {{-- TOP SLIDER BANNER SLIDER --}}
                    <div class="col-12">
                        <div class="slide-1 no-arrow">
                            {{-- TOP SLIDER BANNER SLIDER --}}
                            @if (!empty($widgets['top_slider_banner_slider']->widget_details))
                            @foreach ($widgets['top_slider_banner_slider']->widget_details as
                            $wd_top_slider_banner_slider_item)
                            @if (empty($wd_top_slider_banner_slider_item->detail_id))
                            <div>
                                <div class="slide-main">
                                    <img src="{!! !empty(Image::find($wd_top_slider_banner_slider_item->image_id)) ? Image::find($wd_top_slider_banner_slider_item->image_id)->url : "" !!}"
                                        class="img-fluid bg-img">
                                    <div class="slide-contain">
                                        <div>
                                            @if (!empty($wd_top_slider_banner_slider_item->details))
                                            @foreach ($wd_top_slider_banner_slider_item->details as
                                            $wd_top_slider_banner_slider_item_detail_item)
                                            {!! $wd_top_slider_banner_slider_item_detail_item->content !!}
                                            @endforeach
                                            @endif
                                            <a href="{!! !empty($wd_top_slider_banner_slider_item->url) ? $wd_top_slider_banner_slider_item->url : "" !!}"
                                                class="btn btn-rounded btn-md">
                                                Xem ngay
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            @endforeach
                            @endif


                        </div>
                    </div>
                    {{-- TOP SLIDER-BANNER BANNER LEFT --}}
                    @if (!empty($widgets['top_slider_banner_banner_left']->widget_details))
                    @foreach ($widgets['top_slider_banner_banner_left']->widget_details as
                    $wd_top_slider_banner_banner_left_item)
                    @if (empty($wd_top_slider_banner_banner_left_item->detail_id))
                    <div class="col-md-6">
                        <div
                            class="collection-banner-main banner-18 banner-style7 collection-color13 p-left text-center">
                            <div class="collection-img">
                                <img src="{!! !empty(Image::find($wd_top_slider_banner_banner_left_item->image_id)) ? Image::find($wd_top_slider_banner_banner_left_item->image_id)->url : "" !!}"
                                    class="img-fluid bg-img">
                            </div>
                            <div class="collection-banner-contain ">
                                <div>
                                    @if (!empty($wd_top_slider_banner_banner_left_item->details))
                                    @foreach ($wd_top_slider_banner_banner_left_item->details as
                                    $wd_top_slider_banner_banner_left_detail_item)
                                    {!! $wd_top_slider_banner_banner_left_detail_item->content !!}
                                    @endforeach
                                    @endif
                                    <a href="{!! !empty($wd_top_slider_banner_banner_left_item->url) ? $wd_top_slider_banner_banner_left_item->url : "" !!}"
                                        class="btn btn-rounded btn-xs">Xem ngay</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endif

                </div>
            </div>
            {{-- TOP SLIDER-BANNER BANNER RIGHT --}}
            <div class="col-xl-3 col-lg-12 ">
                <div class="row collection-p6 banner-list">
                    @if (!empty($widgets['top_slider_banner_banner_right']->widget_details))
                    @foreach ($widgets['top_slider_banner_banner_right']->widget_details as
                    $wd_top_slider_banner_banner_right_item)
                    @if (empty($wd_top_slider_banner_banner_right_item->detail_id))
                    <div class="col-xl-12 col-lg-4 col-md-6 banner-list">
                        <div
                            class="collection-banner-main banner-17 banner-style7 collection-color14 p-left text-center">
                            <div class="collection-img">
                                <img src="{!! !empty(Image::find($wd_top_slider_banner_banner_right_item->image_id)) ? Image::find($wd_top_slider_banner_banner_right_item->image_id)->url : "" !!}"
                                    class="img-fluid bg-img">
                            </div>
                            <div class="collection-banner-contain ">
                                <div>
                                    @if (!empty($wd_top_slider_banner_banner_right_item->details))
                                    @foreach ($wd_top_slider_banner_banner_right_item->details as
                                    $wd_top_slider_banner_banner_right_detail_item)
                                    {!! $wd_top_slider_banner_banner_right_detail_item->content !!}
                                    @endforeach
                                    @endif
                                    <a href="{!! !empty($wd_top_slider_banner_banner_right_item->url) ? $wd_top_slider_banner_banner_right_item->url : "" !!}"
                                        class="btn btn-rounded btn-xs">Xem thêm</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>





<!-- Dịch vụ -->
<section class="services2 section-pt-space">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 pr-0">
                <div class="services-slide6 no-arrow">
                    {{-- Free shipping --}}
                    <div>
                        <div class="services-box">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <path style="fill:#5D9CEC;"
                                    d="M414.5,242.268h-59.855v74.996h59.851c11.009,0,21.314,9.429,33.245,20.346 c15.191,13.899,32.409,29.654,56.759,29.654h7.5v-7.5v-0.001v-0.001v-19.994C512,286.006,468.262,242.268,414.5,242.268z" />
                                <path style="fill:#4A89DC;"
                                    d="M414.5,242.268h-36.999c53.762,0,104.496,43.738,104.496,97.5v19.994v0.001v0.001v2.75 c6.814,2.936,14.248,4.75,22.503,4.75h7.5v-7.5v-0.001v-0.001v-19.994C512,286.006,468.262,242.268,414.5,242.268z" />
                                <path style="fill:#CCD1D9;"
                                    d="M406.996,242.268v74.996h7.5c2.528,0,5.018,0.517,7.5,1.415v-76.126 c-2.474-0.188-4.974-0.285-7.496-0.285L406.996,242.268L406.996,242.268z" />
                                <path
                                    d="M347.507,187.613H27.502c-4.142,0-7.5-3.357-7.5-7.5s3.358-7.5,7.5-7.5h320.005c4.142,0,7.5,3.357,7.5,7.5 C355.007,184.255,351.649,187.613,347.507,187.613z" />
                                <path style="fill:#ED5565;"
                                    d="M367.501,187.238H7.5c-4.142,0-7.5-3.357-7.5-7.5v-80c0-4.143,3.358-7.5,7.5-7.5h360.001 c4.142,0,7.5,3.357,7.5,7.5v80C375.001,183.88,371.643,187.238,367.501,187.238z" />
                                <path style="fill:#DA4453;"
                                    d="M20.001,187.238v172.524c0,4.143,3.358,7.5,7.5,7.5h0.001h320.005c4.142,0,7.5-3.357,7.5-7.5V187.238 H20.001z" />
                                <path style="fill:#CE3A50;"
                                    d="M325.004,187.238v172.524c0,4.143-3.358,7.5-7.5,7.5h30.003c4.142,0,7.5-3.357,7.5-7.5V187.238 H325.004z" />
                                <path style="fill:#DA4453;"
                                    d="M367.501,92.237h-30.003c4.142,0,7.5,3.357,7.5,7.5v80c0,4.143-3.358,7.5-7.5,7.5h30.003 c4.142,0,7.5-3.357,7.5-7.5v-80C375.001,95.595,371.643,92.237,367.501,92.237z" />
                                <rect x="147.5" y="187.609" style="fill:#F6BB42;" width="80" height="179.65" />
                                <path style="fill:#FFCE54;"
                                    d="M187.501,52.237c-22.092,0-40.001,17.909-40.001,40v95h80.001v-95 C227.501,70.146,209.592,52.237,187.501,52.237z" />
                                <path style="fill:#F6BB42;"
                                    d="M180.113,52.93c-12.213-11.685-41.12-30.695-72.618-30.695c-49.826,0-56.769,32.278-57.436,70.003 h97.44C147.5,72.671,161.553,56.396,180.113,52.93z" />
                                <path style="fill:#E8AA3D;"
                                    d="M194.949,52.93c12.213-11.685,41.12-30.695,72.618-30.695c49.826,0,56.768,32.278,57.435,70.003 h-97.44C227.563,72.671,213.51,56.396,194.949,52.93z" />
                                <path style="fill:#CCD1D9;"
                                    d="M504.5,367.264c-24.35,0-41.568-15.755-56.759-29.654c-11.931-10.917-22.235-20.346-33.245-20.346 h-59.489v42.498c0,4.143-3.358,7.5-7.5,7.5H27.502h-0.001c-4.139,0-7.494-3.353-7.499-7.49v79.99v0.001c0,0.002,0,0.002,0,0.002 c0,4.144,3.358,7.501,7.5,7.501h139.607h187.785h99.604H479.5h25c4.142,0,7.5-3.357,7.5-7.5v-72.502H504.5z" />
                                <path style="fill:#656D78;"
                                    d="M404.498,489.764c-27.57,0-49.999-22.43-49.999-50c0-27.569,22.429-50,49.999-50 c27.571,0,50.001,22.431,50.001,50C454.499,467.334,432.069,489.764,404.498,489.764z" />
                                <path style="fill:#CCD1D9;"
                                    d="M404.498,459.764c-11.028,0-20-8.972-20-20s8.972-20,20-20s20,8.972,20,20 C424.498,450.792,415.526,459.764,404.498,459.764z" />
                                <path style="fill:#656D78;"
                                    d="M117.504,489.764c-27.57,0-49.999-22.43-49.999-50c0-27.569,22.429-50,49.999-50 c27.571,0,50.001,22.431,50.001,50C167.505,467.334,145.075,489.764,117.504,489.764z" />
                                <path style="fill:#CCD1D9;"
                                    d="M117.504,459.764c-11.028,0-20-8.972-20-20s8.972-20,20-20s20,8.972,20,20 C137.504,450.792,128.532,459.764,117.504,459.764z" />
                                <path style="fill:#AAB2BC;"
                                    d="M481.997,362.514v84.752H504.5c4.142,0,7.5-3.357,7.5-7.5v-72.502h-7.5 C496.245,367.264,488.811,365.449,481.997,362.514z" />
                                <g></g>
                            </svg>
                            Giao hàng miễn phí
                        </div>
                    </div>
                    {{-- Festival discount --}}
                    <div>
                        <div class="services-box">
                            <svg version="1.1" xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512"
                                style="enable-background:new 0 0 512 512;" xml:space="preserve">
                                <g>
                                    <polygon style="fill:#DE4C3C;"
                                        points="136.828,282.483 57.379,476.69 119.172,459.034 145.655,512 225.103,326.621 " />
                                    <polygon style="fill:#DE4C3C;"
                                        points="331.034,273.655 242.759,326.621 322.207,512 348.69,459.034 410.483,476.69 " />
                                </g>
                                <g>
                                    <polygon style="fill:#C74436;"
                                        points="136.828,282.483 107.608,353.898 109.109,354.339 128,412.954 188.204,400.066 192.088,403.597 225.103,326.621 " />
                                    <polygon style="fill:#C74436;"
                                        points="242.759,326.621 275.774,403.597 279.658,400.066 339.862,412.954 358.753,354.339 362.196,353.28 331.034,273.655 " />
                                </g>
                                <g>
                                    <polygon style="fill:#FDB62F;"
                                        points="233.931,0 279.658,41.313 339.862,28.337 358.753,87.04 417.368,105.931 404.48,166.135 445.793,211.862 404.48,257.589 417.368,317.793 358.753,336.684 339.862,395.299 279.658,382.411 233.931,423.724 188.204,382.411 128,395.299 109.109,336.684 50.406,317.793 63.382,257.589 22.069,211.862 63.382,166.135 50.406,105.931 109.109,87.04 128,28.337 188.204,41.313 " />
                                    <path style="fill:#FDB62F;"
                                        d="M454.621,70.621L454.621,70.621c-3.001-18.114-17.196-32.309-35.31-35.31l0,0 c18.114-3.001,32.309-17.196,35.31-35.31l0,0c3.001,18.114,17.196,32.309,35.31,35.31l0,0 C471.817,38.312,457.622,52.506,454.621,70.621z" />
                                </g>
                                <path style="fill:#FFA83D;"
                                    d="M445.793,211.862l-41.313-45.727l12.888-60.204L371.73,91.189 c-49.523,136.739-167.194,214.069-259.443,255.294L128,395.299l60.204-12.888l45.727,41.313l45.727-41.313l60.204,12.888 l18.891-58.615l58.615-18.891l-12.888-60.204L445.793,211.862z" />
                                <g>
                                    <path style="fill:#FFFFFF;"
                                        d="M180.966,194.207c-19.5,0-35.31-15.81-35.31-35.31s15.81-35.31,35.31-35.31s35.31,15.81,35.31,35.31 S200.466,194.207,180.966,194.207z M180.966,141.241c-9.754,0-17.655,7.901-17.655,17.655c0,9.754,7.901,17.655,17.655,17.655 c9.754,0,17.655-7.901,17.655-17.655C198.621,149.142,190.72,141.241,180.966,141.241z" />
                                    <path style="fill:#FFFFFF;"
                                        d="M295.724,308.966c-19.5,0-35.31-15.81-35.31-35.31c0-19.5,15.81-35.31,35.31-35.31 c19.5,0,35.31,15.81,35.31,35.31C331.034,293.155,315.224,308.966,295.724,308.966z M295.724,256 c-9.754,0-17.655,7.901-17.655,17.655c0,9.754,7.901,17.655,17.655,17.655c9.754,0,17.655-7.901,17.655-17.655 C313.379,263.901,305.479,256,295.724,256z" />
                                    <rect x="146.502" y="203.052"
                                        transform="matrix(-0.7071 0.7071 -0.7071 -0.7071 549.1039 196.3124)"
                                        style="fill:#FFFFFF;" width="174.785" height="17.655" />
                                </g>
                            </svg>
                            Siêu giảm giá
                        </div>
                    </div>
                    {{-- 24/7 service --}}
                    <div>
                        <div class="services-box">
                            <svg enable-background="new 0 0 512 512" viewBox="0 0 512 512"
                                xmlns="http://www.w3.org/2000/svg">
                                <g>
                                    <path
                                        d="m414.33 158.33v11.67h-30v-11.67c0-70.76-57.57-128.33-128.33-128.33s-128.33 57.57-128.33 128.33v11.67h-30v-11.67c0-87.3 71.02-158.33 158.33-158.33s158.33 71.03 158.33 158.33z"
                                        fill="#393e9f" />
                                    <path
                                        d="m414.33 158.33v11.67h-30v-11.67c0-70.76-57.57-128.33-128.33-128.33v-30c87.31 0 158.33 71.03 158.33 158.33z"
                                        fill="#340d66" />
                                    <path
                                        d="m175.287 248.594h-54.972c-13.767 0-24.928-11.161-24.928-24.928v-43.901c0-13.767 11.161-24.928 24.928-24.928h54.972z"
                                        fill="#fe4945" />
                                    <path
                                        d="m334.711 248.594h56.974c13.767 0 24.928-11.161 24.928-24.928v-43.901c0-13.767-11.161-24.928-24.928-24.928h-56.974z"
                                        fill="#fa185e" />
                                    <path
                                        d="m512 469.59v42.41h-103.29l-15-15-15 15h-245.42l-15-15-15 15h-103.29v-42.41c0-18.34 11.78-34.59 29.2-40.31l153.66-50.36h146.71v.14l153.23 50.22c17.42 5.72 29.2 21.97 29.2 40.31z"
                                        fill="#13cffe" />
                                    <path
                                        d="m512 469.59v42.41h-103.29l-15-15-15 15h-122.71v-133.08h73.57v.14l153.23 50.22c17.42 5.72 29.2 21.97 29.2 40.31z"
                                        fill="#28abf9" />
                                    <path d="m329.57 306.33v72.59s-37 36.57-73.57 36.57-73.14-36.57-73.14-36.57v-72.59z"
                                        fill="#ffb9ab" />
                                    <path d="m329.57 306.33v72.59s-37 36.57-73.57 36.57v-109.16z" fill="#e39e8d" />
                                    <path
                                        d="m350.72 152.72v31.48l-9.72 10.47h-170l-9.72-10.47v-31.48c0-26.16 10.6-49.84 27.74-66.98s40.82-27.74 66.98-27.74c52.31 0 94.72 42.41 94.72 94.72z"
                                        fill="#ffb81f" />
                                    <path
                                        d="m350.72 152.72v31.48l-9.72 10.47h-85v-136.67c52.31 0 94.72 42.41 94.72 94.72z"
                                        fill="#fc9b28" />
                                    <path
                                        d="m350.72 184.26v64.87c0 6.69-.61 13.22-1.78 19.54-.95 5.15-14.23 15-14.23 15s6.34 10.23 3.8 15c-16.25 30.62-47.11 51.29-82.51 51.29-26.16 0-49.84-11.28-66.98-29.53s-27.74-43.45-27.74-71.3v-64.87h50.52c17.01 0 32.52-6.46 44.2-17.06 13.26-12.04 21.59-29.41 21.59-48.72 0 36.33 29.45 65.78 65.78 65.78z"
                                        fill="#fccbc3" />
                                    <path
                                        d="m350.72 184.26v64.87c0 6.69-.61 13.22-1.78 19.54-.95 5.15-14.23 15-14.23 15s6.34 10.23 3.8 15c-16.25 30.62-47.11 51.29-82.51 51.29v-182.76c13.26-12.04 21.59-29.41 21.59-48.72 0 36.33 29.45 65.78 65.78 65.78z"
                                        fill="#ffb9ab" />
                                    <path d="m348.94 268.67c-1.97 10.71-5.54 20.8-10.43 30h-65.3v-30z" fill="#340d66" />
                                    <path d="m103.286 466h30v46h-30z" fill="#28abf9" />
                                    <path d="m378.714 466h30v46h-30z" fill="#318def" />
                                </g>
                            </svg>
                            Hỗ trợ 24/7
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>





{{------------------------- List product new -------------------------}}
<div class="title8 section-big-pt-space">
    <h4>Sản phẩm mới nhất</h4>
</div>
<section class="section-big-mb-space ratio_square product">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 pr-0">
                <div class="product-slide-4 product-m no-arrow">

                    @if (!$new_products -> isEmpty())
                    @foreach ($new_products as $new_product)
                    <div>
                        <div class="product-box product-box2 product-new-custom">
                            <div class="label-new-custom"><span>New</span></div>
                            <div class="product-imgbox">
                                <div class="product-front">
                                    <a href="{{ route('client.product.detail', ['slug' => $new_product->slug]) }}">
                                        <img src="{{ url($new_product->images[0]->url) }}" class="img-fluid">
                                    </a>
                                </div>
                                <div class="product-back">
                                    <a href="{{ route('client.product.detail', ['slug' => $new_product->slug]) }}">
                                        <img src="{{ url($new_product->images[0]->url) }}" class="img-fluid">
                                    </a>
                                </div>
                                <div class="product-icon icon-inline">
                                    {{-- <a href="javascript:void(0)" data-url="{{ route('client.cart.add') }}"
                                        data-id="{{ $new_product->id }}" class="load-info-product"
                                        class="tooltip-top add-cartnoty custom-add-cart"
                                        data-tippy-content="Thêm vào giỏ hàng">
                                        <i data-feather="shopping-cart"></i>
                                    </a> --}}
                                    <a href="javascript:void(0)" data-url="{{ route('client.home.quickview') }}"
                                        data-id="{{ $new_product->id }}" class="tooltip-top load-info-product add-cart"
                                        data-tippy-content="Thêm vào giỏ hàng">
                                        <i data-feather="shopping-cart"></i>
                                    </a>
                                </div>
                                {{-- <div class="new-label1">
                                    <div>new</div>
                                </div> --}}
                                {{-- <div class="on-sale1">
                                    on sale
                                </div> --}}
                            </div>
                            <div class="product-detail product-detail2 ">
                                <a href="{{ route('client.product.detail', ['slug' => $new_product->slug]) }}">
                                    <h3>{{ $new_product->name }}</h3>
                                </a>
                                <h5>
                                    {{ current_format($new_product->price) }}
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


{{------------------------- List category featured -------------------------}}
<div class="title8 section-big-pt-space">
    <h4>Danh mục nổi bật</h4>
</div>
<section class="rounded-category rounded-category-inverse">
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="slide-6 no-arrow">

                    @if (!$featured_categories->isEmpty())
                    @foreach ($featured_categories as $category)
                    <div>
                        <div class="category-contain">
                            <div class="img-wrapper">
                                <a href="{{ route('client.product.category.index', ['slug'=>$category->slug]) }}">
                                    <img src="{{ $category->thumb }}" alt="category" class="img-fluid">
                                </a>
                            </div>
                            <a href="{{ route('client.product.category.index', ['slug'=>$category->slug]) }}"
                                class="btn-rounded">{{ $category->title }}</a>
                        </div>
                    </div>
                    @endforeach
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>










{{------------------------- Banner sales -------------------------}}
{{-- BOTTOM SLIDER-BANNER BANNER --}}
@if (!empty($widgets['bottom_slider_banner_banner']->widget_details))
{{-- {{ dd($widgets['bottom_slider_banner_banner']->widget_details) }} --}}
<section class="sale-banenr banner-style2  section-big-mb-space">
    @foreach ($widgets['bottom_slider_banner_banner']->widget_details as $wd_bottom_slider_banner_banner_item)
    @if (empty($wd_bottom_slider_banner_banner_item->detail_id))
    <img src="{!! !empty(Image::find($wd_bottom_slider_banner_banner_item->image_id)) ? Image::find($wd_bottom_slider_banner_banner_item->image_id)->url : "" !!}"
        class="img-fluid bg-img">
    <div class="custom-container">
        <div class="row">
            <div class="col-12 position-relative">
                <div class="sale-banenr-contain text-center  p-right">
                    <div>
                        @if (!empty($wd_bottom_slider_banner_banner_item->details))
                        @foreach ($wd_bottom_slider_banner_banner_item->details as
                        $wd_bottom_slider_banner_banner_detail_item)
                        {!! $wd_bottom_slider_banner_banner_detail_item->content !!}
                        @endforeach
                        @endif
                        <a href="{!! !empty($wd_bottom_slider_banner_banner_item->url) ? $wd_bottom_slider_banner_banner_item->url : '' !!}"
                            class="btn btn-rounded">Mua ngay</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endforeach

</section>
@endif






{{------------------------- List product deal highest of the day -------------------------}}
<div class="title8 section-mb-space ">
    <h4>deal tốt nhất hôm nay</h4>
</div>
<section class="hotdeal-second section-big-mb-space">
    <div class="container-fluid">
        <div class="row hotdeal-block2">
            <div class="col-12">
                <div class="hotdeal-slide3 no-arrow">
                    @foreach ($deal_products as $item)
                    <div>
                        <div class="hotdeal-box">
                            <div class="img-wrapper">
                                <a href="{{ route('client.product.detail', ['slug'=>$item->slug]) }}">
                                    <img src="{{ url($item->images[0]->url) }}" class="img-fluid bg-img">
                                </a>
                            </div>
                            <div class="hotdeal-contain">
                                <div>
                                    <a href="{{ route('client.product.detail', ['slug'=>$item->slug]) }}">
                                        <h3>{{ $item->name }}</h3>
                                    </a>
                                    <h5>
                                        <span class="text-danger text-decoration-none">{{ current_format($item->price)
                                            }}</span>
                                        <span class="price">{{ current_format($item->old_price) }}</span>
                                    </h5>
                                    {{-- <div class="timer2">
                                        <p id="demo">
                                        </p>
                                    </div> --}}
                                    <a href="javascript:void(0)" 
                                        data-url="{{ route('client.home.quickview') }}"
                                        data-id="{{ $item->id }}"
                                        class="btn btn-solid btn-sm bg-danger load-info-product checkout">
                                        Mua ngay
                                    </a>

                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
</section>







{{------------------------- List_product purchare highest of a cagteroy parent_id = 0 -------------------------}}
<section class="tab-product-main  tab-second">
    <div class="tab-prodcut-contain">
        <ul class="tabs tab-title">
            <?php $index_category = 10; ?>
            @foreach ($categories_and_products as $category)
            <li class="<?php if($index_category == 10) echo " current" ?>"><a href="tab-{{ $index_category }}">{{
                    $category->title }}</a>
            </li>
            <?php $index_category++; ?>
            @endforeach
        </ul>
    </div>
</section>
<section class="section-big-py-space">
    <div class="custom-container">
        <div class="row ">
            <div class="col-12 p-0">
                <div class="theme-tab product">
                    <div class="tab-content-cls ">

                        <?php $index_product = 10; ?>
                        @foreach ($categories_and_products as $category)
                        <div id="tab-{{ $index_product }}" class="tab-content <?php if($index_product == 10) echo "
                            active default" ?> product-block3">
                            {{-- Trên 5 --}}
                            <div class="col-12">
                                <div class="product-slide-3 no-arrow">
                                    @for ($i = 0; $i < 5; $i++) <?php if(!isset($category->all_sub_product[$i])) break;
                                        ?>
                                        <div>
                                            <div class="product-box3">
                                                <div class="media">
                                                    <div class="img-wrapper">
                                                        <a
                                                            href="{{ route('client.product.detail', ['slug'=>$category->all_sub_product[$i]['slug']]) }}">
                                                            <img width="150px" height="150px" class="img-fluid"
                                                                src="{{ url($category->all_sub_product[$i]['url']) }}">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="product-detail">
                                                            <a
                                                                href="{{ route('client.product.detail', ['slug'=>$category->all_sub_product[$i]['slug']]) }}">
                                                                <h3>{{ $category->all_sub_product[$i]['name'] }}</h3>
                                                            </a>
                                                            <h4>{{
                                                                current_format($category->all_sub_product[$i]['price'])
                                                                }}<span>{{
                                                                    current_format($category->all_sub_product[$i]['old_price'])
                                                                    }}</span></h4>
                                                            {{-- <a
                                                                href="{{ route('client.product.detail', $category->all_sub_product[$i]['slug']) }}"
                                                                class="btn btn-rounded btn-sm">
                                                                Xem chi tiết
                                                            </a> --}}
                                                            <a href="javascript:void(0)"
                                                                data-url="{{ route('client.home.quickview') }}"
                                                                data-id="{{ $category->all_sub_product[$i]['id'] }}"
                                                                class="btn btn-rounded btn-sm load-info-product add-cart">Thêm
                                                                giỏ hàng
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endfor
                                </div>
                            </div>
                            {{-- Dưới 5 --}}
                            <div class="col-12">
                                <div class="product-slide-3 no-arrow">
                                    @for ($i = 5; $i < 10; $i++) <?php if(!isset($category->all_sub_product[$i])) break;
                                        ?>
                                        <div>
                                            <div class="product-box3">
                                                <div class="media">
                                                    <div class="img-wrapper">
                                                        <a
                                                            href="{{ route('client.product.detail', ['slug'=>$category->all_sub_product[$i]['slug']]) }}">
                                                            <img width="150px" height="150px" class="img-fluid"
                                                                src="{{ url($category->all_sub_product[$i]['url']) }}">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="product-detail">
                                                            <a
                                                                href="{{ route('client.product.detail', ['slug'=>$category->all_sub_product[$i]['slug']]) }}">
                                                                <h3>{{ $category->all_sub_product[$i]['name'] }}</h3>
                                                            </a>
                                                            <h4>{{
                                                                current_format($category->all_sub_product[$i]['price'])
                                                                }}<span>{{
                                                                    current_format($category->all_sub_product[$i]['old_price'])
                                                                    }}</span></h4>
                                                            <a href="javascript:void(0)"
                                                                data-url="{{ route('client.home.quickview') }}"
                                                                data-id="{{ $category->all_sub_product[$i]['id'] }}"
                                                                class="btn btn-rounded btn-sm load-info-product add-cart">Thêm
                                                                giỏ hàng
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endfor
                                </div>
                            </div>
                        </div>
                        <?php $index_product++; ?>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>







@endsection