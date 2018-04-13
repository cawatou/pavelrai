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
?>
<div class="images">
    <a href="<?=$image_link?>" class="zoom" data-rel="prettyPhoto[product-gallery]">
        <img src="<?=$image_link?>" class="main_img" alt="">
    </a>
    <?
    $dir = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/product-gallery/'.$post->post_title;
    $files = scandir($dir);
    if(count($files)>0):?>
    <div class="owl-carousel product-carousel">
        <?foreach($files as $img):
            $check = explode('.', $img);
            if(count($check) == 2 && $check[1] != 'db' && $check[1] != ''):?>
                <a href="/wp-content/uploads/product-gallery/<?=$post->post_title?>/<?=$img?>" class="zoom" data-rel="prettyPhoto[product-gallery]">
                    <img src="/wp-content/uploads/product-gallery/<?=$post->post_title?>/<?=$img?>" alt="">
                </a>
            <?endif?>
        <?endforeach?>
    </div>
    <?endif?>
</div>
	<?php do_action( 'woocommerce_product_thumbnails' );?>
</div>
