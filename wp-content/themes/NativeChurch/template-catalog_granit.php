<?php
/*
  Template Name: Catalog_granit
 */
get_header();
?>
<div class="page_content">
	<div class="container_cont">
		<!-- Вывод каталога гранитных памятников
		========================================================================== -->		
		<div class="product-archive main_products">
			<?php
			$x="";
			$posts = get_posts("post_type=product&numberposts=-1&product_cat=granit_memorials");  
			foreach ($posts as $post) : setup_postdata ($product);
			$x=$x+1;											
			?>	
			<ul class="products">
				<?php							
				if($x==4){
				echo '<li class="product last">';
				$x=0;
				}else{
				echo '<li class="product">';
				}?>
				<a href="<?php the_permalink(); ?>">
					<img class="woocommerce-placeholder wp-post-image" width="150" height="150" alt="Заполнитель" src="http://tfb7904.bget.ru/wp-content/plugins/woocommerce/assets/images/placeholder.png">
					<h3><?php the_title(); ?></h3>
				</a>								
				</li>							
			</ul>
			<?php endforeach; ?>
<?php /* if (  $wp_query->max_num_pages > 10 ) : ?>
<div>
	<div><?php next_posts_link(); ?></div>
	<div><?php previous_posts_link(); ?></div>
</div>
<?php endif; */?>
		</div>
	</div>	
</div>
<?php get_footer(); ?>