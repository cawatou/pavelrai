<?header('Content-Type: text/html; charset=utf-8');
$folder = ['granit', 'vase'];
$dir = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/catalog_parcer/'.$folder[1];
$files = scandir($dir);

$fp = fopen('img_name.csv', 'w');

foreach ($files as $name) {
    if($name == '.' || $name == '..') continue;

    $img_src = 'http://'.$_SERVER['HTTP_HOST'].'/wp-content/uploads/catalog_parcer/'.$folder[1].'/'.$name;
    $name = explode('.', $name);
    echo $name[0]."<br>";
    //echo $img_src."<br>";
}
?>