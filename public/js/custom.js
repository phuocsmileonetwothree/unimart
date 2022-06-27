$(document).ready(function () {

    $("ul.collapse-category li").find("ul.sub-collapse").parent().children('a').append("<i class='fa fa-angle-right arrow fade-arrow'></i>");
    $(".fade-arrow").click(function () {
        $(this).parent().parent().children('ul.sub-collapse').slideToggle();
        return false;
    })
    var middle_outer_width_product_content = $(".product-content").outerWidth() / 2;
    var middle_outer_width_extend_content = $(".extend-content").outerWidth() / 2
    var position_left = middle_outer_width_product_content - middle_outer_width_extend_content;
    $("a.extend-content").css('left', position_left);
    $("a.collapse-content").css('left', position_left);
    $('a.extend-content').click(function () {
        $(".product-content").addClass('max-height-none');
        $(".opacity").hide();
        $('a.extend-content').hide();
        $('a.collapse-content').show();
        return false;
    });

    $('a.collapse-content').click(function () {
        $(".product-content").removeClass('max-height-none');
        $(".opacity").show();
        $('a.extend-content').show();
        $('a.collapse-content').hide();
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#content-scroll").offset().top
        }, 1);
        return false;

    });

    $('.custom-minus').click(function () {
        var $input = $(this).parent().find('input');
        var count = parseInt($input.val()) - 1;
        count = count < 1 ? 1 : count;
        $input.val(count);
        $input.change();
        return false;
    });
    $('.custom-plus').click(function () {
        var $input = $(this).parent().find('input');
        $input.val(parseInt($input.val()) + 1);
        $input.change();
        return false;
    });

    // ADD CART AJAX
    $(".custom-add-cart").click(function () {
        // color_id dưới đây được lấy ở modal #product-quick-info
        var color_id = $('#selectSize .product-color .color-select ul li i.active').attr('data-color');
        if (color_id == undefined) {
            color_id = 0;
        }
        var qty = $('.qty-custom-add-cart').val();
        if (qty == undefined) {
            qty = 1;
        }
        var data_url = $(this).attr('data-url-add-cart');
        var product_id = $(this).attr('data-id');
        var data = { product_id: product_id, qty: qty, color_id: color_id };
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
                $("ul.add-product-ajax").empty().append(data.html);
                $(".item-count-contain").text(data.total_qty);
                $(".total-price").text(data.total_price);
                $("input.num-order").change(function () {
                    var data_url = $(this).attr('data-url');
                    var qty = $(this).val();
                    var row_id = $(this).attr('data-id');
                    var data = { row_id: row_id, qty: qty };
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
                            $("input.num-order[name=num-order-" + row_id + "]").val(data.qty);
                            $("h2.sub-total-" + row_id).text(data.sub_total);
                            $(".total-price").text(data.total_price);
                        },
                        error: function (xhr, ajaxOption, thorwnError) {
                            console.log(xhr.status);
                            console.log(thorwnError);
                        }

                    })
                });
            },
            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }

        })

    });

    // ADD CHECKOUT AJAX
    $(".custom-checkout").click(function(){
        var color_id = $('#selectSize .product-color .color-select ul li i.active').attr('data-color');
        if (color_id == undefined) {
            color_id = 0;
        }
        var qty = $('.qty-custom-add-cart').val();
        if (qty == undefined) {
            qty = 1;
        }
        var data_url_checkout = $(this).attr('data-url-add-checkout');
        var product_id = $(this).attr('data-id');
        var data = { product_id: product_id, qty: qty, color_id: color_id };
        $.ajax({
            url: data_url_checkout,
            method: "GET",
            data: data,
            dataType: "json",
            success: function (data) {
                window.location = data.url_checkout;
            },
            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }

        })
    });

    // ADD CART AJAX DETAIL PRODUCT
    $(".custom-add-cart-detail").click(function () {
        // color_id dưới đây được lấy ở modal #product-quick-info
        var color_id = $('#selectSize .product-color .color-select-detail ul li i.active').attr('data-color');
        if (color_id == undefined) {
            color_id = 0;
        }
        var qty = $('.qty-custom-add-cart-detail').val();
        if (qty == undefined) {
            qty = 1;
        }
        var data_url = $(this).attr('data-url-add-cart');
        var product_id = $(this).attr('data-id');
        var data = { product_id: product_id, qty: qty, color_id: color_id };
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
                $("ul.add-product-ajax").empty().append(data.html);
                $(".item-count-contain").text(data.total_qty);
                $(".total-price").text(data.total_price);
                $("input.num-order").change(function () {
                    var data_url = $(this).attr('data-url');
                    var qty = $(this).val();
                    var row_id = $(this).attr('data-id');
                    var data = { row_id: row_id, qty: qty };
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
                            $("input.num-order[name=num-order-" + row_id + "]").val(data.qty);
                            $("h2.sub-total-" + row_id).text(data.sub_total);
                            $(".total-price").text(data.total_price);
                        },
                        error: function (xhr, ajaxOption, thorwnError) {
                            console.log(xhr.status);
                            console.log(thorwnError);
                        }

                    })
                });
            },
            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }

        })

    });
    
    // UPDATE CART QTY
    $("input.num-order").change(function () {
        var data_url = $(this).attr('data-url');
        var qty = $(this).val();
        var row_id = $(this).attr('data-id');
        var data = { row_id: row_id, qty: qty };
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
                $("input.num-order[name=num-order-" + row_id + "]").val(data.qty);
                $(".sub-total-" + row_id).text(data.sub_total);
                $(".item-count-contain").text(data.total_qty);
                $(".total-price").text(data.total_price);
            },
            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }

        })
    });
    // UPDATE BUY NOW QTY
    $("input.num-buy-now").change(function () {
        var data_url = $(this).attr('data-url');
        var qty = $(this).val();
        var id = $(this).attr('data-id');
        var data = { id: id, qty: qty };
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
                $("input.num-buy-now").attr('value', data.qty);
                $(".total-price").text(data.total_price);
            },
            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }

        })
    });

    // FILTER CATEGORY
    $("ul.list-filter li a").click(function () {
        $("input[name='btn_submit_filter']").css('margin-left', '10px');
        $("input[name='btn_submit_filter']").show();
        if ($(this).parent().parent().hasClass('filter-brand')) {
            $(this).toggleClass('active');
        }

        if ($(this).parent().parent().hasClass('filter-price')) {
            $("ul.filter-price li a").removeClass('active');
            $(this).addClass('active');
        }
        return false;
    });

    $("input[name='btn_submit_filter']").click(function () {
        var data_url = $("form").attr('action');
        var brand = [];
        var price = "";
        var sort = "";
        $("ul.filter-brand li a").each(function () {
            if ($(this).hasClass('active')) {
                brand.push($(this).attr('data-brand'));
            }
        });
        $("ul.filter-price li a").each(function () {
            if ($(this).hasClass('active')) {
                price = $(this).attr('data-price');
            }
        });
        sort = $("select[name='sort']").val();


        if (brand.length) {

            brand = '?b=' + brand.join(',');

            if (price != '') {
                price = "&p=" + price;
            } else {
                price = "&p=0";
            }

            if (sort != '') {
                // Mục đích giấu đường dẫn
                if (sort == 'high-to-low') {
                    sort = 1;
                } else {
                    sort = 2;
                }
                sort = "&s=" + sort;
            } else {
                sort = "&s=0";
            }
            window.location = data_url + brand + price + sort;
        } else {
            brand = "?b=0";
            if (price != '') {
                price = "&p=" + pirce;
            } else {
                price = "&p=0";
            }
            if (sort != '') {
                // Mục đích giấu đường dẫn
                if (sort == 'high-to-low') {
                    sort = 1;
                } else {
                    sort = 2;
                }
                sort = "&s=" + sort;
            } else {
                sort = "&s=0";
            }
            window.location = data_url + brand + price + sort;
        }

        return false;
    });
    $("select[name='sort']").change(function () {
        $("input[name='btn_submit_filter']").click();
    })
    // CHECKOUT
    $("a.custom-checkout-ajax").click(function () {
        var _token = $("input[name='_token']").val();
        var data_url = $(this).attr('data-url');
        var info = [];
        var error = 0;
        $("fieldset.custom-checkout-ajax input, textarea").each(function (i, e) {
            if ($(this).val() == '' && $(this).attr('name') != 'note') {
                $(this).addClass('is-invalid');
                $(this).prev('label').append("<span class='text-danger'>(*)</span>")
                error = 1;

            }
            info[$(this).attr('name')] = $(this).val();
        });

        if (error == 0) {
            var data = { _token: _token, fullname: info['fullname'], phone: info['phone'], email: info['email'], address: info['address'], note: info['note'] };
            $.ajax({
                url: data_url,
                method: "POST",
                data: data,
                // Lỗi "SyntaxError: Không mong đợi mã thông báo <trong JSON ở vị trí 0"
                // thường xảy ra khi dữ liệu trả về có ký tự ">" html
                // Khi có hàm show_array thì sẽ có thẻ <pre> </pre>
                // Xem trong f12->internet->response
                dataType: "json",
                success: function (data) {
                    if (data.set_info == true) {
                        $("fieldset[data-index='1']").css({ 'display': 'none', 'position': 'relative', 'opacity': '0' });
                        $("ul#progressbar li[data-index='2']").addClass('active');
                        $("fieldset[data-index='2']").css({ 'display': 'block', 'opacity': '1' });
                        $(".delevery-code > h4 > span").text(info['address']);
                    }
                },
                error: function (xhr, ajaxOption, thorwnError) {
                    console.log(xhr.status);
                    console.log(thorwnError);
                }

            })
        }
        return false;
    });

    if ($("ul#progressbar li[data-index='1']").attr('data-next') == 'true') {
        $("a.custom-checkout-ajax").click();
    }

    $("fieldset a.next, a.previous, a.custom-checkout-ajax").click(function () {
        $([document.documentElement, document.body]).animate({
            scrollTop: $("#progressbar").offset().top
        }, 1);
    });

    // ACTIVE COLOR
    $(".color-select li:first-child i").addClass('active');
    var parent_background = $(".color-select li:first-child").css('background-color');
    if (parent_background == '#ffffff' || parent_background == '#FFF' || parent_background == 'rgb(255, 255, 255)') {
        $(".color-select li:first-child").children('i').css('color', '#333');
    }
    $(".color-select li").click(function () {
        $(".color-select li i").removeClass('active');
        $(this).children('i').addClass('active');
        var parent_background = $(this).css('background-color');
        if (parent_background == '#ffffff' || parent_background == '#FFF' || parent_background == 'rgb(255, 255, 255)') {
            $(this).children('i').css('color', '#333');
        }
        var color_id = $(this).children('i.active').attr('data-color');
        $("input[name='color_id']").attr('value', color_id);

    });

    // ACTIVE COLOR DETAIL
    $(".color-select-detail li:first-child i").addClass('active');
    var parent_background = $(".color-select-detail li:first-child").css('background-color');
    if (parent_background == '#ffffff' || parent_background == '#FFF' || parent_background == 'rgb(255, 255, 255)') {
        $(".color-select-detail li:first-child").children('i').css('color', '#333');
    }
    $(".color-select-detail li").click(function () {
        $(".color-select-detail li i").removeClass('active');
        $(this).children('i').addClass('active');
        var parent_background = $(this).css('background-color');
        if (parent_background == '#ffffff' || parent_background == '#FFF' || parent_background == 'rgb(255, 255, 255)') {
            $(this).children('i').css('color', '#333');
        }
        var color_id = $(this).children('i.active').attr('data-color');
        $("input[name='color_id']").attr('value', color_id);

    });





    var myModal = new bootstrap.Modal(document.getElementById('product-quick-info'), {
        keyboard: false
    })
    // Product Quick Info Load
    $(".load-info-product").click(function () {
        $(".qty-custom-add-cart").val('1');
        $("#product-quick-info .product-color").empty();
        if ($(this).hasClass('add-cart')) {
            $("a.element-checkout").hide();
            $("a.view-detail-checkout").hide();
            $("a.element-add-cart").show();
            $("a.view-detail-add-cart").show();
        }
        if ($(this).hasClass('checkout')) {
            $("a.element-add-cart").hide();
            $("a.view-detail-add-cart").hide();
            $("a.element-checkout").show();
            $("a.view-detail-checkout").show();
        }
        var data_url = $(this).attr('data-url');
        var product_id = $(this).attr('data-id');

        var data = { product_id: product_id };
        $.ajax({
            url: data_url,
            method: "GET",
            data: data,
            dataType: "json",
            success: function (data) {
                if (data.result == true) {
                    $("#product-quick-info .quick-view-img img").attr('src', data.image).css('display', 'block');
                    $("#product-quick-info .name-price h2").text(data.name);
                    $("#product-quick-info .name-price ul li:first-child").text(data.price);
                    $("#product-quick-info .name-price ul li.old-price").remove();
                    if (data.old_price.length > 4) {
                        $("#product-quick-info .name-price ul").append("<li class='old-price'>" + data.old_price + "</li>");
                    }
                    if (data.colors.length > 0) {
                        var color_html = "";
                        color_html += "<h6 class='product-title'>" + "Lựa chọn màu" + "</h6>";
                        color_html += "<div class='color-select inline'>";
                        color_html += "<ul>";
                        data.colors.forEach(function (value) {
                            color_html += "<li " + "style='background-color: " + value.code + "'" + ">";
                            color_html += "<i class='fas fa-check' data-color='" + value.id + "'></i>";
                            color_html += "</li>";
                        });
                        color_html += "</ul>";
                        color_html += "</div>";
                        $("#product-quick-info .product-color").html(color_html);

                    }
                    $("#product-quick-info .product-desc .desc").html(data.desc);
                    $("#product-quick-info .product-buttons a.element-add-cart,a.element-checkout").attr('data-id', data.id)
                    $("#product-quick-info .product-buttons a.view-detail-add-cart,a.view-detail-checkout").attr('href', data.url_detail);



                    myModal.toggle();


                    // Color Selector
                    $(".color-select li:first-child i").addClass('active');
                    var parent_background = $(".color-select li:first-child").css('background-color');
                    if (parent_background == '#ffffff' || parent_background == '#FFF' || parent_background == 'rgb(255, 255, 255)') {
                        $(".color-select li:first-child").children('i').css('color', '#333');
                    }
                    // ACTIVE COLOR
                    $(".color-select li").click(function () {
                        $(".color-select li i").removeClass('active');
                        $(this).children('i').addClass('active');
                        var parent_background = $(this).css('background-color');
                        if (parent_background == '#ffffff' || parent_background == '#FFF' || parent_background == 'rgb(255, 255, 255)') {
                            $(this).children('i').css('color', '#333');
                        }
                        var color_id = $(this).children('i.active').attr('data-color');
                        $("input[name='color_id']").attr('value', color_id);

                    });

                    $('a.custom-add-cart').click(function () {
                        myModal.toggle();
                    })
                }
            },
            error: function (xhr, ajaxOption, thorwnError) {
                console.log(xhr.status);
                console.log(thorwnError);
            }

        })

    });


    // product-3
    $("#tab-1").css("display", "Block");
    $(".default").css("display", "Block");
    $(".tabs li a").on('click', function () {
        // event.preventDefault();
        $('.tab_product_slider').slick('unslick');
        $('.product-slide-3').slick('unslick');
        $(this).parent().parent().find("li").removeClass("current");
        $(this).parent().addClass("current");
        var currunt_href = $(this).attr("href");
        $('#' + currunt_href).show();
        $(this).parent().parent().parent().parent().find(".tab-content").not('#' + currunt_href).css("display", "none");
        $(".product-slide-3").slick({
            arrows: true,
            dots: false,
            infinite: false,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 2,
            responsive: [
                {
                    breakpoint: 1420,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                        infinite: true
                    }
                },
                {
                    breakpoint: 420,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true
                    }
                },
            ]
        });
        // Product Quick Info Load
        $(".load-info-product").click(function () {
            $("#product-quick-info .product-color").empty();
            if ($(this).hasClass('add-cart')) {
                $("a.element-checkout").hide();
                $("a.view-detail-checkout").hide();
                $("a.element-add-cart").show();
                $("a.view-detail-add-cart").show();
            }
            if ($(this).hasClass('checkout')) {
                $("a.element-add-cart").hide();
                $("a.view-detail-add-cart").hide();
                $("a.element-checkout").show();
                $("a.view-detail-checkout").show();
            }
            var data_url = $(this).attr('data-url');
            var product_id = $(this).attr('data-id');

            var data = { product_id: product_id };
            $.ajax({
                url: data_url,
                method: "GET",
                data: data,
                dataType: "json",
                success: function (data) {
                    if (data.result == true) {
                        $("#product-quick-info .quick-view-img img").attr('src', data.image).css('display', 'block');
                        $("#product-quick-info .name-price h2").text(data.name);
                        $("#product-quick-info .name-price ul li:first-child").text(data.price);
                        $("#product-quick-info .name-price ul li.old-price").remove();
                        if (data.old_price.length > 4) {
                            $("#product-quick-info .name-price ul").append("<li class='old-price'>" + data.old_price + "</li>");
                        }
                        if (data.colors.length > 0) {
                            var color_html = "";
                            color_html += "<h6 class='product-title'>" + "Lựa chọn màu" + "</h6>";
                            color_html += "<div class='color-select inline'>";
                            color_html += "<ul>";
                            data.colors.forEach(function (value) {
                                color_html += "<li " + "style='background-color: " + value.code + "'" + ">";
                                color_html += "<i class='fas fa-check' data-color='" + value.id + "'></i>";
                                color_html += "</li>";
                            });
                            color_html += "</ul>";
                            color_html += "</div>";
                            $("#product-quick-info .product-color").html(color_html);

                        }
                        $("#product-quick-info .product-desc .desc").html(data.desc);
                        $("#product-quick-info .product-buttons a.element-add-cart,a.element-checkout").attr('data-id', data.id)
                        $("#product-quick-info .product-buttons a.view-detail-add-cart,a.view-detail-checkout").attr('href', data.url_detail);



                        myModal.toggle();


                        // Color Selector
                        $(".color-select li:first-child i").addClass('active');
                        var parent_background = $(".color-select li:first-child").css('background-color');
                        if (parent_background == '#ffffff' || parent_background == '#FFF' || parent_background == 'rgb(255, 255, 255)') {
                            $(".color-select li:first-child").children('i').css('color', '#333');
                        }
                        // ACTIVE COLOR
                        $(".color-select li").click(function () {
                            $(".color-select li i").removeClass('active');
                            $(this).children('i').addClass('active');
                            var parent_background = $(this).css('background-color');
                            if (parent_background == '#ffffff' || parent_background == '#FFF' || parent_background == 'rgb(255, 255, 255)') {
                                $(this).children('i').css('color', '#333');
                            }
                            var color_id = $(this).children('i.active').attr('data-color');
                            $("input[name='color_id']").attr('value', color_id);

                        });

                        $('a.custom-add-cart').click(function () {
                            myModal.toggle();
                        });
                    }
                },
                error: function (xhr, ajaxOption, thorwnError) {
                    console.log(xhr.status);
                    console.log(thorwnError);
                }
            });
        });
    });
});