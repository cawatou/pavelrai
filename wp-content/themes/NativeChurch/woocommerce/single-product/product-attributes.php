<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.3
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$has_row    = false;
$alt        = 1;
$attributes = $product->get_attributes();
ob_start();

global $product, $wpdb;
//print_r($product);
$price = $product->get_price();
$posts = $wpdb->get_row("SELECT value FROM dollar_course WHERE id = '1' LIMIT 0,1");
$cource = $posts->value;
$price_value = $price*$cource;

?>
<div class="shop_attributes col-md-7">
	<?php foreach ( $attributes as $attribute ) :
		if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
			continue;
		} else {
			$has_row = true;
		}?>
        <div class="prop_value">
            <p class="prop_name"><strong><?php echo wc_attribute_label( $attribute['name'] ); ?>: </strong></p>
            <?php
            if ( $attribute['is_taxonomy'] ) {
                $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
                echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
            } else {
                // Convert pipes to commas and display values
                $values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
                echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
            }?>
        </div>
	<?php endforeach; ?>
</div>

<div class="order_card col-md-5">
    <p class="price"><?=number_format($price_value, 0, '', ' ');?> &#8381;</p>
    <span>Нашли дешевле? Снизим цену</span>
    <div class="ico_items">
        <p class="ico_1">Доставка</p>
        <p class="ico_2">Самовывоз</p>
        <p class="ico_3">Гарантия</p>
    </div>
    <a href="<?=$_SERVER['REQUEST_URI']?>?add-to-cart=<?=$product->id?>" rel="nofollow" data-product_id="<?=$product->id?>" data-product_sku="" class="button add_to_cart_button">Купить</a>
</div>
<?php
// Получение id родительской категории товара
$cat = get_the_terms( $post->ID, 'product_cat' );
$key = key($cat);
$parent_category = $cat[$key]->parent;
//print_r($parent_category);
?>


<?php
// Исключаем все Вазы, Ограды, Столы и лавочки
if($parent_category!==337 && $parent_category!==253 && $parent_category!==495 && $parent_category!==498 && $parent_category!==501 && $parent_category!==504 && $parent_category!==505 && $parent_category!==506) :?>




<?endif?>

<?php
if ( $has_row ) {
	echo ob_get_clean();
} else {
	ob_end_clean();
}