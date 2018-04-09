<?php
/*
  Template Name: cobbles
 */
get_header();
?>
<div class="page_content">
	<div class="container_content cobbles_page">
        <?php the_content() ?>
        <div class="col-md-6 before">
            <p><strong>Было</strong></p>
            <img src="/wp-content/uploads/2014/11/New-Project-35.png">
        </div>

        <div class="col-md-6 after">
            <p><strong>Стало</strong></p>
            <img src="/wp-content/uploads/2014/11/New-Project-34.png">
        </div>
        <div>
            <br>
            <p>Ниже указаны примеры наших работ по установке бордюров:</p>
        </div>
        <div class="gallery_work">
            <div class="gray_bg">&nbsp;</div>
            <p class="title">Примеры работ</p>
            <?=do_shortcode( '[Best_Wordpress_Gallery id="63"]' )?>
            <ul class="pagination pagination_gal"></ul>
        </div>
        <?=q_form()?>
	</div>	
</div>
<?php get_footer(); ?>