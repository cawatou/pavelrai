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
    if($cat_id == 839) {
        $extra_items[$cart_item_key] = $cart_item;
        $extra_count += $cart_item['qty'];
    }else{
        $items[$cart_item_key] = $cart_item;
        $items_count += $cart_item['qty'];
    }
}


//echo "<pre>".print_r($extra_items, 1)."</pre>";


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
            <p><strong>Номер заказа <?=$order->get_order_number(); ?></strong></p>
            <p>Ваш заказ оформлен!</p>
            <p>Письмо с подтверждением заказа отправлено</p>

            <div class="col-md-3">
                <p>Заказ <?=$order->get_order_number(); ?></p>

                <p><?=$items_count?> товара:</p>
                <?foreach($items as $item):?>
                    <p><?=$item['name']?></p>
                    <p><?=$item['qty']?>шт, <?=$item['line_total']?></p>
                <?endforeach;?>

                <p><?=$extra_count?> услуг:</p>
                <?foreach($extra_items as $exitem):?>
                    <p><?=$exitem['name']?></p>
                    <p><?=$exitem['qty']?>шт, <?=$exitem['line_total']?></p>
                <?endforeach;?>

                <p>Товаров и услуг <?=$order->get_formatted_order_total(); ?></p>
                <p><strong>Итого: <?=$order->get_formatted_order_total(); ?></strong></p>
                <a href="/" class="btn">Вернутся на главную</a>
            </div>
        </div>
    </div>
<?php endif; ?>