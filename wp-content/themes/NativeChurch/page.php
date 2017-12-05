<?php get_header();  ?>
    <!-- start page section -->
    <section class="page-section">
    	<div class="container">
            <div class="row">
                <!-- start post -->
                <article class="col-md-12">
                    <section class="page-content">
                        <?php 
                        while(have_posts()):the_post();
                            the_content(); 
                        endwhile;
                        ?>
                    </section>
                </article>
                <!-- end post -->
            </div>
        </div>
    </section>
<?php get_footer(); ?>