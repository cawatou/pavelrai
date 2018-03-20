<?php
/*
  Template Name: blago-border
 */
get_header();
?>
<div class="page_content">
	<div class="container_content blago-border_page">
        <?php the_content() ?>
        <div class="col-md-6">
            <p>Было</p>
            <img src="/wp-content/uploads/2014/11/New-Project-321.png">
        </div>

        <div class="col-md-6">
            <p>Стало</p>
            <img src="/wp-content/uploads/2014/11/New-Project-311.png">
        </div>     
        <div>
            <p>Ниже указаны примеры наших работ по установке бордюров:</p>
        </div>
           
        <?//=do_shortcode( '[Best_Wordpress_Gallery id="36" gal_title="Бордюры и щебень (Благоустройство)"]' )?>
        <?=q_form()?>
	</div>	
</div>
<?php get_footer(); ?>