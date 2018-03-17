<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * Override this template by copying it to yourtheme/woocommerce/content-single-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
?>
<?php
	/**
	 * woocommerce_before_single_product hook
	 *
	 * @hooked wc_print_notices - 10
	 */
	 do_action( 'woocommerce_before_single_product' );
	 if ( post_password_required() ) {
	 	echo get_the_password_form();
	 	return;
	 }
?>
<div itemscope itemtype="<?php echo woocommerce_get_product_schema(); ?>" id="product-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php
		/**
		 * woocommerce_before_single_product_summary hook
		 *
		 * @hooked woocommerce_show_product_sale_flash - 10
		 * @hooked woocommerce_show_product_images - 20
		 */
		do_action( 'woocommerce_before_single_product_summary' );
	?>
	<div class="summary entry-summary">
		<?php
			/**
			 * woocommerce_single_product_summary hook
			 *
			 * @hooked woocommerce_template_single_title - 5
			 * @hooked woocommerce_template_single_rating - 10
			 * @hooked woocommerce_template_single_price - 10
			 * @hooked woocommerce_template_single_excerpt - 20
			 * @hooked woocommerce_template_single_add_to_cart - 30
			 * @hooked woocommerce_template_single_meta - 40
			 * @hooked woocommerce_template_single_sharing - 50
			 */
			do_action( 'woocommerce_single_product_summary' );
		?>
	</div><!-- .summary -->
	<?php
		/**
		 * woocommerce_after_single_product_summary hook
		 *
		 *
		 * @hooked woocommerce_output_related_products - 20
		 */
		do_action( 'woocommerce_after_single_product_summary' );
	?>
	<meta itemprop="url" content="<?php the_permalink(); ?>" />

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
</div><!-- #product-<?php the_ID(); ?> -->
<?php do_action( 'woocommerce_after_single_product' ); ?>
