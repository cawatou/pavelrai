<?header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/woocommerce-csvimport/include/class-woocsv-product.php';
require_once 'wp-load.php';
global $woocommerce;


$iproduct = new woocsvImportProduct();
$excel = file("csv/extra.csv");
$offer_cat = Array(
    'Бюджетные' => 52,
    'Экономные' => 53,
    'Стандартные' => 54,
    'Семейные' => 56,
    'Цветной гранит' => 58,
    'Нестандартные' => 57,
    'Памятники с крестом' => 332,
    'Мраморные памятники' => 59,
    'Мраморная' => 360,
    'Гранитная' => 361
);

$category = Array(
    '1. Выбрать портрет' => 'picture',
    '2. Выбрать вид ФИО и дат' => 'lable',
    '3. Выбрать вид установки' => 'install',
    '4. Требуется ли вам демонтаж памятника? ' => 'uninstall',
    '5. Выбрать покрытие «Антидождь»' => 'antirain'
);


$extra_item = Array();
foreach($excel as $i => $product){
	$ar = explode(";",$product);
	$el = array();
	$el['offer_cat'] = $offer_cat[$ar[0]];
	$el['category']	 = $category[$ar[1]];
	$el['title']	     = trim($ar[2]);
	$el['price']	 = trim($ar[3]);

	if($el['offer_cat'] == '') die('miss offer');
	if($el['category'] == '') die('miss category');

	if($el['title'] == 'Без портрета' || $el['title'] == 'Без ФИО и дат' || $el['title'] == 'Без установки' || $el['title'] == 'Не требуется' || $el['title'] == 'Без покрытия'){
	    continue;
    }

	if(array_key_exists($el['title'], $extra_item)){
        $extra_item[$el['title']]['offer_cat'] = $extra_item[$el['title']]['offer_cat'].','.$el['offer_cat'];
    }else{
        $extra_item[$el['title']] = $el;
    }
}

foreach($extra_item as $i => $item){
    $post_id = wp_insert_post(
        array(
            'post_title' => $item['title'],
            'post_content' => $item['offer_cat'],
            'post_status' => 'publish',
            'post_type' => "product",
        )
    );
    update_post_meta($post_id, '_regular_price', $item['price']);
    update_post_meta($post_id, '_price', $item['price']);

    $term = term_exists( $item['category'], 'product_cat', 839 );
    wp_set_object_terms( $post_id, (int)$term['term_id'], 'product_cat', true );
}

//echo "<pre>".print_r($extra_item, 1)."</pre>";
//echo count($extra_item);
?>