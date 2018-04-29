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
$image_link  = wp_get_attachment_url( get_post_thumbnail_id() );
if(!$image_link) $image_link = '/wp-content/plugins/woocommerce/assets/images/placeholder.png';
$dir = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/product-gallery/'.$post->post_title;
$files = scandir($dir);
if($_REQUEST['dev']){
    echo "<pre>".print_r($files, 1)."</pre>";
}
?>
<div class="images">
    <a href="<?=$image_link?>" class="zoom" data-rel="prettyPhoto[product-gallery]">
        <img src="<?=$image_link?>" class="main_img" alt="">
        <img src="/wp-content/themes/NativeChurch/images/zoom.png" class="zoom_img <?=($files)?'':'no_gallery'?>" alt="">
    </a>
    <?if($files):?>
        <div class="owl-carousel product-carousel">
            <?foreach($files as $img):
                if($img != '.' && $img != '..' && $img != 'Thumbs.db'):?>
                    <a href="/wp-content/uploads/product-gallery/<?=$post->post_title?>/<?=$img?>" class="zoom" data-rel="prettyPhoto[product-gallery]">
                        <img src="/wp-content/uploads/product-gallery/<?=$post->post_title?>/<?=$img?>" alt="">
                    </a>
                <?endif?>
            <?endforeach?>
        </div>
        <img class='left_arr' src="/wp-content/themes/NativeChurch/images/left_arr.png" />
        <img class='right_arr' src="/wp-content/themes/NativeChurch/images/right_arr.png" />
    <?endif?>
</div>
	<?php do_action( 'woocommerce_product_thumbnails' );?>
</div>
