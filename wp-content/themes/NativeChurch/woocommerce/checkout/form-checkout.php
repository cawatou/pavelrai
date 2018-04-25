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
foreach ($cart_items  as $cart_item_key => $cart_item ){
    $category = get_the_terms( $cart_item['product_id'], 'product_cat' );
    if($category[0]->parent > 0) $cat_id = $category[0]->parent;
    else $cat_id = $category[0]->term_id;

    if($cat_id == 839) {
        $extra_items[$cart_item_key] = $cart_item;
        $extra_id[] = $cart_item['product_id'];
    }else{
        $items[$cart_item_key] = $cart_item;
    }
}

$delivery = get_posts("post_type=product&numberposts=100&product_cat=delivery");
//echo "<pre>".print_r($extra_id, 1)."</pre>";
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
    <div class="col-md-12 service_extra" data-delete="0">
        <p><strong>1. Где и как вы хотите получить заказ?</strong></p>

        <div class="col-md-4 checked" data-id="0">
            <div class="col-md-1"><input type="radio" name="del" checked/></div>
            <div class="col-md-10">
                <label>Самовывоз Некрасова, 22, офис 219</label>
                <p class="price">Бесплатно</p></div>
        </div>

        <div class="col-md-4" data-id="0">
            <div class="col-md-1"><input type="radio" name="del" checked/></div>
            <div class="col-md-10">
                <label>Оформить доставку</label>
                <p class="price">от 800 &#8381;</p>
            </div>
        </div>
        <div class="col-md-12">
            <select id="delivery_city">
                <option value="0">Выберите место доставки</option>
                <?foreach($delivery as $k => $del):
                    $tax = get_post_custom( $del->ID );?>
                    <option value="<?=$del->ID?>"><?=$del->post_title?>, <?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</option>
                <?endforeach?>
            </select>
        </div>

    </div>

    <div class="col-md-12 service_extra user_form">
        <p><strong>2. Контактные данные</strong></p>
        <form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>">
            <?php do_action( 'woocommerce_checkout_billing' ); ?>
            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
        </form>
    </div>

    <div class="col-md-12 service_extra end_order">        
        <p><strong>Итого :</strong></p>
        <p>Товаров и услуг <span class="service_total modal_total">0</span> &#8381;</></p>
        <p><strong>к оплате <span class="service_total modal_total">0</span> &#8381;</strong></p>
        <a class="btn add_order">Оформить заказ</a><br>
        <p class="disclaimer">Завершая оформление заказа, я даю свое согласие на обработку персональных данных и подтверждаю ознокомление со сроками хранения товара в соответствии с указанными здесь условиями.</p>
        
    </div>
</div>



