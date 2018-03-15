<?php
/*
  Template Name: information
 */
get_header();
?>
    <div class="page_content">
        <div class="container_content information_page">
            <?php
            $args = array(
                'post_parent' => 10386,
                'post_type'   => 'any',
                'numberposts' => -1,
                'post_status' => 'any'
            );
            $children = get_children( $args );?>
            <ul>
                <?foreach ($children as $child):?>
                    <li>
                        <a href="<?=$child->post_name?>">
                            <p class="date"><?=$child->post_date?></p>
                            <p class="title"><?=$child->post_title?></p>
                        </a>
                    </li>
                <?endforeach;?>
            </ul>
            <?=q_form()?>
        </div>
    </div>
<?php get_footer();?>