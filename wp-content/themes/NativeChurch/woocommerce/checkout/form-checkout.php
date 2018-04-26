<?php
/**
 * Checkout Form
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $woocommerce;
wc_print_notices();

$cart_items = WC()->cart->get_cart();
$items = array();

$items_count = $extra_count = 0;
foreach ($cart_items  as $cart_item_key => $cart_item ){
    $category = get_the_terms( $cart_item['product_id'], 'product_cat' );
    if($category[0]->parent > 0) $cat_id = $category[0]->parent;
    else $cat_id = $category[0]->term_id;

    if($cat_id == 839) {
        $extra_items[$cart_item_key] = $cart_item;
        $extra_id[] = $cart_item['product_id'];
        $extra_count += $cart_item['quantity'];
    }else{
        $items[$cart_item_key] = $cart_item;
        $items_count += $cart_item['quantity'];
    }
}

$delivery = get_posts("post_type=product&numberposts=1000&product_cat=delivery&orderby=ID&order=ASC");
$total = $woocommerce->cart->get_cart_total();
$total_wdel = price_format($total);
$price_notformat = price_notformat($total);

//echo "<pre>".print_r($extra_items, 1)."</pre>";
?>


<div class="cart_steps">
    <img src="/wp-content/themes/NativeChurch/images/cart_2.png" alt="">
    <p>
        <span>Ваша корзина</span>
        <span class="detail active">Детали получения</span>
        <span class="finish">Завершение покупки</span>
    </p>
</div>

<div class="wrap_services">
    <div class="col-md-9 service_extra">
        <p><strong>1. Где и как вы хотите получить заказ?</strong></p>

        <div class="col-md-4 delivery">
            <div class="col-md-1"><input type="radio" name="del"/></div>
            <div class="col-md-10">
                <label>Оформить доставку</label>
                <p class="price">от 800 &#8381;</p>
            </div>
        </div>

        <div class="col-md-4 checked">
            <div class="col-md-1"><input type="radio" name="del" checked/></div>
            <div class="col-md-10">
                <label>Самовывоз Некрасова, 22, офис 219</label>
                <p class="price">Бесплатно</p></div>
        </div>

        <div class="col-md-9 delivery_select">
            <select id="delivery_city">
                <option value="0" data-price="0">Выберите место доставки</option>
                <?foreach($delivery as $k => $del):
                    $tax = get_post_custom( $del->ID );?>
                    <option value="<?=$del->ID?>" data-price="<?=number_format($tax['_price'][0], 0, '', '')?>" data-price-format="<?=number_format($tax['_price'][0], 0, '', ' ')?>"><?=$del->post_title?>, <?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</option>
                <?endforeach?>
            </select>
        </div>

    </div>
    
    <div class="col-md-3 sticky-cart">
        <div class="col-md-12">
            
            <div class="items_block">
                <p class="items">
                    <span class="items_count"><?=$items_count?></span>
                    <span class="items_measure"></span>:
                </p>
                <?foreach($items as $item):?>
                    <div class="item">
                        <p><?=$item['data']->post->post_title?></p>
                        <p><?=$item['quantity']?>шт, <?=number_format($item['line_total'], 0, '', ' ')?> &#8381;</p>
                    </div>
                <?endforeach?>
            </div>

            <div class="separateCheckout"></div>

            <div class="service_block">
                <p class="services">
                    <span class="service_count"><?=$extra_count?></span>
                    <span class="service_measure"></span>:
                </p>
                <?foreach($extra_items as $item):?>
                    <div class="item">
                        <p><?=$item['data']->post->post_title?></p>
                        <p><?=$item['quantity']?>шт, <?=number_format($item['line_total'], 0, '', ' ')?> &#8381;</p>
                    </div>
                <?endforeach?>
            </div>
           
        </div>
    </div>

    <div class="col-md-9 service_extra user_form">
        <p><strong>2. Контактные данные</strong></p>
        <form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>">
            <?php do_action( 'woocommerce_checkout_billing' ); ?>
            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
        </form>
    </div>

    <div class="col-md-9 service_extra end_order">
        <p><strong>Итого :</strong></p>
        <div class="row_total">
            <span class="col-md-2">Товаров и услуг </span><span class="total_wdel col-md-2 raw_val" data-price="<?=$price_notformat?>"><?=$total_wdel?></span><p class="col-md-6"></p>
        </div>
        <div class="row_total">
            <span class="col-md-2">Доставка</span><span class="col-md-2 raw_val"><span class="del_price">0</span> &#8381;</span><p class="col-md-6"></p>
        </div>
        <p class="col-md-12"><strong>к оплате <span class="total_price"> <?=$total_wdel?></span></strong></p>
        <a class="btn add_order">Оформить заказ</a><br>
        <p class="disclaimer">
            Завершая оформление заказа, я даю свое согласие на обработку персональных данных и подтверждаю ознокомление со сроками хранения товара в соответствии с указанными
            <a href="http://<?=$_SERVER['HTTP_HOST']?>/cond.pdf" target="_blank">здесь условиями.</a>
        </p>
        
    </div>
</div>



