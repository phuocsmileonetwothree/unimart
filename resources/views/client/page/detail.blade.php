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
                    <h3>{{ $page->title }}</h3>
                    <ul class="post-social">
                    </ul>
                    <div id="content">
                        {!! $page->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!--Section ends-->
@endsection