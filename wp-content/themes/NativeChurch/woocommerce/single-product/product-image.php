<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("a.gallery").fancybox({
			"padding": 20,
			"imageScale" : true,
			"frameWidth": 400,
			"frameHeight": 300,
			"overlayShow": true,
			"overlayOpacity": 0.3,
			"hideOnContentClick": true,
			"hideOnOverlayClick": true,
			"centerOnScroll": false,
			"showNavArrows": true
		});
	});
</script>
<?php
/**
 * Single Product Image
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.14
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $post, $woocommerce, $product;
?>
<div class="images">
	<?php
		if ( has_post_thumbnail() ) {
			$image_title = esc_attr( get_the_title( get_post_thumbnail_id() ) );
			$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
			$image       = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
				'title' => $image_title
				) );
			$attachment_count = count( $product->get_gallery_attachment_ids() );
			if ( $attachment_count > 0 ) {
				$gallery = '[product-gallery]';
			} else {
				$gallery = '';
			}
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="woocommerce-main-image zoom" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $image_link, $image_title, $image ), $post->ID );
		} else {
			echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="Placeholder" />', wc_placeholder_img_src() ), $post->ID );
		}
	?>
	<?php do_action( 'woocommerce_product_thumbnails' ); 
	$cat = get_the_terms( $post->ID, 'product_cat' );	
	$key = key($cat);
	$parent_category = $cat[$key]->parent;
	if($parent_category!==337 && $parent_category!==253 && $parent_category!==495 && $parent_category!==498 && $parent_category!==501 && $parent_category!==504 && $parent_category!==505 && $parent_category!==506) :
	?>

	<div class="wrap_install">
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
<?php endif;?>
</div>
