<?php
/**
 * Empty cart page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
wc_print_notices();
?>
<p class="cart-empty">Ваша корзина пока, что пустая</p>
<?php do_action( 'woocommerce_cart_is_empty' ); ?>
<a class="gocat" href="/shop-category/granit_memorials/" class="btn">Посмотреть каталог</a>
<?if(1 == 0):?>
<p class="return-to-shop"><a class="button wc-backward" href="<?php echo apply_filters( 'woocommerce_return_to_shop_redirect', get_permalink( wc_get_page_id( 'shop' ) ) ); ?>"><?php _e( 'Return To Shop', 'woocommerce' ) ?></a></p>
<?endif?>