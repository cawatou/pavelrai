<?php
load_theme_textdomain('imic-framework-admin', IMIC_FILEPATH . '/language/');
// Create TinyMCE's editor button & plugin for IMIC Framework Shortcodes
add_action('init', 'imic_sc_button');
function imic_sc_button() {
    if (current_user_can('edit_posts') && current_user_can('edit_pages')) {
        add_filter('mce_external_plugins', 'imic_add_tinymce_plugin');
        add_filter('mce_buttons', 'imic_register_shortcode_button');
    }
}
function imic_register_shortcode_button($button) {
    array_push($button, 'separator', 'imicframework_shortcodes');
    return $button;
}
function imic_add_tinymce_plugin($plugins) {
    $plugins['imicframework_shortcodes'] = get_template_directory_uri() . '/imic-framework/imic-shortcodes/imic-tinymce.editor.plugin.js';
    return $plugins;
}
/* ==================================================
  SHORTCODES OUTPUT
  ================================================== */
/* BUTTON SHORTCODE
  ================================================== */
function imic_button($atts, $content = null) {
    extract(shortcode_atts(array(
        "colour" => "",
        "type" => "",
        "link" => "#",
        "target" => '_self',
        "size" => '',
        "extraclass" => ''
                    ), $atts));
    $button_output = "";
    $button_class = 'btn ' . $colour . ' ' . $extraclass . ' ' . $size;
    $buttonType = ($type == 'disabled') ? 'disabled="disabled"' : '';
    $button_output .= '<a class="' . $button_class . '" href="' . $link . '" target="' . $target . '" ' . $buttonType . '>' . do_shortcode($content) . '</a>';
    return $button_output;
}
add_shortcode('imic_button', 'imic_button');
/* ICON SHORTCODE
  ================================================== */
function imic_icon($atts, $content = null) {
    extract(shortcode_atts(array(
        "image" => ""
                    ), $atts));
    return '<i class="fa ' . $image . '"></i>';
}
add_shortcode('icon', 'imic_icon');
/* STAFF SHORTCODE
  ================================================== */
function imic_staff($atts, $content = null) {
    extract(shortcode_atts(array(
        "number" => "",
        "order" => "",
        "category" => "",
        "column" => ""
                    ), $atts));
    $output = '';
   if ($order == "no") {
        $orderby = "ID";
        $sort_order = "DESC";
    } else {
        $orderby = "menu_order";
        $sort_order = "ASC";
    }
    if ($column == 0) {
        $column = 4;
    }
    query_posts(array(
        'post_type' => 'staff',
        'staff-category' => $category,
        'posts_per_page' => $number,
        'orderby' => $orderby,
        'order' => $sort_order,
    ));
    if (have_posts()):
        while (have_posts()):the_post();
            $custom = get_post_custom(get_the_ID());
            $output .='<div class="col-md-' . $column . ' col-sm-' . $column . '">
                    <div class="grid-item staff-item"> 
                        <div class="grid-item-inner">';
            if (has_post_thumbnail()):
                $output .='<div class="media-box"><a href="' . get_permalink(get_the_ID()) . '">';
                $output .= get_the_post_thumbnail(get_the_ID(), 'full');
                $output .= '</a></div>';
            endif;
            $job_title = get_post_meta(get_the_ID(), 'imic_staff_job_title', true);
            $job = '';
            if (!empty($job_title)) {
                $job = '<div class="meta-data">' . $job_title . '</div>';
            }
            $output .= '<div class="grid-content">
                                <h3> <a href="' . get_permalink(get_the_ID()) . '">' . get_the_title() . '</a></h3>';
            $output .= $job;
             $output .= imic_social_staff_icon();
            $description = imic_excerpt();
            if (!empty($description)) {
                $output .= $description;
            }
            $output .='</div></div>
                    </div>
                </div>';
        endwhile;
    endif;
    wp_reset_query();
    return $output;
}
add_shortcode('staff', 'imic_staff');
/* Sermon SHORTCODE
  ================================================== */
function imic_sermon($atts, $content = null) {
    extract(shortcode_atts(array(
        "number" => "",
        "title" => "",
        "category" => "",
        "column" => "",
                    ), $atts));
    $output = '';
    query_posts(array(
        'post_type' => 'sermons',
        'sermons-category' => $category,
        'posts_per_page' => $number,
        'orderby' => 'ID',
        'order' => 'DESC',
    ));
    if (have_posts()):
        $output .='<div class="col-md-' . $column . ' sermon-archive">';
    if(!empty($title)):
        $output .='<h2>'.$title.'</h2>';
    endif;
        ?>
        <!-- Sermons Listing -->
        <?php
        while (have_posts()):the_post();
            if ('' != get_the_post_thumbnail()) {
                $class = "col-md-8";
            } else {
                $class = "col-md-12";
            }
            $custom = get_post_custom(get_the_ID());
            $output .='<article class="post sermon">
                        <header class="post-title">';
            $output.='<div class="row">
      					<div class="col-md-9 col-sm-9">
            				<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            $output .='<span class="meta-data"><i class="fa fa-calendar"></i>' . __('Posted on ', 'framework') . get_the_time(get_option('date_format'));
            $output .= get_the_term_list(get_the_ID(), 'sermons-speakers', ' | Pastor: ', ', ', '');
            $output .='</span>
                                         </div>';
            $output .='<div class="col-md-3 col-sm-3 sermon-actions">';
            if (!empty($custom['imic_sermons_url'][0])) {
                $output .='<a href="' . get_permalink() . '" data-placement="top" data-toggle="tooltip" data-original-title="' . __('Video', 'framework') . '" rel="tooltip"><i class="fa fa-video-camera"></i></a>';
            }
            $attach_full_audio = imic_sermon_attach_full_audio(get_the_ID());
            if (!empty($attach_full_audio)) {
                $output .='<a href="' . get_permalink() . '/#play-audio" data-placement="top" data-toggle="tooltip" data-original-title="' . __('Audio', 'framework') . '" rel="tooltip"><i class="fa fa-headphones"></i></a>';
            }
            $output .='<a href="' . get_permalink() . '" data-placement="top" data-toggle="tooltip" data-original-title="' . __('Read online', 'framework') . '" rel="tooltip"><i class="fa fa-file-text-o"></i></a>';
            $attach_pdf = imic_sermon_attach_full_pdf(get_the_ID());
            if (!empty($attach_pdf)) {
                $output .='<a href="' . get_template_directory_uri() . '/download/download.php?file=' . $attach_pdf . '" data-placement="top" data-toggle="tooltip" data-original-title="' . __('Download PDF', 'framework') . '" rel="tooltip"><i class="fa fa-book"></i></a>';
            }
            $output .='</div>
                 	</div>';
            $output .='</header>
                        <div class="post-content">
                            <div class="row">';
            if (has_post_thumbnail()):
                $output.='<div class="col-md-4">
                                    <a href="' . get_permalink(get_the_ID()) . '" class="media-box">';
                $output .= get_the_post_thumbnail(get_the_ID(), 'full', array('class' => "img-thumbnail"));
                $output .= '</a></div>';
            endif;
            $output .= '<div class="' . $class . '">';
            $description = imic_excerpt(100);
            if (!empty($description)) {
                $output.= $description;
            }
            $output .= '<p><a href="' . get_permalink() . '" class="btn btn-primary">' . __('Continue reading ', 'framework') . '<i class="fa fa-long-arrow-right"></i></a></p>';
            $output .= '</div>
                            </div>
                        </div>
                    </article>';
        endwhile;
        $output.='</div>';
    endif;
    wp_reset_query();
    return $output;
}
add_shortcode('sermon', 'imic_sermon');
/* Event SHORTCODE
  ================================================== */
function imic_event($atts, $content = null) {
    extract(shortcode_atts(array(
        "number" => "",
        "title" => "",
        "category" => "",
        "style" => "",
        "type" => "",
                    ), $atts));
    $output = '';
    $updated_type =$type;
    $type = ($type == 'future') ? '>=' : '<';
    $today = date('Y-m-d');
if($updated_type=='future'){
$meta_key_for_query='imic_event_frequency_end';  
}else{
$meta_key_for_query='imic_event_start_dt';  
}
    query_posts(array('post_type' => 'event', 'event-category' => $category, 'meta_key' => 'imic_event_start_dt', 'meta_query' => array(array('key' =>$meta_key_for_query, 'value' => $today, 'compare' => $type)),'orderby' => 'meta_value', 'order' => 'ASC','posts_per_page' => $number));
    if (have_posts()):
$event_add = array();
   $rec = 1;
   $no_event = 0;
  $nos_event_menu = 1;
 while(have_posts()):the_post();
$frequency = get_post_meta(get_the_ID(), 'imic_event_frequency', true);
$frequency_count = 0;
$frequency_count = get_post_meta(get_the_ID(), 'imic_event_frequency_count', true);
if ($frequency_count > 0) {
$frequency_count = $frequency_count;
}
else {
$frequency_count = 0;
}
$date_diff = $frequency * 86400;
$sinc = 0;
while ($sinc <= $frequency_count) {
$diff_date = $sinc * $date_diff;
$st_date = get_post_meta(get_the_ID(), 'imic_event_start_dt', true);
if($frequency==30) {
$st_date = strtotime($st_date);
$diff_date = strtotime("+".$sinc." month", $st_date);
}
else {
$st_date = strtotime($st_date);
$diff_date = $st_date + $diff_date;
}
if ($style == 'grid') {
 if($updated_type=='future'){
if($diff_date>=date('U')) {
$event_add[$diff_date + $rec] = get_the_ID();
$no_event++;
 }}else{
   if($diff_date < date('U')) {
$event_add[$diff_date + $rec] = get_the_ID();
$no_event++;
 }  
}}else{
    if($updated_type=='future'){
if($diff_date>=date('U')) {
 $event_add[$diff_date + $rec] = get_the_ID();
 $no_event++;
 }}
 else{
      if($diff_date<=date('U')) {
  $event_add[$diff_date + $rec] = get_the_ID();
 $no_event++;   
 }} 
}
$sinc++; $rec++; }
endwhile;
if($updated_type=='future'){
  ksort($event_add);  
 }else{
  krsort($event_add);    
 }
if ($style == 'grid') {
echo '<div class="col-md-12"><ul class="grid-holder col-3 events-grid">';
foreach ($event_add as $key => $value) {
setup_postdata(get_post($value));
$eventStartDate = strtotime(get_post_meta($value,'imic_event_start_dt',true));
$eventStartTime = strtotime(get_post_meta($value,'imic_event_start_tm',true));
$eventEndTime = strtotime(get_post_meta($value,'imic_event_end_tm',true));
$registration_status = get_post_meta($value,'imic_event_registration_status',true);
/** Event Details Manage **/
if($registration_status==1&&(function_exists('imic_get_currency_symbol'))) {
$eventDetailIcons = array('fa-calendar', 'fa-map-marker','fa-money');	
}else {
$eventDetailIcons = array('fa-calendar', 'fa-map-marker'); }
$stime = ""; $etime = "";
if($eventStartTime!='') { $stime = ' | ' .date_i18n(get_option('time_format'), $eventStartTime) ; }
if($eventEndTime!='') { $etime =  ' - '. date_i18n(get_option('time_format'),$eventEndTime); }
if($registration_status==1&&(function_exists('imic_get_currency_symbol'))) {
$eventDetailsData = array(date_i18n('j M, ',$key).date_i18n('l',$key). $stime .  $etime, get_post_meta($value,'imic_event_address',true),imic_get_currency_symbol(get_option('paypal_currency_options')).get_post_meta($value,'imic_event_registration_fee',true));	
}else {
$eventDetailsData = array(date_i18n('j M, ',$key).date_i18n('l',$key). $stime .  $etime, get_post_meta($value,'imic_event_address',true)); }
$eventValues = array_filter($eventDetailsData, 'strlen');
$frequency = get_post_meta($value,'imic_event_frequency',true); 
$output .= '<li class="grid-item format-standard">';
$date_converted=date('Y-m-d',$key );
$custom_event_url =imic_query_arg($date_converted,$value); 
$output .= '<div class="grid-item-inner">';
$output .= '<a href="'.$custom_event_url.'" class="media-box">';
$output .= get_the_post_thumbnail($value, 'full');
$output .= '</a>';
$output .= '<div class="grid-content">';
$output .= '<h3><a href="' . $custom_event_url. '">' . get_the_title($value). '</a>'.imicRecurrenceIcon($value).'</h3>';
$output .= imic_excerpt(25);
$output .= '</div>';
if(!empty($eventValues)){ 
$output .= '<ul class="info-table">';
$flag = 0;
foreach($eventDetailsData as $edata){
if(!empty($edata)){
$output .= '<li><i class="fa '.$eventDetailIcons[$flag].'"></i> '.$edata.' </li>';
}				
$flag++;	
}
$output.= '</ul>';
$output.= '</div>
</li>';
 } 
if (++$nos_event_menu > $number)
break;
}
$output.= '</ul></div>';
} else {
$output_temp = '';
$pages_e = get_pages(array(
'meta_key' => '_wp_page_template',
'meta_value' => 'template-event-category.php'
));
$imic_event_category_page_url=!empty($pages_e[0]->ID)?get_permalink($pages_e[0]->ID):'';
$output .='<div class="col-md-9 posts-archive">';
 if(!empty($title)):
$output .='<h2>'.$title.'</h2>';
endif;
foreach ($event_add as $key => $value) {
setup_postdata(get_post($value));
$terms = wp_get_post_terms($value, 'event-category');
foreach ($terms as $terms_data) {
$term_link = imic_query_arg_event_cat($terms_data->slug,$imic_event_category_page_url);
if(!empty($imic_event_category_page_url)){
$output_temp.='<i class="fa fa-archive"></i><a href="'
. $term_link . '">'
. $terms_data->name
. "</a> ";
    }}
$frequency = get_post_meta($value, 'imic_event_frequency', true);
if ('' != get_the_post_thumbnail($value)) {
    $class = "col-md-8 col-sm-8";
} else {
    $class = "col-md-12 col-sm-12";
}
$output .='<article class="post taxonomy-event">
            <div class="row">';
$date_converted = date('Y-m-d', $key);
$custom_event_url = get_permalink($value) . '&event_date=' . $date_converted;
if ('' != get_the_post_thumbnail($value)):
    $output .='<div class="col-md-4 col-sm-4">
        <a href="' . $custom_event_url . '">';
    $output .=get_the_post_thumbnail($value, 'full', array('class' => "img-thumbnail"));
    $output .='</a></div>';
endif;
$output .='<div class="' . $class . '">';
$output .='<h3><a href="' . $custom_event_url . '">' . get_the_title($value).'</a>'.imicRecurrenceIcon($value).'</h3>';
$output .='<span class="post-meta meta-data">
                <span><i class="fa fa-calendar"></i>' . date_i18n(get_option('date_format'), $key) . '</span><span>' . $output_temp . '</span> <span>';
$output .='</span></span>';
$description = imic_excerpt(50);
if (!empty($description)) {
    $output .= $description;
}
$output .= '<p><a href="' . $custom_event_url . '" class="btn btn-primary">' . __('Continue reading', 'framework') . '<i class="fa fa-long-arrow-right"></i></a></p>';
$output .= '</div></div>';
$output .= '</article>';
if (++$nos_event_menu > $number)
break;
}
$output .= '</div>';
}
else:
$output .='<h3>' . __('There are no  events to show.', 'framework') . '</h3>';
endif;
    wp_reset_query();
    return $output;
}
add_shortcode('event', 'imic_event');
/* IMAGE SHORTCODE
  ================================================== */
function imic_imagebanner($atts, $content = null) {
    extract(shortcode_atts(array(
        "image" => "",
        "width" => "",
        "height" => "",
        "extraclass" => ""
                    ), $atts));
    $imgWidth = (!empty($width)) ? 'width="' . $width . '"' : '';
    $imgHeight = (!empty($height)) ? ' height="' . $height . '"' : '';
    $image_banner = '';
    $image_banner .= '<div class="post-image">
			<figure class="post-thumbnail"><img src="' . $image . '" alt="" class="thumbnail" ' . $imgWidth . $imgHeight . '></figure>
	  	</div>';
    return $image_banner;
}
add_shortcode('imic_image', 'imic_imagebanner');
/* COLUMN SHORTCODES
  ================================================== */
function imic_one_full($atts, $content = null) {
    extract(shortcode_atts(array(
        "extra" => '',
        "anim" => '',
                    ), $atts));
    $animation = (!empty($anim)) ? 'data-appear-animation="' . $anim . '"' : '';
    return '<div class="col-md-12 ' . $extra . '" ' . $animation . '>' . do_shortcode($content) . '</div>';
}
add_shortcode('one_full', 'imic_one_full');
function imic_one_half($atts, $content = null) {
    extract(shortcode_atts(array(
        "extra" => '',
        "anim" => '',
                    ), $atts));
    $animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
    return '<div class="col-md-6 ' . $extra . '" ' . $animation . '>' . do_shortcode($content) . '</div>';
}
add_shortcode('one_half', 'imic_one_half');
function imic_one_third($atts, $content = null) {
    extract(shortcode_atts(array(
        "extra" => '',
        "anim" => ''
                    ), $atts));
    $animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
    return '<div class="col-md-4 ' . $extra . '" ' . $animation . '>' . do_shortcode($content) . '</div>';
}
add_shortcode('one_third', 'imic_one_third');
function imic_one_fourth($atts, $content = null) {
    extract(shortcode_atts(array(
        "extra" => '',
        "anim" => ''
                    ), $atts));
    $animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
    return '<div class="col-md-3 ' . $extra . '" ' . $animation . '>' . do_shortcode($content) . '</div>';
}
add_shortcode('one_fourth', 'imic_one_fourth');
function imic_one_sixth($atts, $content = null) {
    extract(shortcode_atts(array(
        "extra" => '',
        "anim" => ''
                    ), $atts));
    $animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
    return '<div class="col-md-2 ' . $extra . '" ' . $animation . '>' . do_shortcode($content) . '</div>';
}
add_shortcode('one_sixth', 'imic_one_sixth');
function imic_two_third($atts, $content = null) {
    extract(shortcode_atts(array(
        "extra" => '',
        "anim" => ''
                    ), $atts));
    $animation = ($anim != 0) ? 'data-appear-animation="bounceInRight"' : '';
    return '<div class="col-md-8 ' . $extra . '" ' . $animation . '>' . do_shortcode($content) . '</div>';
}
add_shortcode('two_third', 'imic_two_third');
/* TABLE SHORTCODES
  ================================================= */
function imic_table_wrap($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => ''
                    ), $atts));
    $output = '<table class="table ' . $type . '">';
    $output .= do_shortcode($content) . '</table>';
    return $output;
}
add_shortcode('htable', 'imic_table_wrap');
function imic_table_headtag($atts, $content = null) {
    $output = '<thead>' . do_shortcode($content) . '</thead>';
    return $output;
}
add_shortcode('thead', 'imic_table_headtag');
function imic_table_body($atts, $content = null) {
    $output = '<tbody>' . do_shortcode($content) . '</tbody>';
    return $output;
}
add_shortcode('tbody', 'imic_table_body');
function imic_table_row($atts, $content = null) {
    $output = '<tr>';
    $output .= do_shortcode($content) . '</tr>';
    return $output;
}
add_shortcode('trow', 'imic_table_row');
function imic_table_column($atts, $content = null) {
    $output = '<td>';
    $output .= do_shortcode($content) . '</td>';
    return $output;
}
add_shortcode('tcol', 'imic_table_column');
function imic_table_head($atts, $content = null) {
    $output = '<th>';
    $output .= do_shortcode($content) . '</th>';
    return $output;
}
add_shortcode('thcol', 'imic_table_head');
/* TYPOGRAPHY SHORTCODES
  ================================================= */
// Anchor tag
function imic_anchor($atts, $content = null) {
    extract(shortcode_atts(array(
        "href" => '',
        "extra" => ''
                    ), $atts));
    return '<a href="' . $href . '" class="' . $extra . '" >' . do_shortcode($content) . ' </a>';
}
add_shortcode('anchor', 'imic_anchor');
// Alert tag
function imic_alert($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => '',
        "close" => ''
                    ), $atts));
    $closeButton = ($close == 'yes') ? '<a class="close" data-dismiss="alert" href="#">&times;</a>' : '';
    return '<div class="alert ' . $type . ' fade in">  ' . $closeButton . do_shortcode($content) . ' </div>';
}
add_shortcode('alert', 'imic_alert');
// Heading Tag
function imic_heading_tag($atts, $content = null) {
    extract(shortcode_atts(array(
        "size" => '',
        "extra" => '',
                    ), $atts));
    $output = '<' . $size . ' class="' . $extra . '">' . do_shortcode($content) . '</' . $size . '>';
    return $output;
}
add_shortcode("heading", "imic_heading_tag");
// Divider Tag
function imic_divider_tag($atts, $content = null) {
    extract(shortcode_atts(array(
        "extra" => '',
                    ), $atts));
    return '<hr class="' . $extra . '">';
}
add_shortcode("divider", "imic_divider_tag");
// Paragraph type 
function imic_paragraph($atts, $content = null) {
    extract(shortcode_atts(array(
        "extra" => '',
                    ), $atts));
    return '<p class="' . $extra . '">' . do_shortcode($content) . '</p>';
}
add_shortcode("paragraph", "imic_paragraph");
// Span type 
function imic_span($atts, $content = null) {
    extract(shortcode_atts(array(
        "extra" => '',
                    ), $atts));
    return '<span class="' . $extra . '">' . do_shortcode($content) . '</span>';
}
add_shortcode("span", "imic_span");
// Container type 
function imic_container($atts, $content = null) {
    extract(shortcode_atts(array(
        "extra" => '',
                    ), $atts));
    return '<div class="' . $extra . '">' . do_shortcode($content) . '</div>';
}
add_shortcode("container", "imic_container");
// Section type 
function imic_section($atts, $content = null) {
    extract(shortcode_atts(array(
        "extra" => '',
                    ), $atts));
    return '<section class="' . $extra . '">' . do_shortcode($content) . '</section>';
}
add_shortcode("section", "imic_section");
// Dropcap type 
function imic_dropcap($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => '',
                    ), $atts));
    return '<p class="drop-caps ' . $type . '">' . do_shortcode($content) . '</p>';
}
add_shortcode("dropcap", "imic_dropcap");
// Blockquote type
function imic_blockquote($atts, $content = null) {
    extract(shortcode_atts(array(
        "name" => '',
                    ), $atts));
    if (!empty($name)) {
        $authorName = '<cite>- ' . $name . '</cite>';
    } else {
        $authorName = '';
    }
    return '<blockquote><p>' . do_shortcode($content) . '</p>' . $authorName . '</blockquote>';
}
add_shortcode("blockquote", "imic_blockquote");
// Code type
function imic_code($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => '',
                    ), $atts));
    if ($type == 'inline') {
        return '<code>' . do_shortcode($content) . '</code>';
    } else {
        return '<pre>' . do_shortcode($content) . '</pre>';
    }
}
add_shortcode("code", "imic_code");
// Label Tag
function imic_label_tag($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => '',
                    ), $atts));
    $output = '<span class="label ' . $type . '">' . do_shortcode($content) . '</span>';
    return $output;
}
add_shortcode("label", "imic_label_tag");
// Spacer Tag
function imic_spacer_tag($atts, $content = null) {
    extract(shortcode_atts(array(
        "size" => '',
                    ), $atts));
    $output = '<div class="' . $size . '"></div>';
    return $output;
}
add_shortcode("spacer", "imic_spacer_tag");
/* LISTS SHORTCODES
  ================================================= */
function imic_list($atts, $content = null) {
    extract(shortcode_atts(array(
        "type" => '',
        "extra" => '',
        "icon" => ''
                    ), $atts));
    if ($type == 'ordered') {
        $output = '<ol>' . do_shortcode($content) . '</ol>';
    } else if ($type == 'desc') {
        $output = '<dl>' . do_shortcode($content) . '</dl>';
    } else {
        $output = '<ul class="chevrons ' . $type . ' ' . $extra . '">' . do_shortcode($content) . '</ul>';
    }
    return $output;
}
add_shortcode('list', 'imic_list');
function imic_list_item($atts, $content = null) {
    extract(shortcode_atts(array(
        "icon" => '',
        "type" => ''
                    ), $atts));
    if (($type == 'icon') || ($type == 'inline')) {
        $output = '<li><i class="fa ' . $icon . '"></i> ' . do_shortcode($content) . '</li>';
    } else {
        $output = '<li>' . do_shortcode($content) . '</li>';
    }
    return $output;
}
add_shortcode('list_item', 'imic_list_item');
function imic_list_item_dt($atts, $content = null) {
    $output = '<dt>' . do_shortcode($content) . '</dt>';
    return $output;
}
add_shortcode('list_item_dt', 'imic_list_item_dt');
function imic_list_item_dd($atts, $content = null) {
    $output = '<dd>' . do_shortcode($content) . '</dd>';
    return $output;
}
add_shortcode('list_item_dd', 'imic_list_item_dd');
function imic_page_first($atts, $content = null) {
    return '<li><a href="#"><i class="fa fa-chevron-left"></i></a></li>';
}
add_shortcode('page_first', 'imic_page_first');
function imic_page_last($atts, $content = null) {
    return '<li><a href="#"><i class="fa fa-chevron-right"></i></a></li>';
}
add_shortcode('page_last', 'imic_page_last');
function imic_page($atts, $content = null) {
    extract(shortcode_atts(array(
        "class" => ''
                    ), $atts));
    return '<li class="' . $class . '"><a href="#">' . do_shortcode($content) . ' </a></li>';
}
add_shortcode('page', 'imic_page');
/* SIDEBAR SHORTCODES
  =================================================*/
function imic_sidebar($atts, $content = null) {
    extract(shortcode_atts(array(
        "id" => "",
		"column" => 4
     ), $atts));
	 ob_start();
dynamic_sidebar($id);
$html = ob_get_contents();
ob_end_clean();
return '
<div class="col-md-'.$column.' col-sm-'.$column.'">'.$html.'</div>';
}
add_shortcode('sidebar', 'imic_sidebar'); 
  
/* TABS SHORTCODES
  ================================================= */
function imic_tabs($atts, $content = null) {
    return '<div class="tabs">' . do_shortcode($content) . '</div>';
}
add_shortcode('tabs', 'imic_tabs');
function imic_tabh($atts, $content = null) {
    return '<ul class="nav nav-tabs">' . do_shortcode($content) . '</ul>';
}
add_shortcode('tabh', 'imic_tabh');
function imic_tab($atts, $content = null) {
    extract(shortcode_atts(array(
        "id" => '',
        "class" => ''
                    ), $atts));
    return '<li class="' . $class . '"> <a data-toggle="tab" href="#' . $id . '"> ' . do_shortcode($content) . ' </a> </li>';
}
add_shortcode('tab', 'imic_tab');
function imic_tabc($atts, $content = null) {
    return '<div class="tab-content">' . do_shortcode($content) . '</div>';
}
add_shortcode('tabc', 'imic_tabc');
function imic_tabrow($atts, $content = null) {
    extract(shortcode_atts(array(
        "id" => '',
        "class" => ''
                    ), $atts));
    $output = '<div id="' . $id . '" class="tab-pane ' . $class . '">' . do_shortcode($content) . '</div>';
    return $output;
}
add_shortcode('tabrow', 'imic_tabrow');
/* ACCORDION SHORTCODES
  ================================================= */
function imic_accordions($atts, $content = null) {
    extract(shortcode_atts(array(
        "id" => ''
                    ), $atts));
    return '<div class="accordion" id="accordion' . $id . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('accordions', 'imic_accordions');
function imic_accgroup($atts, $content = null) {
    return '<div class="accordion-group panel">' . do_shortcode($content) . '</div>';
}
add_shortcode('accgroup', 'imic_accgroup');
function imic_acchead($atts, $content = null) {
    extract(shortcode_atts(array(
        "id" => '',
        "class" => '',
        "tab_id" => ''
                    ), $atts));
    $output = '<div class="accordion-heading accordionize"> <a class="accordion-toggle ' . $class . '" data-toggle="collapse" data-parent="#accordion' . $id . '" href="#' . $tab_id . '"> ' . do_shortcode($content) . ' <i class="fa fa-angle-down"></i> </a> </div>';
    return $output;
}
add_shortcode('acchead', 'imic_acchead');
function imic_accbody($atts, $content = null) {
    extract(shortcode_atts(array(
        "tab_id" => '',
        "in" => ''
                    ), $atts));
    $output = '<div id="' . $tab_id . '" class="accordion-body ' . $in . ' collapse">
					  <div class="accordion-inner"> ' . do_shortcode($content) . ' </div>
					</div>';
    return $output;
}
add_shortcode('accbody', 'imic_accbody');
/* TOGGLE SHORTCODES
  ================================================= */
function imic_toggles($atts, $content = null) {
    extract(shortcode_atts(array(
        "id" => ''
                    ), $atts));
    return '<div class="accordion" id="toggle' . $id . '">' . do_shortcode($content) . '</div>';
}
add_shortcode('toggles', 'imic_toggles');
function imic_togglegroup($atts, $content = null) {
    return '<div class="accordion-group panel">' . do_shortcode($content) . '</div>';
}
add_shortcode('togglegroup', 'imic_togglegroup');
function imic_togglehead($atts, $content = null) {
    extract(shortcode_atts(array(
        "id" => '',
        "tab_id" => ''
                    ), $atts));
    $output = '<div class="accordion-heading togglize"> <a class="accordion-toggle" data-toggle="collapse" data-parent="#" href="#' . $tab_id . '"> ' . do_shortcode($content) . ' <i class="fa fa-plus-circle"></i> <i class="fa fa-minus-circle"></i> </a> </div>';
    return $output;
}
add_shortcode('togglehead', 'imic_togglehead');
function imic_togglebody($atts, $content = null) {
    extract(shortcode_atts(array(
        "tab_id" => ''
                    ), $atts));
    $output = '<div id="' . $tab_id . '" class="accordion-body collapse">
              <div class="accordion-inner"> ' . do_shortcode($content) . '  </div>
            </div>';
    return $output;
}
add_shortcode('togglebody', 'imic_togglebody');
/* PROGRESS BAR SHORTCODE
  ================================================= */
function imic_progress_bar($atts) {
    extract(shortcode_atts(array(
        "percentage" => '',
        "name" => '',
        "type" => '',
        "value" => '',
        "colour" => ''
                    ), $atts));
    if ($type == 'progress-striped') {
        $typeClass = $type;
    } else {
        $typeClass = "";
    }
    if ($colour == 'progress-bar-warning') {
        $warningText = '(warning)';
    } else {
        $warningText = "";
    }
    $service_bar_output = '';
    if ($type == "") {
        $type = "standard";
        if (!empty($name)) {
            $service_bar_output = '<div class="progress-label"> <span>' . $name . '</span> </div>';
        }
    }
    $service_bar_output .= '<div class="progress ' . $typeClass . '">';
    if ($type == 'progress-striped') {
        $service_bar_output .= '<div class="progress-bar ' . $colour . '" style="width: ' . $value . '%">';
        $service_bar_output .= '<span class="sr-only">' . $value . '% '.__('Complete(success)','framework').' </span>';
        $service_bar_output .= '</div>';
    } else if ($type == 'colored') {
        if (!empty($warningText)) {
            $spanClass = '';
        } else {
            $spanClass = 'sr-only';
        }
        $service_bar_output .= '<div class="progress-bar ' . $colour . '" style="width: ' . $value . '%"> <span class="' . $spanClass . '">' . $value . '% '.__('Complete','framework'). $warningText . '</span> </div>';
    } else {
        $service_bar_output .= '<div class="progress-bar progress-bar-primary" data-appear-progress-animation="' . $value . '%" data-appear-animation-delay="200"> <span class="progress-bar-tooltip">' . $value . '%</span> </div>';
    }
    $service_bar_output .= '</div>';
    return $service_bar_output;
}
add_shortcode('progress_bar', 'imic_progress_bar');
/* TOOLTIP SHORTCODE
  ================================================= */
function imic_tooltip($atts, $content = null) {
    extract(shortcode_atts(array(
        "title" => '',
        "link" => '#',
        "direction" => 'top'
                    ), $atts));
    $tooltip_output = '<a href="' . $link . '" rel="tooltip" data-toggle="tooltip" data-original-title="' . $title . '" data-placement="' . $direction . '">' . do_shortcode($content) . '</a>';
    return $tooltip_output;
}
add_shortcode('imic_tooltip', 'imic_tooltip');
/* YEAR SHORTCODE
  ================================================= */
function imic_year_shortcode() {
    $year = date('Y');
    return $year;
}
add_shortcode('the-year', 'imic_year_shortcode');
/* WORDPRESS LINK SHORTCODE
  ================================================= */
function imic_wordpress_link() {
    return '<a href="http://wordpress.org/" target="_blank">'.__('WordPress','framework').'</a>';
}
add_shortcode('wp-link', 'imic_wordpress_link');
/* COUNT SHORTCODE
  ================================================= */
function imic_count($atts) {
    extract(shortcode_atts(array(
        "speed" => '2000',
        "to" => '',
        "icon" => '',
        "subject" => '',
        "textstyle" => ''
                    ), $atts));
    $count_output = '';
    if ($speed == "") {
        $speed = '2000';
    }
    $count_output .= '<div class="fact-ico"> <i class="fa ' . $icon . ' fa-4x"></i> </div>';
    $count_output .= '<div class="clearfix"></div>';
    $count_output .= '<div class="timer" data-perc="' . $speed . '"> <span class="count">' . $to . '</span></div>';
    $count_output .= '<div class="clearfix"></div>';
    if ($textstyle == "h3") {
        $count_output .= '<h3>' . $subject . '</h3>';
    } else if ($textstyle == "h6") {
        $count_output .= '<h6>' . $subject . '</h6>';
    } else {
        $count_output .= '<span class="fact">' . $subject . '</span>';
    }
    return $count_output;
}
add_shortcode('imic_count', 'imic_count');
/* MODAL BOX SHORTCODE
  ================================================== */
function imic_modal_box($atts, $content = null) {
    extract(shortcode_atts(array(
        "id" => "",
        "title" => "",
        "text" => "",
        "button" => ""
                    ), $atts));
    $modalBox = '<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#' . $id . '">' . $button . '</button>
            <div class="modal fade" id="' . $id . '" tabindex="-1" role="dialog" aria-labelledby="' . $id . 'Label" aria-hidden="true">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="' . $id . 'Label">' . $title . '</h4>
                  </div>
                  <div class="modal-body"> ' . $text . ' </div>
                  <div class="modal-footer">
               <button type="button" class="btn btn-default inverted" data-dismiss="modal">'.__('Close','framework').'</button>
                  </div>
                </div>
              </div>
            </div>';
    return $modalBox;
}
add_shortcode('modal_box', 'imic_modal_box');
/* FORM SHORTCODE
  ================================================== */
function imic_form_code($atts, $content = null) {
   extract(shortcode_atts(array(
        "form_email" => '',
                    ), $atts));
     if(!empty($form_email)){
        $admin_email = $form_email; 
      }else{
      $admin_email = get_option('admin_email');
       }
$subject_email = __('Contact Form','framework'); 
   $formCode = '<form action="'.get_template_directory_uri().'/mail/contact.php" type="post" class="contact-form">
					  <div class="row">
						<div class="form-group">
						  <div class="col-md-6">
							<label>'.__('Your name','framework').' *</label>
							<input type="text" value="" maxlength="100" class="form-control" name="name" id="name">
						  </div>
						  <div class="col-md-6">
							<label>'.__('Your email address','framework').' *</label>
							<input type="email" value="" maxlength="100" class="form-control" name="email" id="email">
						  </div>
                                                  <div class="col-md-12">
							<label>'.__('Your Phone Number','framework').'</label>
							<input type="text" id="phone" name="phone" class="form-control input-lg">
						  </div>
						</div>
					  </div>
					  <div class="row">
                                          <input type ="hidden" name ="image_path" id="image_path" value ="'.get_template_directory_uri().'">
                                          <input type="hidden" id="phone" name="phone" class="form-control input-lg" placeholder="">
                                          <input id="admin_email" name="admin_email" type="hidden" value ="'.$admin_email.'">
                                              <input id="subject" name="subject" type="hidden" value ="'.$subject_email.'">
						<div class="form-group">
						  <div class="col-md-12">
							<label>'.__('Comment','framework').'</label>
							<textarea maxlength="5000" rows="10" class="form-control" name="comments" id="comments" style="height: 138px;"></textarea>
						  </div>
						</div>
					  </div>
					  <div class="row">
						<div class="col-md-12">
						  <input type="submit" name ="submit" id ="submit" value="'.__('Submit','framework').'" class="btn btn-primary" data-loading-text="'.__('Loading...','framework').'">
						</div>
					  </div>
					</form><div class="clearfix"></div>
                    <div id="message"></div>';
    return $formCode;
}
add_shortcode('imic_form', 'imic_form_code');
/* FULLSCREEN VIDEO SHORTCODE
  ================================================= */
function imic_fullscreen_video($atts, $content = null) {
    extract(shortcode_atts(array(
        "videourl" => '',
                    ), $atts));
    $fw_video_output = "";
    if (!empty($videourl)) {
        $fw_video_output .=imic_video_embed($videourl, 100, 100);
    }
    return $fw_video_output;
}
add_shortcode('fullscreenvideo', 'imic_fullscreen_video');
/* Event Calendar SHORTCODE
  ================================================= */
function event_calendar($atts) {
    extract(shortcode_atts(array(
        "category_id" => '',
                    ), $atts));
return '<div class="col-md-12"><div id ="'.$category_id.'" class ="event_calendar calendar"></div></div>';
}
add_shortcode('event_calendar', 'event_calendar');
?>