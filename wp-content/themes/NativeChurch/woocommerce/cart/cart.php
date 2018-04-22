<?php
/**
 * Cart Page
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $woocommerce;
wc_print_notices();
do_action( 'woocommerce_before_cart' );

$cart_items = WC()->cart->get_cart();
$items = array();
foreach ($cart_items  as $cart_item_key => $cart_item ){
    $category = get_the_terms( $cart_item['product_id'], 'product_cat' );
    if($category[0]->parent > 0) $cat_id = $category[0]->parent;
    else $cat_id = $category[0]->term_id;

    $memorials = [50, 57, 332, 59, 39];
    if(in_array($cat_id, $memorials)) {
        foreach($category as $key => $cat){
            if($cat->term_id == 39) continue;
            else{
                $cart_item['category'] = $cat->term_id;
                $cart_item['extra'] = 1;
                break;
            }
        }
    }

    if($cat_id == 839) $extra_items[$cart_item_key] = $cart_item;
    else $items[$cart_item_key] = $cart_item;

    //echo "<pre>".print_r($category, 1)."</pre>";
}

$pictures = get_posts("post_type=product&numberposts=100&product_cat=picture&orderby='ID'&order='ASC'");

echo "<pre>".print_r($_SESSION, 1)."</pre>";

?>
<div class="cart_steps">
    <img src="/wp-content/themes/NativeChurch/images/cart_1.png" alt="">
    <p>
        <span class="active">Ваша корзина</span>
        <span class="detail">Детали получения</span>
        <span class="finish">Завершение покупки</span>
    </p>
</div>

<div class="col-md-9 cart_left">
<?php do_action( 'woocommerce_before_cart_table' ); ?>
<?foreach ($items as $cart_item_key => $cart_item ):
$_product     = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
$product_id   = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) :?>
    <?//echo "<pre>".print_r($cart_items, 1)."</pre>";?>
    <div class="cart_item col-md-12">
        <div class="img col-md-3">
            <?=apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );?>
        </div>

        <div class="attr col-md-5">
            <p class="item_name"><?=apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );?></p>
            <?if($cart_item['extra']):?>
                <p class="extra">К данному товару рекомендуем</p>
                <p class="add_extra" data-id = "<?=$cart_item['product_id']?>" data-cat-id = "<?=$cart_item['category']?>"><span>добавить дополнительные услуги</span> <span class="plus"> + </span></p>
            <?endif?>
        </div>

        <div class="price_block col-md-4">
            <a class="close" data-key="<?=$cart_item_key?>">x</a>
            <?$price = $cart_item['line_total'] / $cart_item['quantity'];?>
            <span class="amount"><?=number_format($price, 0, '', ' ')?> &#8381;</span>
            <div class="quantity_block">
                <button type="button" class="quantity_block-<?=$cart_item['product_id']?>" data-dir="left">–</button>
                <input type="text" class="item_quantity quantity_block-<?=$cart_item['product_id']?>" data-key="<?=$cart_item_key?>" value="<?=$cart_item['quantity']?>" />
                <button type="button" class="quantity_block-<?=$cart_item['product_id']?>" data-dir="right">+</button>
            </div>
        </div>
    </div>
<?endif?>
<?endforeach?>


<?//================ EXTRA ITEMS ==============?>
<?if(count($extra_items) > 0):?>
    <div class="col-md-12 cart_item cart_extraitem">
        <div class="col-md-8">
            <p><strong>Дополнительные услуги :</strong></p>
            <?$extra_total = 0;
            foreach($extra_items as $cart_item_key => $extra_item):
                $_product     = apply_filters( 'woocommerce_cart_item_product', $extra_item['data'], $extra_item, $cart_item_key );
                $extra_total += intval($extra_item['line_total']);?>
                <div class="img col-md-7">
                    <span class="green_sqr">&nbsp;</span><?=apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $extra_item, $cart_item_key );?>
                </div>
                <div class="col-md-2">
                    <p><?=$extra_item['quantity']?> шт.</p>
                </div>
                <div class="col-md-3">
                    <p><?=apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $extra_item, $cart_item_key );?></p>
                </div>
            <?endforeach?>
            <div class="img col-md-7">
                <p class="add_extra"><span>Изменить доп. услуги</span></p>
            </div>
        </div>
        <div class="col-md-4 total_ex">
            <p class="amount"> + <?=$extra_total?> руб.</p>
        </div>
    </div>
<?endif?>
</div>


<div class="col-md-3 cart_total_block">
    <p class="cart_total">
        <?$price = WC()->cart->get_total();
        $price = price_format($price);
        ?>
        <span class="amount"><?=$price?></span>
    </p>

    <div class="cart_count">
        <span class="item_count"><?=count($items)?></span> <span class="item_measure">товара</span>
    </div>

    <div class="cart_excount">
        <span class="exitem_count"><?=count($extra_items)?></span> <span class="exitem_measure">услуг</span>
    </div>
    <a href="/checkout" class="btn">Оформить заказ</a>
</div>
