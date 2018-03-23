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
    $memorials = [50, 57, 743, 332, 59, 39];
    if(in_array($cat_id, $memorials)) $cart_item['extra'] = 1;

    if($cat_id == 839) $extra_items[$cart_item_key] = $cart_item;
    else $items[$cart_item_key] = $cart_item;
}

$pictures = get_posts("post_type=product&numberposts=100&product_cat=picture&orderby='ID'&order='ASC'");
$lables = get_posts("post_type=product&numberposts=100&product_cat=lable");
$rains = get_posts("post_type=product&numberposts=100&product_cat=antirain");

//echo "<pre>".print_r($extra_items, 1)."</pre>";
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
    <div class="cart_item col-md-12">
        <div class="img col-md-3">
            <?=apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key );?>
        </div>

        <div class="attr col-md-5">
            <p class="item_name"><?=apply_filters( 'woocommerce_cart_item_name', $_product->get_title(), $cart_item, $cart_item_key );?></p>
            <?$attributes = $_product->get_attributes();
            foreach($attributes as $attribute):?>
                <p class="prop_name"><strong><?php echo wc_attribute_label( $attribute['name'] ); ?>: </strong></p>
                <?if ( $attribute['is_taxonomy'] ) {
                    $values = wc_get_product_terms( $_product->id, $attribute['name'], array( 'fields' => 'names' ) );
                    echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
                } else {
                    // Convert pipes to commas and display values
                    $values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
                    echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
                }?>
            <?endforeach;?>

            <?if($cart_item['extra']):?>
                <p class="extra"><strong>К данному товару рекомендуем</strong></p>
                <p class="add_extra"><span>добавить дополнительные услуги</span> <span class="plus"> + </span></p>
            <?endif?>
        </div>

        <div class="price_block col-md-4">
            <a class="close" data-key="<?=$cart_item_key?>">x</a>
            <?=apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );?>
            <div class="quantity_block">
                <button type="button" class="quantity_block-<?=$cart_item['product_id']?>" data-dir="left">-</button>
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
    <p class="cart_total"><?=WC()->cart->get_total()?></p>

    <div class="cart_count">
        <span class="item_count"><?=count($items)?></span> <span class="item_measure">товара</span>
    </div>

    <div class="cart_excount">
        <span class="exitem_count"><?=count($extra_items)?></span> <span class="exitem_measure">услуг</span>
    </div>
    <a href="/checkout" class="btn">Оформить заказ</a>
</div>


<div id="modal_extra" class="modal_window">
    <p class="close modal_close">X</p>
    <div class="wrap_services">
        <h3>Дополнительные услуги</h3>
        <div class="col-md-12 service_extra">
            <p><strong>1. Выбрать портрет</strong></p>

            <div class="col-md-3 checked">
                <div class="col-md-1"><input type="radio" name="picture" checked/></div>
                <div class="col-md-10"><label>Без портрета</label></div>
            </div>

            <?foreach($pictures as $k => $picture):
                $tax = get_post_custom( $picture->ID );?>
                <div class="col-md-3">
                    <div class="col-md-1"><input type="radio" name="picture" /></div>
                    <div class="col-md-10">
                        <label><?=$picture->post_title?></label>
                        <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                    </div>
                </div>
            <?endforeach?>
        </div>
        <div class="col-md-12 service_extra">
            <p><strong>2. Выбрать вид ФИО и дат</strong></p>

            <div class="col-md-3 checked">
                <div class="col-md-1"><input type="radio" name="lable" checked/></div>
                <div class="col-md-10"><label>Без ФИО и дат</label></div>
            </div>

            <?foreach($lables as $k => $lable):
                $tax = get_post_custom( $lable->ID );?>
                <div class="col-md-3">
                    <div class="col-md-1"><input type="radio" name="lable" /></div>
                    <div class="col-md-10">
                        <label><?=$lable->post_title?></label>
                        <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                    </div>
                </div>
            <?endforeach?>
        </div>
        <div class="col-md-12 service_extra">
            <p><strong>3. Выбрать покрытие "Антидождь"</strong></p>
            <p>Для быстрого и эффективного избавления от плесени на природных и формованных камнях</p>
            <p>а также для удаления пятен от птичьего помета и иных органических загрязнений</p>

            <div class="col-md-3 checked">
                <div class="col-md-1"><input type="radio" name="rain" checked/></div>
                <div class="col-md-10"><label>Без покрытия</label></div>
            </div>

            <?foreach($rains as $k => $rain):
                $tax = get_post_custom( $rain->ID );?>
                <div class="col-md-3">
                    <div class="col-md-1"><input type="radio" name="rain" /></div>
                    <div class="col-md-10">
                        <label><?=$rain->post_title?></label>
                        <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                    </div>
                </div>
            <?endforeach?>

        </div>
        <div class="col-md-12 service_extra">
            <div class="col-md-6">
                <p><strong>Итого  <span class="modal_total">0</span> &#8381;</strong></p>
            </div>
            <div class="col-md-6">
                <a class="btn modal_close">Продолжить</a>
            </div>
        </div>
    </div>
</div>
