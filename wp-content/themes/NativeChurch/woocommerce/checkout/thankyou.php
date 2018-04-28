<?php
/**
 * Thankyou page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.2.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $woocommerce;

$order = new WC_Order($order->id);
$order_items = $order->get_items();
$items_count = $extra_count = 0;
foreach ($order_items as $cart_item_key => $cart_item) {
    //echo "<pre>".print_r($cart_item, 1)."</pre>";
    $category = get_the_terms( $cart_item['product_id'], 'product_cat' );
    if($category[0]->parent > 0) $cat_id = $category[0]->parent;
    else $cat_id = $category[0]->term_id;
    //echo "<pre>".print_r($cart_item, 1)."</pre>";
    if($cat_id == 839 && $category[0]->term_id != 843) {
        $extra_items[$cart_item_key] = $cart_item;
        $extra_count += $cart_item['qty'];
    }elseif($category[0]->term_id != 843){
        $items[$cart_item_key] = $cart_item;
        $items_count += $cart_item['qty'];
    }

    if($category[0]->term_id == 843){
        $d_price = $cart_item['line_total'];
    }
}


//echo "<pre>".print_r($extra_items, 1)."</pre>";
$price_notformat = price_notformat($order->get_formatted_order_total());
if($d_price) $without_discount = $price_notformat - $d_price;
else $without_discount = $price_notformat;


if ( $order ) : ?>
    <div class="cart_steps">
        <img src="/wp-content/themes/NativeChurch/images/cart_3.png" alt="">
        <p>
            <span>Ваша корзина</span>
            <span class="detail">Детали получения</span>
            <span class="finish active">Завершение покупки</span>
        </p>
    </div>

    <div class="wrap_services thankyou">
        <div class="col-md-12">
            <p class="order_num">Номер заказа <?=$order->get_order_number(); ?></p>
            <p>Ваш заказ оформлен!</p>
            <p>Письмо с подтверждением заказа отправлено</p>

            <div class="col-md-3">
                <p>Заказ <?=$order->get_order_number(); ?></p>

                <div class="separateCheckout"></div>

                <div class="items_block">
                    <p class="items">
                        <span class="items_count"><?=$items_count?></span>
                        <span class="items_measure"></span>:
                    </p>
                    <?foreach($items as $item):?>
                        <div class="item">
                            <p><?=$item['name']?></p>
                            <p><?=$item['qty']?>шт, <?=number_format($item['line_total'], 0, '', ' ')?> &#8381;</p>
                        </div>
                    <?endforeach?>
                </div>

                <?if($extra_count > 0):?>
                    <div class="service_block">
                        <p class="services">
                            <span class="service_count"><?=$extra_count?></span>
                            <span class="service_measure"></span>:
                        </p>
                        <?foreach($extra_items as $item):?>
                            <div class="item">
                                <p><?=$item['name']?></p>
                                <p><?=$item['qty']?>шт, <?=number_format($item['line_total'], 0, '', ' ')?> &#8381;</p>
                            </div>
                        <?endforeach?>
                    </div>
                <?endif?>
                
                <div class="separateCheckout"></div>

                <div class="row_total">
                    <span class="col-md-2">Товаров и услуг </span><span class="total_wdel col-md-2 raw_val"><?=number_format($without_discount, 0, '', ' ')?> &#8381;</span>
                </div>
                <div class="row_total">
                    <span class="col-md-2">Доставка</span><span class="col-md-2 raw_val"><span class="del_price"><?=($d_price) ? number_format($d_price, 0, '', ' ') : 0 ;?></span> &#8381;</span>
                </div>
                <p class="col-md-12"><strong>Итого: <span class="total_price"> <?=price_format($order->get_formatted_order_total(), 0, '', ' ')?></span></strong></p>

            </div>
            <a class="gohome" href="/" class="btn">Вернутся на главную</a>
        </div>
    </div>
<?php endif; ?>