<?php
/**
 * Loop Price
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product, $wpdb;
$price = $product->get_price();
$posts = $wpdb->get_row("SELECT value FROM dollar_course WHERE id = '1' LIMIT 0,1");
$cource = $posts->value;
$value = $price*$cource;

$query = 'SELECT meta_value FROM wp_postmeta WHERE meta_key = "_virtual" AND post_id = '.$product->id.' LIMIT 0,1';
$res = $wpdb->get_row($query);
$hide = $res->meta_value;
$cat = get_the_terms( $post->ID, 'product_cat' );?>
<?php if($price && $hide == "no" && key($cat) != 743):?>
	<span class="price"><?=number_format($value, 0, '', ' ');?> руб.</span>
<?php endif; ?>