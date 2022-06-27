@extends('layouts.client')

@section('wp-content')
<!-- breadcrumb start -->
@include('layouts.breadcrumb')
<!-- breadcrumb End -->

<!-- section start -->
<section class="section-big-py-space blog-page ratio2_3">
    <div class="custom-container">
        <div class="row">
            <!--Blog sidebar start-->
            <div class="col-xl-3 col-lg-4 col-md-5">
                <div class="blog-sidebar">
                    <div class="theme-card">
                        <h4>Nhiều người đọc</h4>
                        <ul class="popular-blog">
                            @foreach ($posts_most_viewed as $item)
                            <li>
                                <a href="{{ route('client.post.detail', ['slug' => $item->slug]) }}">
                                    <div class="media">
                                        <div class="blog-date" style="padding: 0!important"><img width="70px" height="70px" src="{{ url($item->thumb) }}" alt=""></div>
                                        <div class="media-body align-self-center">
                                            <h6>{{ $item->title }}</h6>
                                            <p>{{ $item->views }} lượt xem</p>
                                        </div>
                                    </div>
                                    <p>{!! $item->desc !!}</p>
                                </a>
                            </li>                                
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!--Blog sidebar start-->
            <!--Blog List start-->
            <div class="col-xl-9 col-lg-8 col-md-7 order-sec">
                @foreach ($posts as $post)
                <div class="row blog-media">
                    <div class="col-xl-6 ">
                        <div class="blog-left">
                            <a href="{{ route('client.post.detail', ['slug' => $post->slug]) }}"><img src="{{ url($post->thumb) }}" class="img-fluid"></a>
                            <div class="label-block">
                                <div class="date-label">
                                    {{ $post->created_at->format('d-m-Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 ">
                        <div class="blog-right">
                            <div>
                                <a href="{{ route('client.post.detail', ['slug' => $post->slug]) }}">
                                    <h4>{{ $post->title }}</h4>
                                </a>
                                <ul class="post-social">
                                    <li>Tác giả : {{ $post->user->name }}</li>
                                    <li><i class="fa fa-eye"></i> {{ $post->views }} lượt xem</li>
                                    <li><i class="fa fa-comments"></i> 10 Comment</li>
                                </ul>
                                <p>{!! $post->desc !!}</p>
                            </div>
                        </div>
                    </div>
                </div>                    
                @endforeach
                {!! get_pagging_client($paginate['page'], $paginate['total_page'], route('client.post.category.index', ['slug' => $paginate['slug'], 'page' => ''])) !!}
            </div>
            <!--Blog List start-->
        </div>
    </div>
</section>
<!-- Section ends -->
@endsection