<?
$csv = file("img_name.csv");
foreach($csv as $row){
	$ar = explode(";",$row);
	$title = trim($ar[0]);

	$img_src = 'http://pavelrai.ru/wp-content/uploads/catalog_parcer/'.$title;
	file_put_contents($_SERVER['DOCUMENT_ROOT'].'/img_src.txt', $img_src."\r\n", FILE_APPEND);
	echo $img_src."<br>";
}
?>