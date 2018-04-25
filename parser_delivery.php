<?header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/woocommerce-csvimport/include/class-woocsv-product.php';
require_once 'wp-load.php';

$excel = file("csv/delivery.csv");

$delivery_item = Array();
foreach($excel as $i => $product){
	$ar = explode(";",$product);
	$el = array();
	$el['city']  = trim($ar[0]);
	$el['price'] = trim($ar[1]);

	if($el['city'] == '') die('miss city');
	if($el['price'] == '') die('miss price');
    $delivery_item[$i] = $el;
}

echo "<pre>".print_r($delivery_item, 1)."</pre>";

//die();
foreach($delivery_item as $i => $item){
    $post_id = wp_insert_post(
        array(
            'post_title' => $item['city'],
            'post_status' => 'publish',
            'post_type' => "product",
        )
    );
    update_post_meta($post_id, '_regular_price', $item['price']);
    update_post_meta($post_id, '_price', $item['price']);

    wp_set_object_terms( $post_id, 843, 'product_cat', true );
}

//echo "<pre>".print_r($extra_item, 1)."</pre>";
//echo count($extra_item);
?>