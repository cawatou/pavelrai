<?php
/*
  Template Name: cobbles
 */
get_header();
?>
<div class="page_content">
	<div class="container_content cobbles_page">
        <?php the_content() ?>
        <div class="col-md-6">
            <p>Было</p>
            <img src="/wp-content/uploads/2014/11/New-Project-35.png">
        </div>

        <div class="col-md-6">
            <p>Стало</p>
            <img src="/wp-content/uploads/2014/11/New-Project-34.png">
        </div>
        <div>
            <p>Ниже указаны примеры наших работ по установке бордюров:</p>
        </div>
           
        <?=q_form()?>
	</div>	
</div>
<?php get_footer(); ?>