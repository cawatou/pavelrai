<?php
/**
 * Additional Information tab
 * 
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	// Exit if accessed directly
	exit;
}
global $product, $wpdb;
//print_r($product);
$price = $product->get_price();
$posts = $wpdb->get_row("SELECT value FROM dollar_course WHERE id = '1' LIMIT 0,1");
$cource = $posts->value;
$price_value = $price*$cource;

$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "_virtual" AND post_id = '.$product->id.' LIMIT 0,1';
$res = $wpdb->get_row($query);
$hide = $res->meta_value;
//echo $hide,$value;
$heading = apply_filters( 'woocommerce_product_additional_information_heading', __( 'Additional Information', 'woocommerce' ) );
$cat = get_the_terms( $post->ID, 'product_cat' );?>

<?php $product->list_attributes();?>

