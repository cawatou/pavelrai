<?php
/*
  Template Name: blago-fund
 */
get_header();
?>
    <div class="page_content">
        <div class="container_content blago-border_page">
            <?php the_content() ?>
            <div class="gallery_work">
                <div class="gray_bg">&nbsp;</div>
                <p class="title">Примеры работ</p>
                <?=do_shortcode( '[Best_Wordpress_Gallery id="51"]' )?>
                <ul class="pagination pagination_gal"></ul>
            </div>
            <?=q_form()?>
        </div>
    </div>
<?php get_footer(); ?>