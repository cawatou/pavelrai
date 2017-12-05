<?php get_header(); ?>
<div class="container">
    <div class="row">
        <div class="col-md-9 posts-archive">
            <?php
            if (have_posts()) :
                while (have_posts()):the_post();
                    echo'<article class="post">
                            <div class="row">';
                    if (has_post_thumbnail()):
                        echo '<div class="col-md-4 col-sm-4">
                    	<a href="' . get_permalink() . '">';
                        the_post_thumbnail('600x400', array('class' => "img-thumbnail"));
                        echo'</a></div>';
                    endif;
                    echo '<div class="col-md-8 col-sm-8">';
                    echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
                    echo '<span class="post-meta meta-data">
                    		<span><i class="fa fa-calendar"></i>' . get_the_time(get_option('date_format')) . '</span><span><i class="fa fa-archive"></i>'.imic_custom_taxonomies_terms_links().'</span> <span>';
                    comments_popup_link('<i class="fa fa-comment"></i>'.__('No comments yet','framework'), '<i class="fa fa-comment"></i>1', '<i class="fa fa-comment"></i>%', 'comments-link',__('Comments are off for this post','framework'));
                    echo'</span></span>';
                    echo imic_excerpt(50);
                    echo '<p><a href="' . get_permalink() . '" class="btn btn-primary">' . __('Continue reading', 'framework') . '<i class="fa fa-long-arrow-right"></i></a></p>';
                    echo '</div></div>';
                    echo '</article>';
                endwhile;
            else:
                echo '<article class="post">';
                if (current_user_can('edit_posts')) :
                    ?>
                    <h3><?php _e('No posts to display', 'framework'); ?></h3>
                    <p><?php printf(__('Ready to publish your first post? <a href="%s">Get started here</a>.', 'framework'), admin_url('post-new.php')); ?></p>
                <?php else : ?>
                    <h3><?php _e('Nothing Found', 'framework'); ?></h3>
                    <p><?php printf(__('Apologies, but no results were found. Perhaps searching will help find a related post..', 'framework')); ?></p>
                    <?php
                    echo '</article>';
                endif;
                ?>
            <?php
            endif; // end have_posts() check 
            pagination();
            ?>
        </div>
        <!-- Start Sidebar -->
        <?php if(is_active_sidebar('post-sidebar')){
            echo '<div class="col-md-3 sidebar">';
            dynamic_sidebar('post-sidebar');
            echo '</div>';
            } ?>
        <!-- End Sidebar -->
    </div>
</div>
<?php get_footer(); ?>