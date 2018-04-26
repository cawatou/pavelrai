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

        if (content_height > menu_height || content_height >= 1187) {

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


    /*=============================== cart ====================================*/

    // Изменение количества товара в корзине
    $('.price_block button').on('click', function(){
        var class_name = this.className;
        var direction = $(this).attr('data-dir');
        var quantity = $('input.' + class_name).val();
        var cart_key = $('input.' + class_name).attr('data-key');
        console.log(class_name, direction, quantity, cart_key);

        if(direction == 'left' && quantity > 0) quantity--;
        if(direction == 'right') quantity++;
        $('input.' + class_name).val(quantity);


        if(quantity == 0) {
            $(this).parents(".cart_item").next().remove();
            $(this).parents(".cart_item").remove();
            var product_id = $(this).attr('data-id');
            ajax_cart('delete', product_id, 0, cart_key);
        }else{
            ajax_cart('update', 0, quantity, cart_key);
        }
        calculateQuantity();
    })

    // Удалить товар из корзины
    $('.price_block .close').on('click', function(){
        var cart_key = $(this).attr('data-key');
        var product_id = $(this).attr('data-id');
        ajax_cart('delete', product_id, 0, cart_key);
        if($(this).parents(".cart_item").attr('data-have-extra') == '1'){
            $(this).parents(".cart_item").next().remove();
        }
        $(this).parents(".cart_item").remove();
        calculateQuantity();
    })

    // Переход на 3 шаг корзины
    $('.add_order').on('click', function(){
        var url = location.origin + '/ajax/cart.php';
        var product_id = $('#delivery_city option:selected').val();
        $.ajax({
            'type': 'post',
            'url': url,
            'data': {
                'act': 'add',
                'product_id': product_id,
                'quantity': 1
            },
            success: function() {
                $('#terms').attr('checked', 'checked');
                $('#place_order').click();
            }
        })

    })

    // Добавление товара в корзину
    $('.add_to_cart_button').on('click', function(){
        var product_id = $(this).attr('data-product_id');
        ajax_cart('add', product_id, 1, 0);
    })

    $('.fence_btn').on('click', function(){
        var l_fence = Number($('.l_fence').val());
        var w_fence = Number($('.w_fence').val());
        var product_id = $('.fence_calc').attr('data-id');
        var quantity = (l_fence + w_fence) * 2;

        ajax_cart('add', product_id, quantity, 0);
        $('#modal_fence').hide();
    })

    // Подсчет количества (п.м) оградок
    $('.l_fence, .w_fence').keyup(function () {
        var l_fence = Number($('.l_fence').val());
        var w_fence = Number($('.w_fence').val());
        var fence_price = Number($('.fence_price').text());
        var quantity = (l_fence + w_fence) * 2;
        var total_price = fence_price * quantity;
        $('#modal_fence .total_price').text(total_price);
        $('#modal_fence .quantity').text(quantity + ' м.п');
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
                if(action == 'update' || action == 'delete'){
                    $('.cart_total .amount').empty();
                    $('.cart_total .amount').append(res);
                    if($('.cart_item').length < 1) location.reload();
                }
            }
        })
    }


    $('.add_extra').click(function(event){
        event.preventDefault();
        var id = $(this).attr('data-id');
        var cat_id = $(this).attr('data-cat-id');
        $('#overlay').fadeIn(400, // сначала плавно показываем темную подложку
            function(){ // после выполнения предъидущей анимации
                $.ajax({
                    'type': 'post',
                    'url': '/modal_extra',
                    'data': {
                        id: id,
                        cat_id: cat_id
                    },
                    success: function(res) {
                        $("#modal_extra").empty();
                        $("#modal_extra").append(res);
                        $('#modal_extra').css('display', 'block').animate({opacity: 1, top: '50%'}, 200);
                    }
                });
        });
    });

    $(document).on('click', '.wrap_services .col-md-3, .wrap_services .col-md-4', function(){
        $(this).find('input[type=radio]').attr('checked', 'checked');
        $(this).siblings().removeClass('checked');
        $(this).addClass('checked');

        var totalPrice = 0;
        var extra_id = [];
        $('.wrap_services .checked').each(function(){
            var current_price = $(this).attr('data-price');
            if(current_price === undefined) return;

            var id = $(this).attr('data-id');
            totalPrice += Number(current_price);
            extra_id.push(id);
        })
        //console.log(extra_id);

        $('.modal_total').text(number_format(totalPrice, 0, '', ' '));
        $('#extra_id').val(extra_id.join(','));

        // 2 Шаг корзины
        if($(this).hasClass('delivery')){
            $('.delivery_select').show();
        }else{
            $('.delivery_select').hide();
        }
    })

    $(document).on('click', '.accept_extra', function(){
        var product_id = $('#product_id').val();
        var extra_id = $('#extra_id').val();
        var url = location.origin + '/ajax/cart.php';
        $.ajax({
            'type': 'post',
            'url': url,
            'data': {
                act: 'add_extra',
                product_id: product_id,
                extra: extra_id
            },
            success: function(res) {
                location.reload();
            }
        });
        console.log(product_id, extra_id);
    })

    $('#delivery_city').change(function () {
        var price_delivery = $('#delivery_city option:selected').attr('data-price');
        var price_dformat = $('#delivery_city option:selected').attr('data-price-format');
        var total_wdel = $('.total_wdel').attr('data-price');

        var total_price = Number(price_delivery) + Number(total_wdel);
        total_price = number_format(total_price, 0, '', ' ') + " ₽";
        $('.del_price').text(price_dformat);
        $('.total_price').text(total_price);
        console.log(price_delivery, total_wdel, total_price);
    })

    calculateQuantity();
    function calculateQuantity(){
        var item_count = 0;
        $('.item_quantity').each(function(){
            item_count += Number(this.value);
        });

        $('.item_count').text(item_count);
        var item_text = declOfNum(item_count, ['товар', 'товара', 'товаров']);
        $('.item_measure').empty();
        $('.item_measure').text(item_text);

        var extra_count = $('.extra_item').length;
        $('.exitem_count').text(extra_count)
        var extra_text = declOfNum(extra_count, ['услуга', 'услуги', 'услуг']);
        $('.exitem_measure').empty();
        $('.exitem_measure').text(extra_text);
    }

    $('#billing_first_name').attr('placeholder', 'Введите ваше имя');
    $('#billing_email').attr('placeholder', 'Введите вашу почту');
    $('#billing_phone').attr('placeholder', 'Введите номер телефона');

    $('.cart_btn').on('click', function () {
        location.href = '/cart/';
    })

    $(".single_prod .main_img")
        .mouseover(function() {
           $('.single_prod .zoom_img').attr('src', '/wp-content/themes/NativeChurch/images/zoom_h.png');
       })
        .mouseout(function() {
           $('.single_prod .zoom_img').attr('src', '/wp-content/themes/NativeChurch/images/zoom.png');
        });

})

// Плавающий блок в карточке товара
jQuery(window).scroll(function() {
    if (jQuery('.sticky-block').hasClass("col-md-5")){
        console.log('scroll');
        var sb_m = 80;
        /* отступ сверху и снизу */
        var mb = 550;
        /* высота подвала с запасом */
        var st = jQuery(window).scrollTop();
        var sb = jQuery(".sticky-block");
        var sb_ot = sb.offset().top;
        var sb_h = sb.height();

        if (sb_h + jQuery(document).scrollTop() + sb_m + mb < jQuery(document).height()) {
            if (st > sb_ot) {
                var h = Math.round(st - sb_ot) + sb_m;
                sb.css({"paddingTop": h});
            }
            else {
                sb.css({"paddingTop": 0});
            }
        }
    }
});

// Плавающий блок в корзине
jQuery(window).scroll(function() {
    if (jQuery('.sticky-cart').hasClass("col-md-3")){
        var sb_m = 80;
        /* отступ сверху и снизу */
        var mb = 140;
        /* высота подвала с запасом */
        var st = jQuery(window).scrollTop();
        var sb = jQuery(".sticky-cart");
        var sb_ot = sb.offset().top;
        var sb_h = sb.height();

        if (sb_h + jQuery(document).scrollTop() + sb_m + mb < jQuery(document).height()) {
            if (st > sb_ot) {
                var h = Math.round(st - sb_ot) + sb_m;
                sb.css({"paddingTop": h});
            }
            else {
                sb.css({"paddingTop": 0});
            }
        }
    }
});



//    declOfNum(count, ['найдена', 'найдено', 'найдены']);
function declOfNum(number, titles) {
    var cases = [2, 0, 1, 1, 1, 2];
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
};




function number_format( number, decimals, dec_point, thousands_sep ) {
    var i, j, kw, kd, km;

    if( isNaN(decimals = Math.abs(decimals)) ){
        decimals = 2;
    }

    if( dec_point == undefined ){
        dec_point = ",";
    }
    if( thousands_sep == undefined ){
        thousands_sep = ".";
    }

    i = parseInt(number = (+number || 0).toFixed(decimals)) + "";

    if( (j = i.length) > 3 ){
        j = j % 3;
    } else{
        j = 0;
    }

    km = (j ? i.substr(0, j) + thousands_sep : "");
    kw = i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands_sep);
    kd = (decimals ? dec_point + Math.abs(number - i).toFixed(decimals).replace(/-/, 0).slice(2) : "");
    return km + kw + kd;
}

