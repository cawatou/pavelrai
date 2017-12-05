<?php
// - standalone json feed -
header('Content-Type:application/json');
// - grab wp load, wherever it's hiding -
include "../../../../wp-config.php";
include '../../../../wp-load.php';
include_once('../../../../wp-includes/wp-db.php');
// - grab date barrier -
//$today6am = strtotime('today 6:00') + ( get_option( 'gmt_offset' ) * 3600 );
$today = date('Y-m-d');
// - query -
global $wpdb;
if (isset($_POST['event_cat_id'])&&!empty($_POST['event_cat_id'])){
  $event_cat_id = $_POST['event_cat_id'];
  $querystr = "
    SELECT * FROM $wpdb->posts INNER JOIN $wpdb->term_relationships ON ($wpdb->posts.ID = $wpdb->term_relationships.object_id) INNER JOIN $wpdb->postmeta ON ($wpdb->posts.ID = $wpdb->postmeta.post_id) INNER JOIN $wpdb->postmeta AS mt1 ON ($wpdb->posts.ID = mt1.post_id) WHERE 1=1 AND ( $wpdb->term_relationships.term_taxonomy_id IN (SELECT `term_taxonomy_id` FROM $wpdb->term_taxonomy  WHERE `term_id`=$event_cat_id) ) AND $wpdb->posts.post_type = 'event' AND ($wpdb->posts.post_status = 'publish') AND ($wpdb->postmeta.meta_key = 'imic_event_start_dt' AND (mt1.meta_key = 'imic_event_frequency_end' AND CAST(mt1.meta_value AS CHAR) > $today) ) GROUP BY $wpdb->posts.ID ORDER BY $wpdb->postmeta.meta_value ASC LIMIT 0, 500
 ";
}
else{
    $querystr = "
    SELECT *
    FROM $wpdb->posts wposts, $wpdb->postmeta metastart, $wpdb->postmeta metaend
    WHERE (wposts.ID = metastart.post_id AND wposts.ID = metaend.post_id)
    AND (metaend.meta_key = 'imic_event_end_dt' AND metaend.meta_value > $today )
    AND metastart.meta_key = 'imic_event_end_dt'
    AND wposts.post_type = 'event'
    AND wposts.post_status = 'publish'
    ORDER BY metastart.meta_value ASC LIMIT 500
 ";
}
$events = $wpdb->get_results($querystr, OBJECT);
$jsonevents = array();
// - loop -
if ($events):
    global $post, $imic_options;
    foreach ($events as $post):
        setup_postdata($post);
		$frequency = get_post_meta(get_the_ID(),'imic_event_frequency',true);	
		$cat_id = wp_get_post_terms( get_the_ID(), 'event-category', array('orderby' => 'name', 'order' => 'ASC', 'fields' => 'all') );
		$cat_id = $cat_id[0]->term_id;
		$cat_data = get_option("category_".$cat_id);
		$event_color = ($cat_data['catBG']!='')?$cat_data['catBG']:$imic_options['event_default_color'];
		$frequency_count = '';
			$frequency_count = get_post_meta(get_the_ID(),'imic_event_frequency_count',true);
			if($frequency>0) { $color = $imic_options['recurring_event_color']; $frequency_count = $frequency_count; } else { $frequency_count = 0; $color = $event_color; }
$rec = 0;
$seconds = $frequency*86400;
while($rec<=$frequency_count) {
		$sv = $rec*$seconds;
        $sd=$ed=$stime=$etime=$gmte=$gmts='';
// - custom post type variables -
        $event_s_tm = get_post_meta(get_the_ID(),'imic_event_start_tm','true');
		$event_s_tm = strtotime($event_s_tm);
		if($event_s_tm!='') { $event_s_tm = date('h:i A',$event_s_tm); }
        $event_e_tm = get_post_meta(get_the_ID(),'imic_event_end_tm','true');
		$event_e_tm = strtotime($event_e_tm);
		if($event_e_tm!='') { $event_e_tm = date('h:i A',$event_e_tm); }
        $event_s_dt = get_post_meta(get_the_ID(),'imic_event_start_dt','true');
        $event_e_dt = get_post_meta(get_the_ID(),'imic_event_end_dt','true');
		if($event_e_dt=='') { $event_e_dt = $event_s_dt; }
        if(($event_s_tm == '') && ($event_e_tm == '')) {
            $sd = strtotime($event_s_dt);
			if($frequency==30) { $sd = strtotime("+".$rec." month", $sd); } else { $sd = $sd+$sv; }
            $ed = strtotime($event_e_dt);
			if($frequency==30) { $ed = strtotime("+".$rec." month", $ed); } else { $ed = $ed+$sv; }
            $stime = gmdate('Y-m-d H:i:s',$sd+60*60*9);
            $etime = gmdate('Y-m-d H:i:s', $ed +60*60*9);
           } else if (($event_s_tm == '') && ($event_e_tm != '')) {
             $sd = strtotime($event_s_dt);
			 if($frequency==30) { $sd = strtotime("+".$rec." month", $sd); } else { $sd = $sd+$sv; }
             $ed = strtotime($event_e_dt.' '.$event_e_tm);
			 if($frequency==30) { $ed = strtotime("+".$rec." month", $ed); } else { $ed = $ed+$sv; }
             $gmte = date('Y-m-d H:i:s', $ed);
			 $gmte = strtotime($gmte);
             $stime = gmdate('Y-m-d H:i:s',$sd+60*60*9);
             $etime = date('c', $gmte);  
             } else if (($event_s_tm != '') && ($event_e_tm == '')) {
            $sd = strtotime($event_s_dt.' '.$event_s_tm);
			if($frequency==30) { $sd = strtotime("+".$rec." month", $sd); } else { $sd = $sd+$sv; }
            $ed = strtotime($event_e_dt);
			if($frequency==30) { $ed = strtotime("+".$rec." month", $ed); } else { $ed = $ed+$sv; }
            $gmts = date('Y-m-d H:i:s', $sd);
			$gmts = strtotime($gmts);
           // - set to ISO 8601 date format -
            $stime = date('c', $gmts);
            $etime = gmdate('Y-m-d H:i:s', $ed + 60*60*9);
            } else {
            $sd = strtotime($event_s_dt.' '.$event_s_tm);
			if($frequency==30) { $sd = strtotime("+".$rec." month", $sd); } else { $sd = $sd+$sv; }
            $ed = strtotime($event_e_dt.' '.$event_e_tm);
			if($frequency==30) { $ed = strtotime("+".$rec." month", $ed); } else { $ed = $ed+$sv; }
            $gmts = date('Y-m-d H:i:s', $sd);
            $gmte = date('Y-m-d H:i:s', $ed);
            $gmts = strtotime($gmts);
            $gmte = strtotime($gmte);
            $stime = date('c', $gmts);
            $etime = date('c', $gmte);
        }
         $date_converted=date('Y-m-d',strtotime($stime));
        
//         $stime = date_i18n(get_option('time_format'),$stime);
        $custom_event_url =imic_query_arg($date_converted,$post->ID);
     // - json items -
        $jsonevents[] = array(
            'title' => $post->post_title,
            'allDay' => false, // <- true by default with FullCalendar
            'start' => $stime,
            'end' => $etime,
            'url' => $custom_event_url,
			'backgroundColor' => $color,
			'borderColor' => $color
        );
$rec++; }
endforeach;
else :
endif;
// - fire away -
$options = get_option('imic_options');
$events_feeds = $options['event_feeds'];
if($events_feeds==1) {
echo json_encode($jsonevents); }
?>
