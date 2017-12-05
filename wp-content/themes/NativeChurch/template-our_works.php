<?php
/*
  Template Name: our_works
 */
get_header();
?>
<div class="page_content">
    <div class="container_content">
        <div id="wrap_works">
            <ul id="works">
                <li class="our_works"><a href="/portfolio/econom/"><img src="<?php bloginfo('template_url'); ?>/images/our_works/econom.jpg" alt="" /><span>Модели эконом</span></a></li>
                <li class="our_works"><a href="/portfolio/vertical/"><img src="<?php bloginfo('template_url'); ?>/images/our_works/vertical.jpg" alt="" /><span>Вертикальные</span></a></li>
                <li class="our_works"><a href="/portfolio/family/"><img src="<?php bloginfo('template_url'); ?>/images/our_works/family.jpg" alt="" /><span>Семейные</span></a></li>
                <li class="our_works"><a href="/portfolio/dificult/"><img src="<?php bloginfo('template_url'); ?>/images/our_works/individual.jpg" alt="" /><span>Сложные и индивидуальные</span></a></li>
                <li class="our_works"><a href="/portfolio/blago/"><img src="<?php bloginfo('template_url'); ?>/images/our_works/blago.jpg" alt="" /><span>Благоустройство</span></a></li>
                <li class="our_works"><a href="/portfolio/figure/"><img src="<?php bloginfo('template_url'); ?>/images/our_works/figure.jpg" alt="" /><span>Фигурные плиты, площадки</span></a></li>
                <li class="our_works"><a href="/portfolio/sculpture/"><img src="<?php bloginfo('template_url'); ?>/images/our_works/sculpture.jpg" alt="" /><span>Скульптуры</span></a></li>
                <li class="our_works"><a href="/portfolio/fence/"><img src="<?php bloginfo('template_url'); ?>/images/our_works/fence.jpg" alt="" /><span>Ограды</span></a></li>
                <li class="our_works"><a href="/portfolio/marble/"><img src="<?php bloginfo('template_url'); ?>/images/our_works/marble.jpg" alt="" /><span>Мрамор</span></a></li>
            </ul>
        </div>    
        <?php the_content() ?>
    </div>  
</div>
<?php get_footer(); ?>