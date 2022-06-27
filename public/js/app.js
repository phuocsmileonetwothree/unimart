$(document).ready(function () {


    $('.nav-link.active .sub-menu').slideDown();
    // $("p").slideUp();

    $('#sidebar-menu .arrow').click(function () {
        $(this).parents('li').children('.sub-menu').slideToggle();
        $(this).toggleClass('fa-angle-right fa-angle-down');
    });

    $("input[name='checkall']").click(function () {
        var checked = $(this).is(':checked');
        $('.table-checkall tbody tr td input:checkbox').prop('checked', checked);
    });

    // Only Edit For Collaborators
    $('select.only-check-create').each(function () {
        var id = $(this).val();
        var title = $(this).find(":selected").text();
        if (id == 4 || title == 'Cộng tác viên') {
            $(this).closest('.only-create').find("input:checkbox").removeAttr('disabled');
            $(this).closest('.only-create').find("input:checkbox").attr('disabled', 'disabled');
            $(this).closest('.only-create').find("input.create-permission").removeAttr('disabled');
        } else {
            $(this).closest('.only-create').find("input:checkbox").removeAttr('disabled');
        }
    });
    // Only Create For Collaborators
    $("select.only-check-create").change(function () {
        var id = $(this).val();
        var title = $(this).find(":selected").text();
        if (id == 4 || title == 'Cộng tác viên') {
            $(this).closest('.only-create').find("input:checkbox").prop('checked', false);
            $(this).closest('.only-create').find("input:checkbox").removeAttr('disabled');
            $(this).closest('.only-create').find("input:checkbox").attr('disabled', 'disabled');
            $(this).closest('.only-create').find("input.create-permission").removeAttr('disabled');
        } else {
            $(this).closest('.only-create').find("input:checkbox").removeAttr('disabled');
        }

    });

    // CheckAll Permission Edit
    $('input.check-all').each(function () {
        if ($(this).is(':checked')) {
            var status = $(this).prop('checked');
            $(this).parent().parent().find("input.check-item").each(function () {
                if (status == true) {
                    $(this).attr('disabled', 'disabled');
                } else {
                    $(this).removeAttr('disabled');
                }
                $(this).prop('checked', status);
            });
        }

    });
    // CheckAll Permission Create
    $("input.check-all").click(function () {
        var checked = $(this).is(':checked');
        $(this).parent().parent().find("input.check-item").prop('checked', checked);
        $(this).parent().parent().find("input.check-item").attr('disabled', 'disabled');
        if (checked == false) {
            $(this).parent().parent().find("input.check-item").removeAttr('disabled');
        }
    });
    // Update Image Action Edit Post
    function imagePreview(fileInput) {
        if (fileInput.files && fileInput.files[0]) {
            var fileReader = new FileReader();
            fileReader.onload = function (event) {
                $('.preview-image').attr('src', event.target.result);
            };
            fileReader.readAsDataURL(fileInput.files[0]);
        }
    }
    $("#preview-file").change(function () {
        imagePreview(this);
    });

    // Delete Image Action Edit Product
    $("ul.list-update-thumb li a").click(function () {
        var data_url = $(this).parent().parent().attr('data-url');
        var product_id = $(this).attr('data-id');
        var image_id = $(this).attr('data-image')
        var action = $(this).attr('class');
        if (action == 'delete' && confirm("Bạn chắc chắn xóa hình ảnh . Không thể hoàn tác lại khi đã xóa") == false) {
            return false;
        }
        var data = { image_id: image_id, product_id: product_id };
        $.ajax({
            url: data_url,
            method: "GET",
            data: data,
            // Lỗi "SyntaxError: Không mong đợi mã thông báo <trong JSON ở vị trí 0"
            // thường xảy ra khi dữ liệu trả về có ký tự ">" html
            // Khi có hàm show_array thì sẽ có thẻ <pre> </pre>
            // Xem trong f12->internet->response
            dataType: "json",
            success: function (data) {
                if (data.delete == false) {
                    alert("Không thể xóa tất cả hình ảnh . Bạn có thể thêm 1 ảnh mới và sau đó xóa ảnh bạn muốn xóa");
                }
                if (data.delete == true) {
                    $("ul#list-thumb img[data-image=" + image_id + "]").attr('src', '');
                    $("ul.list-update-thumb li a[data-image=" + image_id + "]").parent().parent().parent().css({ "background": "red", "color": "#fff", "transition": "2s", "opacity": "0.5" });
                    $("ul.list-update-thumb li a[data-image=" + image_id + "]").parent().parent().parent().fadeOut(1000);
                }
            },
            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }

        })

        return false;
    });
    // Add Image Action Edit Product
    $("input.add-list-image").change(function () {
        var form_data = new FormData();

        var _token = $("input[name='_token']").val();
        var data_url = $(this).attr('data-url');
        var product_id = $(this).attr('data-id');
        var totalfiles = document.getElementById('files').files.length;

        for (var index = 0; index < totalfiles; index++) {
            form_data.append("files[]", document.getElementById('files').files[index]);
        }
        form_data.append("product_id", product_id);
        form_data.append("_token", _token);
        $.ajax({
            url: data_url,
            type: 'POST',
            data: form_data,
            dataType: 'html',
            cache: false,
            contentType: false,
            processData: false,
            success: function (data) {
                $("ul#list-thumb").append(data);
            },
            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }
        });
    })
    // Swap Order Image Action Edit Product
    var image_swap = [];
    $("ul#list-thumb li img").click(function () {
        var image_id = $(this).attr('data-image');
        var data_url = $(this).parent().parent().attr('data-url');
        image_swap.push(image_id);
        $(this).addClass('border-2px');
        var count = $('ul#list-thumb li img.border-2px').length;
        if (count == 2) {
            if (confirm("Bạn chắc chắn đổi vị trí của hình ảnh . Vị trí của hình ảnh theo thứ tự đầu tiên đến cuối cùng được tính từ trái sang phải , từ trên xuống dưới") == true) {
                var data = { image_one: image_swap[0], image_two: image_swap[1] };

                $.ajax({
                    url: data_url,
                    method: "GET",
                    data: data,
                    // Lỗi "SyntaxError: Không mong đợi mã thông báo <trong JSON ở vị trí 0"
                    // thường xảy ra khi dữ liệu trả về có ký tự ">" html
                    // Khi có hàm show_array thì sẽ có thẻ <pre> </pre>
                    // Xem trong f12->internet->response
                    dataType: "json",
                    success: function (data) {
                        if (data.swap_image == false) {
                            alert("Hệ thống đã xảy ra lỗi . Mong bạn thử lại sau");
                        } else {
                            $("ul#list-thumb li img[data-image=" + image_swap[0] + "]").removeAttr('src').attr('src', data.new_src_img_one);
                            $("ul#list-thumb li img[data-image=" + image_swap[1] + "]").removeAttr('src').attr('src', data.new_src_img_two);
                            image_swap = [];
                            $('ul#list-thumb li img').removeClass('border-2px');
                        }
                    },
                    error: function (xhr, ajaxOption, thorwnError) {
                        console.log(xhr.status);
                        console.log(thorwnError);
                    }

                })
            } else {
                $('ul#list-thumb li img').removeClass('border-2px');
                image_swap = [];
                console.log(image_swap);
            }
        }
    });

    // Widget Content
    $("ul.list-icon li").click(function () {
        $(this).parent().children("li").css('border', 'none');
        $(this).css('border', '2px solid #007bff');
    });
    var type_icon = "";
    $("ul.list-icon li").dblclick(function () {
        type_icon = $(this).children("i").attr('class');
        $("input[name='type_icon']").val(type_icon);
        $("button.close").click();
    });
    $("ul.list-slider-banner li").click(function () {
        $(this).parent().children("li").css('border', 'none');
        $(this).css('border', '2px solid #007bff');
    });
    var type_src = "";
    $("ul.list-slider-banner li").dblclick(function () {
        type_src = $(this).children("img").attr('src');
        var data_image_id = $(this).children("img").attr('data-image-id')
        $("input[name='image_id']").val(data_image_id);
        $("button.close").click();
    });

    $("select[name='type_content']").change(function () {
        plaintext_ = $(this).val();
        var content = "";
        if (plaintext_ == "") { //# Đây là không chọn plaintext
            $(".plaintext").slideUp();
        } else if (plaintext_ == "plaintext-icon") { //# Đây là plaintext icon Done
            $(".plaintext").slideDown();
            $(".plaintext-icon").show();
            $(".plaintext-slider-banner").hide();
            $(".plaintext-slider-banner").hide();
            $(".plaintext-child-slider-banner").hide();


            $(".card-body").on("change dblclick", "input[name='content'], select.type-heading, select.type-color, ul.list-icon li", function () {

                var content = $("input[name='content']").val();
                var type_heading = $("select.type-heading").val();
                var type_color = $("select.type-color").val();
                if (type_color != "") {
                    type_color = " style='color:" + type_color + ";'";
                }
                if (type_heading != "") {
                    content = "<" + type_heading + type_color + ">" + content + "</" + type_heading + ">";
                }
                if (type_icon != "") {
                    // $("input[name='content']").val("").val(type_icon);
                    content = "<i class='" + type_icon + "'></i>" + "&emsp;" + content;
                }
                $(".preview-content").css('color', $("select.type-color").val());
                $(".preview-content").empty().append(content);
            });
        } else if (plaintext_ == "plaintext-slider-banner-group") { //# Đây là plaintext slider banner group
            alert("Bạn có thể thêm slider hoặc banner trước và sau đó chọn các plaintext con phụ thuộc đã được thêm trước đó vào slider này . Nếu chưa có plaintext con phụ thuộc , hãy tạo và chọn nó phụ thuộc vào slider hoặc banner đang tạo")
            $(".plaintext").slideDown();
            $(".plaintext .col-6:first-child").hide();
            $(".plaintext .plaintext-child-slider-banner").show();
            $(".plaintext-slider-banner").show();
            $(".plaintext-icon").hide();


            $(".card-body").on("change dblclick", "select[name='detail_id[]'], ul.list-slider-banner li", function () {
                $(".preview-content").parent().children('label').html("Preview : <small class='text-danger'>Bạn có thể thêm các plaintext con phụ thuộc trước . Sau đó hãy thêm Slider hoặc Banner và chọn các khối con phụ thuộc vào . Plaintext phụ thuộc và hình sẽ tự động trôi nổi theo mặc định . Đây chỉ là bản xem thử</small>");
                var content = $("select[name='detail_id[]']").find("*:selected").text();
                $("input[name='content']").val(type_src);
                if (type_src != "") {
                    content = "<img src='" + type_src + "'>" + content;
                }
                $(".preview-content").empty().append(content);
            });

        } else { //# Đây là plaintext basic DONE
            $(".plaintext").slideDown();
            $(".plaintext .col-6:first-child").show();
            $(".plaintext-icon").hide();
            $(".plaintext-slider-banner").hide();
            $(".plaintext-child-slider-banner").hide();


            $("input[name='content'], select.type-heading, select.type-color").change(function () {
                var content = $("input[name='content']").val();
                var type_heading = $("select.type-heading").val();
                var type_color = $("select.type-color").val();
                if (type_color != "") {
                    type_color = " style='color:" + type_color + ";'";
                }
                if (type_heading != "") {
                    content = "<" + type_heading + type_color + ">" + content + "</" + type_heading + ">";
                }
                $(".preview-content").css('color', $("select.type-color").val());
                $(".preview-content").empty().append(content);
            });
        }
    });




    $("select.choose-only-one, input.choose-only-one").change(function () {
        var value = $(this).val();
        $("input[name='url']").val(value);
        $("select.choose-only-one").val("");
        $("input.choose-only-one").val("");
        $(this).val(value);

        $("#preview-url").empty().append("<a target='_blank' href='" + value + "'>" + value + "</a>")
        $("#preview-url>a").css('color', '#0d6efd');
    });



    $(".get-widget").click(function () {
        var data_url = $(this).attr('data-url');
        var data_widget = $(this).attr('data-widget');
        var widget_title = $(this).attr('data-title');
        var data = { data_widget: data_widget };
        $.ajax({
            url: data_url,
            method: "GET",
            data: data,
            // Lỗi "SyntaxError: Không mong đợi mã thông báo <trong JSON ở vị trí 0"
            // thường xảy ra khi dữ liệu trả về có ký tự ">" html
            // Khi có hàm show_array thì sẽ có thẻ <pre> </pre>
            // Xem trong f12->internet->response
            dataType: "json",
            success: function (data) {
                if (data.result == false) {
                    alert("Hiện tại Widget " + widget_title + " chưa có bản xem trước . Xin vui lòng liên hệ quản trị hệ thống để biết thêm chi tiết");
                } else {
                    $('#modal-widget').modal('show');
                    $(".modal-title").text(widget_title);
                    $(".modal-body").empty().append("<img src='" + data.url + "' class='fit-img'>");
                }
            },
            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }

        })


        return false;
    })



    // Load Brand Ajax
    $('select.event-load-brand-ajax').change(function () {
        if ($(this).val() != '') {
            var data_url = $(this).attr('data-url');
            var cat_id = $(this).val();
            var data = { cat_id: cat_id };

            $.ajax({
                url: data_url,
                method: "GET",
                data: data,
                dataType: "json",
                success: function (data) {
                    if (data.result == true) {
                        $("select.load-brand-ajax").removeAttr('disabled');
                        $("select.load-brand-ajax").empty().append(data.html_option);
                    } else {
                        $("select.load-brand-ajax").parent().find('label').empty().append("Thuộc thương hiệu : <small class='text-danger'>Hiện tại danh mục bạn chọn không có thương hiệu con . Vui lòng cập nhật thương hiệu cho danh mục bạn đang chọn</small>");
                    }
                },
                error: function (xhr, ajaxOption, thorwnError) {
                    console.log(xhr.status);
                    console.log(thorwnError);
                }

            })
        }
    });
    $("input#color-picker").change(function(){
        var color = $(this).val();
        $(this).parent().children('label').empty().append('Mã màu : ' + "<span>" + color + "</span>");
        $(this).parent().children('label').children('span').css('color', color);
    });
    
    
       // Color Select Mutiple
    $("select#color").find("*:selected").css("display", 'list-item');
    $("select#color").change(function () {
        $('#color option').each(function () {
            if ($(this).is(':selected')) {
                $(this).css("display", 'list-item');
            }
        });
    });

});