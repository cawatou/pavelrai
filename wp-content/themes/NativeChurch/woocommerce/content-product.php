<?php
/**
 * The template for displaying product content within loops.
 *
 * Override this template by copying it to yourtheme/woocommerce/content-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product, $woocommerce_loop;
// Store loop count we're currently on
if ( empty( $woocommerce_loop['loop'] ) )
	$woocommerce_loop['loop'] = 0;
// Store column count for displaying the grid
if ( empty( $woocommerce_loop['columns'] ) )
	$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
// Ensure visibility
if ( ! $product || ! $product->is_visible() )
	return;
// Increase loop count
$woocommerce_loop['loop']++;
// Extra post classes
$classes = array();
if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	$classes[] = 'first';
if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	$classes[] = 'last';
?>
<li <?php post_class( $classes ); ?>>
	<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
	<a href="<?php the_permalink(); ?>">
		<div class="wraper_img">
			<?php
				/**
				 * woocommerce_before_shop_loop_item_title hook
				 *
				 * @hooked woocommerce_show_product_loop_sale_flash - 10
				 * @hooked woocommerce_template_loop_product_thumbnail - 10
				 */
				do_action( 'woocommerce_before_shop_loop_item_title' );
			?>
		</div>
        <p class="detail_view">Посмотреть подробнее</p>
        <div class="wrapper_attr">
            <p class="prod_title"><?php the_title(); ?></p>
            <span class="product_price"><?=number_format($product->get_price(), 0, '', ' ')?> &#8381;</span>
            <p class="cat_product"><?=$product->get_categories()?></p>
            <div id="attr_product">
                <?/* // Вывод Габаритов и цвета под ценой товара
                $attributes = $product->get_attributes();
                foreach ( $attributes as $attribute ) :
                    if (wc_attribute_label($attribute['name'])=="Габариты" || wc_attribute_label($attribute['name'])=="Цвет"){
                        $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
                        $res_string =  apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
                        $res_string = trim($res_string, "<p></p>");
                        if(wc_attribute_label($attribute['name'])=="Цвет") $res_string = $res_string."  ";
                        if(wc_attribute_label($attribute['name'])=="Габариты") $res_string = $res_string;
                        echo $res_string;
                    }
                endforeach;*/?>
            </div>
        </div>

	</a>
	<?php do_action( 'woocommerce_after_shop_loop_item' ); ?>
</li>