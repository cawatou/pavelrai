<?php
/**
 * Description tab
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $woocommerce, $post;
$heading = esc_html( apply_filters( 'woocommerce_product_description_heading', __( 'Product Description', 'woocommerce' ) ) );
$cat = get_the_terms( $post->ID, 'product_cat' );
/*if(key($cat) != 743):*/?><!--
    <h2><?php /*echo $heading; */?></h2>
    <?php /*the_content(); */?>
--><?/*endif*/?>
