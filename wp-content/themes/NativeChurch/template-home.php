<?php
/*
  Template Name: Home
 */
get_header();
?>
<!-- Start Content -->
<div class="main_home" role="main">
	<div id="content" class="content full">
		<div class="container">
			<div class="wrap_cont">  
				<?php dynamic_sidebar('inner-page-sidebar'); ?>
				<div class="page_content">
					<!-- Вывод каталога популярных памятников ( Теперь выводится Short кодом из Админки)
					==================================================================================-->					
					<div class="main_products no_marker">
						<h2>Популярные памятники</h2>
						<ul class="products">
							<?php							
							$x="";
							$posts = get_posts("post_type=product&numberposts=18&product_cat=popular_memorials");  							
							foreach ($posts as $post) : setup_postdata ($product);
							$x=$x+1;											
							if($x==3){
								echo '<li class="product last">';
								$x=0;
							}else{
								echo '<li class="product">';
							}?>
								<a href="<?php the_permalink(); ?>">
									<?php the_post_thumbnail(); ?>									
									<h3><?php the_title(); ?></h3>
									<?php 
										$args = array(
											'tax_query' => array(
												array(
													'taxonomy' => 'pa_gabarits',
													'field' => 'id',
													'terms' => 'id'
												)
											)
										);
										$tax = get_posts($args);
										//print_r($tax);
									?>
								</a>								
							</li>			
							<?php endforeach; ?>
						</ul>					
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Вывод Контента из админки
============================-->
<?php the_content() ?>
<?php get_footer(); ?>