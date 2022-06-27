<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bigdeal - Multi-purpopse E-commerce Html Template</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="big-deal">
    <meta name="keywords" content="big-deal">
    <meta name="author" content="big-deal">
    {{-- <link rel="icon" href="../assets/images/favicon/favicon.png" type="image/x-icon"> --}}
    {{-- <link rel="shortcut icon" href="../assets/images/favicon/favicon.png" type="image/x-icon"> --}}

    <!--Google font-->
    <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Raleway&display=swap" rel="stylesheet">

    <style type="text/css">
        .wrapper {
            text-align: center;
            width: 650px;
            font-family: 'Open Sans', sans-serif;
            background-color: #e2e2e2;
            display: block;
            margin: 20px auto;
        }

        ul {
            margin: 0;
            padding: 0;
        }

        li {
            display: inline-block;
            text-decoration: unset;
        }

        a {
            text-decoration: none;
        }

        p {
            margin: 15px 0;
        }

        h5 {
            color: #444;
            text-align: left;
            font-weight: 400;
        }

        .text-center {
            text-align: center
        }

        .main-b-g-light {
            background-color: #fafafa;
        }

        .title {
            color: #444444;
            font-size: 22px;
            font-weight: bold;
            margin-top: 10px;
            margin-bottom: 10px;
            padding-bottom: 0;
            text-transform: uppercase;
            display: inline-block;
            line-height: 1;
        }

        table {
            margin-top: 30px
        }

        table.top-0 {
            margin-top: 0;
        }

        table.order-detail,
        .order-detail th,
        .order-detail td {
            border: 1px solid #ddd;
            border-collapse: collapse;
        }

        .order-detail th {
            font-size: 16px;
            padding: 15px;
            text-align: center;
        }

        .footer-social-icon tr td img {
            margin-left: 5px;
            margin-right: 5px;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <table align="center" border="0" cellpadding="0" cellspacing="0" style="padding: 0 30px;background-color: #f8f9fa; -webkit-box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);box-shadow: 0px 0px 14px -4px rgba(0, 0, 0, 0.2705882353);width: 100%;">
            <tbody>
                <tr>
                    <td>
                        <table align="center" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td>
                                    <img src="{{ url('public/images/email/delivery.png') }}" style=";margin-bottom: 30px;">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <img src="{{ url('public/images/email/success.png') }}">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h2 class="title">thank you</h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Đơn hàng đã được tiếp nhận và đang trên đường vận chuyển</p>
                                    <p>Mã tra cứu đơn hàng : {{ $data['order']['order_code'] }}</p>
                                </td>
                            </tr>
                            <tr>
    
                                <td>
                                    <div style="border-top:1px solid #777;height:1px;margin-top: 30px;">
                                </td>
                            </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" align="center">
                            <tr>
                                <td>
                                    <h2 class="title">Chi tiết đơn hàng của {{ $data['order']['fullname'] }}</h2>
                                </td>
                            </tr>
                        </table>
                        <table class="order-detail" border="0" cellpadding="0" cellspacing="0" align="center">
                            <tr align="left">
                                <th>HÌNH ẢNH</th>
                                <th style="padding-left: 15px;">TÊN SẢN PHẨM</th>
                                <th>SỐ LƯỢNG</th>
                                <th>GIÁ</th>
                            </tr>
                            <?php $total_price = 0; ?>
                            @foreach ($data['order_detail'] as $item)
                            <?php $total_price += ($item->qty * $item->product->price); ?>
                            <tr>
                                <td>
                                    <img src="{{ url($item->product->images[0]->url) }}" width="70">
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="margin-top: 15px;">{{ $item->product->name }}</h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="font-size: 14px; color:#444;margin-top: 10px;">QTY : <span>{{ $item->qty }}</span></h5>
                                </td>
                                <td valign="top" style="padding-left: 15px;">
                                    <h5 style="font-size: 14px; color:#444;margin-top:15px"><b>{{ current_format($item->qty * $item->product->price) }}</b></h5>
                                </td>
                            </tr>
                            @endforeach
    
    
                            <tr>
                                <td colspan="2"
                                    style="line-height: 49px;font-size: 13px;color: #000000;padding-left: 20px;text-align:left;border-right: unset;">
                                    Tạm tính:</td>
                                <td colspan="3" class="price"
                                    style="line-height: 49px;text-align: right;padding-right: 28px;font-size: 13px;color: #000000;text-align:right;border-left: unset;">
                                    <b>{{ current_format($total_price) }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="2"
                                    style="line-height: 49px;font-size: 13px;color: #000000;padding-left: 20px;text-align:left;border-right: unset;">
                                    Giảm giá :</td>
                                <td colspan="3" class="price"
                                    style="line-height: 49px;text-align: right;padding-right: 28px;font-size: 13px;color: #000000;text-align:right;border-left: unset;">
                                    <b>{{ current_format(0) }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="line-height: 49px;font-size: 13px;color: #000000;
                                        padding-left: 20px;text-align:left;border-right: unset;">Phí vận chuyển :</td>
                                <td colspan="3" class="price"
                                    style="
                                            line-height: 49px;text-align: right;padding-right: 28px;font-size: 13px;color: #000000;text-align:right;border-left: unset;">
                                    <b>{{ current_format(0) }}</b></td>
                            </tr>
                            <tr>
                                <td colspan="2" style="line-height: 49px;font-size: 13px;color: #000000;
                                        padding-left: 20px;text-align:left;border-right: unset;">TỔNG TIỀN ĐƠN HÀNG :</td>
                                <td colspan="3" class="price"
                                    style="line-height: 49px;text-align: right;padding-right: 28px;font-size: 13px;color: #000000;text-align:right;border-left: unset;">
                                    <b>{{ current_format($total_price) }}</b></td>
                            </tr>
                        </table>
                        <table cellpadding="0" cellspacing="0" border="0" align="left"
                            style="width: 100%;margin-top: 30px;    margin-bottom: 30px;">
                            <tbody>
                                <tr>
                                    <td style="font-size: 13px; font-weight: 400; color: #444444; letter-spacing: 0.2px;width: 100%;">
                                        <h5 style="font-size: 16px; font-weight: 500;color: #000; line-height: 16px; padding-bottom: 13px; border-bottom: 1px solid #e6e8eb; letter-spacing: -0.65px; margin-top:0; margin-bottom: 13px;">
                                            ĐỊA CHỈ NHẬN HÀNG</h5>
                                        <p style="text-align: left;font-weight: normal; font-size: 14px; color: #000000;line-height: 21px;margin-top: 0;">{{ $data['order']['address'] }}</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table class="main-b-g-light text-center top-0" align="center" border="0" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td style="padding: 30px;">
                    <div>
                        <h4 class="title" style="margin:0;text-align: center;">Follow us</h4>
                    </div>
                    <table border="0" cellpadding="0" cellspacing="0" class="footer-social-icon" align="center" class="text-center" style="margin-top:20px;">
                        <tr>
                            <td>
                                <a href="#"><img src="{{ url('images/email/facebook.png') }}" alt=""></a>
                            </td>
                            <td>
                                <a href="#"><img src="{{ url('images/email/youtube.png') }}" alt=""></a>
                            </td>
                            <td>
                                <a href="#"><img src="{{ url('images/email/twitter.png') }}" alt=""></a>
                            </td>
                            <td>
                                <a href="#"><img src="{{ url('images/email/gplus.png') }}" alt=""></a>
                            </td>
                            <td>
                                <a href="#"><img src="{{ url('images/email/linkedin.png') }}" alt=""></a>
                            </td>
                            <td>
                                <a href="#"><img src="{{ url('images/email/pinterest.png') }}" alt=""></a>
                            </td>
                        </tr>
                    </table>
                    <div style="border-top: 1px solid #ddd; margin: 20px auto 0;"></div>
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 20px auto 0;">
                        <tr>
                            <td>
                                <a href="#" style="font-size:13px">Không nhận thêm bất kỳ email nào của Unimart</a>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p style="font-size:13px; margin:0;">2022 - Unimart Copyright</p>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>