<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<script src="/wp-content/themes/NativeChurch/js/bootstrap.js"></script>
<link rel='stylesheet' href='/wp-content/themes/NativeChurch/css/bootstrap.css' type='text/css'>
<br>
<b>Отображение цен по категориям</b>
<?require_once $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
$res = $wpdb->get_results("SELECT cat_id, hide FROM display_price");
foreach($res as $value){
	$id = $value->cat_id;
	$hide[$id] = $value->hide;
}
//echo "<pre>".print_r($hide, 1);

$taxonomy     = 'product_cat';
$orderby      = 'name';
$show_count   = 0;
$pad_counts   = 0;
$hierarchical = 1;
$title        = '';
$empty        = 0;
$args = array(
	'taxonomy'     => $taxonomy,
	'orderby'      => $orderby,
	'show_count'   => $show_count,
	'pad_counts'   => $pad_counts,
	'hierarchical' => $hierarchical,
	'title_li'     => $title,
	'hide_empty'   => $empty
);
?>
<ul>
<?$all_categories = get_categories( $args );
//echo "<pre>".print_r($all_categories, 1);
foreach ($all_categories as $cat) {
	//echo "<pre>".print_r($cat, 1);
	if($cat->category_parent == 0) {
		$category_id = $cat->term_id;?>
		<li class="category cat_parent" style="list-style: disc; margin-left: 20px;" data-id="<?=$cat->term_taxonomy_id?>" data-count="<?=$cat->count?>">
            <?=$cat->name?>
            <?$cat_id = $cat->term_taxonomy_id;
            if($hide[$cat_id] == 'no') $checked = 'checked';
            else $checked = '';?>
            <input type="checkbox" class="cat_checkbox" data-id="<?=$cat->term_taxonomy_id?>" <?=$checked?>>
            <input class="display_btn" type="button" value="Показать" data-hide="no">
            <input class="display_btn" type="button" value="Не показывать" data-hide="yes">

            <?php
            $args2 = array(
                'taxonomy'     => $taxonomy,
                'child_of'     => 0,
                'parent'       => $category_id,
                'orderby'      => $orderby,
                'show_count'   => $show_count,
                'pad_counts'   => $pad_counts,
                'hierarchical' => $hierarchical,
                'title_li'     => $title,
                'hide_empty'   => $empty
            );
            $sub_cats = get_categories( $args2 );
            if($sub_cats) :?>
                <ul class="sub1" style="margin-left: 25px;">
                <?foreach($sub_cats as $sub_category):?>
                    <li class="category" data-id="<?=$sub_category->term_taxonomy_id?>" data-count="<?=$sub_category->count?>">
                        - <?=$sub_category->name?>
                        <?$cat_id = $sub_category->term_taxonomy_id;
			            if($hide[$cat_id] == 'no') $checked = 'checked';
			            else $checked = '';?>
			            <input type="checkbox" class="cat_checkbox" data-id="<?=$sub_category->term_taxonomy_id?>" <?=$checked?>>
                        <input class="display_btn" type="button" value="Показать" data-hide="no" data-id="<?=$sub_category->term_taxonomy_id?>">
                        <input class="display_btn" type="button" value="Не показывать" data-hide="yes" data-id="<?=$sub_category->term_taxonomy_id?>">
                        <?$category_id = $sub_category->term_id;
                        $args3 = array(
                            'taxonomy'     => $taxonomy,
                            'child_of'     => 0,
                            'parent'       => $category_id,
                            'orderby'      => $orderby,
                            'show_count'   => $show_count,
                            'pad_counts'   => $pad_counts,
                            'hierarchical' => $hierarchical,
                            'title_li'     => $title,
                            'hide_empty'   => $empty
                        );
                        $sub_cats2 = get_categories( $args3 );
                        if($sub_cats2) :?>
                            <ul class="sub2" style="margin-left: 25px;">
                            <?foreach($sub_cats2 as $sub_category2):?>
                                <li class="category" data-id="<?=$sub_category2->term_taxonomy_id?>" data-count="<?=$sub_category2->count?>">
                                    - - <?=$sub_category2->name?>
                                    <?$cat_id = $sub_category2->term_taxonomy_id;
						            if($hide[$cat_id] == 'no') $checked = 'checked';
						            else $checked = '';?>
						            <input type="checkbox" class="cat_checkbox" data-id="<?=$sub_category2->term_taxonomy_id?>" <?=$checked?>>
                                    <input class="display_btn" type="button" value="Показать" data-hide="no" data-id="<?=$sub_category2->term_taxonomy_id?>">
                                    <input class="display_btn" type="button" value="Не показывать" data-hide="yes" data-id="<?=$sub_category2->term_taxonomy_id?>">
                                </li>
                            <?endforeach?>
                            </ul>
                        <?endif?>
                    </li>
                <?endforeach?>
                </ul>
            <?endif?>
        </li>
	<?php }
}
?>
</ul>
<script>

$('.display_btn').on('click', function(event){
    event.preventDefault();
    var count = $(this).parent().attr('data-count');
    var id = '';
    var all_id = '';
    if(count == 0) {
    	all_id = $(this).parent().attr('data-id')+',';
    	$(this).parent().find('.category').each(function(i){
    		var check = $(this).attr('data-count');
    		if(check != 0){
    			id = id + $(this).attr('data-id')+',';
    		}   		
    		all_id = all_id + $(this).attr('data-id')+',';
    	})
    }else{
    	id = $(this).attr('data-id');
    	all_id = $(this).parent().attr('data-id');
    }    
    var status = $(this).attr('data-hide');
    console.log(all_id);
    $.ajax({
        type: 'POST',
        url: '/ajax/change_display.php',
        data: {
            id: id,
            status: status,
            all_id: all_id
        },
        success: function (data) {            
            location.reload();
        }
    });
});

$('.cat_checkbox').on('click', function(event){
	event.preventDefault();
})
</script>
