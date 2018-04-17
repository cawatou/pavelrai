jQuery(document).ready(function($){
    initFunction();
    compose_pagination();
    $(document).find('.page_gal').on('click', function(){
        if($(this).hasClass('active')) return false;
        var current_page = $('.paging-input_0 .total-pages_0:first-child').text().trim();
        console.log($(this));

        var move_page = $(this).attr('data-page');
        if(current_page < move_page) {
            move_page = parseInt(move_page) - 1;
            spider_page_0(this, move_page, 1);
        }
        if(current_page > move_page) {
            move_page = parseInt(move_page) + 1;
            spider_page_0(this, move_page, -1);        }

        $('.page_gal').removeClass('active');
        $(this).addClass('active');
        console.log(current_page, move_page);
    })


    function compose_pagination(){

        var el ='';
        var page_count = $('.paging-input_0 .total-pages_0:last-child').text().trim();
        for(var i=1; i<=page_count; i++){
            if(i == 1) el = '<li class="page_gal active" data-page="'+i+'"><span>' + i +'</span></li>';
            else el = '<li class="page_gal" data-page="'+i+'"><span>' + i +'</span></li>';
            $('ul.pagination_gal').append(el);
        }
    }

    function initFunction() {

        // ============================== drawSeparateLine =========================
        var menu_height = $('.menu-left_menu-container').height();
        var content_height = $('.page_content').height();
        if(content_height == null) content_height = $('.product-archive').height();

        if (content_height > menu_height) {

            if($("div").is(".page_content")) $('.page_content').addClass('content_separate');
            else $('.product-archive').addClass('content_separate');
        }
        else $('.menu-left_menu-container').addClass('menu_separate');
        console.log(menu_height, content_height);


        /*=============================== carousel ====================================*/
        var carousel = $('#our_works .owl-carousel');
        carousel.owlCarousel({
            loop:true,
            stagePadding:30,
            pagination:true,
            items: 4,
            singleItem: false,
        });

        if($('div').hasClass('product-carousel')) {
            var prod_carousel = $('.product-carousel');
            prod_carousel.owlCarousel({
                loop:true,
                stagePadding:30,
                pagination:false,
                items: 5,
                singleItem: false,
            });
        }

        $("#our_works .right_arr").click( () => carousel.trigger('owl.next'));
        $("#our_works .left_arr").click( () => carousel.trigger('owl.prev'));
        $(".single_prod .right_arr").click( () => prod_carousel.trigger('owl.next'));
        $(".single_prod .left_arr").click( () => prod_carousel.trigger('owl.prev'));

        /*=============================== active parent menu (ico) ====================================*/
        $('.current-menu-item a').addClass('active');

        if($("li").is(".current-menu-item") == false) console.log('no hover');
        console.log($("li").is(".current-menu-item"));
    }

    $('.price_block button').on('click', function(){
        var class_name = this.className;
        var direction = $(this).attr('data-dir');
        var quantity = $('input.' + class_name).val();
        var cart_key = $('input.' + class_name).attr('data-key');
        console.log(class_name, direction, quantity, cart_key);

        if(direction == 'left' && quantity > 0) quantity--;
        if(direction == 'right') quantity++;
        $('input.' + class_name).val(quantity);

        ajax_cart('update', 0, quantity, cart_key);
        if(quantity == 0) $(this).parents(".cart_item").empty();
    })

    $('.price_block .close').on('click', function(){
        var cart_key = $(this).attr('data-key');
        ajax_cart('update', 0, 0, cart_key);
        $(this).parents(".cart_item").empty();
    })

    $('.wrap_services .col-md-3').on('click', function(){
        $(this).find('input[type=radio]').attr('checked', 'checked');
        $(this).siblings().removeClass('checked');
        $(this).addClass('checked');

        var id = $(this).attr('data-id');
        var del = $(this).parents('.service_extra').attr('data-delete');

        console.log(id, del);
        $(this).parents('.service_extra').attr('data-delete', id);
        if(del == 0) {
            ajax_cart('add', id, 1, 0);
        }else{
            ajax_cart('update', del, 0);
            ajax_cart('add', id, 1, 0);
        }
    })


    $('.add_order').on('click', function(){
        $('#terms').attr('checked', 'checked');
        $('#place_order').click();
    })


    $('.add_to_cart_button').on('click', function(){
        var product_id = $(this).attr('data-product_id');
        ajax_cart('add', product_id, 1, 0);
    })


    function ajax_cart(action, product_id, quantity, cart_key){
        var url = location.origin + '/ajax/cart.php';
        $.ajax({
            'type': 'post',
            'url': url,
            'data': {
                'act': action,
                'product_id': product_id,
                'cart_key': cart_key,
                'quantity': quantity
            },
            success: function(res) {
                if(action == 'update'){
                    $('.cart_total').empty();
                    $('.cart_total').append(res);
                }
            }
        }).fail(function (xhr, ajaxOptions, thrownError) {
            if(xhr.status == 404){
                if(action == 'update') {
                    $('.cart_total').empty();
                    $('.cart_total').append(xhr.responseText);
                }
            }
        });

    }

    var item_count = $('.item_count').text();
    var item_text = declOfNum(item_count, ['товар', 'товара', 'товаров']);
    $('.item_measure').empty();
    $('.item_measure').text(item_text);

    var extra_count = $('.exitem_count').text();
    var extra_text = declOfNum(extra_count, ['услуга', 'услуги', 'услуг']);
    $('.exitem_measure').empty();
    $('.exitem_measure').text(extra_text);


    $('#billing_first_name').attr('placeholder', 'Введите ваше имя');
    $('#billing_email').attr('placeholder', 'Введите вашу почту');
    $('#billing_phone').attr('placeholder', 'Введите номер телефона');

    $('.cart_btn').on('click', function () {
        location.href = '/cart/';
    })

    $(".single_prod .images")
        .mouseover(function() {
           $('.single_prod .zoom_img').attr('src', '/wp-content/themes/NativeChurch/images/zoom_h.png');
       })
        .mouseout(function() {
           $('.single_prod .zoom_img').attr('src', '/wp-content/themes/NativeChurch/images/zoom.png');
        });

})

// Плавающий блок
jQuery(window).scroll(function() {
    console.log('scroll');
    var sb_m = 80; /* отступ сверху и снизу */
    var mb = 500; /* высота подвала с запасом */
    var st = jQuery(window).scrollTop();
    var sb = jQuery(".sticky-block");
    var sb_ot = sb.offset().top;
    var sb_h = sb.height();

    if(sb_h + jQuery(document).scrollTop() + sb_m + mb < jQuery(document).height()) {
        if(st > sb_ot) {
            var h = Math.round(st - sb_ot) + sb_m;
            sb.css({"paddingTop" : h});
        }
        else {
            sb.css({"paddingTop" : 0});
        }
    }
});

//    declOfNum(count, ['найдена', 'найдено', 'найдены']);
function declOfNum(number, titles) {
    cases = [2, 0, 1, 1, 1, 2];
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
}

