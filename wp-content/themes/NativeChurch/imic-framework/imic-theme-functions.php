<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly
/*
 *
 * 	imic Framework Theme Functions
 * 	------------------------------------------------
 * 	imic Framework v2.0
 * 	Copyright imic  2014 - http://www.imicreation.com/
 * 	imic_theme_activation()
 * 	imic_maintenance_mode()
 * 	imic_custom_login_logo()
 * 	imic_add_nofollow_cat()
 * 	imic_admin_bar_menu()
 * 	imic_admin_css()
 * 	imic_analytics()
 * 	imic_custom_styles()
 * 	imic_custom_script()
 *      imic_content_filter()
 *      imic_video_embed()
 *      imic_video_youtube()
 *      imic_video_vimeo()
 * 	imic_register_sidebars()
 *      imic_custom_taxonomies_terms_links()    
 * 	event_time_columns()
 * 	event_time_column_content()
 * 	sortable_event_column()
 *      event_time_orderby()
 *      imic_register_meta_box()
 *      class IMIC_Custom_Nav
 *      imic_get_all_types()
 *      imic_day_diff()
  *     imic_get_recursive_event_data()
 *      imic_get_cat_list()
 *      imic_widget_titles()
 *      widget_text filter
 *      imic_month_translate()
 *      imic_short_month_translate()
 *      imic_day_translate()
 *      imic_global_month_name()
 *      RevSliderShortCode()
 *      imic_gallery_flexslider()
 *      imic_sermon_attach_full_audio()
 *      imic_sermon_attach_full_pdf()
 *      imic_query_arg()
 *      imicAddQueryVarsFilter()
 *      ImicConvertDate()
 *      imic_cat_count_flag()
 *	imic_page_design()
 *      imic_get_home_recursive_event_data()
 *      imicBlogTemplateRedirect()
 *      imicGetThumbAndLargeSize()
 *      imic_disable_admin_bar()
 */
/* THEME ACTIVATION
  ================================================== */
if (!function_exists('imic_theme_activation')) {
    function imic_theme_activation() {
        global $pagenow;
        if (is_admin() && 'themes.php' == $pagenow && isset($_GET['activated'])) {
            #provide hook so themes can execute theme specific functions on activation
            do_action('imic_theme_activation');
          }
    }
    add_action('admin_init', 'imic_theme_activation');
}
/* MAINTENANCE MODE
  ================================================== */
if (!function_exists('imic_maintenance_mode')) {
    function imic_maintenance_mode() {
        $options = get_option('imic_options');
        $custom_logo = $custom_logo_output = $maintenance_mode = "";
        if (isset($options['custom_admin_login_logo'])) {
            $custom_logo = $options['custom_admin_login_logo'];
        }
        $custom_logo_output = '<img src="' . $custom_logo['url'] . '" alt="maintenance" style="height: 62px!important;margin: 0 auto; display: block;" />';
        if (isset($options['enable_maintenance'])) {
            $maintenance_mode = $options['enable_maintenance'];
        } else {
            $maintenance_mode = false;
        }
        if ($maintenance_mode) {
            if (!current_user_can('edit_themes') || !is_user_logged_in()) {
                wp_die($custom_logo_output . '<p style="text-align:center">' . __('We are currently in maintenance mode, please check back shortly.', 'framework') . '</p>', __('Maintenance Mode', 'framework'));
            }
        }
    }
    add_action('get_header', 'imic_maintenance_mode');
}
/* CUSTOM LOGIN LOGO
  ================================================== */
if (!function_exists('imic_custom_login_logo')) {
    function imic_custom_login_logo() {
        $options = get_option('imic_options');
        $custom_logo = "";
        if (isset($options['custom_admin_login_logo'])) {
            $custom_logo = $options['custom_admin_login_logo'];
        }
        echo '<style type="text/css">
			    .login h1 a { background-image:url(' . $custom_logo['url'] . ') !important; background-size: auto !important; width: auto !important; height: 95px !important; }
			</style>';
    }
    add_action('login_head', 'imic_custom_login_logo');
}
/* CATEGORY REL FIX
  ================================================== */
if (!function_exists('imic_add_nofollow_cat')) {
    function imic_add_nofollow_cat($text) {
        $text = str_replace('rel="category tag"', "", $text);
        return $text;
    }
    add_filter('the_category', 'imic_add_nofollow_cat');
}
/* CUSTOM ADMIN MENU ITEMS
  ================================================== */
if (!function_exists('imic_admin_bar_menu')) {
    function imic_admin_bar_menu() {
        global $wp_admin_bar;
        if (current_user_can('manage_options')) {
            $theme_customizer = array(
                'id' => '2',
                'title' => __('Color Customizer', 'framework'),
                'href' => admin_url('/customize.php'),
                'meta' => array('target' => 'blank')
            );
            $wp_admin_bar->add_menu($theme_customizer);
        }
    }
    add_action('admin_bar_menu', 'imic_admin_bar_menu', 99);
}
/* ADMIN CUSTOM POST TYPE ICONS
  ================================================== */
if (!function_exists('imic_admin_css')) {
    function imic_admin_css() {
        $mywp_version = get_bloginfo('version');
        if ($mywp_version < 3.8) {
            ?>
            <style type="text/css" media="screen">
                #menu-posts-event .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/portfolio.png) no-repeat 6px 7px!important;
                    background-size: 17px 15px;
                }
                #menu-posts-events:hover .wp-menu-image, #menu-posts-events.wp-has-current-submenu .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/portfolio_rollover.png) no-repeat 6px 7px!important;
                }
                #menu-posts-staff .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/team.png) no-repeat 6px 11px!important;
                    background-size: 18px 9px;
                }
                #menu-posts-staff:hover .wp-menu-image, #menu-posts-staff.wp-has-current-submenu .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/team_rollover.png) no-repeat 6px 11px!important;
                }
                #menu-posts-sermons .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/jobs.png) no-repeat 6px 11px!important;
                    background-size: 18px 9px;
                }
                #menu-posts-sermons:hover .wp-menu-image, #menu-posts-sermons.wp-has-current-submenu .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/jobs_rollover.png) no-repeat 6px 11px!important;
                }
                #menu-posts-gallery .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/showcase.png) no-repeat 6px 11px!important;
                    background-size: 18px 9px;
                }
                #menu-posts-gallery:hover .wp-menu-image, #menu-posts-gallery.wp-has-current-submenu .wp-menu-image {
                    background: url(<?php echo get_template_directory_uri(); ?>/images/wp/showcase_rollover.png) no-repeat 6px 11px!important;
                }
                #menu-posts-slide .wp-menu-image img {
                    width: 16px;
                }
                #toplevel_page_imic_theme_options .wp-menu-image img {
                    width: 11px;
                    margin-top: -2px;
                    margin-left: 3px;
                }
                .toplevel_page_imic_theme_options #adminmenu li#toplevel_page_imic_theme_options.wp-has-current-submenu a.wp-has-current-submenu, .toplevel_page_imic_theme_options #adminmenu #toplevel_page_imic_theme_options .wp-menu-arrow div, .toplevel_page_imic_theme_options #adminmenu #toplevel_page_imic_theme_options .wp-menu-arrow {
                    background: #222;
                    border-color: #222;
                }
                #wpbody-content {
                    min-height: 815px;
                }
                .wp-list-table th#thumbnail, .wp-list-table td.thumbnail {
                    width: 80px;
                }
                .wp-list-table td.thumbnail img {
                    max-width: 100%;
                    height: auto;
                }
            </style>
            <?php
        } else {
            ?>
            <style type="text/css" media="screen">
                .icon16.icon-post:before, #adminmenu #menu-posts-event div.wp-menu-image:before
                {
                    content: "\f337";
                }
                .icon16.icon-post:before, #adminmenu #menu-posts-sermons div.wp-menu-image:before
                {
                    content: "\f110";
                }
                .icon16.icon-post:before, #adminmenu #menu-posts-staff div.wp-menu-image:before
                {
                    content: "\f307";
                }
                .icon16.icon-post:before, #adminmenu #menu-posts-gallery div.wp-menu-image:before
                {
                    content: "\f161";
                }
                #menu-posts-slide .wp-menu-image img {
                    width: 16px;
                }
                #toplevel_page_imic_theme_options .wp-menu-image img {
                    width: 11px;
                    margin-top: -2px;
                    margin-left: 3px;
                }
                .toplevel_page_imic_theme_options #adminmenu li#toplevel_page_imic_theme_options.wp-has-current-submenu a.wp-has-current-submenu, .toplevel_page_imic_theme_options #adminmenu #toplevel_page_imic_theme_options .wp-menu-arrow div, .toplevel_page_imic_theme_options #adminmenu #toplevel_page_imic_theme_options .wp-menu-arrow {
                    background: #222;
                    border-color: #222;
                }
                #wpbody-content {
                    min-height: 815px;
                }
                .wp-list-table th#thumbnail, .wp-list-table td.thumbnail {
                    width: 80px;
                }
                .wp-list-table td.thumbnail img {
                    max-width: 100%;
                    height: auto;
                }
            </style>	
            <?php
        }
    }
    add_action('admin_head', 'imic_admin_css');
}
/* ----------------------------------------------------------------------------------- */
/* Show analytics code in footer */
/* ----------------------------------------------------------------------------------- */
if (!function_exists('imic_analytics')) {
    function imic_analytics() {
        $options = get_option('imic_options');
        if (isset($options['tracking-code'])&&$options['tracking-code'] != "") {
            echo '<script>';
            echo $options['tracking-code'];
            echo '</script>';
        }
    }
    add_action('wp_head', 'imic_analytics');
}
/* CUSTOM CSS OUTPUT
  ================================================== */
if (!function_exists('imic_custom_styles')) {
    function imic_custom_styles() {
        $options = get_option('imic_options');
       
        // OPEN STYLE TAG
        echo '<style type="text/css">' . "\n";
        // Custom CSS
        $custom_css = $options['custom_css'];
		 $header_height = $options['header_area_height'];
                        $header_height=!empty($header_height)?$header_height:80;
			$logo_height=!empty($header_height)?$header_height-15:65;
                       $slider_height=!empty($header_height)?$header_height+1:81;
		      $slider_margin=!empty($header_height)?$header_height+1:81;
			  $header_style3a=!empty($header_height)?$header_height+39:119;
			  $header_style3b=!empty($header_height)?$header_height+79:159;
        if ($options['theme_color_type'][0] == 1) {
            $customColor = $options['custom_theme_color'];
            echo '.text-primary, .btn-primary .badge, .btn-link,a.list-group-item.active > .badge,.nav-pills > .active > a > .badge, p.drop-caps:first-child:first-letter, .accent-color, .events-listing .event-detail h4 a, .featured-sermon h4 a, .page-header h1, .post-more, ul.nav-list-primary > li a:hover, .widget_recent_comments a, .navigation .megamenu-container .megamenu-sub-title, .woocommerce div.product span.price, .woocommerce div.product p.price, .woocommerce #content div.product span.price, .woocommerce #content div.product p.price, .woocommerce-page div.product span.price, .woocommerce-page div.product p.price, .woocommerce-page #content div.product span.price, .woocommerce-page #content div.product p.price, .woocommerce ul.products li.product .price, .woocommerce-page ul.products li.product .price, .cause-item .progress-label, .payment-to-cause a{
                                    color:' . $customColor . ';
                            }
                            a:hover{
                                    color:' . $customColor . ';
                            }
                            .events-listing .event-detail h4 a:hover, .featured-sermon h4 a:hover, .featured-gallery p, .post-more:hover, .widget_recent_comments a:hover{
                                    opacity:.9
                            }
                            p.drop-caps.secondary:first-child:first-letter, .accent-bg, .fa.accent-color, .btn-primary,
                            .btn-primary.disabled,
                            .btn-primary[disabled],
                            fieldset[disabled] .btn-primary,
                            .btn-primary.disabled:hover,
                            .btn-primary[disabled]:hover,
                            fieldset[disabled] .btn-primary:hover,
                            .btn-primary.disabled:focus,
                            .btn-primary[disabled]:focus,
                            fieldset[disabled] .btn-primary:focus,
                            .btn-primary.disabled:active,
                            .btn-primary[disabled]:active,
                            fieldset[disabled] .btn-primary:active,
                            .btn-primary.disabled.active,
                            .btn-primary[disabled].active,
                            fieldset[disabled] .btn-primary.active,
                            .dropdown-menu > .active > a,
                            .dropdown-menu > .active > a:hover,
                            .dropdown-menu > .active > a:focus,
                            .nav-pills > li.active > a,
                            .nav-pills > li.active > a:hover,
                            .nav-pills > li.active > a:focus,
                            .pagination > .active > a,
                            .pagination > .active > span,
                            .pagination > .active > a:hover,
                            .pagination > .active > span:hover,
                            .pagination > .active > a:focus,
                            .pagination > .active > span:focus,
                            .label-primary,
                            .progress-bar,
                            a.list-group-item.active,
                            a.list-group-item.active:hover,
                            a.list-group-item.active:focus,.panel-primary > .panel-heading, .carousel-indicators .active, .owl-theme .owl-controls .owl-page.active span, .owl-theme .owl-controls.clickable .owl-page:hover span, hr.sm, .flex-control-nav a:hover, .flex-control-nav a.flex-active, .title-note, .timer-col #days, .featured-block strong, .featured-gallery, .nav-backed-header, .next-prev-nav a, .event-description .panel-heading, .media-box .media-box-wrapper, .staff-item .social-icons a, .accordion-heading .accordion-toggle.active, .accordion-heading:hover .accordion-toggle, .accordion-heading:hover .accordion-toggle.inactive, .nav-tabs li a:hover, .nav-tabs li a:active, .nav-tabs li.active a, .fc-events, .site-header .social-icons a, .fc-event-inners, .timeline > li > .timeline-badge, .header-style3 .toprow, .featured-star, .featured-event-time,.goingon-events-floater-inner{
                              background-color: ' . $customColor . ';
                            }
                            .mejs-controls .mejs-time-rail .mejs-time-loaded, p.demo_store, .woocommerce a.button.alt, .woocommerce button.button.alt, .woocommerce input.button.alt, .woocommerce #respond input#submit.alt, .woocommerce #content input.button.alt, .woocommerce-page a.button.alt, .woocommerce-page button.button.alt, .woocommerce-page input.button.alt, .woocommerce-page #respond input#submit.alt, .woocommerce-page #content input.button.alt, .woocommerce .woocommerce-info:before, .woocommerce-page .woocommerce-info:before, .woocommerce .woocommerce-message:before, .woocommerce-page .woocommerce-message:before, .woocommerce span.onsale, .woocommerce-page span.onsale, .wpcf7-form .wpcf7-submit, .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce-page .widget_price_filter .ui-slider .ui-slider-handle, .woocommerce .widget_layered_nav ul li.chosen a, .woocommerce-page .widget_layered_nav ul li.chosen a{
                              background: ' . $customColor . ';
                            }
                            .btn-primary:hover,
                            .btn-primary:focus,
                            .btn-primary:active,
                            .btn-primary.active,
                            .open .dropdown-toggle.btn-primary, .next-prev-nav a:hover, .staff-item .social-icons a:hover, .site-header .social-icons a:hover, .woocommerce a.button.alt:hover, .woocommerce button.button.alt:hover, .woocommerce input.button.alt:hover, .woocommerce #respond input#submit.alt:hover, .woocommerce #content input.button.alt:hover, .woocommerce-page a.button.alt:hover, .woocommerce-page button.button.alt:hover, .woocommerce-page input.button.alt:hover, .woocommerce-page #respond input#submit.alt:hover, .woocommerce-page #content input.button.alt:hover, .woocommerce a.button.alt:active, .woocommerce button.button.alt:active, .woocommerce input.button.alt:active, .woocommerce #respond input#submit.alt:active, .woocommerce #content input.button.alt:active, .woocommerce-page a.button.alt:active, .woocommerce-page button.button.alt:active, .woocommerce-page input.button.alt:active, .woocommerce-page #respond input#submit.alt:active, .woocommerce-page #content input.button.alt:active, .wpcf7-form .wpcf7-submit{
                              background: ' . $customColor . ';
                              opacity:.9
                            }
							.woocommerce .woocommerce-info, .woocommerce-page .woocommerce-info, .woocommerce .woocommerce-message, .woocommerce-page .woocommerce-message{
							border-top-color: ' .$customColor . ';
							}
                            .nav .open > a,
                            .nav .open > a:hover,
                            .nav .open > a:focus,
                            .pagination > .active > a,
                            .pagination > .active > span,
                            .pagination > .active > a:hover,
                            .pagination > .active > span:hover,
                            .pagination > .active > a:focus,
                            .pagination > .active > span:focus,
                            a.thumbnail:hover,
                            a.thumbnail:focus,
                            a.thumbnail.active,
                            a.list-group-item.active,
                            a.list-group-item.active:hover,
                            a.list-group-item.active:focus,
                            .panel-primary,
                            .panel-primary > .panel-heading, .fc-events{
                                    border-color:' . $customColor . ';
                            }
                            .panel-primary > .panel-heading + .panel-collapse .panel-body{
                                    border-top-color:' . $customColor . ';
                            }
                            .panel-primary > .panel-footer + .panel-collapse .panel-body{
                                    border-bottom-color:' . $customColor . ';
                            }
                            blockquote{
                                    border-left-color:' . $customColor . ';
                            }';
        }
		echo '.site-header .topbar{
								height:'.$header_height.'px;
							}
							.site-header h1.logo{
								height:'.$logo_height.'px;
							}
							.home .hero-slider{
								top:-'.$slider_height.'px;
								margin-bottom:-'.$slider_margin.'px;
							}
							.home .slider-revolution-new{
								top:-'.$slider_height.'px;
								margin-bottom:-'.$slider_margin.'px;
							}
							@media only screen and (max-width: 992px) {
								.main-menu-wrapper{
									top:'.$header_height.'px;
								}
							}
							@media only screen and (max-width: 992px) {
								.header-style3 .main-menu-wrapper{
									top:'.$header_style3a.'px;
								}
							}
							@media only screen and (max-width: 767px) {
								.header-style3 .main-menu-wrapper{
									top:'.$header_style3b.'px;
								}
							}';
		
		//Body Fonts
		$body_font=$options['body_font_typography']['font-family'];
        $body_font=!empty($body_font)?$body_font:'Roboto';
		//$body_font_color=$options['body_font_typography']['color'];
        //$body_font_color=!empty($body_font_color)?$body_font_color:'#333333';
		$body_font_spacing=$options['body_font_typography']['letter-spacing'];
        $body_font_spacing=!empty($body_font_spacing)?$body_font_spacing:'0px';
		$body_font_backup=$options['body_font_typography']['font-backup'];
        $body_font_backup=!empty($body_font_backup)?$body_font_backup:$body_font;
		$body_font_word=$options['body_font_typography']['word-spacing'];
        $body_font_word=!empty($body_font_word)?$body_font_word:'';
		//Heading Fonts
        $heading_font=$options['heading_font_typography']['font-family'];
        $heading_font=!empty($heading_font)?$heading_font:'Roboto Condensed';
		//$heading_font_color=$options['body_font_typography']['color'];
        //$heading_font_color=!empty($heading_font_color)?$heading_font_color:'#cccccc';
		$heading_font_spacing=$options['heading_font_typography']['letter-spacing'];
        $heading_font_spacing=!empty($heading_font_spacing)?$heading_font_spacing:'0px';
		$heading_font_backup=$options['heading_font_typography']['font-backup'];
        $heading_font_backup=!empty($heading_font_backup)?$heading_font_backup:$heading_font;
		$heading_font_word=$options['heading_font_typography']['word-spacing'];
        $heading_font_word=!empty($heading_font_word)?$heading_font_word:'';
		//Meta Fonts
        $metatext_date_font=$options['metatext_date_font_typography']['font-family'];
        $metatext_date_font=!empty($metatext_date_font)?$metatext_date_font:'Volkhov';
		//$metatext_date_font_color=$options['body_font_typography']['color'];
        //$metatext_date_font_color=!empty($metatext_date_font_color)?$metatext_date_font_color:'#ffffff';
		$metatext_date_font_spacing=$options['metatext_date_font_typography']['letter-spacing'];
        $metatext_date_font_spacing=!empty($metatext_date_font_spacing)?$metatext_date_font_spacing:'0';
		$metatext_date_font_backup=$options['metatext_date_font_typography']['font-backup'];
        $metatext_date_font_backup=!empty($metatext_date_font_backup)?$metatext_date_font_backup:$metatext_date_font;
		$metatext_date_font_word=$options['metatext_date_font_typography']['word-spacing'];
        $metatext_date_font_word=!empty($metatext_date_font_word)?$metatext_date_font_word:'0';
                 echo 'h1,h2,h3,h4,h5,h6,body,.event-item .event-detail h4,.site-footer-bottom{
                                    font-family:"' .$body_font .'","'.$body_font_backup.'";
										letter-spacing:'.$body_font_spacing.';
										word-spacing:'.$body_font_word.';
                                    }';
                  echo 'h4,.title-note,.btn,.top-navigation,.navigation,.notice-bar-title strong,.timer-col #days, .timer-col #hours, .timer-col #minutes, .timer-col #seconds,.event-date,.event-date .date,.featured-sermon .date,.page-header h1,.timeline > li > .timeline-badge span,.woocommerce a.button, .woocommerce button.button, .woocommerce input.button, .woocommerce #respond input#submit, .woocommerce #content input.button, .woocommerce-page a.button, .woocommerce-page button.button, .woocommerce-page input.button, .woocommerce-page #respond input#submit, .woocommerce-page #content input.button{
                                    font-family:"' .$heading_font .'","'.$heading_font_backup.'";
										letter-spacing:'.$heading_font_spacing.';
										word-spacing:'.$heading_font_word.';
                                    }';
                   echo 'blockquote p,.cursive,.meta-data,.fact{
                                    font-family:"' .$metatext_date_font .'","'.$metatext_date_font_backup.'";
										letter-spacing:'.$metatext_date_font_spacing.';
										word-spacing:'.$metatext_date_font_word.';
                                    }';
        // USER STYLES
        if ($custom_css) {
            echo "\n" . '/*========== User Custom CSS Styles ==========*/' . "\n";
            echo $custom_css;
        }
        // CLOSE STYLE TAG
        echo "</style>" . "\n";
    }
    add_action('wp_head', 'imic_custom_styles');
}
/* CUSTOM JS OUTPUT
  ================================================== */
if (!function_exists('imic_custom_script')) {
    function imic_custom_script() {
        $options = get_option('imic_options');
        $custom_js = $options['custom_js'];
        if ($custom_js) {
            echo'<script type ="text/javascript">';
            echo $custom_js;
            echo '</script>';
        }
    }
    add_action('wp_footer', 'imic_custom_script');
}
/* SHORTCODE FIX
  ================================================== */
if (!function_exists('imic_content_filter')) {
    function imic_content_filter($content) {
        // array of custom shortcodes requiring the fix 
        $block = join("|", array("imic_button", "icon", "iconbox", "imic_image", "anchor", "paragraph", "divider", "heading", "alert", "blockquote", "dropcap", "code", "label", "container", "spacer", "span", "one_full", "one_half", "one_third", "one_fourth", "one_sixth","two_third", "progress_bar", "imic_count", "imic_tooltip", "imic_video", "htable", "thead", "tbody", "trow", "thcol", "tcol", "pricing_table", "pt_column", "pt_package", "pt_button", "pt_details", "pt_price", "list", "list_item", "list_item_dt", "list_item_dd", "accordions", "accgroup", "acchead", "accbody", "toggles", "togglegroup", "togglehead", "togglebody", "tabs", "tabh", "tab", "tabc", "tabrow", "section", "page_first", "page_last", "page", "modal_box", "imic_form", "fullcalendar", "staff","fullscreenvideo","event_calender"));
        // opening tag
        $rep = preg_replace("/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", "[$2$3]", $content);
        // closing tag
        $rep = preg_replace("/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", "[/$2]", $rep);
        return $rep;
    }
    add_filter("the_content", "imic_content_filter");
}
/* VIDEO EMBED FUNCTIONS
  ================================================== */
if (!function_exists('imic_video_embed')) {
    function imic_video_embed($url, $width = 200, $height = 150) {
        if (strpos($url, 'youtube') || strpos($url, 'youtu.be')) {
            return imic_video_youtube($url, $width, $height);
        } else {
            return imic_video_vimeo($url, $width, $height);
        }
    }
}
/* Video Youtube
  ================================================== */
if (!function_exists('imic_video_youtube')) {
    function imic_video_youtube($url, $width = 200, $height = 150) {
        if (stristr($url,'youtu.be/'))
        { preg_match('/(https:|http:|)(\/\/www\.|\/\/|)(.*?)\/(.{11})/i', $url, $video_id); return '<iframe itemprop="video" src="http://www.youtube.com/embed/' . $video_id[4] . '?wmode=transparent&autoplay=0" width="' . $width . '" height="' . $height . '" ></iframe>'; }
    else 
        { preg_match('/(https:|http:|):(\/\/www\.|\/\/|)(.*?)\/(embed\/|watch\?v=|(.*?)&v=|v\/|e\/|.+\/|watch.*v=|)([a-z_A-Z0-9]{11})/i', $url, $video_id); return '<iframe itemprop="video" src="http://www.youtube.com/embed/' . $video_id[6] . '?wmode=transparent&autoplay=0" width="' . $width . '" height="' . $height . '" ></iframe>';
		}
    }
}
/* Video Vimeo
  ================================================== */
if (!function_exists('imic_video_vimeo')) {
   function imic_video_vimeo($url, $width = 200, $height = 150) {
        preg_match('/https?:\/\/vimeo.com\/(\d+)$/', $url, $video_id);
        return '<iframe src="//player.vimeo.com/video/' . $video_id[1] . '?title=0&amp;byline=0&amp;autoplay=0&amp;portrait=0" width="' . $width . '" height="' . $height . '" allowfullscreen></iframe>';
    }
}
/* REGISTER SIDEBARS
  ================================================== */
if (!function_exists('imic_register_sidebars')) {
    function imic_register_sidebars() {
        if (function_exists('register_sidebar')) {
			$options = get_option('imic_options');
			$footer_class = $options["footer_layout"];
            register_sidebar(array(
                'name' => __('Home Page Sidebar', 'framework'),
                'id' => 'main-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h3 class="widgettitle">',
                'after_title' => '</h3>'
            ));
            register_sidebar(array(
                'name' => __('Contact Sidebar', 'framework'),
                'id' => 'contact-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="sidebar-widget-title"><h3 class="widgettitle">',
                'after_title' => '</h3></div>'
            ));
            register_sidebar(array(
                'name' => __('Inner Page Sidebar', 'framework'),
                'id' => 'inner-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="sidebar-widget-title"><h3 class="widgettitle">',
                'after_title' => '</h3></div>'
            ));
            register_sidebar(array(
                'name' => __('Sermons Sidebar', 'framework'),
                'id' => 'sermons-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="sidebar-widget-title"><h3 class="widgettitle">',
                'after_title' => '</h3></div>'
            ));
            register_sidebar(array(
                'name' => __('Event Page Sidebar', 'framework'),
                'id' => 'event-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="sidebar-widget-title"><h3 class="widgettitle">',
                'after_title' => '</h3></div>'
            ));
            register_sidebar(array(
                'name' => __('Single Event Page Sidebar', 'framework'),
                'id' => 'single-event-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div id="%1$s" class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="sidebar-widget-title"><h3 class="widgettitle">',
                'after_title' => '</h3></div>'
            ));
            register_sidebar(array(
                'name' => __('Post Sidebar', 'framework'),
                'id' => 'post-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div class="widget sidebar-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<div class="sidebar-widget-title"><h3>',
                'after_title' => '</h3></div>'
            ));
            register_sidebar(array(
                'name' => __('Footer Sidebar', 'framework'),
                'id' => 'footer-sidebar',
                'description' => '',
                'class' => '',
                'before_widget' => '<div class="col-md-'.$footer_class.' col-sm-'.$footer_class.' widget footer-widget %2$s">',
                'after_widget' => '</div>',
                'before_title' => '<h4 class="footer-widget-title">',
                'after_title' => '</h4>'
            ));
        }
    }
    add_action('init', 'imic_register_sidebars', 35);
}
/* EVENT GRID FUNCTION
  ================================================== */
function imic_event_grid() {
	$EventTerm = '';
	$offset = get_option('timezone_string');
		if($offset=='') { $offset = "Australia/Melbourne"; }
	date_default_timezone_set($offset);
    echo '<div class="listing events-listing">
	<header class="listing-header">
		<div class="row">
			<div class="col-md-6 col-sm-6">
				<h3>' . __('All events', 'framework') . '</h3>
		  </div>
		  <div class="listing-header-sub col-md-6 col-sm-6">';
    $currentEventTime = $_POST['date'];
	$EventTerm = $_POST['term'];
    $prev_month = date('Y-m', strtotime('-1 month', strtotime($currentEventTime)));
    $next_month = date('Y-m', strtotime('+1 month', strtotime($currentEventTime)));
    echo '<h5>' . date_i18n('F', strtotime($currentEventTime)) . '</h5>
				<nav class="next-prev-nav">
					<a href="javascript:" class="upcomingEvents" rel="'.$EventTerm.'" id="' . $prev_month . '"><i class="fa fa-angle-left"></i></a>
					<a href="javascript:" class="upcomingEvents" rel="'.$EventTerm.'" id="' . $next_month . '"><i class="fa fa-angle-right"></i></a>
				</nav>
		  </div>
	  </div>
	</header>
	<section class="listing-cont">
	  <ul>';
    $today = date('Y-m');
	$curr_month = date('Y-m-t', strtotime('-1 month', strtotime($currentEventTime)));
    $currentTime = date(get_option('time_format'));
    query_posts(array(
        'post_type' => 'event',
		'event-category'=>$EventTerm,
        'meta_key' => 'imic_event_start_dt',
        'meta_query' => array(
            'relation' => 'AND',
			array(
                'key' => 'imic_event_frequency_end',
                'value' => $curr_month,
                'compare' => '>'
            ),
            array(
                'key' => 'imic_event_start_dt',
                'value' => date('Y-m-t 23:59', strtotime($currentEventTime)),
                'compare' => '<='
            )),
        'orderby' => 'meta_value',
        'order' => 'ASC',
        'posts_per_page' => -1
            )
    );
    $count = 0;
	$sinc = 1;
	$sp = array();
    if (have_posts()) {
        while (have_posts()):the_post();
            $custom_event = get_post_custom(get_the_ID());
            $eventStartDate = strtotime(get_post_meta(get_the_ID(),'imic_event_start_dt',true));
            $eventStartTime = strtotime(get_post_meta(get_the_ID(),'imic_event_start_tm',true));
            $eventMonth = date('n', $eventStartDate);
			$frequency = get_post_meta(get_the_ID(),'imic_event_frequency',true);
			$frequency_count = '';
			$frequency_count = get_post_meta(get_the_ID(),'imic_event_frequency_count',true);
			if($frequency>0) { $frequency_count = $frequency_count; } else { $frequency_count = 0; }
			$seconds = $frequency*86400;
			$sai = 0;
			while($sai<=$frequency_count) {
			$icon = "";
			$eventStartDate = $custom_event['imic_event_start_dt'][0];
			$eventStartTime = $custom_event['imic_event_start_tm'][0];
			$eventStartDate = strtotime($eventStartDate.' '.$eventStartTime);
			if($frequency==30) {
			$eventStartDate = strtotime("+".$sai." month", $eventStartDate);
			}
			else {
			$sv = $sai*$seconds;
			$eventStartDate = $eventStartDate+$sv;
			}
			$sn = date('Y-m-t 23:59',strtotime($currentEventTime));
			$month_start_date = date('Y-m-1',strtotime($currentEventTime));
			if($eventStartDate>=strtotime($month_start_date)&&($eventStartDate<=strtotime($sn))) {
            if (strtotime($currentEventTime) == strtotime($today)) {
                if ($eventStartDate == strtotime(date('Y-m-d'))) {
                    if ($eventStartTime > strtotime($currentTime)) {
						$sp[$eventStartDate+$sinc] = get_the_ID();
						$sinc++;
                        $count++;
                    }
                } elseif ($eventStartDate > strtotime(date('Y-m-d'))) {
					$sp[$eventStartDate+$sinc] = get_the_ID();
						$sinc++;
                    $count++;
                }
            } else {
				$sp[$eventStartDate+$sinc] = get_the_ID();
						$sinc++;
                $count++;
            } } $sai++; }
        endwhile; 
    }if ($count == 0) {
        echo '<li class="item event-item">	
			  <div class="event-detail">
				<h4>' . __('Sorry, there are no events for this month.', 'framework') . '</h4>
			  </div>
			</li>';
    } ksort($sp);
	foreach($sp as $key =>$value) {
              	$frequency = get_post_meta($value, 'imic_event_frequency', true);
       	$frequency_count = get_post_meta($value, 'imic_event_frequency_count', true);
		switch($frequency) {
			case 1:
			$recur = 'Every Day';
			break;
			case 2:
			$recur = 'Every Second Day';
			break;
			case 3:
			$recur = 'Every Third Day';
			break;
			case 4:
			$recur = 'Every Fourth Day';
			break;
			case 5:
			$recur = 'Every Fifth Day';
			break;
			case 6:
			$recur = 'Every Sixth Day';
			break;
			case 7:
			$recur = 'Every Week';
			break;
			case 30:
			$recur = 'Every Month';
			break;
		}   
				$satime = get_post_meta($value,'imic_event_start_tm',true);
				$satime = strtotime($satime);
                                $date_converted=date('Y-m-d',$key );
                                $custom_event_url =  imic_query_arg($date_converted,$value);
                                echo '<li class="item event-item">	
				  <div class="event-date"> <span class="date">' . date_i18n('d', $key) . '</span> <span class="month">' .imic_global_month_name($key). '</span> </div>
				  <div class="event-detail">
                                      <h4><a href="'.$custom_event_url.'">' . get_the_title($value) .'</a>'.imicRecurrenceIcon($value).'</h4>';
                $stime = '';
                if ($satime != '') {
                    $stime = ' | ' . date(get_option('time_format'), $satime);
                }
                echo '<span class="event-dayntime meta-data">' . date_i18n('l', $key) . $stime . '</span> </div>
				  <div class="to-event-url">
					<div><a href="' .$custom_event_url.'" class="btn btn-default btn-sm">' . __('Details', 'framework') . '</a></div>
				  </div>
				</li>';
	}
    echo '</ul>
	</section>
  </div>';
    die();
}
add_action('wp_ajax_nopriv_imic_event_grid', 'imic_event_grid');
add_action('wp_ajax_imic_event_grid', 'imic_event_grid');
// get taxonomies terms links
if (!function_exists('imic_custom_taxonomies_terms_links')) {
    function imic_custom_taxonomies_terms_links() {
        global $post;
        // get post by post id
        $post = get_post($post->ID);
        // get post type by post
        $post_type = $post->post_type;
        // get post type taxonomies
        $taxonomies = get_object_taxonomies($post_type, 'objects');
        $out = array();
        foreach ($taxonomies as $taxonomy_slug => $taxonomy) {
            // get the terms related to post
            $terms = get_the_terms($post->ID, $taxonomy_slug);
            if (!empty($terms)) {
                $i = 1;
                foreach ($terms as $term) {
                    if ($i == 1) {
                        $out[] =
                                ' <a href="'
                                . get_term_link($term->slug, $taxonomy_slug) . '">'
                                . $term->name
                                . "</a>";
                    }
                    $i++;
                }
            }
        }
        return implode('', $out);
    }
}
//Manage Custom Columns for Event Post Type 
if (!function_exists('event_time_columns')) {
    add_filter('manage_edit-event_columns', 'event_time_columns');
    function event_time_columns($columns) {
        $columns['Event'] = __('Event', 'framework');
        $columns['Attendees'] = __('Attendees', 'framework');
        $columns['Staff'] = __('Staff', 'framework');
		$columns['Recurring'] = __('Recurring', 'framework');
        return $columns;
    }
}
if (!function_exists('event_time_column_content')) {
    add_action('manage_event_posts_custom_column', 'event_time_column_content', 10, 2);
    function event_time_column_content($column_name, $post_id) {
        switch ($column_name) {
            case 'Event':
                $sdate = get_post_meta($post_id, 'imic_event_start_dt', true);
                $stime = get_post_meta($post_id, 'imic_event_start_tm', true);
				$edate = get_post_meta($post_id, 'imic_event_end_dt', true);
                $etime = get_post_meta($post_id, 'imic_event_end_tm', true);
                echo '<abbr title="'.$sdate .' '.$stime.'">'.$sdate.'</abbr><br title="'.$edate.' '.$etime.'">'.$edate;
                break;
            case 'Attendees':
                $attendees = get_post_meta($post_id, 'imic_event_attendees', true);
                echo $attendees;
                break;
            case 'Staff':
                $staff = get_post_meta($post_id, 'imic_event_staff_members', true);
                echo $staff;
                break;
			case 'Recurring':
                $frequency = get_post_meta($post_id, 'imic_event_frequency', true);
				$frequency_count = get_post_meta($post_id, 'imic_event_frequency_count', true);
				if($frequency==1){ $sent = "Every Day"; }
				elseif($frequency==2){ $sent = "Every 2nd Day"; }
				elseif($frequency==3){ $sent = "Every 3rd Day"; }
				elseif($frequency==4){ $sent = "Every 4th Day"; }
				elseif($frequency==5){ $sent = "Every 5th Day"; }
				elseif($frequency==6){ $sent = "Every 6th Day"; }
				elseif($frequency==30){ $sent = "Every Month"; }
				else{ $sent = "Every week"; }
				if($frequency>0) {
                echo '<abbr title="'.$sent .' '.$sent.'">'.$sent.'</abbr><br>'.$frequency_count.' time';
				}
                break;
        }
    }
}
if (!function_exists('sortable_event_column')) {
    add_filter('manage_edit-event_sortable_columns', 'sortable_event_column');
    function sortable_event_column($columns) {
        $columns['Event'] = 'event';
        return $columns;
    }
}
if (!function_exists('event_time_orderby')) {
    add_action('pre_get_posts', 'event_time_orderby');
    function event_time_orderby($query) {
        if (!is_admin())
            return;
        $orderby = $query->get('orderby');
        if ('event' == $orderby) {
            $query->set('meta_key', 'imic_event_start_dt');
            $query->set('orderby', 'meta_value');
        }
    }
}
/**
 * Sidebar Meta Box.
 * @since NativeChurch 1.2
 */
if (!function_exists('imic_get_all_sidebars')) {
    function imic_get_all_sidebars() {
        $all_sidebars = array();
        global $wp_registered_sidebars;
        $all_sidebars = array('' => '');
        foreach ($wp_registered_sidebars as $sidebar) {
            $all_sidebars[$sidebar['id']] = $sidebar['name'];
        }
        return $all_sidebars;
    }
}
if (!function_exists('imic_register_meta_box')) {
    add_action('admin_init', 'imic_register_meta_box');
    function imic_register_meta_box() {
        // Check if plugin is activated or included in theme
        if (!class_exists('RW_Meta_Box'))
            return;
        $prefix = 'imic_';
        $meta_box = array(
            'id' => 'select_sidebar',
            'title' => __("Select Sidebar", 'framework'),
            'pages' => array('post', 'page', 'event', 'sermons', 'staff', 'product', 'causes'),
            'context' => 'normal',
            'fields' => array(
                array(
                    'name' => 'Select Sidebar from list',
                    'id' => $prefix . 'select_sidebar_from_list',
                    'desc' => __("Select Sidebar from list", 'framework'),
                    'type' => 'select',
                    'options' => imic_get_all_sidebars(),
                ),
            )
        );
        new RW_Meta_Box($meta_box);
    }
}
//Manage Staff Post Type Menu Order Column
function add_new_staff_column($header_text_columns) {
  $header_text_columns['menu_order'] = "Order";
  return $header_text_columns;
}
add_action('manage_edit-staff_columns', 'add_new_staff_column');
function show_order_column($name){
  global $post;
  switch ($name) {
    case 'menu_order':
      $order = $post->menu_order;
      echo $order;
      break;
   default:
      break;
   }
}
add_action('manage_staff_posts_custom_column','show_order_column');
function order_column_register_sortable($columns){
  $columns['menu_order'] = 'menu_order';
  return $columns;
}
add_filter('manage_edit-staff_sortable_columns','order_column_register_sortable');
function afterSavePost()
{
	if(isset($_GET['post']))
	 { 
	 $postId = $_GET['post'];
	$post_type = get_post_type($postId);
	if($post_type=='event')
	{
		
		$sdate = get_post_meta($postId,'imic_event_start_dt',true);
		$end_event_date = get_post_meta($postId,'imic_event_end_dt',true);
		if($end_event_date=='') { update_post_meta($postId,'imic_event_end_dt',$sdate); }
		$frequency = get_post_meta($postId,'imic_event_frequency',true);
		$frequency_count = get_post_meta($postId,'imic_event_frequency_count',true);
		$value = strtotime($sdate);
		if($frequency==30) {
		$svalue = strtotime("+".$frequency_count." month", $value);
		$suvalue = date('Y-m-d',$svalue);
		}
		else {
		$svalue = $frequency*$frequency_count*86400;
		$suvalue = $svalue+$value;
		$suvalue = date('Y-m-d',$suvalue);
		}
		update_post_meta($postId,'imic_event_frequency_end',$suvalue);
	} }
}
afterSavePost();
//Add New Custom Menu Option
if ( !class_exists('IMIC_Custom_Nav')) {
class IMIC_Custom_Nav {
public function add_nav_menu_meta_boxes() {
   
add_meta_box(
'mega_nav_link',
__('Mega Menu','framework'),
array( $this, 'nav_menu_link'),
'nav-menus',
'side',
'low'
);
}
public function nav_menu_link() {
    
     global $_nav_menu_placeholder, $nav_menu_selected_id;
	$_nav_menu_placeholder = 0 > $_nav_menu_placeholder ? $_nav_menu_placeholder - 1 : -1;
    
        ?>
<div id="posttype-wl-login" class="posttypediv">
<div id="tabs-panel-wishlist-login" class="tabs-panel tabs-panel-active">
<ul id ="wishlist-login-checklist" class="categorychecklist form-no-clear">
<li>
<label class="menu-item-title">
<input type="checkbox" class="menu-item-object-id" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-object-id]" value="<?php echo $_nav_menu_placeholder; ?>"> <?php _e('Create Column','framework'); ?>
</label>
    <input type="hidden" class="menu-item-db-id" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-db-id]" value="0">
    <input type="hidden" class="menu-item-object" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-object]" value="page">
<input type="hidden" class="menu-item-parent-id" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-parent-id]" value="0">
   <input type="hidden" class="menu-item-type" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-type]" value="">
<input type="hidden" class="menu-item-title" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-title]" value="<?php _e('Column','framework'); ?>">
<input type="hidden" class="menu-item-classes" name="menu-item[<?php echo $_nav_menu_placeholder; ?>][menu-item-classes]" value="custom_mega_menu">
</li>
</ul>
</div>
<p class="button-controls">
<span class="add-to-menu">
<input type="submit" class="button-secondary submit-add-to-menu right" value="<?php _e('Add to Menu','framework'); ?>" name="add-post-type-menu-item" id="submit-posttype-wl-login">
<span class="spinner"></span>
</span>
</p>
</div>
<?php }
}
}
$custom_nav = new IMIC_Custom_Nav;
add_action('admin_init', array($custom_nav, 'add_nav_menu_meta_boxes'));
//Get All Post Types
if(!function_exists('imic_get_all_types')){
add_action( 'wp_loaded', 'imic_get_all_types');
function imic_get_all_types(){
   $args = array(
   'public'   => true,
   );
$output = 'names'; // names or objects, note names is the default
return $post_types = get_post_types($args, $output); 
}
}
//Get Days Diff
if(!function_exists('imic_day_diff')){
function imic_day_diff($value) {
    $endEventTemp = get_post_meta($value, 'imic_event_end_dt', true);
    $startEventTemp = get_post_meta($value, 'imic_event_start_dt', true);
    $timeTemp = get_post_meta($value, 'imic_event_start_tm', true);
	$timeTemp = strtotime($timeTemp);
	$timeTemp = date(get_option('time_format'),$timeTemp);
    $endEventTemp = $endEventTemp . ' ' . $timeTemp;
    $startEventTemp = $startEventTemp . ' ' . $timeTemp;
    $endEventTemp = strtotime($endEventTemp);
    $startEventTemp = strtotime($startEventTemp);
    $daysTemp = $endEventTemp - $startEventTemp;
    $daysTemp = $daysTemp / 86400;
    return $daysTemp = floor($daysTemp);
}
}
//Attachment Meta Box
if(!function_exists('imic_attachment_url')){
function imic_attachment_url( $fields, $post ) {
$meta = get_post_meta($post->ID, 'meta_link', true);
$fields['meta_link'] = array(
'label' => __('Image URL','framework'),
'input' => 'text',
'value' => $meta,
'show_in_edit' => true,
);
return $fields;
}
add_filter( 'attachment_fields_to_edit', 'imic_attachment_url', 10, 2 );
}
/**
* Update custom field on save
*/
if(!function_exists('imic_update_attachment_url')){
function imic_update_attachment_url($attachment){
global $post;
update_post_meta($post->ID, 'meta_link', $attachment['attachments'][$post->ID]['meta_link']);
return $attachment;
}
add_filter( 'attachment_fields_to_save', 'imic_update_attachment_url', 4);
}
/**
* Update custom field via ajax
*/
if(!function_exists('imic_save_attachment_url')){
function imic_save_attachment_url() {
$post_id = $_POST['id'];
$meta = $_POST['attachments'][$post_id ]['meta_link'];
update_post_meta($post_id , 'meta_link', $meta);
clean_post_cache($post_id);
}
add_action('wp_ajax_save-attachment-compat', 'imic_save_attachment_url', 0, 1);
}
//Get Attachment Fields
if(!function_exists('imic_wp_get_attachment')){
function imic_wp_get_attachment( $attachment_id ) {
	$attachment = get_post( $attachment_id );
	return array(
		'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
		'caption' => $attachment->post_excerpt,
		'description' => $attachment->post_content,
		'href' => get_permalink( $attachment->ID ),
		'src' => $attachment->guid,
		'title' => $attachment->post_title,
		'url' => $attachment->meta_link
	);
}
}
/* -------------------------------------------------------------------------------------
  Get Recursive Event Data.
  @since NativeChurch 1.4
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_get_recursive_event_data')) {
    function imic_get_recursive_event_data($menuposttype, $menupost, $p = '') {
        $event_add_menu = array();
        $sinc = 1;
        $item_output = '';
        $today_menu = date('Y-m-d');
        $posts_event = get_posts(array('post_type' => $menuposttype, 'p' => $p, 'post_status' => 'publish', 'meta_key' => 'imic_event_start_dt', 'suppress_filters' => false, 'meta_query' => array(array('key' => 'imic_event_frequency_end', 'value' => $today_menu, 'compare' => '>=')), 'orderby' => 'meta_value', 'order' => 'ASC', 'posts_per_page' => $menupost));
        if (!empty($posts_event)) {
            foreach ($posts_event as $event_post_data) {
                $eventDate = strtotime(get_post_meta($event_post_data->ID, 'imic_event_start_dt', true));
                $eventTime = get_post_meta($event_post_data->ID, 'imic_event_start_tm', true);
               
                $frequency = get_post_meta($event_post_data->ID, 'imic_event_frequency', true);
                $frequency_count = '';
                $frequency_count = get_post_meta($event_post_data->ID, 'imic_event_frequency_count', true);
                if ($frequency > 0) {
                    $frequency_count = $frequency_count;
                } 
                else { $frequency_count = 0; }
                $seconds = $frequency * 86400;
                $fr_repeat = 0;
                while ($fr_repeat <= $frequency_count) {
                    $eventDate = get_post_meta($event_post_data->ID, 'imic_event_start_dt', true);
                    $eventDate = strtotime($eventDate);
                    if($frequency==30) {
			$eventDate = strtotime("+".$fr_repeat." month", $eventDate);
			}
			else {
            $new_date = $seconds * $fr_repeat;
            $eventDate = $eventDate + $new_date;
			}
                  
                    $date_sec = date('Y-m-d', $eventDate);
                    $exact_time = strtotime($date_sec . ' ' .$eventTime);
                    if ($exact_time >= date('U')) {
                        $event_add_menu[$eventDate + $sinc] = $event_post_data->ID;
                        $sinc++;
                    } $fr_repeat++;
                }
            }
            $nos_event_menu = 1;
            ksort($event_add_menu);
            foreach ($event_add_menu as $key => $value) {
                 $date_converted=date('Y-m-d',$key );
                $custom_event_url= imic_query_arg($date_converted,$value);
            $recurrence = get_post_meta($value, 'imic_event_frequency', true);
                if ($recurrence > 0) {
                    $icon = ' <i class="fa fa-refresh" style="font-size:80%;" title="'.__('Recurring','framework').'"></i>';
                } else {
                    $icon = '';
                }
                $eventDataTitle = get_the_title($value);
                $eventDataURL = $custom_event_url;
                
                $day = date_i18n('l', $key). ' |';
                $eventStartTime = get_post_meta($value, 'imic_event_start_tm', true);
                $eventTime = get_post_meta($value, 'imic_event_start_tm', true);
                $eventTime = strtotime($eventTime);
                $stime = '';
                if ($eventTime != '') {
                    $stime = date_i18n(get_option('time_format'), $eventTime);
                }
                $item_output.='<li>';
                $item_output.='<a href="' . $eventDataURL . '">' . $eventDataTitle . $icon . '</a>';
                $item_output.= '<span class="meta-data">' . $day . '  ' . $stime . '</span>';
                $item_output.='</li>';
                if (++$nos_event_menu > $menupost)
                    break;
            }
        }
        return $item_output;
    }
}
/* -------------------------------------------------------------------------------------
  Get Cat List.
  @since NativeChurch 1.4
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_get_cat_list')) {
    function imic_get_cat_list() {
        $amp_categories_obj = get_categories('exclude=1');
         
        $amp_categories = array();
        if(count($amp_categories_obj)>0){
        foreach ($amp_categories_obj as $amp_cat) {
            $amp_categories[$amp_cat->cat_ID] = $amp_cat->name;
        }}
        return $amp_categories;
    }
}
/* -------------------------------------------------------------------------------------
  Filter the Widget Title.
  @since NativeChurch 1.4
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_widget_titles')) {
    add_filter('dynamic_sidebar_params', 'imic_widget_titles', 20);
    function imic_widget_titles(array $params) {
        // $params will ordinarily be an array of 2 elements, we're only interested in the first element
        $widget = & $params[0];
        $id = $params[0]['id'];
        if ($id == 'footer-sidebar') {
            $widget['before_title'] = '<h4 class="widgettitle">';
            $widget['after_title'] = '</h4>';
        } else {
            $widget['before_title'] = '<div class="sidebar-widget-title"><h3 class="widgettitle">';
            $widget['after_title'] = '</h3></div>';
        }
        return $params;
    }
}
/* -------------------------------------------------------------------------------------
  Filter the Widget Text.
  @since NativeChurch 1.4
  ----------------------------------------------------------------------------------- */
add_filter('widget_text', 'do_shortcode');
/* -------------------------------------------------------------------------------------
Month Translate in Default.
  @since NativeChurch 1.4
  ----------------------------------------------------------------------------------- */
    if(!function_exists('imic_month_translate')){
function imic_month_translate( $str ) {
  
	$options = get_option('imic_options');
       $months = $options["calendar_month_name"];
    $months = explode(',',$months);
  if(count($months)<=1){
  $months = array("January","February","March","April","May","June","July","August","September","October","November","December");
}
$sb = array();
foreach($months as $month) { $sb[] = $month; } 
    $engMonth = array("January","February","March","April","May","June","July","August","September","October","November","December");
    $trMonth = $sb;
    $converted = str_replace($engMonth, $trMonth, $str);
    return $converted;
    }
    /* -------------------------------------------------------------------------------------
  Filter the  Month name of Post.
  @since NativeChurch 1.4
  ----------------------------------------------------------------------------------- */
add_filter( 'get_the_time', 'imic_month_translate' );
add_filter( 'the_date', 'imic_month_translate' );
add_filter( 'get_the_date', 'imic_month_translate' );
add_filter( 'comments_number', 'imic_month_translate' );
add_filter( 'get_comment_date', 'imic_month_translate' );
add_filter( 'get_comment_time', 'imic_month_translate' );
add_filter( 'date_i18n', 'imic_month_translate' );
}
/* -------------------------------------------------------------------------------------
  Short Month Translate in Default.
  @since NativeChurch 1.4
  ----------------------------------------------------------------------------------- */
if(!function_exists('imic_short_month_translate')){
function imic_short_month_translate( $str ) {
    
       $options = get_option('imic_options');
       $months = $options["calendar_month_name_short"];
    $months = explode(',',$months);
  if(count($months)<=1){
  $months = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
}
$sb = array();
foreach($months as $month) { $sb[] = $month; } 
    $engMonth = array("/\bJan\b/","/\bFeb\b/","/\bMar\b/","/\bApr\b/","/\bMay\b/","/\bJun\b/","/\bJul\b/","/\bAug\b/","/\bSep\b/","/\bOct\b/","/\bNov\b/","/\bDec\b/");
    $trMonth = $sb;
    $converted = preg_replace($engMonth, $trMonth, $str);
    return $converted;
}
/* -------------------------------------------------------------------------------------
  Filter the  Sort Month name of Post.
  @since NativeChurch 1.4
  ----------------------------------------------------------------------------------- */
add_filter( 'get_the_time', 'imic_short_month_translate' );
add_filter( 'the_date', 'imic_short_month_translate' );
add_filter( 'get_the_date', 'imic_short_month_translate' );
add_filter( 'comments_number', 'imic_short_month_translate' );
add_filter( 'get_comment_date', 'imic_short_month_translate' );
add_filter( 'get_comment_time', 'imic_short_month_translate' );
add_filter( 'date_i18n', 'imic_short_month_translate' );
}
 if(!function_exists('imic_day_translate')){
function imic_day_translate( $str ) {
	$options = get_option('imic_options');
       $days = $options["calendar_day_name"];
    $days = explode(',',$days);
  if(count($days)<=1){
  $days = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
}
$sb = array();
foreach($days as $month) { $sb[] = $month; } 
    $engDay = array("Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday");
    $trDay = $sb;
    $converted = str_replace($engDay, $trDay, $str);
    return $converted;
    }
    /* -------------------------------------------------------------------------------------
  Filter the  Day name of Post.
  @since NativeChurch 1.4
  ----------------------------------------------------------------------------------- */
add_filter('date_i18n', 'imic_day_translate');
}
 /* -------------------------------------------------------------------------------------
  Global Month Name.
  @since NativeChurch 1.4
  ----------------------------------------------------------------------------------- */
if(!function_exists('imic_global_month_name')){
function imic_global_month_name($key){
    return date_i18n("M",$key);
}}
/* -------------------------------------------------------------------------------------
  RevSlider ShortCode
  @since NativeChurch 1.4
  ----------------------------------------------------------------------------------- */
if(!function_exists('RevSliderShortCode')){
function RevSliderShortCode(){
     $slidernames = array();
    if(class_exists('RevSlider')){
     $sld = new RevSlider();
                $sliders = $sld->getArrSliders();
        if(!empty($sliders)){
           
        foreach($sliders as $slider){
          $title=$slider->getParam('title','false');
           $shortcode=$slider->getParam('shortcode','false');
            $slidernames[$shortcode]=$title;
        }}
           
}
return $slidernames;
        }}
/** -------------------------------------------------------------------------------------
 * Gallery Flexslider
 * @since NativeChurch 1.5
 * @param ID of current Post.
 * @return Div with flexslider parameter.
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_gallery_flexslider')) {
    function imic_gallery_flexslider($id) {
		$speed = (get_post_meta(get_the_ID(), 'imic_gallery_slider_speed', true)!='')?get_post_meta(get_the_ID(), 'imic_gallery_slider_speed', true):5000;
        $pagination = get_post_meta(get_the_ID(), 'imic_gallery_slider_pagination', true);
        $auto_slide = get_post_meta(get_the_ID(), 'imic_gallery_slider_auto_slide', true);
        $direction = get_post_meta(get_the_ID(), 'imic_gallery_slider_direction_arrows', true);
        $effect = get_post_meta(get_the_ID(), 'imic_gallery_slider_effects', true);
        $pagination = !empty($pagination) ? $pagination : 'yes';
        $auto_slide = !empty($auto_slide) ? $auto_slide : 'yes';
        $direction = !empty($direction) ? $direction : 'yes';
        $effect = !empty($effect) ? $effect : 'slide';
        echo '<div class="flexslider" data-autoplay="' . $auto_slide . '" data-pagination="' . $pagination . '" data-arrows="' . $direction . '" data-style="' . $effect . '" data-pause="yes" data-speed='.$speed.'>';
    }
}
/** -------------------------------------------------------------------------------------
 * Sermons Audio
 * @since NativeChurch 1.6
 * @param ID of current Post.
 * @return Attach Full Audio Url.
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_sermon_attach_full_audio')) {
    function imic_sermon_attach_full_audio($id) {
                        $imic_sermons_audio_upload = get_post_meta($id, 'imic_sermons_audio_upload', true);
                        if($imic_sermons_audio_upload==1){
                          $imic_sermons_audio = get_post_meta($id, 'imic_sermons_audio', true);  
                          $attach_full_audio = wp_get_attachment_url($imic_sermons_audio);
                         }
                         else{
                            $imic_sermons_audio = get_post_meta($id, 'imic_sermons_url_audio', true);  
                          $attach_full_audio = $imic_sermons_audio;  
                         }
                         return $attach_full_audio;
    }
}
/** -------------------------------------------------------------------------------------
 * Sermons Pdf
 * @since NativeChurch 1.6
 * @param ID of current Post.
 * @return Attach Full Pdf Url.
  ----------------------------------------------------------------------------------- */
if (!function_exists('imic_sermon_attach_full_pdf')) {
    function imic_sermon_attach_full_pdf($id) {
                        $imic_sermons_pdf_upload_option = get_post_meta($id, 'imic_sermons_pdf_upload_option', true);
                        if($imic_sermons_pdf_upload_option==1){
                          $imic_sermons_pdf = get_post_meta($id, 'imic_sermons_Pdf', true);  
                         $attach_pdf = wp_get_attachment_url($imic_sermons_pdf);
                         }
                         else{
                          $attach_pdf = get_post_meta($id,'imic_sermons_pdf_by_url', true);  
                         }
                         return $attach_pdf;
    }
}
/** -------------------------------------------------------------------------------------
 * Add Query Arg
 * @since NativeChurch 1.6
 * @param  ID,param1,param2 of current Post.
 * @return  Url with Query arg which is passed default is event_date.
  ----------------------------------------------------------------------------------- */
if(!function_exists('imic_query_arg')){
 function imic_query_arg($date_converted,$id){
        $custom_event_url=add_query_arg('event_date',$date_converted,get_permalink($id));
    return $custom_event_url;
  }
}
/** -------------------------------------------------------------------------------------
 * Add Query Arg For Event Cat
 * @since NativeChurch 1.6
 * @param  ID,param1 of current Post.
 * @return  Url with Query arg which is passed.
  ----------------------------------------------------------------------------------- */
if(!function_exists('imic_query_arg_event_cat')){
 function imic_query_arg_event_cat($string,$url){
        $imic_event_category_page_url=add_query_arg('event_cat',$string,$url);
    return $imic_event_category_page_url;
        
    }
}
/** -------------------------------------------------------------------------------------
 * Query Var Filter
 * @since NativeChurch 1.6
 * @description event_date parameter is added to query_vars filter
----------------------------------------------------------------------------------- */
if(!function_exists('imicAddQueryVarsFilter')){
function imicAddQueryVarsFilter( $vars ){
  $vars[] = "event_date";
  $vars[] = "event_cat";
  $vars[] = "pg";
  return $vars;
}
add_filter('query_vars','imicAddQueryVarsFilter');
}
/** -------------------------------------------------------------------------------------
 * Convert the Format String from php to fullcalender
 * @see http://arshaw.com/fullcalendar/docs/utilities/formatDate/
 * @since NativeChurch 1.6
 * @param $format
----------------------------------------------------------------------------------- */
if(!function_exists('ImicConvertDate')){
	 function ImicConvertDate($format) {
	 	$format_rules = array('a'=>'tt',
			 'A'=>'TT',
			 'B'=>'',
			 'c'=>'u',
			 'd'=>'dd',
			 'D'=>'ddd',
			 'F'=>'MMMM',
			 'g'=>'h',
			 'G'=>'H',
			 'h'=>'hh',
			 'H'=>'HH',
			 'i'=>'mm',
			 'I'=>'',
			 'j'=>'d',
			 'l'=>'dddd',
			 'L'=>'',
			 'm'=>'MM',
			 'M'=>'MMM',
			 'n'=>'M',
			 'O'=>'',
			 'r'=>'',
			 's'=>'ss',
			 'S'=>'S',
			 't'=>'',
			 'T'=>'',
			 'U'=>'',
			 'w'=>'',
			 'W'=>'',
			 'y'=>'yy',
			 'Y'=>'yyyy',
			 'z'=>'',
			 'Z'=>'');
	 	  $ret = '';
	 	for ($i=0; $i<strlen($format); $i++) {
	 		if (isset($format_rules[$format[$i]])) {
	 			$ret .= $format_rules[$format[$i]];
	 		} else {
	 			$ret .= $format[$i];
	 		}
	 	}
	 	return $ret;
}}
/** -------------------------------------------------------------------------------------
 * Return 0 if category have any post
 * @since NativeChurch 1.6
 ----------------------------------------------------------------------------------- */
if(!function_exists('imic_cat_count_flag')){
function imic_cat_count_flag(){
    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
             $flag=1;
              if(!empty($term)){
                 $flag= $output=($term->count==0)?0:1;
              }
             global $cat;
             if(!empty($cat)){
                  $cat_data= get_category($cat);
                $flag=($cat_data->count==0)?0:1;
             }
             return $flag;
}}
/** -------------------------------------------------------------------------------------
 * Return sidebar and set page design 
 * @since NativeChurch 1.7
 ----------------------------------------------------------------------------------- */
if(!function_exists('imic_page_design')){
	function imic_page_design($id = '', $block=9){
		//Make page design according sidebar conditions
		$options = get_option('imic_options');
		$ID = (!empty($id) &&  $id != '')? $id : get_the_ID();
		$pageSidebar = get_post_meta($ID,'imic_select_sidebar_from_list', true);
		$post_type = get_post_type($ID);
		$sidebar_value = $sidebar = '';
		switch ($post_type) {
			case 'post':
				$sidebar_value = $options['post_sidebar'];
				break;
			case 'page':
				$sidebar_value = $options['page_sidebar'];
				break;
			case 'event':
				$sidebar_value = $options['event_sidebar'];
				break;
			case 'causes':
				$sidebar_value = $options['cause_sidebar'];
				break;
			case 'sermons':
				$sidebar_value = $options['sermon_sidebar'];
				break;
			case 'staff':
				$sidebar_value = $options['staff_sidebar'];
				break;
		}
		$classMain = 'col-md-'. $block;
		if(!empty($pageSidebar)){
			$sidebar = $pageSidebar;
		}else if(!empty($sidebar_value)){
			$sidebar = $sidebar_value;	
		}else{
			$classMain = 'col-md-12';	
		}		
		$pageDesign = array('class' => $classMain, 'sidebar' => $sidebar);
		return $pageDesign;		
	}
}
/** -------------------------------------------------------------------------------------
 * Return Recursive Event data 
 * @since NativeChurch 1.7
 ----------------------------------------------------------------------------------- */
if (!function_exists('imic_get_home_recursive_event_data')) {
function imic_get_home_recursive_event_data($specific_event_cat) {
$item_output = '';
$event_add_menu = array();
if(!empty($specific_event_cat)){
$event_cat_data= get_term_by('id',$specific_event_cat,'event-category');
$event_cat= $event_cat_data->slug;
$sinc = 1;
$today_specific = date('Y-m-d');
$posts_event = get_posts(array('post_type' => 'event', 'event-category' => $event_cat,'post_status' => 'publish', 'meta_key' => 'imic_event_start_dt', 'suppress_filters' => false, 'meta_query' => array(array('key' => 'imic_event_frequency_end', 'value' => $today_specific, 'compare' => '>=')), 'orderby' => 'meta_value', 'order' => 'ASC', 'posts_per_page' => -1));
if (!empty($posts_event)) {
foreach ($posts_event as $event_post_data) {
$eventDate = strtotime(get_post_meta($event_post_data->ID, 'imic_event_start_dt', true));
$eventTime = get_post_meta($event_post_data->ID, 'imic_event_start_tm', true);
$frequency = get_post_meta($event_post_data->ID, 'imic_event_frequency', true);
$frequency_count = '';
$frequency_count = get_post_meta($event_post_data->ID, 'imic_event_frequency_count', true);
if ($frequency > 0) {
    $frequency_count = $frequency_count;
} 
else { $frequency_count = 0; }
$seconds = $frequency * 86400;
$fr_repeat = 0;
while ($fr_repeat <= $frequency_count) {
$eventDate = get_post_meta($event_post_data->ID, 'imic_event_start_dt', true);
$eventDate = strtotime($eventDate);
if($frequency==30) {
$eventDate = strtotime("+".$fr_repeat." month", $eventDate);
}
else {
$new_date = $seconds * $fr_repeat;
$eventDate = $eventDate + $new_date;
}
$date_sec = date('Y-m-d', $eventDate);
$exact_time = strtotime($date_sec . ' ' .$eventTime);
if ($exact_time >= date('U')) {
$event_add_menu[$eventDate + $sinc] = $event_post_data->ID;
$sinc++;
} $fr_repeat++;
}
}
$nos_event_menu = 1;
ksort($event_add_menu);
foreach ($event_add_menu as $key => $value) {
$date_converted=date('Y-m-d',$key );
$custom_event_url= imic_query_arg($date_converted,$value);
$eventDataTitle = get_the_title($value);
$eventDataURL = $custom_event_url;
$item_output.='<h5>';
$item_output.='<a href="' . $eventDataURL . '">' . $eventDataTitle.'</a></h5>';
$item_output.= '<span class="meta-data">' .date_i18n( get_option( 'date_format' ),$key). '</span>';
$item_output.='</div>';
$eventTime = get_post_meta($value, 'imic_event_start_tm', true);
$eventTime = strtotime($eventTime);
$counter_time = date('h:i A',$eventTime);
$firstEventDateData = date('F j, Y', $key) . ' ' . $counter_time;
$item_output.='<div id="counter" class="col-md-4 col-sm-6 col-xs-12 counter" data-date="'.strtotime($firstEventDateData).'">';
if (++$nos_event_menu > 1)
    break;
}
}}
return $item_output;
}
}
/** -------------------------------------------------------------------------------------
 * Blog Template Redirect
 * @since NativeChurch 1.7
 ----------------------------------------------------------------------------------- */
if(!function_exists('imicBlogTemplateRedirect')){
function imicBlogTemplateRedirect()
{   
$page_for_posts= get_option('page_for_posts');  
//check by Blog
if(is_home()&&!empty($page_for_posts)){
$page_for_posts= get_option('page_for_posts');
$page_template= get_post_meta(get_option('page_for_posts'),'_wp_page_template',true);
if($page_template!='default'){
include (TEMPLATEPATH . '/'.$page_template);
exit;
}}
 }
// add our function to template_redirect hook
add_action('template_redirect', 'imicBlogTemplateRedirect');
}
/** -------------------------------------------------------------------------------------
 * 600x400 image for Thumbnail enable
 * 600x1000 image for Large image
 * @since NativeChurch 1.7
 ----------------------------------------------------------------------------------- */
add_image_size('600x400',600,400,true);
add_image_size('1000x800',1000,800,true);
/** -------------------------------------------------------------------------------------
 * Thumb And Large Size if Thumbnail enable
 * @since NativeChurch 1.7
 ----------------------------------------------------------------------------------- */
if(!function_exists('imicGetThumbAndLargeSize')){
function imicGetThumbAndLargeSize(){
global $imic_options;
if(isset($imic_options['switch-thumbnail'])&&($imic_options['switch-thumbnail']==1)){
$size_thumb ='600x400';
$size_large ='1000x800';
}else{
$size_thumb=$size_large='full';
}
return array($size_thumb,$size_large);
}}
/*AJAX LOGIN FORM FUNCTION
  ================================================================*/
if(!function_exists('ajax_login_init')) {
function ajax_login_init(){
    wp_register_script('ajax-login-script', get_template_directory_uri() . '/js/ajax-login-script.js', array('jquery') ); 
    wp_enqueue_script('ajax-login-script');
    wp_localize_script( 'ajax-login-script', 'ajax_login_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'loadingmessage' => __('Sending user info, please wait...','framework')
    ));
    add_action( 'wp_ajax_nopriv_ajaxlogin', 'ajax_login' );
}
if (!is_user_logged_in()) {
    add_action('init', 'ajax_login_init');
} }
if(!function_exists('ajax_login')) {
function ajax_login(){
    check_ajax_referer( 'ajax-login-nonce', 'security' );
    $info = array();
    $info['user_login'] = $_POST['username'];
    $info['user_password'] = $_POST['password'];
	if($_POST['rememberme']=='true') {
    $info['remember'] = true; }
	else{
	$info['remember'] = false; }
    $user_signon = wp_signon( $info, false );
    if ( is_wp_error($user_signon) ){
        echo json_encode(array('loggedin'=>false, 'message'=>__('Wrong username or password.','framework')));
    } else {
        echo json_encode(array('loggedin'=>true, 'message'=>__('Login successful, redirecting...','framework')));
    }
    die();
} }
/* Agent Register Funtion
  ================================================== */
function imic_agent_register() {
	if(!$_POST) exit;
	// Email address verification, do not edit.
	function isEmail($email) {
		return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
	}
	
	if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");
	
	$username     = $_POST['username'];
	$email    = $_POST['email'];
	$pwd1  = $_POST['pwd1'];
	$pwd2 = $_POST['pwd2'];
	
	if(trim($username) == '') {
		echo '<div class="alert alert-error">You must enter your username.</div>';
		exit();
	} else if(trim($email) == '') {
		echo '<div class="alert alert-error">You must enter email address.</div>';
		exit();
	} else if(!isEmail($email)) {
		echo '<div class="alert alert-error">You must enter a valid email address.</div>';
		exit();
	}else if(trim($pwd1) == '') {
		echo '<div class="alert alert-error">You must enter password.</div>';
		exit();
	}else if(trim($pwd2) == '') {
		echo '<div class="alert alert-error">You must enter repeat password.</div>';
		exit();
	}else if(trim($pwd1) != trim($pwd2)) {
		echo '<div class="alert alert-error">You must enter a same password.</div>';
		exit();
	}
	
	
	$err = '';
	$success = '';
	
	global $wpdb, $PasswordHash, $current_user, $user_ID;
	
	if (isset($_POST['task']) && $_POST['task'] == 'register') {
		$username = esc_sql(trim($_POST['username']));
		$pwd1 = esc_sql(trim($_POST['pwd1']));
		$pwd2 = esc_sql(trim($_POST['pwd2']));
		$email = esc_sql(trim($_POST['email']));
	   
		if ($email == "" || $pwd1 == "" || $pwd2 == "" || $username == "") {
			$err = 'Please don\'t leave the required fields.';
		} else if ($pwd1 <> $pwd2) {
			$err = 'Password do not match.';
		} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$err = 'Invalid email address.';
		} else if (email_exists($email)) {
			$err = 'Email already exist.';
		} else {
	
			$user_id = wp_insert_user(
							array(
								'user_pass' => apply_filters('pre_user_user_pass', $pwd1), 
								'user_login' => apply_filters('pre_user_user_login', $username), 
								'user_email' => apply_filters('pre_user_user_email', $email), 
								'role' => 'subscriber')
							);
							
			if (is_wp_error($user_id)) {
				$err = 'Error on user creation.';
			} else {
				do_action('user_register', $user_id);
				$success = 'You\'re successfully register';
                                $info_register = array();
                                $info_register['user_login'] = $username;
                                $info_register['user_password'] = $pwd1;
                                wp_signon( $info_register, false );
                               }
		}
	}
	
	if (!empty($err)) :
		echo '<div class="alert alert-error">' . $err . '</div>';
	endif;
	
	if (!empty($success)) :
		echo '<div class="alert alert-success">' . $success . '</div>';
	endif;
    die();
}
add_action('wp_ajax_nopriv_imic_agent_register', 'imic_agent_register');
add_action('wp_ajax_imic_agent_register', 'imic_agent_register');
/**
 * Disable admin bar on the frontend of your website
 * for subscribers.
 */
if(!function_exists('imic_disable_admin_bar')){
function imic_disable_admin_bar() { 
	if( ! current_user_can('edit_posts') )
        add_filter('show_admin_bar', '__return_false');	
}
add_action( 'after_setup_theme', 'imic_disable_admin_bar' );
}
 /**
 * Redirect back to homepage and not allow access to 
 * WP admin for Subscribers.
 */
if(!function_exists('imic_redirect_admin')){
function imic_redirect_admin(){
	if ( ! current_user_can( 'edit_posts' ) &&! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ){
		wp_redirect( site_url() );
exit;
}
}
add_action( 'admin_init', 'imic_redirect_admin' );   
}
function imicRecurrenceIcon($value){
      $frequency = get_post_meta($value,'imic_event_frequency', true);
    switch($frequency) {
			case 1:
			$recur =__('Every Day','framework');
			break;
			case 2:
			$recur = __('Every Second Day','framework');
			break;
			case 3:
			$recur = __('Every Third Day','framework');
			break;
			case 4:
			$recur = __('Every Fourth Day','framework');
			break;
			case 5:
			$recur = __('Every Fifth Day','framework');
			break;
			case 6:
			$recur = __('Every Sixth Day','framework');;
			break;
			case 7:
			$recur = __('Every Week','framework');
			break;
			case 30:
			$recur = __('Every Month','framework');
			break;
                        default:
                        $recur='';  
                         break;
		}
                $frequency_count = get_post_meta($value, 'imic_event_frequency_count', true);
                $icon = ' <a data-placement="bottom" data-toggle="tooltip-live" data-original-title="Recurring '.$recur.', for '.$frequency_count.' Times" rel="tooltip"><i class="fa fa-refresh"></i></a>';
				  $recurrence = get_post_meta($value,'imic_event_frequency',true);
				  if($recurrence>0) { $icon = $icon; } else { $icon = ''; }
                                  return $icon;
}
?>