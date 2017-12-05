<?php get_header(); 
$pageOptions = imic_page_design(); //page design options ?>
<div class="container">
    <div class="row">
        <div class="<?php echo $pageOptions['class']; ?>"> 
            <header class="post-title">
            <?php
            echo'<div class="row">
            <div class="col-md-9 col-sm-9">
            <h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
            echo'<span class="meta-data">';
            echo get_the_term_list(get_the_ID(), 'staff-category',__('Categories','framework').': ', ', ', '');
            echo'</span></div></div>';
            ?>
            </header>
            <article class="post-content">
            <?php if (has_post_thumbnail()): ?>
            <div class="featured-image">
            <?php
            the_post_thumbnail('full');
            ?>
            </div>
            <?php
            endif;
            while (have_posts()):the_post();
            the_content();
            endwhile;
            $job_title = get_post_meta(get_the_ID(), 'imic_staff_job_title', true);
            $job = '';
            if (!empty($job_title)) {
            $job = '<div class="meta-data">' .__('Position','framework').': '. $job_title . '</div>';
            }
            $output = '';
            $output .= $job;
            $output .= imic_social_staff_icon();
            echo $output;
            ?>	
            </article>
        </div>
        <?php if(!empty($pageOptions['sidebar'])){ ?>
        <!-- Start Sidebar -->
        <div class="col-md-3 sidebar">
            <?php dynamic_sidebar($pageOptions['sidebar']); ?>
        </div>
        <!-- End Sidebar -->
        <?php } ?>
    </div>
</div>
<?php get_footer(); ?>