<?php
/**
 * Related Products
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
global $product, $woocommerce_loop;
$related = $product->get_related( $posts_per_page );

$cat = get_the_terms( $post->ID, 'product_cat' );
if(key($cat) == 743):?>
	<div class="related products">
		<h2>Похожие гранитные комплексы</h2>
		<ul>
			<li style="width: 250px !important; height: 120px; float: left;"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/uploads/photo-gallery/granit_monuments/IMG_9979.JPG"><img src="http://pavelrai.ru/wp-content/uploads/photo-gallery/granit_monuments/IMG_9979.JPG"  width="180"/></a></li>
			<li style="width: 250px !important; height: 120px; float: left;"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/uploads/photo-gallery/granit_monuments/IMG_9571.JPG"><img src="http://pavelrai.ru/wp-content/uploads/photo-gallery/granit_monuments/IMG_9571.JPG"  width="180"/></a></li>
			<li style="width: 250px !important; height: 120px; float: left;"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/uploads/photo-gallery/granit_monuments/IMG_9470.JPG"><img src="http://pavelrai.ru/wp-content/uploads/photo-gallery/granit_monuments/IMG_9470.JPG"  width="180"/></a></li>
		</ul>
		<ul>
			<li style="width: 250px !important; height: 150px; float: left; overflow: hidden"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/uploads/photo-gallery/individual/сложные (114).JPG"><img src="http://pavelrai.ru/wp-content/uploads/photo-gallery/individual/thumb/сложные (114).JPG" width="180" /></a></li>
			<li style="width: 250px !important; height: 150px; float: left; overflow: hidden"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/uploads/photo-gallery/individual/сложные (113).JPG"><img src="http://pavelrai.ru/wp-content/uploads/photo-gallery/individual/thumb/сложные (113).JPG"  width="180" /></a></li>
			<li style="width: 250px !important; height: 150px; float: left; overflow: hidden"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/uploads/photo-gallery/individual/сложные (112).jpg"><img src="http://pavelrai.ru/wp-content/uploads/photo-gallery/individual/thumb/сложные (112).jpg"  width="180" /></a></li>
		</ul>
		<ul>
			<li style="width: 250px !important; height: 150px; float: left; overflow: hidden"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/uploads/photo-gallery/sculpture/скульптуры (56).jpg"><img src="http://pavelrai.ru/wp-content/uploads/photo-gallery/sculpture/thumb/скульптуры (56).jpg" width="180" /></a></li>
			<li style="width: 250px !important; height: 150px; float: left; overflow: hidden"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/uploads/photo-gallery/sculpture/скульптуры (54).jpg"><img src="http://pavelrai.ru/wp-content/uploads/photo-gallery/sculpture/thumb/скульптуры (54).jpg"  width="180" /></a></li>
			<li style="width: 250px !important; height: 150px; float: left; overflow: hidden"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/uploads/photo-gallery/sculpture/скульптуры (49).jpg"><img src="http://pavelrai.ru/wp-content/uploads/photo-gallery/sculpture/thumb/скульптуры (49).jpg"  width="180" /></a></li>
		</ul>
		<ul>
			<li style="width: 250px !important; height: 150px; float: left; overflow: hidden"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/uploads/2016/03/Дж 1-3.jpg"><img src="http://pavelrai.ru/wp-content/uploads/2016/03/Дж 1-3.jpg" width="180" /></a></li>
			<li style="width: 250px !important; height: 150px; float: left; overflow: hidden"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/uploads/2016/03/Дж 10-3.jpg"><img src="http://pavelrai.ru/wp-content/uploads/2016/03/Дж 10-3.jpg"  width="180" /></a></li>
			<li style="width: 250px !important; height: 150px; float: left; overflow: hidden"><a class="gallery" rel="group" title="" href="http://pavelrai.ru/wp-content/uploads/2016/03/Дж 101-1.jpg"><img src="http://pavelrai.ru/wp-content/uploads/2016/03/Дж 101-1.jpg"  width="180" /></a></li>
		</ul>
	</div>
<?endif;

if ( sizeof( $related ) == 0 ) return;
$args = apply_filters( 'woocommerce_related_products_args', array(
	'post_type'            => 'product',
	'ignore_sticky_posts'  => 1,
	'no_found_rows'        => 1,
	'posts_per_page'       => $posts_per_page,
	'orderby'              => $orderby,
	'post__in'             => $related,
	'post__not_in'         => array( $product->id )
) );
$products = new WP_Query( $args );
$woocommerce_loop['columns'] = $columns;


if ( $products->have_posts() &&  key($cat) != 743) : ?>
	<div class="related products">
		<h2><?php _e( 'Related Products', 'woocommerce' ); ?></h2>
		<?php woocommerce_product_loop_start(); ?>
			<?php while ( $products->have_posts() ) : $products->the_post(); ?>
				<?php wc_get_template_part( 'content', 'product' ); ?>
			<?php endwhile; // end of the loop. ?>
		<?php woocommerce_product_loop_end(); ?>
	</div>
<?php endif;
wp_reset_postdata();
