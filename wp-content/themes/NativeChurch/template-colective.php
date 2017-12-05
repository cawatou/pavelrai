<?php
/*
	Template Name: colective
 */
get_header(); ?>
<div class="page_content">
	<div class="container_cont">
		<article>
			<?php
			$posts = get_posts("post_type=staff&numberposts=-1&order=ASC");  
			foreach ($posts as $post) : setup_postdata ($staff);
			?> 			
			<div class="box_staff col-sm-4">
				<div class="grid-item staff-item">
					<div class="grid-item-inner">
						<div class="media-box">
							<?php the_post_thumbnail('600x400'); ?>
						</div>
						<div class="grid-content">
							<h3><?php the_title();?></h3>
							<div class="meta-data">
								<?=get_post_meta($post->ID, 'imic_staff_job_title', true)?>
							</div>
						</div>
					</div>
				</div>
			</div>
			<?php endforeach;?>			
		</article>
	</div>
</div>
<?php get_footer(); ?>