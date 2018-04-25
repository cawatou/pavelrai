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
session_start();
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
if(count($extra_items) < 1) session_destroy();

$count_item = $count_extra = 0;
//echo count($extra_items);
if($_REQUEST['dev']){
    echo "<pre>".print_r($cart_items, 1)."</pre>";
}
//echo "<pre>".print_r($_SESSION['extra'], 1)."</pre>";
;?>
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
    <?$count_item += $cart_item['quantity'];
    //echo "<pre>".print_r($cart_item, 1)."</pre>";?>
    <div class="cart_item col-md-12">
        <div class="img col-md-3">
            <?=apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );?>
        </div>

        <div class="attr col-md-5">
            <p class="item_name"><?=apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );?></p>
            <?if($cart_item['extra'] && !array_key_exists ($cart_item['product_id'], $_SESSION['extra'])):?>
                <p class="extra">К данному товару рекомендуем</p>
                <p class="add_extra" data-id = "<?=$cart_item['product_id']?>" data-cat-id = "<?=$cart_item['category']?>"><span>добавить дополнительные услуги</span> <span class="plus"> + </span></p>
            <?endif?>
        </div>

        <div class="price_block col-md-4">
            <a class="close" data-key="<?=$cart_item_key?>" data-id="<?=$cart_item['product_id']?>">x</a>
            <?$price = $cart_item['line_total'] / $cart_item['quantity'];?>
            <span class="amount"><?=number_format($price, 0, '', ' ')?> &#8381;</span>
            <div class="quantity_block">
                <button type="button" class="quantity_block-<?=$cart_item['product_id']?>" data-dir="left" data-id = "<?=$cart_item['product_id']?>">–</button>
                <input type="text" class="item_quantity quantity_block-<?=$cart_item['product_id']?>" data-key="<?=$cart_item_key?>" value="<?=$cart_item['quantity']?>" />
                <button type="button" class="quantity_block-<?=$cart_item['product_id']?>" data-dir="right" data-id = "<?=$cart_item['product_id']?>">+</button>
            </div>
        </div>
    </div>
    <?//================ EXTRA ITEMS ==============?>
    <?if($_SESSION['extra'] && array_key_exists ($cart_item['product_id'], $_SESSION['extra'])):
        $extra_id = explode(',', $_SESSION['extra'][$cart_item['product_id']]);?>
        <div class="col-md-12 cart_extraitem">
            <div class="col-md-8">
                <p class="title">Дополнительные услуги :</p>
                <?$extra_total = 0;
                foreach($extra_items as $cart_item_key => $extra_item):
                    if(in_array($extra_item['product_id'], $extra_id)):
                        $_product     = apply_filters( 'woocommerce_cart_item_product', $extra_item['data'], $extra_item, $cart_item_key );
                        $extra_total += intval($extra_item['line_total']) / $extra_item['quantity'];
                        $count_extra ++;?>
                        <div class="extra_item">
                            <div class="title_list col-md-7">
                                <span class="green_sqr">&nbsp;</span><?=apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $extra_item, $cart_item_key );?>
                            </div>
                            <div class="col-md-2">
                                <p>1 шт.</p>
                            </div>
                            <div class="col-md-3">
                                <p>
                                    <? $price = apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $extra_item, $cart_item_key );?>
                                    <span class="amount"><?=price_format($price);?></span>
                                </p>
                            </div>
                        </div>
                    <?endif?>
                <?endforeach?>
                <div class="img col-md-7">
                    <p class="add_extra" data-id = "<?=$cart_item['product_id']?>" data-cat-id = "<?=$cart_item['category']?>"><span>Изменить доп. услуги</span></p>
                </div>
            </div>
            <div class="col-md-4 total_ex">
                <p class="amount"> + <?=number_format($extra_total, 0, '', ' ')?> &#8381;</p>
            </div>
        </div>
    <?endif?>
<?endif?>
<?endforeach?>

</div>


<div class="col-md-3 cart_total_block">
    <p class="cart_total">
        <?$price = WC()->cart->get_total();
        $price = price_format($price);?>
        <span class="amount"><?=$price?></span>
    </p>

    <div class="cart_count">
        <span class="item_count"></span> <span class="item_measure"></span>
    </div>

    <div class="cart_excount">
        <span class="exitem_count"></span> <span class="exitem_measure"></span>
    </div>
    <a href="/checkout" class="btn">Оформить заказ</a>
</div>
