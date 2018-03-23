jQuery(document).ready(function($){
    compose_pagination();
    drawSeparateLine();
    
    $(document).find('input[name=pagination_gal]').on('click', function(){
        var current_page = $('#our_works .paging-input_0 .total-pages_0:first-child').text().trim();
        var move_page = this.value;
        
        if(current_page < move_page) {
            move_page = parseInt(move_page) - 1;
            spider_page_0(this, move_page, 1);
        }
        if(current_page > move_page) {
            move_page = parseInt(move_page) + 1;
            spider_page_0(this, move_page, -1);
        }
        
        compose_pagination();
        
        console.log(current_page, move_page);
    })


    function compose_pagination(){
        var el ='';
        var page_count = $('#our_works .paging-input_0 .total-pages_0:last-child').text().trim();
        for(var i=1; i<=page_count; i++){
            if(i == 1) el = '<label class="radio-inline"><input type="radio" name="pagination_gal" value="'+i+'" checked></label>';
            else el = '<label class="radio-inline"><input type="radio" name="pagination_gal" value="'+i+'"></label>';
            $('#bwg_container1_0').append(el);
        }
    }

    function drawSeparateLine() {
        var menu_height = $('.menu-left_menu-container').height();
        var content_height = $('.page_content').height();

        if (content_height > menu_height) {
            $('.page_content').addClass('content_separate');
        }
        else $('.menu-left_menu-container').addClass('menu_separate');
        console.log(menu_height, content_height);
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
        $('#place_order').click();
    })



    function ajax_cart(action, prodict_id, quantity, cart_key){
        $.ajax({
            'type': 'post',
            'url': '../ajax/cart.php',
            'data': {
                'act': action,
                'product_id': prodict_id,
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
})

function declOfNum(number, titles) {
    cases = [2, 0, 1, 1, 1, 2];
    return titles[ (number%100>4 && number%100<20)? 2 : cases[(number%10<5)?number%10:5] ];
}
//    declOfNum(count, ['найдена', 'найдено', 'найдены']);

