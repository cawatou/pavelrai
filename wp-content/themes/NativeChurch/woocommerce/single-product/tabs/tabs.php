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
global $product;
$category_obj = get_the_terms( $product->id, 'product_cat' );
foreach ($category_obj as $obj){
    if($obj->parent > 0) $cat_id = $obj->parent;
    else $cat_id = $obj->term_id;
}

//echo "<pre>".print_r($product, 1);

//$tabs = apply_filters( 'woocommerce_product_tabs', array() );
$tab = Array(
    'title' => 'Дополнительная информация',
    'priority' => 20,
    'callback' => 'woocommerce_product_additional_information_tab'
);
?>
<div class="woocommerce-tabs">
    <div class="panel entry-content" id="tab-additional_information">
        <?php call_user_func( $tab['callback'], 'additional_information', $tab ) ?>
    </div>
</div>
<?$memorials = array(50, 57, 743, 332, 59, 39, 360, 361, 830);
if(in_array($cat_id, $memorials)):?>
    <div class="col-md-9 extra_service">
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
            <p>18 565 &#8381;</p>
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
            <p>800 &#8381;</p>
            <p>5 200 &#8381;</p>
            <p>7 280 &#8381;</p>
            <p>4 056 &#8381;</p>
            <p>2 800 &#8381;</p>
            <p>от 3 000 &#8381;</p>
            <p>Бесплатно</p>
        </div>
    </div>

    <div class="col-md-9 extra_service">
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
            <p>Бесплатно</p>
            <p>от 2 660 &#8381;</p>
            <p>Бесплатно</p>
            <p>от 900 &#8381;</p>
            <p>500 &#8381;</p>
        </div>
    </div>

<?else:?>
    <div class="col-md-9 container_content">
        <?if($product->post->post_content) echo $product->post->post_content;
        else echo "<h2>Описание отсутствует</h2>"?>
    </div>
<?endif?>
