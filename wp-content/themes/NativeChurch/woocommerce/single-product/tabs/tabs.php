<?php
/**
 * Single Product tabs
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * Filter tabs and allow third parties to add their own
 *
 * Each tab is an array containing title, callback and priority.
 * @see woocommerce_default_product_tabs()
 */
global $product, $wpdb;
$category_obj = get_the_terms( $product->id, 'product_cat' );
foreach ($category_obj as $obj){
    if($obj->parent > 0) $cat_id = $obj->parent;
    else $cat_id = $obj->term_id;
}


$attributes_tax = $product->get_attributes();
ob_start();


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
//echo "<pre>".print_r($product, 1)."</pre>";
?>

<div class="woocommerce-tabs">
    <div class="panel entry-content" id="tab-additional_information">
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

            <?if($cat_id == 253):?>
                <p class="fence_calc" data-price="<?=number_format($price_value, 0, '', '');?>" data-title="<?=$product->post->post_title?>" data-id="<?=$product->id?>">
                    Калькулятор стоимости
                </p>
            <?endif?>
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
    </div>
</div>
<?$memorials = array(50, 57, 743, 332, 59, 39, 360, 361);
if(in_array($cat_id, $memorials)):?>
    <div class="col-md-9 extra_service extra_service_fst">
        <h5>Художественные работы на памятник</h5>
        <div class="col-md-5">
            <img src="/wp-content/themes/NativeChurch/images/type3.jpg" />
        </div>
        <div class="col-md-4">
            <p class="title">Вид Услуги</p>
            <p>Портрет на камне</p>
            <p>Фото на металле</p>
            <p>Фото на фарфоре</p>
            <p>ФИО и даты</p>
            <p>Слова эпитафии</p>
            <p>Цветы</p>
            <p>Крест на памятнике</p>
            <p>Сюжеты</p>
        </div>
        <div class="col-md-3">
            <p class="title">Стоимость</p>
            <p>от 2 950 &#8381;</p>
            <p>от 1 250 &#8381;</p>
            <p>от 2 900 &#8381;</p>
            <p>от 950 &#8381;</p>
            <p>от 10 &#8381; за 1 знак</p>
            <p>от 400 &#8381;</p>
            <p>от 200 &#8381;</p>
            <p>от 300 &#8381;</p>
        </div>
    </div>


    <div class="col-md-9 extra_service">
        <h5>Установка памятника</h5>
        <div class="col-md-5">
            <img src="/wp-content/themes/NativeChurch/images/type2.jpg" />
        </div>
        <div class="col-md-4">
            <p class="title">Установка</p>
            <p>в металлическую рамку</p>
            <p>на плиту "Подиум"</p>
            <p>на плиту «Миниракушка»</p>
            <p>на бетонный фундамент «Стандарт»</p>
            <p>на плиту "Ракушка"</p>
            <p>на плиту «Греция»</p>
        </div>
        <div class="col-md-3">
            <p class="title">Стоимость</p>
            <p>3 600 &#8381;</p>
            <p>4 900 &#8381;</p>
            <p>3 600 &#8381;</p>
            <p class="double_row">18 565 &#8381;</p>
            <p>10 800 &#8381;</p>
            <p>5 500 &#8381;</p>
        </div>
    </div>


    <div class="col-md-9 extra_service">
        <h5>Доставка без установки</h5>
        <div class="col-md-5">
            <img src="/wp-content/themes/NativeChurch/images/delivery_wi.png" />
        </div>
        <div class="col-md-4">
            <p class="title">Доставка</p>
            <p>по Уссурийску</p>
            <p>Борисовка, Михайловка, Воздвиженка, Новоникольск</p>
            <p>Владивосток</p>
            <p>Славянка</p>
            <p>Сибирцево</p>
            <p>Покровка, Алексеевка, Раздольное, Галенки</p>
            <p>по России</p>
            <p>Хранение на складе</p>
        </div>
        <div class="col-md-3">
            <p class="title">Стоимость</p>
            <p>800 &#8381;</p>
            <p class="double_row">800 &#8381;</p>
            <p>5 200 &#8381;</p>
            <p>7 280 &#8381;</p>
            <p>4 056 &#8381;</p>
            <p class="double_row">2 800 &#8381;</p>
            <p>от 3 000 &#8381;</p>
            <p>Бесплатно</p>
        </div>
    </div>

    <div class="col-md-9 extra_service extra_service_lst">
        <h5>Дополнительная информация</h5>
        <div class="col-md-5">
            <img src="/wp-content/themes/NativeChurch/images/type1.jpg" />
        </div>
        <div class="col-md-4">
            <p class="title">Вид услуги</p>
            <p>Комплектация памятника цветником</p>
            <p>Комплектация памятника накрывной плитой</p>
            <p>Демонтаж временного памятника</p>
            <p>Демонтаж бетонного памятника</p>
            <p>Покрытие «Антидождь»</p>
        </div>
        <div class="col-md-3">
            <p class="title">Стоимость</p>
            <p class="double_row">Бесплатно</p>
            <p class="double_row">от 2 660 &#8381;</p>
            <p class="double_row">Бесплатно</p>
            <p class="double_row">от 900 &#8381;</p>
            <p>500 &#8381;</p>
        </div>
    </div>

<?else:?>
    <div class="col-md-9 container_content">
        <h2>Описание</h2>
        <?if($product->post->post_content):?>
            <?=$product->post->post_content?>
        <?else:?>
            <p>описание отсутствует</p>
        <?endif?>
    </div>
<?endif?>
<?//ob_end_clean();?>