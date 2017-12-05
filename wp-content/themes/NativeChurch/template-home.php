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
					<!-- Вывод Контента из админки 
					============================-->
					<?php the_content() ?>

					<!-- Вывод каталога популярных памятников ( Теперь выводится Short кодом из Админки)
					==================================================================================-->					
					<!--div class="main_products no_marker">
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
										print_r($tax);
									?>
								</a>								
							</li>			
							<?php endforeach; ?>
						</ul>					
					</div--> 
					<!-- Вывод новостей 
					==========================================================================-->					
					<div class="listing">
						<a class="news_block" href="/novosti">
							<h2>Новости</h2>
						</a>	
						<?php $posts = get_posts("orderby=date&numberposts=3"); ?> 
						<?php if ($posts) : ?>
						<?php foreach ($posts as $post) : setup_postdata ($post); ?>
						<section id="news_section" class="listing-cont">
							<ul>
								<li class="item post news_post">
										<div class="col-md-4 news_img">
												<?php the_post_thumbnail('600x400'); ?>
										</div>
										<div class="col-md-8">
											<div class="post-title">
												<h2><?php the_title(); ?></h2>																								
											</div>											
										</div>
										<?php the_content(); ?>

								</li>			
					  		</ul>
						</section> 
						<?php endforeach; ?>
						<?php endif; ?>
					</div>
				</div>	
			</div>
		</div>
	</div>
</div>    
<?php get_footer(); ?>