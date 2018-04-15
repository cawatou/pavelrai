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

$tabs = apply_filters( 'woocommerce_product_tabs', array() );
if ( ! empty( $tabs ) ) : ?>
	<div class="woocommerce-tabs">
		<ul class="tabs">
			<?php foreach ( $tabs as $key => $tab ) : ?>
				<li class="<?php echo $key ?>_tab">
					<a href="#tab-<?php echo $key ?>"><?php echo apply_filters( 'woocommerce_product_' . $key . '_tab_title', $tab['title'], $key ) ?></a>
				</li>
                <?break?>
			<?php endforeach; ?>
		</ul>
		<?php foreach ( $tabs as $key => $tab ) : ?>
			<div class="panel entry-content" id="tab-<?php echo $key ?>">
				<?php call_user_func( $tab['callback'], $key, $tab ) ?>
			</div>
            <?break?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>



<?$memorials = array(50, 57, 743, 332, 59, 39);
if(in_array($cat_id, $memorials)):?>
    <div class="col-md-12">
        <div class="wrap_install col-md-4">
            <?if(key($cat) != 743):?>
                <ul>
                    <li><a href="?page_id=813" target="_blank"><p>Установка памятника в металлическую рамку - 3 600 руб.</p><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/type1.jpg" alt=""></a></li>
                    <li><a href="?page_id=813" target="_blank"><p>Установка памятника на плиту «Миниракушка»- 3 600 руб.</p><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/type3.jpg" alt=""></a></li>
                    <li><a href="?page_id=825" target="_blank"><p>Установка памятника на плиту "Подиум" - 4 900 руб.</p><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/type2.jpg" alt=""></a></li>
                    <li><a href="?page_id=829" target="_blank"><p>Установка памятника на плиту "Ракушка" - 10 800 руб.</p><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/type5.jpg" alt=""></a></li>
                    <li><a href="?page_id=838" target="_blank"><p>Установка памятника на фундамент "Стандарт" - 18 565 руб.</p><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/type4.jpg" alt=""></a></li>
                    <li><a href="/type_install/" target="_blank"><p>Установка памятника на плиту «Греция» - 5 500 руб.</p><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/type6.jpg" alt=""></a></li>
                </ul>
            <?else:
                $random = array('1', '2', '3', '4', '5', '6', '7', '8', '9');
                shuffle($random);
                //echo "<pre>".print_r($random, 1);?>
                <ul>
                    <li style="width: 220px !important; height: 375px; float: left;"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[0]?>.jpg"><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[0]?>.jpg" /></a></li>
                    <li style="width: 220px !important; height: 375px; float: left;"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[1]?>.jpg"><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[1]?>.jpg" /></a></li>
                    <li style="height: 250px; float: left; overflow: hidden; margin-bottom: 20px;"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[2]?>.jpg"><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[2]?>.jpg" /></a></li>
                    <li style="width: 220px !important; height: 375px; float: left;"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[3]?>.jpg"><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[3]?>.jpg" /></a></li>
                    <li style="width: 220px !important; height: 375px; float: left;"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[4]?>.jpg"><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[4]?>.jpg" /></a></li>
                    <li style="height: 250px; float: left; overflow: hidden; margin-bottom: 20px;"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[5]?>.jpg"><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[5]?>.jpg" /></a></li>
                    <li style="width: 220px !important; height: 375px; float: left;"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[6]?>.jpg"><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[6]?>.jpg" /></a></li>
                    <li style="width: 220px !important; height: 375px; float: left;"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[7]?>.jpg"><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[7]?>.jpg" /></a></li>
                    <li><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[8]?>.jpg"><img src="http://pavelrai.ru/wp-content/themes/NativeChurch/images/c<?=$random[8]?>.jpg" /></a></li>
                </ul>
            <?endif?>
        </div>
        <div class="col-md-4">
            <h2>Установка памятника</h2>
            <table class='shop_attributes'>
                <tbody>
                <tr>
                    <th>Установка памятника в металлическую рамку</th>
                    <td><p>3 600 руб.</p></td>
                </tr>
                <tr>
                    <th>Установка памятника на плиту «Миниракушка»</th>
                    <td><p>3 600 руб.</p></td>
                </tr>
                <tr class='alt'>
                    <th>Установка памятника на плиту "Подиум"</th>
                    <td><p>4 900 руб.</p></td>
                </tr>
                <tr>
                    <th>Установка памятника на плиту "Ракушка"</th>
                    <td><p>10 800 руб.</p></td>
                </tr>
                <tr class='alt'>
                    <th>Установка памятника на фундамент 'Стандарт'</th>
                    <td><p>18 565 руб.</p></td>
                </tr>
                <tr class='alt'>
                    <th>Установка памятника на плиту «Греция»</th>
                    <td><p>5 500 руб.</p></td>
                </tr>
                </tbody>
            </table>


            <h2>Доставка памятника</h2>
            <table class='shop_attributes'>
                <tbody>
                <tr>
                    <th>Доставка по Уссурийску</th>
                    <td><p>800 руб.</p></td>
                </tr>
                <tr class='alt'>
                    <th>Доставка Борисовка, Михайловка, Воздвиженка, Новоникольск</th>
                    <td><p>800 руб.</p></td>
                </tr>
                <tr>
                    <th>Доставка Владивосток</th>
                    <td><p>4 500 руб.</p></td>
                </tr>
                <tr class='alt'>
                    <th>Доставка Славянка</th>
                    <td><p>6 750 руб.</p></td>
                </tr>
                <tr>
                    <th>Доставка Сибирцево</th>
                    <td><p>3 150 руб.</p></td>
                </tr>
                <tr class='alt'>
                    <th>Доставка Покровка, Алексеевка, Раздольное, Галенки</th>
                    <td><p>1 800 руб.</p></td>
                </tr>
                <tr>
                    <td colspan='2' style='padding: 8px'>
                        <p>Доставка в любой населенный пункт - 1 руб. - 1 километр в одну сторону. Пример расчета : Уссурийск - Владивосток 100км ( 45р * 100км = 4500 руб.)</p>
                    </td>
                </tr>
                <tr class='alt'>
                    <th>Доставка по России</th>
                    <td><p>от 3 000 руб.</p></td>
                </tr>
                <tr>
                    <th>Хранение на складе</th>
                    <td><p>Бесплатно</p></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
<?endif?>
