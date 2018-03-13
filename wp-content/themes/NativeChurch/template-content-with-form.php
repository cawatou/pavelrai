<?php
/*
  Template Name: content-with-form
 */
get_header();
?>
<div class="page_content">
	<div class="container_content">
        <?php the_content() ?>
        <?=q_form()?>
	</div>	
</div>
<?php get_footer(); ?>