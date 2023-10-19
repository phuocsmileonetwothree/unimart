<!DOCTYPE html>
<html lang="en">

<head>
    <title></title>
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
                                    <h2 class="title">Xác nhận quên mật khẩu</h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p>Click vào đường dẫn bên dưới để thay đổi mật khẩu</p>
                                    <p>{{ route('client.change_password', ['crypt' =>$data['random']]) }}</p>
                                </td>
                            </tr>
                            <tr>
    
                                <td>
                                    <div style="border-top:1px solid #777;height:1px;margin-top: 30px;">
                                </td>
                            </tr>
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