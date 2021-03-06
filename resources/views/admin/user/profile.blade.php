@extends('layouts.admin')

@section('wp-content')
<style>
    .section-head {
        margin-top: 20px;
    }

    .section-head h1 {
        font-size: 25px;
        text-align: center;
        padding-bottom: 10px;
    }

    .section-head span.note {
        width: 100% !important;
        color: #5f6368;
        font-size: 14px;
        display: block;
        text-align: center;
    }

    .section-detail .box {
        margin-top: 40px;
        display: flex;
        flex-wrap: wrap;
        border: 1px solid #d1d7de;
        border-radius: 6px;
        box-shadow: 0 2px 5px 1px rgb(64 60 67 / 8%);
    }

    .box .box-head {
        flex-basis: 100%;
        /* margin-bottom: 30px; */
    }

    .box-head h1 {
        font-size: 21px;
        padding: 20px 0 30px 20px;
    }

    .box .box-body {
        flex-basis: 100%;
    }

    ul#list-info li {
        display: flex;
        flex-wrap: wrap;
        padding: 20px 0;
        padding-left: 20px;
        border-bottom: 1px solid #d1d7de;
    }

    ul#list-info li:hover {
        background: whitesmoke;
    }

    ul#list-info li:last-child {
        padding: 20px 0 0 0;
        padding-left: 20px;
        padding-bottom: 20px;
        border: none;
    }

    ul#list-info li.first-child {
        padding: 0;
        align-items: center;
        padding-left: 20px;
    }

    li span.label {
        flex-basis: 20%;
        color: #5f6368;
        font-size: 13px;
    }

    li span.result {
        flex-basis: 75%;
        font-size: 15px;
    }

    li span.note {
        flex-basis: 60%;
        color: #5f6368;
        font-size: 12px;
        width: 100% !important;
        margin-bottom: 0;
    }

    span.thumb {
        display: inline-block;
        background: #ddd;
        cursor: pointer;
        border-radius: 50%;
        overflow: hidden;
        position: relative;
    }

    input#thumb_avatar {
        height: 80px;
        width: 80px;
        position: absolute;
        top: 0;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }

    span.thumb img {
        width: 80px;
        height: 80px;
    }
</style>
<div id="content" class="container-fluid">
    <div class="message">
        @if (session('success') !== null)
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error') !== null)
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        @if (session('warning') !== null)
        <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif
    </div>
    <div class="card"  style="padding: 20px;">
        <div class="section-head">
            <h1>Th??ng tin c?? nh??n</h1>
            <span class="note">Ki???m tra t??n v?? c??c th??ng tin kh??c trong T??i kho???n Admin Unimart c???a b???n</span>
        </div>
        <div class="section-detail">
            <div class="box">
                <div class="box-head">
                    <h1>Th??ng tin c?? b???n</h1>
                </div>
                <div class="box-body">
                    @if (!empty($info))
                    <ul id="list-info">
                        <li>
                            <span class="label">T??n</span>
                            <span class="result">{{ $info->name }}</span>
                        </li>
                        <li>
                            <span class="label">Ng??y gia nh???p</span>
                            <span class="result">{{ $info->created_at->format('d-m-Y') }}</span>
                        </li>
                        <li>
                            <span class="label">Vai tr?? trong h??? th???ng</span>
                            <span class="result">{{ $info->role->title }}</span>
                        </li>
                    </ul>  
                    @endif




                </div>
            </div>
        </div>

        <div class="section-detail">
            <div class="box">
                <div class="box-head">
                    <h1>Th??ng tin li??n h???</h1>
                </div>
                <div class="box-body">
                    @if (!empty($info))
                    <ul id="list-info">
                        <li>
                            <span class="label">Email</span>
                            <span class="result">{{ $info->email }}</span>
                        </li>
                        <li>
                            <span class="label">??i???n tho???i</span>
                            <span class="result">{{ !empty($info->phone) ? $info->phone : "Ch??a h??? tr???" }}</span>
                        </li>
                    </ul>                        
                    @endif



                </div>
            </div>
        </div>

        <div class="section-detail">
            <div class="box">
                <div class="box-head">
                    <h1>Th??ng tin quy???n ???????c ????ng k??</h1>
                </div>
                <div class="box-body">
                    @if (!empty($permissions))
                    <ul id="list-info">
                        @foreach ($permissions as $values)
                        @foreach ($values as $key => $value)
                        <li>
                            <span class="label">{{ $key=='All' ? "T???t c??? module" : $key }}</span>
                            <span class="result">{{ $value=="All" ? "T???t c??? quy???n" : $value }}</span>
                        </li>        
                        @endforeach
                        
                        @endforeach
                    </ul>                        
                    @endif

                </div>
            </div>
        </div>

    </div>
</div>
@endsection