<?php
/*
  Template Name: cobbles
 */
get_header();
?>
<div class="page_content">
	<div class="container_content cobbles_page">
        <div class="col-md-6">
            <p>Было</p>
            <img src="/wp-content/uploads/2014/11/New-Project-32.png">
        </div>

        <div class="col-md-6">
            <p>Стало</p>
            <img src="/wp-content/uploads/2014/11/New-Project-31.png">
        </div>     
        <?php the_content() ?>
           
        <?=q_form()?>
	</div>	
</div>
<?php get_footer(); ?>