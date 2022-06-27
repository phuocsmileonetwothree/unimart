<?php 
$user = Auth::user(); 
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.1/css/solid.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/themify.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.tiny.cloud/1/q6gpeq218kqbjcuzhtdogzh1xbl0sziylwcir6m4a9sf0v5c/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <title>Admintrator</title>
</head>

<body>
    <div id="warpper" class="nav-fixed">
        <nav class="topnav shadow navbar-light bg-white d-flex">
            <div class="navbar-brand"><a href="{{ route('admin.dashboard') }}">UNITOP ADMIN</a></div>
            <div class="nav-right ">
                <div class="btn-group mr-auto">
                    <button type="button" class="btn dropdown" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        <i class="plus-icon fas fa-plus-circle"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('admin.post.create') }}">Thêm bài viết</a>
                        <a class="dropdown-item" href="{{ route('admin.product.create') }}">Thêm sản phẩm</a>
                        <a class="dropdown-item" href="{{ route('admin.page.create') }}">Thêm trang</a>
                    </div>
                </div>
                <div class="btn-group">
                    <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true"
                        aria-expanded="false">
                        {{ Auth::user() -> name }}
                    </button>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="{{ route('admin.user.profile') }}">Tài khoản</a>
                        <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                            {{ __('Thoát') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </nav>
        <!-- end nav  -->
        <div id="page-body" class="d-flex">
            <div id="sidebar" class="bg-white" style="width: 12rem!important">
                <ul id="sidebar-menu">
                    @php
                    $module_active = session('module_active')
                    @endphp

                    {{-- Dashboard --}}
                    <li class="nav-link {{ $module_active == 'dashboard' ? 'active' : '' }}">
                        <a href="{{ route('admin.dashboard') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Dashboard
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                    </li>

                    {{-- Product --}}
                    <li class="nav-link {{ $module_active == 'product' ? 'active' : '' }}">
                        <a href="{{ route('admin.product.list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Sản phẩm
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ route('admin.product.create') }}">Thêm mới</a></li>
                            <li><a href="{{ route('admin.product.list') }}">Danh sách</a></li>
                            <li><a href="{{ route('admin.product.cat.list') }}">Danh mục</a></li>
                            <li><a href="{{ route('admin.product.brand.list') }}">Thương hiệu</a></li>
                            <li><a href="{{ route('admin.product.color.list') }}">Màu sắc</a></li>
                        </ul>
                    </li>

                    {{-- Order --}}
                    <li class="nav-link {{ $module_active == 'order' ? 'active' : '' }}">
                        <a href="{{ route('admin.order.list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Bán hàng
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ route('admin.order.list') }}">Đơn hàng</a></li>
                        </ul>
                    </li>

                    {{-- Post --}}
                    <li class="nav-link {{ $module_active == 'post' ? 'active' : '' }}">
                        <a href="{{ route('admin.post.list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Bài viết
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ route('admin.post.create') }}">Thêm mới</a></li>
                            <li><a href="{{ route('admin.post.list') }}">Danh sách</a></li>
                            <li><a href="{{ route('admin.post.cat.list') }}">Danh mục</a></li>
                        </ul>
                    </li>

                    {{-- Page --}}
                    <li class="nav-link {{ $module_active == 'page' ? 'active' : '' }}">
                        <a href="{{ route('admin.page.list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Trang
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            <li><a href="{{ route('admin.page.create') }}">Thêm mới</a></li>
                            <li><a href="{{ route('admin.page.list') }}">Danh sách</a></li>
                        </ul>
                    </li>

                    {{-- Widget --}}
                    <li class="nav-link {{ $module_active == 'widget' ? 'active' : '' }}">
                        <a href="{{ route('admin.widget.list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Khối giao diện
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ route('admin.widget.list') }}">Danh sách khối</a></li>
                            <li><a href="{{ route('admin.widget.list') }}">Menu</a></li>
                            <li><a href="{{ route('admin.slider.list') }}">Danh sách slider</a></li>
                            <li><a href="{{ route('admin.banner.list') }}">Danh sách banner</a></li>
                            
                        </ul>
                    </li>

                    {{-- Profile --}}
                    <li class="nav-link {{ $module_active == 'user' ? 'active' : '' }}">
                        <a href="{{ route('admin.user.profile') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Profile
                        </a>
                        <i class="arrow fas fa-angle-right"></i>

                        <ul class="sub-menu">
                            <li><a href="{{ route('admin.user.edit_info') }}">Edit Info</a></li>
                        </ul>
                    </li>

                    {{-- Access --}}
                    @if (($user->role->id == 1 or $user->role->id == 2) and ($user->role->title == "Quản lý" or $user->role->title == "Quản trị hệ thống"))
                    <li class="nav-link {{ $module_active == 'access' ? 'active' : '' }}">
                        <a href="{{ route('admin.access.list') }}">
                            <div class="nav-link-icon d-inline-flex">
                                <i class="far fa-folder"></i>
                            </div>
                            Access Control
                        </a>
                        <i class="arrow fas fa-angle-right"></i>
                        <ul class="sub-menu">
                            <li><a href="{{ route('admin.access.create') }}">Thêm User</a></li>
                            <li><a href="{{ route('admin.access.list') }}">Danh sách User</a></li>
                        </ul>
                    </li>
                    @endif
                    
                </ul>
            </div>
            <div id="wp-content" style="padding-left: 12rem!important;">

                @yield('wp-content')
            </div>
        </div>


    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>




    <script>
        var editor_config = {
        path_absolute : "http://localhost/Back-End/LARAVELPro/Lesson/unimart/",
        selector: 'textarea',
        relative_urls: false,
        height: 500,
        plugins: [
        "advlist autolink lists link image charmap print preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime media nonbreaking save table directionality",
        "emoticons template paste textpattern"
        ],
        a11y_advanced_options: true,
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media",
        file_picker_callback : function(callback, value, meta) {
        var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
        var y = window.innerHeight|| document.documentElement.clientHeight|| document.getElementsByTagName('body')[0].clientHeight;

        var cmsURL = editor_config.path_absolute + 'laravel-filemanager?editor=' + meta.fieldname;
        if (meta.filetype == 'image') {
            cmsURL = cmsURL + "&type=Images";
        } else {
            cmsURL = cmsURL + "&type=Files";
        }

        tinyMCE.activeEditor.windowManager.openUrl({
            url : cmsURL,
            title : 'Filemanager',
            width : x * 0.8,
            height : y * 0.8,
            resizable : "yes",
            close_previous : "no",
            onMessage: (api, message) => {
            callback(message.content);
            }
        });
        }
    };
    tinymce.init(editor_config);
    </script>
</body>

</html>