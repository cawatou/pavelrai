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
do_action( 'woocommerce_before_checkout_form', $checkout );
// If checkout registration is disabled and not logged in, the user cannot checkout
if ( ! $checkout->enable_signup && ! $checkout->enable_guest_checkout && ! is_user_logged_in() ) {
	echo apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) );
	return;
}
// filter hook for include new pages inside the payment method
$get_checkout_url = apply_filters( 'woocommerce_get_checkout_url', WC()->cart->get_checkout_url() );


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

$delivery = get_posts("post_type=product&numberposts=100&product_cat=delivery&orderby='ID'&order='ASC'");
$installs = get_posts("post_type=product&numberposts=100&product_cat=install");
$uninstalls = get_posts("post_type=product&numberposts=100&product_cat=uninstall");

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

        <div class="col-md-3 checked" data-id="0">
            <div class="col-md-1"><input type="radio" name="del" checked/></div>
            <div class="col-md-10">
                <label>Самовывоз Некрасова, 22, офис 219</label>
                <p class="price">Бесплатно</p></div>
        </div>

        <?foreach($delivery as $k => $del):
            $tax = get_post_custom( $del->ID );?>
            <div class="col-md-3" data-id="<?=$del->ID?>">
                <div class="col-md-1"><input type="radio" name="del" /></div>
                <div class="col-md-10">
                    <label><?=$del->post_title?></label>
                    <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                </div>
            </div>
        <?endforeach?>
    </div>


    <div class="col-md-12 service_extra" data-delete="0">
        <p><strong>2. Установка памятника</strong></p>

        <div class="col-md-3 checked" data-id="0">
            <div class="col-md-1"><input type="radio" name="install" checked/></div>
            <div class="col-md-10"><label>Без установки</label></div>
        </div>

        <?foreach($installs as $k => $install):
            $tax = get_post_custom( $install->ID );?>
            <div class="col-md-3" data-id="<?=$install->ID?>">
                <div class="col-md-1"><input type="radio" name="install" /></div>
                <div class="col-md-10">
                    <label><?=$install->post_title?></label>
                    <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                </div>
            </div>
        <?endforeach?>
    </div>


    <div class="col-md-12 service_extra" data-delete="0">
        <p><strong>3. Нужен ли вам демонтаж памятника?</strong></p>

        <div class="col-md-3 checked" data-id="0">
            <div class="col-md-1"><input type="radio" name="uninstall" checked/></div>
            <div class="col-md-10">
                <label>Демонтаж временного памятника</label>
                <p class="price">Бесплатно</p>
            </div>
        </div>

        <?foreach($uninstalls as $k => $uninstall):
            $tax = get_post_custom( $uninstall->ID );?>
            <div class="col-md-3" data-id="<?=$uninstall->ID?>">
                <div class="col-md-1"><input type="radio" name="uninstall" /></div>
                <div class="col-md-10">
                    <label><?=$uninstall->post_title?></label>
                    <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                </div>
            </div>
        <?endforeach?>
    </div>


    <div class="col-md-12 service_extra user_form">
        <p><strong>4. Контактные данные</strong></p>
        <form name="checkout" method="post" class="checkout" action="<?php echo esc_url( $get_checkout_url ); ?>">
            <?php do_action( 'woocommerce_checkout_billing' ); ?>
            <?php do_action( 'woocommerce_checkout_order_review' ); ?>
        </form>
    </div>

    <div class="col-md-12 service_extra">
        <div class="col-md-6">
            <p><strong>Итого  <span class="modal_total">0</span> &#8381;</strong></p>
            <p><strong>к оплате <span class="modal_total">0</span> &#8381;</strong></p>
            <a class="btn add_order">Оформить заказ</a>
            <p>Завершая оформление заказа, я даю свое согласие на обработку персональных данных и подтверждаю ознокомление со сроками хранения товара в соответствии с указанными здесь условиями.</p>
        </div>
    </div>
</div>



