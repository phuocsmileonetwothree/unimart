@extends('layouts.client')

@section('wp-content')
<!-- breadcrumb start -->
@include('layouts.breadcrumb')
<!-- breadcrumb End -->

<!--section start-->

<section class="blog-detail-page section-big-py-space ratio2_3">
    <div class="container">
        <div class="row section-big-pb-space">
            <div class="col-sm-12 blog-detail">
                <div class="creative-card">
                    <img src="{{ url($post->thumb) }}" class="img-fluid w-100 " alt="blog">
                    <h3>{{ $post->title }}</h3>
                    <ul class="post-social">
                        <li>{{ $post->created_at->format('d-m/Y') }}</li>
                        <li>Tác giả : {{ $post->user->name }}</li>
                        <li><i class="fa fa-eye"></i> {{ $post->views }} lượt xem</li>
                        <li><i class="fa fa-comments"></i> 10 Comment</li>
                    </ul>
                    <div id="content">
                        <style>
                            #content h2, p{
                                margin-bottom: 20px;
                            }
                        </style>
                        {!! $post->content !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Posts Related --}}
        @if (!$posts_related->isEmpty())
        <div class="row section-big-pb-space blog-advance ">
            <div class="product-slide-6 product-m no-arrow">
                @foreach ($posts_related as $item)
                <div class="col-lg-6 ">
                    <div class="creative-card">
                        <img width="150px" height="150px" src="{{ url($item->thumb) }}" class="img-fluid ">
                        <ul>
                            <li>{{ $item->title }}</li>
                        </ul>
                    </div>
                </div>
                @endforeach
            </div>
            
        </div>
        @endif


        {{-- Custommer Commented --}}
        {{-- <div class="row section-big-pb-space">
            <div class="col-sm-12 ">
                <div class="creative-card">
                    <ul class="comment-section">
                        <li>
                            <div class="media"><img src="../assets/images/avtar/1.jpg" alt="Generic placeholder image">
                                <div class="media-body">
                                    <h6>Mark Jecno <span>( 12 Jannuary 2018 at 1:30AM )</span></h6>
                                    <p>Donec rhoncus massa quis nibh imperdiet dictum. Vestibulum id est sit amet felis
                                        fringilla bibendum at at leo. Proin molestie ac nisi eu laoreet. Integer
                                        faucibus enim nec ullamcorper tempor. Aenean nec felis dui.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media"><img src="../assets/images/avtar/2.jpg" alt="Generic placeholder image">
                                <div class="media-body">
                                    <h6>Mark Jecno <span>( 12 Jannuary 2018 at 1:30AM )</span></h6>
                                    <p>Donec rhoncus massa quis nibh imperdiet dictum. Vestibulum id est sit amet felis
                                        fringilla bibendum at at leo. Proin molestie ac nisi eu laoreet. Integer
                                        faucibus enim nec ullamcorper tempor. Aenean nec felis dui.</p>
                                </div>
                            </div>
                        </li>
                        <li>
                            <div class="media"><img src="../assets/images/avtar/3.jpg" alt="Generic placeholder image">
                                <div class="media-body">
                                    <h6>Mark Jecno <span>( 12 Jannuary 2018 at 1:30AM )</span></h6>
                                    <p>Donec rhoncus massa quis nibh imperdiet dictum. Vestibulum id est sit amet felis
                                        fringilla bibendum at at leo. Proin molestie ac nisi eu laoreet. Integer
                                        faucibus enim nec ullamcorper tempor. Aenean nec felis dui.</p>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div> --}}

        {{-- Comment --}}
        <div class=" row blog-contact">
            <div class="col-sm-12  ">
                <div class="creative-card">
                    <h2>Leave Your Comment</h2>
                    <form class="theme-form">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" placeholder="Enter Your name"
                                    required="">
                            </div>
                            <div class="col-md-12">
                                <label for="email">Email</label>
                                <input type="text" class="form-control" id="email" placeholder="Email" required="">
                            </div>
                            <div class="col-md-12">
                                <label for="exampleFormControlTextarea1">Comment</label>
                                <textarea class="form-control" placeholder="Write Your Comment"
                                    id="exampleFormControlTextarea1" rows="6"></textarea>
                            </div>
                            <div class="col-md-12">
                                <button class="btn btn-normal" type="submit">Post Comment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</section>
<!--Section ends-->
@endsection