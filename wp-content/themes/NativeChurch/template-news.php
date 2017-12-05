<?php
/*
  Template Name: news
 */
get_header();
?>
<div class="page_content">
	<div class="container_cont">
		<!--====================================
		 Вывод новостей 
		 =======================================-->					
		<div class="listing">
			<?php $posts = get_posts("orderby=date&numberposts=-1"); ?> 
			<?php if ($posts) : ?>
			<?php foreach ($posts as $post) : setup_postdata ($post); ?>
			<section class="listing-cont">
				<ul>
					<li class="item post news_post">
						<div class="row">
							<div class="col-md-4 news_img">
								<?php the_post_thumbnail('600x400'); ?>
							</div>
							<div class="col-md-8">
								<div class="post-title">
									<h2><?php the_title(); ?></h2>												
								</div>											
							</div>
							<?php the_content(); ?>
						</div>
					</li>			
				</ul>
			</section> 
			<?php endforeach; ?>
			<?php endif; ?>
		</div>
	</div>	
</div>
<?php get_footer(); ?>