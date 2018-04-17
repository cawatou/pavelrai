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
$attributes_tax = $product->get_attributes();
ob_start();

global $product, $wpdb;
//print_r($product);
$price = $product->get_price();
$posts = $wpdb->get_row("SELECT value FROM dollar_course WHERE id = '1' LIMIT 0,1");
$cource = $posts->value;
$price_value = $price*$cource;
$attr_count = 0;
foreach ($attributes_tax as $tax => $data){
    $values = wc_get_product_terms( $product->id, $data['name'], array( 'fields' => 'names' ) );
    //echo "<pre>".print_r($values, 1)."</pre>";
    if($values[0] != '') $attr_count++;
}
//echo "<pre>".print_r($attr_count, 1)."</pre>";
?>
<div class="shop_attributes col-md-7">
    <?if($attr_count > 0):?><p><strong>Характеристики</strong></p><?endif?>
    <?php foreach ( $attributes_tax as $tax =>$attribute ) :
        if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
            continue;
        } else {
            $has_row = true;
        }

        $values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
        $obj_attr = get_the_terms( $product->id, $tax );
        if($obj_attr):?>
            <div class="prop_value">

                    <p class="prop_name">
                        <strong><?php echo wc_attribute_label( $attribute['name'] ); ?>: </strong>
                    </p>

                    <?echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );?>

            </div>
        <?endif;?>
    <?php endforeach; ?>
</div>

<div class="col-md-5 sticky-block">
    <div class="order_card">
        <p class="price"><?=number_format($price_value, 0, '', ' ');?> &#8381;</p>
        <span>Нашли дешевле? <span id="bestprice">Снизим цену</span></span>
        <div class="ico_items">
            <a href="/delivery/" class="ico_1">Доставка</a>
            <a href="/contact/" class="ico_2">Самовывоз</a>
            <a href="/garantii/" class="ico_3">Гарантия</a>
        </div>
        <a data-product_id="<?=$product->id?>" class="button add_to_cart_button">Купить</a>
    </div>
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