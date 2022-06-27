@extends('layouts.client')

@section('wp-content')
<section class="p-0 b-g-light">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <div class="error-section">
                    <h1>404</h1>
                    <h2>Không tìm thấy trang</h2>
                    <a href="{{ route('client.home') }}" class="btn btn-normal">Quay lại trang chủ</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection