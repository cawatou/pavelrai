<?header('Content-Type: text/html; charset=utf-8');
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/plugins/woocommerce-csvimport/include/class-woocsv-product.php';
class mysql {
	private $link = false;
	private $lastsql = false;
	private $lastQuery;

	function __construct($params = array()){
		global $dbconfig;
		if(is_array($params)){
			if($params['host']) $dbconfig['host'] = $params['host'];
			if($params['user']) $dbconfig['user'] = $params['user'];
			if($params['pass']) $dbconfig['pass'] = $params['pass'];
			if($params['name']) $dbconfig['name'] = $params['name'];
 		}
		$this->connect($dbconfig['host'], $dbconfig['user'], $dbconfig['pass'], $dbconfig['name']);
	}

    function _link($newLink=false) {
        if($newLink) $this->link = $newLink;
        return $this->link;
    }

    function _fixSql($args) {
        $sql = array_shift($args);
        if(count($args)) {
            $data = array_map(array('mysql','esc'), $args);
            //$sql = str_replace(array('%','?'), array('%%','%s'), $sql);
            $sql = vsprintf($sql, $data);
        }
        $this->lastsql = $sql;
        return $sql;
    }
    function stripslashes_json($str){
    	$str = str_replace("\u","{u}",$str);
    	$str = stripslashes($str);
    	$str = str_replace("{u}","\u",$str);
    	return $str;
    }

    function _error($errMsg, $sql='') {
        $str = '<br /><b>'.$errMsg.'</b>: <tt>'.mysql_error().'</tt>';
        if($sql) $str .= '  ['.$sql.']';
        die($str);
    }

    function count($increment=false) {
        static $count = 0;
        if($increment) $count++;
        return $count;
    }

    function connect($host, $user, $pass, $dbName) {
    	global $charset;
        if($link=@mysql_connect($host, $user, $pass)) $this->_link($link);
        else mysql::_error('Database server connection failure');
        if(!@mysql_select_db($dbName, $this->_link())) mysql::_error('Database selection failure');
        mysql_query('SET NAMES "utf8"', $this->_link());
    }

    function disconnect() {
        mysql_close($this->_link());
    }
    function close() {
        mysql_close($this->_link());
    }

    function showSQL() {
        return $this->lastsql;
    }

    function query() {
        $this->count(1);
        $sql = mysql::_fixSql(func_get_args());
        if(!$query=mysql_query($sql, $this->_link())) mysql::_error('Database query failure', $sql);
        $this->lastQuery = new mysqlResultSet($query, $this->_link());
        return $this->lastQuery;
    }

    function esc($str) {
        return mysql_escape_string(mysql::stripslashes_json($str));
    }

	function __call($name, $args = array()) {
		eval("$"."result = $"."this->lastQuery->".$name."(".((count($args)>0)?"\"".implode("\",\"",$args)."\"":"").");");
		return $result;
	}

}
class mysqlResultSet {

	private $q = false;
	private $link = false;
	private $var = false;

	function __construct($resource,$link = false) {
		$this->q = $resource;
		if($link) $this->link = $link;
	}

	function resetFetch(){
		return mysql_data_seek($this->q,0);
	}
	function getRow(){
		return mysql_fetch_object($this->q);
	}
	function getRowAssoc(){
		return mysql_fetch_assoc($this->q);
	}
	function getRowFetch(){
		return mysql_fetch_row($this->q);
	}
	function getVar($offset=0){
		return ($row=mysql_fetch_row($this->q)) ? $row[$offset] : false;
	}
	function justVar($offset=0){
		if($this->var) return $this->var;
		$var = ($row = mysql_fetch_row($this->q)) ? $row[$offset] : false;
		$this->var = $var;
		return $this->var;
	}

	function getAll(){
		$all = false;
		while($row=$this->getRow()) $all[] = $row;
		return $all;
	}

	function getCol($offset=0){
		$col = false;
		while($var=$this->getVar($offset)) $col[] = $var;
		return $col;
	}

	function rowCount($affected = false){
		if($affected && strtolower($affected)!="select") return mysql_affected_rows($this->link);
		return mysql_num_rows($this->q);
	}

	function insertId() {
		return mysql_insert_id($this->link);
	}

	function getByField($params = false){
		if(!$params || !is_array($params) || !$params['field'] || !$params['return']) return false;
		$this->resetFetch();
		$field = $params['field'];
		$value = $params['value'];
		$return = $params['return'];
		while($row = $this->getRowAssoc()){
			if($row[$field]==$value) return $row[$return];
		}
	}

}

$iproduct = new woocsvImportProduct();
$dbconfig = array();

$db = new mysql(array(
	"host"=>"localhost",
	"user"=>"root",
	"pass"=>"d[jlyfhfpLDF3",
	"name"=>"pavelrai"	
));

// wp_terms - значения свойств
// wp_term_taxonomy - значения свойств к свойству
// wp_term_relationships -назначение свойств объекту

// CSV файлы для парсинга свойств товара лежат в папке /csv/
// post_content можно записать через плагин CSV Import из админки,
// Изображения парсятся теперь из этого файла






$cat = file("csv/new.csv");

foreach($cat as $i => $product){
	$ar = explode(";",$product);
	$el = array();
	$el['cat_slug']						= trim($ar[0]);
	$el['title']						= trim($ar[1]);
	$el['property']['pa_material'] 		= trim($ar[2]);
	$el['property']['pa_color'] 		= trim($ar[3]);
	$el['property']['pa_poilning'] 		= trim($ar[4]);
	$el['property']['pa_height'] 		= trim($ar[5]);
	$el['property']['pa_weight'] 		= trim($ar[6]);
	$el['property']['pa_volume'] 		= trim($ar[7]);
	$el['property']['pa_size'] 			= trim($ar[8]);
	$el['property']['pa_time'] 			= trim($ar[9]);
	$el['property']['pa_fraction'] 		= trim($ar[10]);
	$el['property']['pa_measure'] 		= trim($ar[11]);
	$el['property']['pa_shape']	 		= trim($ar[12]);
	$el['property']['pa_height_flight']	= trim($ar[13]);
	$el['property']['pa_height_pole'] 	= trim($ar[14]);
	$el['property']['pa_casing']	 	= trim($ar[15]);
	$el['property']['pa_twists']	 	= trim($ar[16]);
	$el['property']['pa_handles']		= trim($ar[17]);
	$el['property']['pa_lacq']		 	= trim($ar[18]);
	// all cell is empty  						  [19]
	$el['property']['pa_fittings']	 	= trim($ar[20]);
	$el['property']['pa_manual']	 	= trim($ar[21]);
	$el['property']['pa_finish']	 	= trim($ar[22]);
	$el['property']['pa_cap']		 	= trim($ar[23]);
	$el['property']['pa_gabarits_s']	= trim($ar[24]);
	$el['property']['pa_gabarits_t']	= trim($ar[25]);
	$el['property']['pa_gabarits_f']	= trim($ar[26]);
	$el['price']					 	= trim($ar[27]);
	$el['extraprice']					= trim($ar[28]);

	
	




	// Мраморные памятники
//	if($i <= 546) continue;
//	if($i == 683) break;

	// Ограды
//	if($i <= 683) continue;
//	if($i == 713) break;

	// Столики
//	if($i <= 712) continue;
//	if($i == 753) break;

	// Вазы
/*	if($i <= 474) continue;
    if($i == 547) break;*/

	//if($i <= 813) continue;



	echo "<pre>".print_r($el, 1)."</pre>";
	//continue;

	//else continue;
	// Также необходимо комментировать обращения к БД для конкретной группы товара у которой нет определенных свойств

	if(!$el['title']) continue;

	$res = $db->query("SELECT ID FROM `wp_posts` WHERE `post_type` = 'product' AND `post_title` = '%s' LIMIT 1", $el['title']);
	$object_id = $res->justVar();

	if(!$object_id){
		$res = $db->query("INSERT INTO `wp_posts` (`post_author`,`post_date`,`post_date_gmt`,`post_title`,`post_type`) VALUES ('1','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s",time()-10800)."','%s','product')", $el['title']);
		$object_id = $res->insertId();
	}

	if(!$object_id) continue;


	$res = $db->query("UPDATE `wp_posts` SET `post_name` = '%s' WHERE `ID` = '%s' LIMIT 1", rand(1000000,99999999), $object_id);

	//$res = $db->query("SELECT * FROM `wp_postmeta` WHERE `post_id` = '2057'");
	$res = $db->query("SELECT * FROM `wp_postmeta` WHERE `post_id` = '".$object_id."'");


	// Проходим по всем имеющимся свойствам
	while($row = $res->getRowAssoc()){
		$meta_key = $row['meta_key'];
		$meta_value = $row['meta_value'];

		$res2 = $db->query("SELECT meta_id FROM `wp_postmeta` WHERE `post_id` = '%s' AND `meta_key` = '".$meta_key."' LIMIT 1", $object_id);
		if(!$res2->justVar()){
			$res2 = $db->query("INSERT INTO `wp_postmeta` (`post_id`,`meta_key`,`meta_value`) VALUES ('%s','".$meta_key."','".$meta_value."')", $object_id);
		}
	}



	// Проставление видимости свойств у добавляемых элементов (Сначала необходимо добавить по 1 типу товара вручную из админки)
	// Все свойства
	$meta_value = 'a:24:{s:8:"pa_color";a:6:{s:4:"name";s:8:"pa_color";s:5:"value";s:0:"";s:8:"position";s:1:"1";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:11:"pa_material";a:6:{s:4:"name";s:11:"pa_material";s:5:"value";s:0:"";s:8:"position";s:1:"2";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:13:"pa_gabarits_s";a:6:{s:4:"name";s:13:"pa_gabarits_s";s:5:"value";s:0:"";s:8:"position";s:1:"3";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:16:"pa_height_flight";a:6:{s:4:"name";s:16:"pa_height_flight";s:5:"value";s:0:"";s:8:"position";s:1:"4";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:14:"pa_height_pole";a:6:{s:4:"name";s:14:"pa_height_pole";s:5:"value";s:0:"";s:8:"position";s:1:"5";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:9:"pa_height";a:6:{s:4:"name";s:9:"pa_height";s:5:"value";s:0:"";s:8:"position";s:1:"6";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:9:"pa_volume";a:6:{s:4:"name";s:9:"pa_volume";s:5:"value";s:0:"";s:8:"position";s:1:"7";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:9:"pa_weight";a:6:{s:4:"name";s:9:"pa_weight";s:5:"value";s:0:"";s:8:"position";s:1:"8";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:13:"pa_gabarits_t";a:6:{s:4:"name";s:13:"pa_gabarits_t";s:5:"value";s:0:"";s:8:"position";s:1:"9";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:13:"pa_gabarits_f";a:6:{s:4:"name";s:13:"pa_gabarits_f";s:5:"value";s:0:"";s:8:"position";s:2:"10";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:11:"pa_poilning";a:6:{s:4:"name";s:11:"pa_poilning";s:5:"value";s:0:"";s:8:"position";s:2:"11";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:7:"pa_size";a:6:{s:4:"name";s:7:"pa_size";s:5:"value";s:0:"";s:8:"position";s:2:"12";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:7:"pa_time";a:6:{s:4:"name";s:7:"pa_time";s:5:"value";s:0:"";s:8:"position";s:2:"13";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:11:"pa_fraction";a:6:{s:4:"name";s:11:"pa_fraction";s:5:"value";s:0:"";s:8:"position";s:2:"14";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:10:"pa_measure";a:6:{s:4:"name";s:10:"pa_measure";s:5:"value";s:0:"";s:8:"position";s:2:"15";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:8:"pa_shape";a:6:{s:4:"name";s:8:"pa_shape";s:5:"value";s:0:"";s:8:"position";s:2:"16";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:9:"pa_casing";a:6:{s:4:"name";s:9:"pa_casing";s:5:"value";s:0:"";s:8:"position";s:2:"17";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:9:"pa_twists";a:6:{s:4:"name";s:9:"pa_twists";s:5:"value";s:0:"";s:8:"position";s:2:"18";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:10:"pa_handles";a:6:{s:4:"name";s:10:"pa_handles";s:5:"value";s:0:"";s:8:"position";s:2:"19";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:7:"pa_lacq";a:6:{s:4:"name";s:7:"pa_lacq";s:5:"value";s:0:"";s:8:"position";s:2:"20";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:11:"pa_fittings";a:6:{s:4:"name";s:11:"pa_fittings";s:5:"value";s:0:"";s:8:"position";s:2:"21";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:9:"pa_manual";a:6:{s:4:"name";s:9:"pa_manual";s:5:"value";s:0:"";s:8:"position";s:2:"22";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:9:"pa_finish";a:6:{s:4:"name";s:9:"pa_finish";s:5:"value";s:0:"";s:8:"position";s:2:"23";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:6:"pa_cap";a:6:{s:4:"name";s:6:"pa_cap";s:5:"value";s:0:"";s:8:"position";s:2:"24";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}}';

	echo $object_id;
	$res = $db->query("SELECT meta_id FROM `wp_postmeta` WHERE `post_id` = '%s' AND `meta_key` = '_product_attributes' LIMIT 1", $object_id);
	if(!$res->justVar()){
		echo " Свойство не отображается"."<br>";
	}else{
		echo " Свойство уже отображается"."<br>";
	}
	if(!$res->justVar()){
		echo $object_id.'- Установлено отображение'."<br>";
		$res = $db->query("INSERT INTO `wp_postmeta` (`post_id`,`meta_key`,`meta_value`) VALUES ('%s','_product_attributes','".$meta_value."')", $object_id);
		$res = $db->query("INSERT INTO `wp_postmeta` (`post_id`,`meta_key`,`meta_value`) VALUES ('%s','_visibility','visible')", $object_id);
	}

	//Цена
	$res = $db->query("INSERT INTO `wp_postmeta` (`post_id`,`meta_key`,`meta_value`) VALUES ('%s','_price','".$el['price']."')", $object_id);

	//continue;

	// Категории
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `slug` = '%s' LIMIT 1", $el['cat_slug']);
	if($res->justVar()){
		$term_id = $res->justVar();
		$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' LIMIT 1", $term_id);
		if($res->justVar()){
			$term_taxonomy_id = $res->justVar();
			$res = $db->query("SELECT object_id FROM `wp_term_relationships` WHERE `object_id` = '%s' AND `term_taxonomy_id` = '%s' LIMIT 1", $object_id, $term_taxonomy_id);
			if(!$res->justVar()){
				$res = $db->query("INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`) VALUES ('%s', '%s')", $object_id, $term_taxonomy_id);
			}
		}
	}


	// Свойства товара
	foreach ($el['property'] as $prop_name => $prop_value){
		if($prop_value == '') continue;
		$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $prop_value);
		if(!$res->justVar()){
			$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $prop_value);
			$term_id = $res->insertId();
		} else {
			$term_id = $res->justVar();
		}
		if($term_id){
			$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = '%s' LIMIT 1", $term_id, $prop_name);
			if(!$res->justVar()){
				$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','%s')", $term_id, $prop_name);
				$term_taxonomy_id = $res->insertId();
			} else {
				$term_taxonomy_id = $res->justVar();
			}
			if($term_taxonomy_id){
				$res = $db->query("SELECT object_id FROM `wp_term_relationships` WHERE `object_id` = '%s' AND `term_taxonomy_id` = '%s' LIMIT 1", $object_id, $term_taxonomy_id);
				if(!$res->justVar()){
					$res = $db->query("INSERT INTO `wp_term_relationships` (`object_id`, `term_taxonomy_id`) VALUES ('%s', '%s')", $object_id, $term_taxonomy_id);
				}
			}
		}
		$term_id = false;
	}

	// Добавляем изображение
	$iproduct->body['ID'] = $object_id;
	$file_name = $el['title'];
	$img_oldname = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/catalog_parcer/'.$file_name.'.png';
	$file_name = ru2lat($file_name);
	$img_newname = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/catalog_parcer/'.$file_name.'.png';

	if(copy($img_oldname, $img_newname)){
		$img_src = 'http://'.$_SERVER['HTTP_HOST'].'/wp-content/uploads/catalog_parcer/'.$file_name.'.png';
		$iproduct->featuredImage = $img_src;
		$iproduct->saveFeaturedImage();
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/tt.txt', $el['title']."\r\n", FILE_APPEND);
		//unlink($_SERVER['HTTP_HOST'].'/wp-content/uploads/catalog_parcer/'.$file_name.'.png';);
	}else{
		echo "Не удалось переименовать изображение: ".$img_oldname;
        file_put_contents($_SERVER['DOCUMENT_ROOT'].'/tt.txt', $el['title']." - Нет фото\r\n", FILE_APPEND);
	};
}
// Функция для переименовывания изображений 
function ru2lat($str){
	$tr = array(
		"А"=>"a", "Б"=>"b", "В"=>"v", "Г"=>"g", "Д"=>"d",
		"Е"=>"e", "Ё"=>"yo", "Ж"=>"zh", "З"=>"z", "И"=>"i",
		"Й"=>"j", "К"=>"k", "Л"=>"l", "М"=>"m", "Н"=>"n",
		"О"=>"o", "П"=>"p", "Р"=>"r", "С"=>"s", "Т"=>"t",
		"У"=>"u", "Ф"=>"f", "Х"=>"kh", "Ц"=>"ts", "Ч"=>"ch",
		"Ш"=>"sh", "Щ"=>"sch", "Ъ"=>"", "Ы"=>"y", "Ь"=>"",
		"Э"=>"e", "Ю"=>"yu", "Я"=>"ya", "а"=>"a", "б"=>"b",
		"в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"yo",
		"ж"=>"zh", "з"=>"z", "и"=>"i", "й"=>"j", "к"=>"k",
		"л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p",
		"р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f",
		"х"=>"kh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch",
		"ъ"=>"", "ы"=>"y", "ь"=>"", "э"=>"e", "ю"=>"yu",
		"я"=>"ya", " "=>"-", "."=>"", ","=>"", "/"=>"-",
		":"=>"", ";"=>"","—"=>"", "–"=>"-"
	);
	return strtr($str,$tr);
}


echo "finish";
?>