@extends('layouts.client')


@section('wp-content')
<!-- breadcrumb start -->
@include('layouts.breadcrumb')
<!-- breadcrumb End -->

<!-- section start -->
<section class="section-big-pt-space ratio_asos b-g-light">
    <div class="collection-wrapper">
        <div class="custom-container">
            <div class="row">
                <div class="collection-content col">
                    <div class="page-main-content">
                        <div class="row">
                            <div class="col-sm-12">

                                {{-- Banner --}}
                                {{-- <div class="top-banner-wrapper">
                                    <a href="product-page(left-sidebar).html"><img src="../assets/images/category/1.jpg"
                                            class="img-fluid  w-100" alt=""></a>
                                </div> --}}

                                {{-- Filter ListProduct Paginate --}}
                                <div class="collection-product-wrapper">


                                    {{-- Filter --}}
                                    {!! Form::open(['method' => "GET", 'url' => route('client.product.category.index', ['slug' => !empty($category->slug) ? $category->slug : "all"])]) !!}
                                    <div class="product-top-filter bg-white">
                                        <div class="container-fluid p-0">
                                            {{-- Filter Icon Mobile --}}
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="filter-main-btn ">
                                                        <span class="filter-btn ">
                                                            <i class="fa fa-filter" aria-hidden="true"></i> Bộ lọc
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 position-relative">
                                                    <div class="product-filter-content horizontal-filter-mian ">
                                                        {{-- Filter Icon Normal --}}
                                                        <div class="horizontal-filter-toggle">
                                                            <h4><i data-feather="filter"></i>Bộ lọc</h4>
                                                        </div>
                                                        <div class="horizontal-filter collection-filter"
                                                            style="z-index: 999">
                                                            <div class="horizontal-filter-contain"
                                                                style="flex-wrap: wrap">
                                                                <div class="collection-mobile-back"><span
                                                                        class="filter-back"><i class="fa fa-angle-left"
                                                                            aria-hidden="true"></i> back</span></div>
                                                                {{-- Hãng --}}
                                                                @if (!empty($brands))
                                                                <div style="flex-basis: 100%; margin-bottom: 20px">
                                                                    <div class="collection-collapse-block">
                                                                        <h6>Hãng</h6>
                                                                        <div class="collection-collapse-block-content">
                                                                            <div class="color-selector">
                                                                                <ul class="list-filter filter-brand">
                                                                                    @foreach ($brands as $brand)
                                                                                    <li><a href="" <?php if(!empty($_GET['b']) and in_array($brand['id'], explode(',', $_GET['b']))) echo "class='active'" ?> data-brand="{{ $brand['id'] }}">{{ $brand['name'] }}</a>
                                                                                    </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                                {{-- Giá --}}
                                                                @if (!empty($range_prices))
                                                                <div style="flex-basis: 100%; margin-bottom: 20px">
                                                                    <div class="collection-collapse-block">
                                                                        <h6>Giá</h6>
                                                                        <div class="collection-collapse-block-content">
                                                                            <div class="color-selector">
                                                                                <ul class="list-filter filter-price">
                                                                                    @foreach ($range_prices as
                                                                                    $range_price)
                                                                                    <li><a href="" <?php if(!empty($_GET['p']) and $_GET['p']==$range_price['id']) echo "class='active'" ?> data-price="{{ $range_price['id'] }}">{{ $range_price['title'] }}</a>
                                                                                    </li>
                                                                                    @endforeach
                                                                                </ul>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                @endif

                                                            </div>
                                                            <div class="button-filter">
                                                                <a href="javascript:void(0)"
                                                                    class="btn btn-solid btn-sm close-filter">Đóng</a>
                                                                <a href="" class="submit_query"
                                                                    style="display: none"></a>
                                                                {!! Form::submit('Xem kết quả', ['name' =>
                                                                'btn_submit_filter', 'style' => 'display:none;', 'class'
                                                                => 'btn btn-solid btn-sm']) !!}
                                                            </div>
                                                        </div>
                                                        {{-- <div class="collection-grid-view">
                                                            <ul>
                                                                <li><img src="../assets/images/category/icon/2.png"
                                                                        alt="" class="product-2-layout-view"></li>
                                                                <li><img src="../assets/images/category/icon/3.png"
                                                                        alt="" class="product-3-layout-view"></li>
                                                                <li><img src="../assets/images/category/icon/4.png"
                                                                        alt="" class="product-4-layout-view"></li>
                                                                <li><img src="../assets/images/category/icon/6.png"
                                                                        alt="" class="product-6-layout-view"></li>
                                                            </ul>
                                                        </div>
                                                        <div class="product-page-per-view">
                                                            <select>
                                                                <option value="High to low">24 Products Par Page
                                                                </option>
                                                                <option value="Low to High">50 Products Par Page
                                                                </option>
                                                                <option value="Low to High">100 Products Par Page
                                                                </option>
                                                            </select>
                                                        </div> --}}
                                                        {{-- Lọc giá cao đến thấp --}}
                                                        <div class="product-page-filter">
                                                            <select name="sort" class="sort">
                                                                <option <?php if(empty($_GET['s'])) echo "selected" ?>
                                                                    value="0">Sắp xếp theo : Mặc định</option>
                                                                <option <?php if(!empty($_GET['s']) and $_GET['s']==1)
                                                                    echo "selected" ?> value="high-to-low">Sắp xếp theo
                                                                    : Giá cao đến thấp</option>
                                                                <option <?php if(!empty($_GET['s']) and $_GET['s']==2)
                                                                    echo "selected" ?> value="low-to-high">Sắp xếp theo
                                                                    : Giá thấp đến cao </option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {!! Form::close() !!}

                                    {{-- List Product --}}
                                    @if (!$products->isEmpty())
                                    <div class="product-wrapper-grid product">
                                        <div class="row justify-content-center">

                                            @foreach ($products as $product)
                                            <div class="col-xl-2 col-lg-3 col-md-4 col-6 col-grid-box product-20">
                                                <div class="product-box">
                                                    <div class="product-imgbox">
                                                        <div class="product-front">
                                                            <a
                                                                href="{{ route('client.product.detail', ['slug' => $product->slug]) }}">
                                                                <img src="{{ url($product->images[0]->url) }}" class="img-fluid" alt="product"> </a>
                                                        </div>
                                                        <div class="product-back">
                                                            <a
                                                                href="{{ route('client.product.detail', ['slug' => $product->slug]) }}">
                                                                <img src="{{ url(!empty($product->images[1]->url) ? $product->images[1]->url : $product->images[0]->url) }}" class="img-fluid  " alt="product"> </a>
                                                        </div>
                                                    </div>
                                                    <div class="product-detail detail-center detail-inverse">
                                                        <div class="detail-title">
                                                            <div class="detail-left">
                                                                {{-- <div class="rating-star"> <i
                                                                        class="fa fa-star"></i> <i
                                                                        class="fa fa-star"></i> <i
                                                                        class="fa fa-star"></i> <i
                                                                        class="fa fa-star"></i> <i
                                                                        class="fa fa-star"></i> </div> --}}
                                                                <a href="product-page(left-sidebar).html">
                                                                    <h6 class="price-title">{{ $product->name }}</h6>
                                                                </a>
                                                            </div>
                                                            <div class="detail-right">
                                                                <div class="check-price">{{ $product->old_price }}</div>
                                                                <div class="price">
                                                                    <div class="price">{{
                                                                        current_format($product->price) }}</div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="icon-detail">
                                                            <a href="javascript:void(0)"
                                                                data-url="{{ route('client.home.quickview') }}" data-id="{{ $product->id }}"
                                                                class="tooltip-top load-info-product add-cart" data-tippy-content="Thêm vào giỏ hàng">
                                                                <i data-feather="shopping-cart"></i>
                                                            </a>
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php $paginate['index']++; ?>
                                            @endforeach


                                        </div>
                                    </div>
                                    @else
                                    <h4 style="margin-top: 60px; text-align: center;">Không tìm thấy sản phẩm</h4>
                                    @endif






                                    {{-- Pagination --}}
                                    <div class="product-pagination" style="border: 0!important">
                                        <div class="theme-paggination-block">
                                            <div class="container-fluid p-0">
                                                <div class="row" style="justify-content: center">
                                                    <div class="col-xl-6 col-md-6 col-sm-12">
                                                        @if (isset($_GET['b']) or isset($_GET['p']) or
                                                        isset($_GET['s']))
                                                        <?php echo get_pagging_client($paginate['page'], $paginate['total_page'], route('client.product.category.index', ['slug' => $paginate['slug'], 'b' => urldecode($_GET['b']), 'p' => isset($_GET['p']) ? $_GET['p'] : '', 's' => isset($_GET['s']) ? $_GET['s'] : '', 'page' => ''])) ?>

                                                        @else
                                                        {!! get_pagging_client($paginate['page'],
                                                        $paginate['total_page'], route('client.product.category.index',
                                                        ['slug' => $paginate['slug'], 'page' => ''])) !!}
                                                        @endif
                                                        {{-- <nav aria-label="Page navigation">
                                                            <ul class="pagination justify-content-center">
                                                                <li class="page-item"><a class="page-link"
                                                                        href="javascript:void(0)"
                                                                        aria-label="Previous"><span
                                                                            aria-hidden="true"><i
                                                                                class="fa fa-chevron-left"
                                                                                aria-hidden="true"></i></span> <span
                                                                            class="sr-only">Previous</span></a></li>
                                                                <li class="page-item "><a class="page-link"
                                                                        href="javascript:void(0)">1</a></li>
                                                                <li class="page-item"><a class="page-link"
                                                                        href="javascript:void(0)">2</a></li>
                                                                <li class="page-item"><a class="page-link"
                                                                        href="javascript:void(0)">3</a></li>
                                                                <li class="page-item"><a class="page-link"
                                                                        href="javascript:void(0)"
                                                                        aria-label="Next"><span aria-hidden="true"><i
                                                                                class="fa fa-chevron-right"
                                                                                aria-hidden="true"></i></span> <span
                                                                            class="sr-only">Next</span></a></li>
                                                            </ul>
                                                        </nav> --}}
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- section End -->

@endsection