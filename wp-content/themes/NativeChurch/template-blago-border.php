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
                <p><strong>Было</strong></p>
                <img src="/wp-content/uploads/2014/11/New-Project-321.png">
            </div>

            <div class="col-md-6">
                <p><strong>Стало</strong></p>
                <img src="/wp-content/uploads/2014/11/New-Project-311.png">
            </div>
            <div>
                <br>
                <p>Ниже указаны примеры наших работ по установке бордюров:</p>
            </div>
            <div class="gallery_work">
                <p class="title">Наши работы</p>
                <?=do_shortcode( '[Best_Wordpress_Gallery id="45" gal_title="Бордюры и щебень (Благоустройство)"]' )?>
            </div>
            <?=q_form()?>
        </div>
    </div>
<?php get_footer(); ?>