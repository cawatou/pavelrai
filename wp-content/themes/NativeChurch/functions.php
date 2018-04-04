<?php
/* -----------------------------------------------------------------------------------
  Here we have all the custom functions for the theme
  Please be extremely cautious editing this file,
  When things go wrong, they tend to go wrong in a big way.
  You have been warned!
  ----------------------------------------------------------------------------------- */
/*
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
  ----------------------------------------------------------------------------------- */
define('IMIC_THEME_PATH', get_template_directory_uri());
define('IMIC_FILEPATH', get_template_directory());
/* -------------------------------------------------------------------------------------
  Load Translation Text Domain
  ----------------------------------------------------------------------------------- */
add_action('after_setup_theme', 'imic_theme_setup');
function imic_theme_setup() {
    load_theme_textdomain('framework', IMIC_FILEPATH . '/language');
}
/* -------------------------------------------------------------------------------------
  Menu option
  ----------------------------------------------------------------------------------- */
function register_menu() {
    register_nav_menu('primary-menu', __('Primary Menu', 'framework'));
    register_nav_menu('top-menu', __('Top Menu', 'framework'));
    register_nav_menu('footer-menu', __('Footer Menu', 'framework'));
}
add_action('init', 'register_menu');
/* -------------------------------------------------------------------------------------
  Set Max Content Width (use in conjuction with ".entry-content img" css)
  ----------------------------------------------------------------------------------- */
if (!isset($content_width))
    $content_width = 680;
/* -------------------------------------------------------------------------------------
  Configure WP2.9+ Thumbnails & gets the current post type in the WordPress Admin
  ----------------------------------------------------------------------------------- */
if (function_exists('add_theme_support')) {
    $post_type_name = '';
    if (isset($_GET['post'])) {
        $post_type_name = get_post_type($_GET['post']);
    }
    if (isset($_REQUEST['post_type'])) {
        $post_type_name = sanitize_key($_REQUEST['post_type']);
    }
    add_theme_support('post-thumbnails');
    add_theme_support('automatic-feed-links');
    if ($post_type_name == 'gallery') {
        add_theme_support('post-formats', array(
            'video', 'image', 'gallery', 'link'
        ));
    } else {
        add_theme_support('post-formats', array(
            'video', 'image', 'audio'
        ));
    }
    set_post_thumbnail_size(958, 9999);
    add_theme_support('woocommerce');
}
/* -------------------------------------------------------------------------------------
  Custom Gravatar Support
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_custom_gravatar')) {
    function imic_custom_gravatar($avatar_defaults) {
        $imic_avatar = get_template_directory_uri() . '/images/img_avatar.png';
        $avatar_defaults[$imic_avatar] = 'Custom Gravatar (/images/img_avatar.png)';
        return $avatar_defaults;
    }
    add_filter('avatar_defaults', 'imic_custom_gravatar');
}
/* -------------------------------------------------------------------------------------
  Load Theme Options
  ----------------------------------------------------------------------------------- */
require_once(IMIC_FILEPATH . '/includes/ReduxCore/framework.php');
require_once(IMIC_FILEPATH . '/includes/sample/sample-config.php');
include_once(IMIC_FILEPATH . '/imic-framework/imic-framework.php');
/* -------------------------------------------------------------------------------------
  For Paginate
  ----------------------------------------------------------------------------------- */
if (!function_exists('pagination')) {
    function pagination($pages = '', $range = 4) {
        $showitems = ($range * 2) + 1;
        global $paged;
        if (empty($paged))
            $paged = 1;
        if ($pages == '') {
            global $wp_query;
            $pages = $wp_query->max_num_pages;
            if (!$pages) {
                $pages = 1;
            }
        }
        if (1 != $pages) {
            echo '<ul class="pagination">';
            //echo '<li><a href="' . get_pagenum_link(1) . '" title="'.__('First','framework').'"><i class="fa fa-chevron-left"></i></a></li>';
            for ($i = 1; $i <= $pages; $i++) {
                if (1 != $pages && (!($i >= $paged + $range + 3 || $i <= $paged - $range - 3) || $pages <= $showitems )) {
                    echo ($paged == $i) ? "<li class=\"active\"><span>" . $i . "</span></li>" : "<li><a href='" . get_pagenum_link($i) . "' class=\"\">" . $i . "</a></li>";
                }
            }
            //echo '<li><a href="' . get_pagenum_link($pages) . '" title="'.__('Last','framework').'"><i class="fa fa-chevron-right"></i></a></li>';
            echo '</ul>';
        }
    }
}
/* -------------------------------------------------------------------------------------
  For Remove Dimensions from thumbnail image
  ----------------------------------------------------------------------------------- */
add_filter('post_thumbnail_html', 'remove_thumbnail_dimensions', 10);
add_filter('image_send_to_editor', 'remove_thumbnail_dimensions', 10);
function remove_thumbnail_dimensions($html) {
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}
/* -------------------------------------------------------------------------------------
  Excerpt More and  length
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_custom_read_more')) {
    function imic_custom_read_more() {
        return '';
    }
}
if (!function_exists('imic_excerpt')) {
    function imic_excerpt($limit = 50) {
        return '<p>' . wp_trim_words(get_the_excerpt(), $limit, imic_custom_read_more()) . '</p>';
    }
}
/* ----------------------------------------------------------------------------------- */
/* 	Comment Styling
  /*----------------------------------------------------------------------------------- */
if (!function_exists('imic_comment')) {
    function imic_comment($comment, $args, $depth) {
        $isByAuthor = false;
        if ($comment->comment_author_email == get_the_author_meta('email')) {
            $isByAuthor = true;
        }
        $GLOBALS['comment'] = $comment;
        ?>
        <li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
            <div class="post-comment-block">
                <div id="comment-<?php comment_ID(); ?>">
                    <div class="img-thumbnail"><?php echo get_avatar($comment, $size = '40'); ?></div>
        <?php
         echo preg_replace('/comment-reply-link/', 'comment-reply-link btn btn-primary btn-xs pull-right', get_comment_reply_link(array_merge($args, array('depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __('Reply','framework')))), 1);
       echo '<h5>' . get_comment_author() .__(' says','framework').'</h5>';
        ?>            
                    <span class="meta-data">
            <?php
            echo get_comment_date();
            _e(' at ', 'framework');
            echo get_comment_time();
            ?>
                    </span>
            <?php if ($comment->comment_approved == '0') : ?>
                        <em class="moderation"><?php _e('Your comment is awaiting moderation.', 'framework') ?></em>
                        <br />
            <?php endif; ?>
            <?php comment_text() ?>
                </div>
            </div>
            <?php
        }
    }
    if (!function_exists('imic_get_data_by_path')) {
        function imic_get_data_by_path($id, $imic_custom_read_more) {
            $slug_data = get_post($id);
            $post_type = get_post_type($id);
            $slug_thumbnail_id = get_post_meta($id, '_thumbnail_id', 'true');
            $src = wp_get_attachment_image_src($slug_thumbnail_id, 'full');
            $read_More_text = !empty($imic_custom_read_more) ? $imic_custom_read_more : $slug_data->post_title;
            if (!empty($slug_thumbnail_id)) {
                echo '<div class="col-md-4 col-sm-4 featured-block">';
                if ($post_type == 'event') {
                    $customeventSt = strtotime(get_post_meta($id, 'imic_event_start_dt', true));
                    $date_converted = date('Y-m-d', $customeventSt);
                  $custom_event_url= imic_query_arg($date_converted,$slug_data->ID);
                    } else {
                    $custom_event_url = get_permalink($slug_data->ID);
                }
                echo'<a href="' . $custom_event_url . '" class="img-thumbnail"> <img src="' . $src[0] . '" alt="' . $slug_data->post_title . '"> <strong>' . $read_More_text . '</strong> <span class="more">' . __('read more', 'framework') . '</span> </a> </div>';
            }
        }
    }
   if (!class_exists('run_once')){
    class run_once{
        function run($key){
            $test_case = get_option('run_once');
            if (isset($test_case[$key]) && $test_case[$key]){
                return false;
            }else{
                $test_case[$key] = true;
                update_option('run_once',$test_case);
                return true;
            }
        }
    }
}
$run_once = new run_once;
if ($run_once->run('do_stuff')){
	$args = ('post_type=staff&posts_per_page=-1');
				$staffs = get_posts($args);
				foreach($staffs as $post) {
				setup_postdata($post);
				$id = get_the_ID();
				$facebook = get_post_meta($id,'imic_staff_member_facebook',true);
				$twitter = get_post_meta($id,'imic_staff_member_twitter',true);
				$google = get_post_meta($id,'imic_staff_member_google_plus',true);
				$pinterest = get_post_meta($id,'imic_staff_member_pinterest',true);
				
$fbtitle = __("Facebook",'framework');
$twtitle = __("Twitter",'framework');
$gptitle = __("Google Plus",'framework');
$ptitle = __("Pinterest",'framework');
$sb = $array = array(array($fbtitle, $facebook),array($twtitle, $twitter),array($gptitle, $google),array($ptitle, $pinterest));
update_post_meta($id,'imic_social_icon_list',$sb);
				}}
function imic_social_staff_icon() {
        $output = '';
        $staff_icons = get_post_meta(get_the_ID(), 'imic_social_icon_list', false);
        if (!empty($staff_icons[0]) || get_post_meta(get_the_ID(), 'imic_staff_member_email', true) != '') {
            $output.='<nav class="social-icons">';
            if (!empty($staff_icons[0])) {
                foreach ($staff_icons[0] as $list => $values) {
                    if (!empty($values[1])) {
                        $className = preg_replace('/\s+/', '-', strtolower($values[0]));
                        $className = 'fa fa-' . $className;
                        $output.='<a href="' . $values[1] . '" target ="_blank"><i class="' . $className . '"></i></a>';
                    }
                }
            }
            if (get_post_meta(get_the_ID(), 'imic_staff_member_email', true) != '') {
                $output.='<a href="mailto:' . get_post_meta(get_the_ID(), 'imic_staff_member_email', true) . '"><i class="fa fa-envelope"></i></a>';
            }
            $output.='</nav>';
        }
        return $output;
    }

/* -------------------------------------------------------------------------------------
  Вывод количества похожего товара ( Внизу карточки товара )
  ----------------------------------------------------------------------------------- */

function woocommerce_output_related_products() {
 woocommerce_related_products(4,4); // Показывать 3 товара
 }

/* -------------------------------------------------------------------------------------
  Вывод количества товара на одной странице
  ----------------------------------------------------------------------------------- */
  add_filter('loop_shop_per_page', create_function('$cols', 'return 9;'));

/* -------------------------------------------------------------------------------------
  Подключение Java Script
  ----------------------------------------------------------------------------------- */
function my_theme_load_resources() {
    $theme_uri = get_template_directory_uri();
 
    wp_register_script('my_theme_functions', $theme_uri.'/js/jquery.fancybox-1.2.1.pack.js', array('jquery'), '0.1');
    wp_enqueue_script('my_theme_functions');

    wp_register_script('my_theme_functions2', get_template_directory_uri().'/js/start.js', array('jquery'), '0.1');
    wp_enqueue_script('my_theme_functions2');
 
    /*Если хотим подключить стиль или скрипт только на определённых страницах
    if ( is_page( array(2, 3) ) ) {
        wp_register_script('my_theme_login', $theme_uri.'/js/login.js', array('jquery', 'my_theme_functions'), '0.1');
        wp_enqueue_script('my_theme_login');
    }*/
}
add_action('wp_enqueue_scripts', 'my_theme_load_resources');

            
/*================== Вывод формы "Остались вопросы" =================*/
function q_form(){
    require_once($theme_uri . 'q_form.php');
}

/*================== Вывод карусели "Наши работы" =================*/
function works_carousel(){
    require_once($theme_uri . 'works_carousel.php');
}

// Убираем ненужные поля
add_filter( 'woocommerce_checkout_fields' , 'remove_extra_checkout_fields' );
function remove_extra_checkout_fields( $fields ) {
    unset( $fields['billing']['billing_last_name'] );
    unset( $fields['billing']['billing_company'] );
    unset( $fields['billing']['billing_address_1'] );
    unset( $fields['billing']['billing_address_2'] );
    unset( $fields['billing']['billing_city'] );
    unset( $fields['billing']['billing_postcode'] );
    unset( $fields['billing']['billing_country'] );
    unset( $fields['billing']['billing_state'] );
    unset( $fields['shipping']['shipping_first_name'] );
    unset( $fields['shipping']['shipping_last_name'] );
    unset( $fields['shipping']['shipping_company'] );
    unset( $fields['shipping']['shipping_address_1'] );
    unset( $fields['shipping']['shipping_address_2'] );
    unset( $fields['shipping']['shipping_city'] );
    unset( $fields['shipping']['shipping_postcode'] );
    unset( $fields['shipping']['shipping_country'] );
    unset( $fields['shipping']['shipping_state'] );
    unset( $fields['account']['account_username'] );
    unset( $fields['account']['account_password'] );
    unset( $fields['account']['account_password-2'] );
    unset( $fields['order']['order_comments'] );
    return $fields;
}

?>



