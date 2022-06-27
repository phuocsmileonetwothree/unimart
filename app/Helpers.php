<?php

use App\Category;
use App\Module;
use App\Permission;
use App\Widget;
use Illuminate\Support\Str;

if(!function_exists('get_fontawesome')){
    function get_fontawesome(){
        $list_font = [
            0 => 'far fa-folder',
            1 => 'plus-icon fas fa-plus-circle',
            2 => 'arrow fas fa-angle-right',
            3 => 'arrow fas fa-angle-down',
            4 => 'fa fa-phone',
            5 => 'fa fa-map-marker',
            6 => 'fa fa-envelope',
            7 => 'fa fa-fax',
            8 => 'ti-user',
            9 => 'ti-email',
            10 => 'fab fa-facebook',
            11 => 'fab fa-google-plus-g',
            12 => 'fab fa-twitter',
            13 => 'fab fa-instagram',
            14 => 'fa fa-rss',
            
        ];
        return $list_font;
    }
}

if (!function_exists('convert_breadcrumb')) {
    function convert_breadcrumb($module)
    {
        
        $list_module = [
            'product' => 'sản phẩm',
            'post' => 'bài viết',
            'page' => 'trang',
        ];
        if(array_key_exists($module, $list_module)){
            return $list_module[$module];
        }
    }
}
if (!function_exists('convert_permission')) {
    function convert_permission($module_id, $permission_id)
    {
        $result = [];
        $list_module = Module::all()->pluck('title', 'id')->toArray();
        
        $list_permission = Permission::all()->pluck('title', 'id')->toArray();
        if(array_key_exists($module_id, $list_module) and array_key_exists($permission_id, $list_permission)){
            return $result = array(
                $list_module[$module_id] => $list_permission[$permission_id]
            );
        }
    }
}

if (!function_exists('convert_filter')) {
    function convert_filter($filter)
    {
        $list_filter = array(
            'all' => 'Tất cả',
            'active' => 'Hoạt động',
            'inactive' => 'Vô hiệu hóa',
            'on' => 'Đã đăng',
            'off' => 'Đã ẩn - Chưa duyệt',
            'trash' => 'Thùng rác',
            'unknown_author' => 'Không rõ tác giả',
            'still' => 'Còn hàng',
            'out' => 'Tạm hết hàng',
            'processing' => 'Đang xử lý',
            'cancelled' => 'Đã hủy',
            'transported' => 'Đang vận chuyển',
            'successful' => 'Giao hàng thành công',
        );
        if (array_key_exists($filter, $list_filter)) {
            return $list_filter[$filter];
        }
        return "NONE";
    }
}

if (!function_exists('convert_class_status')) {
    function convert_class_status($status)
    {
        $list_status = array(
            'on' => 'success',
            'off' => 'danger',
            'still' => 'success',
            'out' => 'danger',
            'processing' => 'warning',
            'cancelled' => 'danger',
            'transported' => 'primary',
            'successful' => 'success'
        );
        if (array_key_exists($status, $list_status)) {
            return $list_status[$status];
        }
        return "NONE";
    }
}

if (!function_exists('convert_action')) {
    function convert_action($action)
    {
        $list_action = array(
            'destroy' => 'Xóa tạm thời',
            'forceDelete' => 'Xóa vĩnh viễn',
            'on' => 'Công khai',
            'off' => 'Tắt công khai',
            'restore' => 'Phục hồi',
            'still' => 'Còn hàng',
            'out' => 'Tạm hết hàng',
            'processing' => 'Đang xử lý',
            'cancelled' => 'Đã hủy',
            'transported' => 'Đang vận chuyển',
            'successful' => 'Giao hàng thành công',
        );
        if (array_key_exists($action, $list_action)) {
            return $list_action[$action];
        }
        return "NONE";
    }
}

if (!function_exists('show_note')) {
    function show_note($type, $name)
    {
        $note['product_category'] = array(
            'delete' => "Xóa danh mục sẽ không xóa sản phẩm trong danh mục đó. Thay vì thế, sản phẩm sẽ được chuyển đến danh mục mặc định Uncategorized. Danh mục mặc định không thể xóa.",
            'title' => "Tên riêng của danh mục để hiển thị trên trang web của bạn",
            'slug' => "Chuỗi đường dẫn tĩnh là tên hợp chuẩn với ĐƯỜNG DẪN (URL). Chuỗi này thường bao gồm chữ cái thường, số , ngăn cách nhau bởi dấu gạch ngang (-) và thường trùng với tên danh mục",
            'parent_cat' => "Chỉ định một danh mục cha để tạo danh mục phân cấp. Ví dụ danh mục Áo sẽ là chuyên mục cha của Áo sơ mi và Áo thể thao",
            'desc' => "Thông thường mô tả này không được sử dụng thường xuyên trong một số giao diện, tuy nhiên một vài giao diện có thể sử dụng thông tin này"
        );

        $note['product'] = array(
            'name' => "Tên riêng của sản phẩm để hiển thị trên trang web của bạn",
            'code' => "Mã riêng của sản phẩm để phân biệt và quản lý danh sách sản phẩm của bạn",
            'price' => "Hãy cho biết sản phẩm này có đáng giá bao nhiêu",
            'desc' => "Mô tả ngắn của sản phẩm . Thông thường được sử dụng mô tả cấu hình của sản phẩm",
            'content' => "Mô tả chi tiết về sản phẩm . Giúp khách hàng hiểu thêm về sản phẩm này",
            'thumb' => "Hình ảnh sản phẩm",
            'product_cat' => "Chỉ định sản phẩm này thuộc danh mục nào để dễ dàng phân tách . Ví dụ sản phẩm Laptop Asus 13 inch thuộc danh mục Asus",
            'status' => "Chỉ định trạng thái sản phẩm . Nếu muốn sản phẩm không hiển thị trên trang web của khách hàng hãy chọn OFF",

        );

        $note['page'] = array(
            'title' => "Tên riêng của trang để hiển thị trên trang web của bạn . Ví dụ : trang LIÊN HỆ , trang VỀ CHÚNG TÔI,...",
            'slug' => "Chuỗi đường dẫn tĩnh là tên hợp chuẩn với ĐƯỜNG DẪN (URL). Chuỗi này thường bao gồm chữ cái thường, số , ngăn cách nhau bởi dấu gạch ngang (-) và thường trùng với tên trang",
            'content' => "Nội dung chi tiết của trang sẽ được hiển thị trên trang web"
        );

        $note['post_category'] = array(
            'delete' => "Xóa danh mục sẽ không xóa bài viết trong danh mục đó. Thay vì thế, bài viết sẽ được chuyển đến danh mục mặc định Uncategorized. Danh mục mặc định không thể xóa.",
            'title' => "Tên riêng của danh mục để hiển thị trên trang web của bạn",
            'slug' => "Chuỗi đường dẫn tĩnh là tên hợp chuẩn với ĐƯỜNG DẪN (URL). Chuỗi này thường bao gồm chữ cái thường, số , ngăn cách nhau bởi dấu gạch ngang (-) và thường trùng với tên danh mục",
            'parent_cat' => "Chỉ định một danh mục cha để tạo danh mục phân cấp. Ví dụ danh mục Thể thao sẽ là chuyên mục cha của Bóng đá và Bơi lội",
            'desc' => "Thông thường mô tả này không được sử dụng thường xuyên trong một số giao diện, tuy nhiên một vài giao diện có thể sử dụng thông tin này"
        );

        $note['post'] = array(
            'unknown_author' => "Bài viết không rõ tác giả mặc định sẽ bị xóa tạm thời - thùng rác . Thành viên khôi phục bài viết sẽ là tác giả mới của bài viết",
            'title' => "Tiêu đề của bài viết để hiển thị trên trang web của bạn",
            'content' => "Chi tiết về bài viết . Giúp người đọc có thể cảm nhận được sự uy tín của cửa hàng và hiểu được cửa hàng đang truyền tải thông tin gì",
            'slug' => "Chuỗi đường dẫn tĩnh là tên hợp chuẩn với ĐƯỜNG DẪN (URL). Chuỗi này thường bao gồm chữ cái thường, số , ngăn cách nhau bởi dấu gạch ngang (-) và thường trùng với tên danh mục",
            'thumb' => "Hình ảnh đại diện của bài viết",
            'parent_cat' => "Chỉ định một danh mục mà bài viết này thuộc vào",
        );

        $note['widget'] = array(
            'title' => "Tên riêng của khối",
            'code' => "Mã riêng của khối để dễ dàng quản lý danh sách khối",
            'content' => "Chi tiết về nội dung của khối sẽ hiển thị trên trang web của bạn",
        );

        $note['menu'] = array(
            'main' => "Mỗi menu sẽ có một danh mục được liên kết . Chỉ được liên kết một danh mục hoặc một trang vào một menu nhất định",
            'title' => "Tên menu sẽ hiển thị trên trang web . Ví dụ \"Trang chủ\" , \"Liên hệ\"",
            'slug' => "Chuỗi đường dẫn tĩnh cho menu",
            'page' => "Trang liên kết đến menu",
            'category_product' => "Danh mục sản phẩm liên kết đến menu",
            'category_post' => "Danh mục bài viết liên kết đến menu",
            'order' => "Thứ tự xuất hiện của các menu , được tính từ trái sang",
        );

        $note['slider'] = array(
            'title' => "Tên của slider để dễ dàng phân biệt",
            'link' => "Đường dẫn mà slider muốn đưa khách hàng đến . Ví dụ \"slider 1\" sẽ đưa khách hàng đến \"danh sách sản phẩm\"",
            'desc' => "Mô tả ngắn về slider . Có thể thêm hoặc không",
            'order' => "Thứ tự xuất hiện của slider được tính từ trái sang phải",
            'url_slider' => "Hình ảnh tức slider",
        );

        $note['banner'] = array(
            'title' => "Tên của banner để dễ dàng phân biệt",
            'link' => "Đường dẫn mà banner muốn đưa khách hàng đến . Ví dụ \"banner 1\" sẽ đưa khách hàng đến \"danh sách sản phẩm\"",
            'desc' => "Mô tả ngắn về banner . Có thể thêm hoặc không",
            'order' => "Thứ tự xuất hiện của banner được tính từ trái sang phải",
            'url_banner' => "Hình ảnh tức banner",
        );
        if (!empty($note[$type][$name])) {
            return $note[$type][$name];
        }
    }
}

if (!function_exists('data_tree')) {
    function data_tree($data = array(), $parent_id = 0, $level = 0)
    {
        $result = array();
        if (!empty($data)) {
            foreach ($data as $item) {
                if ($item['parent_id'] == $parent_id) {
                    $item['level'] = $level;
                    $result[] = $item;
                    // unset($data[$item['id']]);
                    $child = data_tree($data, $item['id'], $level + 1);
                    $result = array_merge($result, $child);
                }
            }
        }
        return $result;
    }
}

if (!function_exists('data_tree_widget_details')) {
    function data_tree_widget_details($data = array(), $detail_id = NULL, $level = 0)
    {
        $result = array();
        if (!empty($data)) {
            foreach ($data as $item) {
                if ($item['detail_id'] == $detail_id) {
                    $item['level'] = $level;
                    $result[] = $item;
                    // unset($data[$item['id']]);
                    $child = data_tree_widget_details($data, $item['id'], $level + 1);
                    $result = array_merge($result, $child);
                }
            }
        }
        return $result;
    }
}

if (!function_exists('get_param_pagging')) {
    function get_param_pagging($num_per_page, $total_row, $page_on_click)
    {
        $pagging['page'] = (int)$page_on_click;
        $pagging['total_row'] = $total_row;
        $pagging['total_page'] = (int)ceil($total_row / $num_per_page);
        $pagging['index'] = ($page_on_click * $num_per_page) - $num_per_page + 1;
        $pagging['start'] = ($page_on_click * $num_per_page) - $num_per_page;
        $pagging['end'] = $num_per_page + $pagging['start'] - 1;
        return $pagging;
    }
}

if (!function_exists('get_param_pagging_offset_limit')) {
    function get_param_pagging_offset_limit($num_per_page, $total_row, $page_on_click)
    {
        $pagging['page'] = (int)$page_on_click;
        $pagging['total_row'] = $total_row;
        $pagging['total_page'] = (int)ceil($total_row / $num_per_page);
        $pagging['index'] = ($page_on_click * $num_per_page) - $num_per_page + 1;
        $pagging['start'] = ($page_on_click * $num_per_page) - $num_per_page;
        $pagging['end'] = $num_per_page + $pagging['start'];
        return $pagging;
    }
}

if (!function_exists('get_pagging')) {
    function get_pagging($page_on_click, $total_pages, $url)
    {
        $str_pagging = "";
        $first_disabled = "";
        $last_disabled = "";
        $first_page_on_click = $page_on_click == 1 ? $page_on_click : $page_on_click - 1;
        $last_page_on_click = $page_on_click == $total_pages ? $page_on_click : $page_on_click + 1;
        if ($total_pages == 1) {
            return;
        }

        $range = 10; #Giới hạn tổng li>a nằm trên 1 page trừ đi 1 và cuối cùng -> 5 li>a . CHỈ ĐƯỢC LẺ

        if ($page_on_click == 1) {
            $first_disabled = "disabled";
        }
        if ($page_on_click == $total_pages) {
            $last_disabled = "disabled";
        }


        $str_pagging = "<nav><ul class='pagination'>";
        $str_pagging .= "<li class='page-item {$first_disabled}'><a class='page-link' href='{$url}{$first_page_on_click}' rel='prev' aria-label='« Previous'>‹</a></li>";


        $i = 1;
        while ($i <= $total_pages) {
            $class_active = "";
            if ($page_on_click == $i) {
                $class_active = "active";
            }

            $str_pagging .= "<li class='page-item {$class_active}'><a class='page-link' href='{$url}{$i}'>{$i}</a></li>";
            $i++;
        }


        $str_pagging .= "<li class='page-item {$last_disabled}'><a class='page-link' href='{$url}{$last_page_on_click}'>›</a></li>";
        $str_pagging .= "</ul></nav>";
        return $str_pagging;
    }
}

if (!function_exists('get_pagging_client')) {
    function get_pagging_client($page_on_click, $total_pages, $url)
    {
        $str_pagging = "";
        $first_disabled = "";
        $last_disabled = "";
        $first_page_on_click = $page_on_click == 1 ? $page_on_click : $page_on_click - 1;
        $last_page_on_click = $page_on_click == $total_pages ? $page_on_click : $page_on_click + 1;
        if ($total_pages == 1 or $total_pages == 0) {
            return;
        }

        $range = 10; #Giới hạn tổng li>a nằm trên 1 page trừ đi 1 và cuối cùng -> 5 li>a . CHỈ ĐƯỢC LẺ

        if ($page_on_click == 1) {
            $first_disabled = "disabled";
        }
        if ($page_on_click == $total_pages) {
            $last_disabled = "disabled";
        }


        $str_pagging = "<nav><ul class='pagination justify-content-center'>";
        $str_pagging .= "<li class='page-item {$first_disabled}'><a class='page-link' href='{$url}{$first_page_on_click}' rel='prev' aria-label='« Previous'>‹</a></li>";


        $i = 1;
        while ($i <= $total_pages) {
            $class_active = "";
            if ($page_on_click == $i) {
                $class_active = "active";
            }

            $str_pagging .= "<li class='page-item {$class_active}'><a class='page-link' href='{$url}{$i}'>{$i}</a></li>";
            $i++;
        }


        $str_pagging .= "<li class='page-item {$last_disabled}'><a class='page-link' href='{$url}{$last_page_on_click}'>›</a></li>";
        $str_pagging .= "</ul></nav>";
        return $str_pagging;
    }
}

if (!function_exists('validation_image')) {
    function validation_image($label_field, $error_class, $upload_dir, $size = 20000000, $format = array('jpg', 'jpeg', 'png', 'gif'))
    {
        $data = array();
        global $_FILES, $error;


        // Vì là mutiple nên phải !empty tới phần tử thứ 0 của 'name'
        if (empty($_FILES[$label_field]['name'][0])) {
            $error[$label_field] = "<p class='{$error_class}'>Tải lên hình ảnh</p>";
        } else {
            if (is_array($_FILES[$label_field]['name'])) { #Mutiple Images
                foreach ($_FILES[$label_field]['name'] as $k_file => $v_file) {

                    # Lấy đường dẫn tạm của ảnh trước khi up lên server
                    $tmp_name = $_FILES[$label_field]['tmp_name'][$k_file];

                    # Lấy đường dẫn real của ảnh sau khi up lên server
                    $upload_file = $upload_dir . $_FILES[$label_field]['name'][$k_file];

                    # Lấy định dạng ảnh . VD : jpg, png để kiểm tra 
                    $file_format = pathinfo($_FILES[$label_field]['name'][$k_file], PATHINFO_EXTENSION);

                    # Lấy tên ảnh và up lên server . VD : hehe, huhu
                    $file_name = pathinfo($_FILES[$label_field]['name'][$k_file], PATHINFO_FILENAME);
                    // Kiểm tra
                    # Đúng định dạng ảnh
                    # Đúng kích thước ảnh
                    # Tồn tại ảnh
                    if (!in_array(strtolower($file_format), $format)) {
                        $string_format = implode(', ', $format);
                        $error[$label_field] = "<p class='{$error_class}'>Hệ thống chỉ hỗ trợ file ảnh có định dạng {$string_format}</p>";
                    } else {
                        if ($_FILES[$label_field]['size'][$k_file] > $size) {
                            $error[$label_field] = "<p class='{$error_class}'>Hệ thống hỗ trợ file ảnh có kích thước <20MB</p>";
                        } else {
                            if (file_exists(base_path($upload_file))) {
                                $new_upload_file =  $upload_dir . $file_name . " - Copy." . $file_format;
                                $k = 2;
                                while (file_exists(base_path($new_upload_file))) {
                                    $new_upload_file =  $upload_dir . $file_name . " - Copy({$k})." . $file_format;
                                    $k++;
                                }
                                $data[] = array(
                                    'url' => $new_upload_file,
                                    'name' => $file_name,
                                    'tmp_name' => $tmp_name
                                );
                            } else {
                                $data[] = array(
                                    'url' => $upload_file,
                                    'name' => $file_name,
                                    'tmp_name' => $tmp_name
                                );
                            }
                        }
                    }
                }
            } else { #Only one
                # Lấy đường dẫn tạm của ảnh trước khi up lên server
                $tmp_name = $_FILES[$label_field]['tmp_name'];

                # Lấy đường dẫn real của ảnh sau khi up lên server
                $upload_file = $upload_dir . $_FILES[$label_field]['name'];

                # Lấy định dạng ảnh . VD : jpg, png để kiểm tra 
                $file_format = pathinfo($_FILES[$label_field]['name'], PATHINFO_EXTENSION);

                # Lấy tên ảnh và up lên server . VD : hehe, huhu
                $file_name = pathinfo($_FILES[$label_field]['name'], PATHINFO_FILENAME);

                // Kiểm tra
                # Đúng định dạng ảnh
                # Đúng kích thước ảnh
                # Tồn tại ảnh
                if (!in_array(strtolower($file_format), $format)) {
                    $string_format = implode(', ', $format);
                    $error[$label_field] = "<p class='{$error_class}'>Hệ thống chỉ hỗ trợ file ảnh có định dạng {$string_format}</p>";
                } else {
                    if ($_FILES[$label_field]['size'] > $size) {
                        $error[$label_field] = "<p class='{$error_class}'>Hệ thống hỗ trợ file ảnh có kích thước <20MB</p>";
                    } else {
                        if (file_exists(base_path($upload_file))) {
                            $new_upload_file =  $upload_dir . $file_name . " - Copy." . $file_format;
                            $k = 2;
                            while (file_exists(base_path($new_upload_file))) {
                                $new_upload_file =  $upload_dir . $file_name . " - Copy({$k})." . $file_format;
                                $k++;
                            }
                            $data = array(
                                'url' => $new_upload_file,
                                'name' => $file_name,
                                'tmp_name' => $tmp_name
                            );
                        } else {
                            $data = array(
                                'url' => $upload_file,
                                'name' => $file_name,
                                'tmp_name' => $tmp_name
                            );
                        }
                    }
                }
            }
            return $data;
        }
    }
}

if (!function_exists('current_format')) {
    function current_format($number, $unit = " ₫")
    {
        return number_format($number, 0, ".", ".") . $unit;
    }
}

if (!function_exists('show_category_data_tree')) {
    function show_category_data_tree($list_category, $link, $parent_id = 0, $level_ul = 1)
    {
        $result = array();
        $class = '';
        foreach ($list_category as $key => $value) {
            if ($value['parent_id'] == $parent_id) {
                $value['link_id'] = $link . '/' . $value['slug'];
                $result[] = $value;
                unset($list_category[$key]);
            }
        }


        if($level_ul == 1){
            $class = "collapse-category open";
        }else{
            $class = "sub-collapse";
        }

        if(!empty($result)){
            echo "<ul class='{$class}'>";
            if($level_ul == 1){
                echo "<li class='back-btn'><i class='fa fa-angle-left'></i> back</li>";
            }
            foreach ($result as $key => $value) {
                echo "<li>";
                echo "<a href='{$value['link_id']}'>{$value['title']}</a>";
                show_category_data_tree($list_category, $link, $value['id'], ++$level_ul);
                echo "</li>";
            }
            echo "</ul>";
        }

    }
}

if (!function_exists('show_category_post_data_tree')) {
    function show_category_post_data_tree($list_category, $link, $parent_id = 0, $level_ul = 0)
    {
        $result = array();

        foreach ($list_category as $key => $value) {
            if ($value['parent_id'] == $parent_id) {
                $value['link_id'] = $link . '/' . $value['slug'];
                $result[] = $value;
                unset($list_category[$key]);
            }
        }




        if(!empty($result)){
            echo "<ul>";
            foreach ($result as $key => $value) {
                echo "<li>";
                echo "<a class='dark-menu-item' href='{$value['link_id']}'>{$value['title']}</a>";
                show_category_post_data_tree($list_category, $link, $value['id'], ++$level_ul);
                echo "</li>";
            }
            echo "</ul>";
        }

    }
}


if(!function_exists('get_all_id_sub_categories')){
    function get_all_id_sub_categories($category){
        $result = [];
        foreach($category->child_items as $item){
            $result[] = $item->id;
            if(!$item->child_items->isEmpty()){
                $child = get_all_id_sub_categories($item);
                $result = array_merge($result, $child);
            }
        }
        return $result;
    }
}

if(!function_exists('percent_discount')){
    function percent_discount($price, $old_price){
        return current_format(($old_price - $price) / $price * 100, "%");
    }
}

if(!function_exists('get_widget_not_childrent')){
    function get_widget_not_childrent($widgets){
        $result = [];
        foreach($widgets as $item){
            if($item->child_items->isEmpty()){
                $result[Str::slug($item->title, "_")] = $item;
                $child = get_all_id_sub_categories($item);
                $result = array_merge($result, $child);
            }
        }
        return $result;
    }
}

if(!function_exists('convert_widget_url')){
    function convert_widget_url($widget_title){
        $widgets = Widget::all('title')->toArray();
        // dd($widgets);
        foreach($widgets as $key => $value){
            foreach($value as $sub_value){
                $widgets[Str::slug($sub_value, "_")] = 'public/images/widget/' . Str::slug($sub_value, "_") . ".jpg";
                unset($widgets[$key]);
            }
        }
        if (array_key_exists($widget_title, $widgets)) {
            return $widgets[$widget_title];
        }else{
            return "NONE";
        }
    }
}