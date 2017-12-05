<?php
/**
 * Single Product title
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     1.6.4
 */
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
$cat = get_the_terms( $post->ID, 'product_cat' );
if(key($cat) == 743):?>
    <p>Наша компания изготавливает и производит монтаж памятников и гранитных монументов из цветных гранитов и мрамора в  Уссурийске .Такие комплексы называют комбинированными, составными, сложными.  В этом разделе представлены образцы и макеты таких памятников -  выполненных из сочетания гранитов различных цветов. Каждый такой памятник имеет  размеры и цену, а также любой из них можно сделать по размерам, нужным заказчику</p>
<?else:?>
    <h1 itemprop="name" class="product_title entry-title"><?php the_title(); ?></h1>
<?endif?>