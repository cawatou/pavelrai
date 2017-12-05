<?php
/**
 * Displayed when no products are found matching the current query.
 *
 * Override this template by copying it to yourtheme/woocommerce/loop/no-products-found.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$variable_post_id= get_option('woocommerce_shop_page_id');
$pageOptions = imic_page_design($variable_post_id,8); //page design options 
?>
<div class="<?php echo $pageOptions['class']; ?> product-archive">  
<p class="woocommerce-info"><?php _e( 'No products were found matching your selection.', 'woocommerce' ); ?></p>
</div>