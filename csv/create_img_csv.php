<?php
$dir    = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/catalog_parcer';
$files = scandir($dir);
//print_r($files);

$fp = fopen('img_name.csv', 'w');

foreach ($files as $name) {
    if($name == '.' || $name == '..') continue;
    echo $name."<br>";
    fputcsv($fp, $name);
}
?>