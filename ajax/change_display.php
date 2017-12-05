<?php
require_once '../wp-load.php';
$id = trim($_REQUEST['id'], ',');
$id = explode(',', $id);

// Для отображения чекбоксов
$all_id = trim($_REQUEST['all_id'], ',');
$all_id = explode(',', $all_id);

if(count($id) > 1){	
	foreach($id as $cat_id){
		udpate_status($cat_id, $_REQUEST['status']);
	}
	foreach($all_id as $cat_id){
		udpate_status_checkbox($cat_id, $_REQUEST['status']);
	}
}else{
	udpate_status($id[0], $_REQUEST['status']);
	udpate_status_checkbox($all_id[0], $_REQUEST['status']);
}
function udpate_status($id, $status){
	global $wpdb;
	$query = 'SELECT object_id FROM wp_term_relationships WHERE term_taxonomy_id = '.$id;
	//echo $query;
	$posts = $wpdb->get_results($query);
	foreach($posts as $post_id){
	    $pid = $post_id->object_id;
	    //echo $pid;
	    $wpdb->update(
	        'wp_postmeta',
	        array('meta_value' => $status),
	        array('post_id' => $pid, 'meta_key' => '_virtual'),
	        array("%s"),
	        array("%d", "%s")
	    );
	}	
}

function udpate_status_checkbox($id, $status){
	file_put_contents($_SERVER['DOCUMENT_ROOT'].'/tt.txt', '1');
	global $wpdb;		
    $wpdb->update(
        'display_price',
        array('hide' => $status),
        array('cat_id' => $id),
        array("%s"),
        array("%d")
    );	
}
?>