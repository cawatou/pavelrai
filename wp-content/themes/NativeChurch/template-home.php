<?php
/*
  Template Name: Home
 */
get_header();?>
<!-- Start Content -->
<div class="main_home" role="main">
    <div id="content" class="content full">
        <div class="container">
            <div class="wrap_cont">
                <?php dynamic_sidebar('inner-page-sidebar'); ?>
                <div class="page_content">
                    <!-- Вывод каталога популярных памятников ( Теперь выводится Short кодом из Админки)
                    ==================================================================================-->
                    <div class="main_products no_marker">
                        <h2>Популярные памятники</h2>
                        <ul class="products">
                            <?$x = 0;
                            $posts = get_posts("post_type=product&numberposts=18&product_cat=popular_memorials");
                            foreach ($posts as $post) :
                                $x = $x + 1;
                                if ($x == 3) {
                                    echo '<li class="product last">';
                                    $x = 0;
                                } else {
                                    echo '<li class="product">';
                                }?>
                                    <h4 href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail(); ?>
                                        <span><?php the_title(); ?></span>
                                        <?$tax = get_post_custom( $post->ID );?>
                                        <span class="product_price"><?=number_format($tax['_price'][0], 0, '', ' ')?> P</span>
                                        <?$cats = get_the_terms( $post->ID, 'product_cat' );
                                        
                                        //echo "<pre>".print_r($tax, 1)."</pre>";
                                        //echo $post->get_price();
                                        foreach ($cats as $cat):
                                            if($cat->name !== 'Популярные памятники'):?>
                                                <p ><?=$cat->name?></p>
                                                <?break?>
                                            <?endif?>    
                                        <?endforeach?>            
                                    </span>
                                    <p class="detail_view">Посмотреть подробнее</p>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Вывод Контента из админки
============================-->
<?php the_content() ?>
<?php get_footer(); ?>