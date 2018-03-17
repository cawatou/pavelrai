<? 
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

//exit;

$dbconfig = array();

$db = new mysql(array(
	"host"=>"localhost",
	"user"=>"cl107295_wp",
	"pass"=>"RFHVH00A",
	"name"=>"cl107295_wp"	
));

/*
$res = $db->query("SHOW TABLES");

while($row = $res->getRowFetch()){
	print_r($row);
}
*/

	

// wp_terms - значения свойств
// wp_term_taxonomy - значения свойств к свойству
// wp_term_relationships -назначение свойств объекту

// CSV файлы для парсинга свойст товара лежат в папке /public_html/csv/
// CSV файлы для парсинга изображений товара лежат в папке /public_html/wp-content/uploads/csvimport/
// До начала парсинга или после нужно записать (post_title, category, и post_content) через плагин CSV Import из админки,
// это даст возможность отображения товара на сайте, также этот плагин необходим для парсинга изображений товара.

$cat = file("csv/combine.csv");

foreach($cat as $product){
	$ar = explode(";",$product);

	$title = trim($ar[0]);
	$cat_slug = trim($ar[1]);
	//$material = trim($ar[2]);
	$complect = trim($ar[2]);// - Комплектация (Для Комбинированных памятников)
	//$colors = trim($ar[3]);
	$weight = trim($ar[3]);// - Вес (Для Комбинированных памятников)
	//$full_width = trim($ar[4]); // Высота с тумбой (Для Скульптур и памятников)
	//$height_vase = trim($ar[4]); // - Высота вазы (Для Ваз)
	//$height_flight = trim($ar[4]); // - Высота пролета (Для Оградок)
	//$height = trim($ar[4]); // - Высота (Для Столов и лавочек)
	$volume = trim($ar[4]); // - Обьем (Для Комбинированных памятников)
	//$height_pole = trim($ar[5]); // - Высота столба (Для Оградок)
	//$weight_attr = intval(trim($ar[5])); // - Вес (Для Скульптур, Для Столов и лавочек и памятников)
	//$gabarits = trim($ar[6]); // Для Скульптур и памятников



	// Также необходимо комментировать обращения к БД для конкретной группы товара у которой нет определенных свойств

	if(!$title) continue;

	$res = $db->query("SELECT ID FROM `wp_posts` WHERE `post_title` = '%s' LIMIT 1", $title);
	$object_id = $res->justVar();

	if(!$object_id){
		$res = $db->query("INSERT INTO `wp_posts` (`post_author`,`post_date`,`post_date_gmt`,`post_title`,`post_type`) VALUES ('1','".date("Y-m-d H:i:s")."','".date("Y-m-d H:i:s",time()-10800)."','%s','product')", $title);
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

	// Проставление видимости свойств у добавляемых элементов

	// для Скульптур и памятников
	//$meta_value = 'a:5:{s:11:"pa_gabarits";a:6:{s:4:"name";s:11:"pa_gabarits";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:14:"pa_weight_attr";a:6:{s:4:"name";s:14:"pa_weight_attr";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:13:"pa_full_width";a:6:{s:4:"name";s:13:"pa_full_width";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:11:"pa_material";a:6:{s:4:"name";s:11:"pa_material";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:8:"pa_color";a:6:{s:4:"name";s:8:"pa_color";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}}';
	
	// для Ваз
	//$meta_value = 'a:3:{s:14:"pa_height_vase";a:6:{s:4:"name";s:14:"pa_height_vase";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:11:"pa_material";a:6:{s:4:"name";s:11:"pa_material";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:8:"pa_color";a:6:{s:4:"name";s:8:"pa_color";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}}';

	// для Оградок
	//$meta_value = 'a:4:{s:14:"pa_height_pole";a:6:{s:4:"name";s:14:"pa_height_pole";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:16:"pa_height_flight";a:6:{s:4:"name";s:16:"pa_height_flight";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:11:"pa_material";a:6:{s:4:"name";s:11:"pa_material";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:8:"pa_color";a:6:{s:4:"name";s:8:"pa_color";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}}';

	// для Столиков и лавочек
	//$meta_value = 'a:4:{s:9:"pa_height";a:6:{s:4:"name";s:9:"pa_height";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:14:"pa_weight_attr";a:6:{s:4:"name";s:14:"pa_weight_attr";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:11:"pa_material";a:6:{s:4:"name";s:11:"pa_material";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:8:"pa_color";a:6:{s:4:"name";s:8:"pa_color";s:5:"value";s:0:"";s:8:"position";s:1:"0";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}}';

	// для памятников
	$meta_value = 'a:9:{s:11:"pa_material";a:6:{s:4:"name";s:11:"pa_material";s:5:"value";s:0:"";s:8:"position";s:2:"20";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:8:"pa_color";a:6:{s:4:"name";s:8:"pa_color";s:5:"value";s:0:"";s:8:"position";s:2:"21";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:11:"pa_poilning";a:6:{s:4:"name";s:11:"pa_poilning";s:5:"value";s:0:"";s:8:"position";s:2:"22";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:9:"pa_height";a:6:{s:4:"name";s:9:"pa_height";s:5:"value";s:0:"";s:8:"position";s:2:"23";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:9:"pa_weight";a:6:{s:4:"name";s:9:"pa_weight";s:5:"value";s:0:"";s:8:"position";s:2:"24";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:7:"pa_time";a:6:{s:4:"name";s:7:"pa_time";s:5:"value";s:0:"";s:8:"position";s:2:"25";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:11:"pa_gabarits";a:6:{s:4:"name";s:11:"pa_gabarits";s:5:"value";s:0:"";s:8:"position";s:2:"26";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:8:"pa_tumba";a:6:{s:4:"name";s:8:"pa_tumba";s:5:"value";s:0:"";s:8:"position";s:2:"27";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}s:10:"pa_flowers";a:6:{s:4:"name";s:10:"pa_flowers";s:5:"value";s:0:"";s:8:"position";s:2:"28";s:10:"is_visible";i:1;s:12:"is_variation";i:0;s:11:"is_taxonomy";i:1;}}';

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
	}

	//continue;

	// Категории
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `slug` = '%s' LIMIT 1", $cat_slug);
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


	// Объем, м3
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $volume);
	if(!$res->justVar()){
		$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $volume);
		$term_id = $res->insertId();
	} else {
		$term_id = $res->justVar();
	}
	if($term_id){
		$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = 'pa_volume' LIMIT 1", $term_id);
		if(!$res->justVar()){
			$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','pa_volume')", $term_id);
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
	//

	// Комплектация
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $complect);
	if(!$res->justVar()){
		$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $complect);
		$term_id = $res->insertId();
	} else {
		$term_id = $res->justVar();
	}
	if($term_id){
		$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = 'pa_complect' LIMIT 1", $term_id);
		if(!$res->justVar()){
			$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','pa_complect')", $term_id);
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
	//

	// Вес (Комбинированные памятники)
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $weight);
	if(!$res->justVar()){
		$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $weight);
		$term_id = $res->insertId();
	} else {
		$term_id = $res->justVar();
	}
	if($term_id){
		$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = 'pa_weight' LIMIT 1", $term_id);
		if(!$res->justVar()){
			$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','pa_weight')", $term_id);
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
	//

	/*//

	// Материал
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $material);
	if(!$res->justVar()){
		$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $material);
		$term_id = $res->insertId();
	} else {
		$term_id = $res->justVar();
	}
	if($term_id){
		$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = 'pa_material' LIMIT 1", $term_id);
		if(!$res->justVar()){
			$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','pa_material')", $term_id);
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
	//

	// Цвет
	$colors = trim($colors,".,");
	$colors = explode(",",$colors);
	if(count($colors)>0){
		foreach($colors as $color){
			$color = trim($color);
			$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $color);
			if(!$res->justVar()){
				$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $color);
				$term_id = $res->insertId();
			} else {
				$term_id = $res->justVar();
			}
			if($term_id){
				$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = 'pa_color' LIMIT 1", $term_id);
				if(!$res->justVar()){
					$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','pa_color')", $term_id);
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
	}
	//

	// Высота с тумбой
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $full_width);
	if(!$res->justVar()){
		$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $full_width);
		$term_id = $res->insertId();
	} else {
		$term_id = $res->justVar();
	}
	if($term_id){
		$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = 'pa_full_width' LIMIT 1", $term_id);
		if(!$res->justVar()){
			$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','pa_full_width')", $term_id);
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
	//

	// Вес
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $weight_attr);
	if(!$res->justVar()){
		$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $weight_attr);
		$term_id = $res->insertId();
	} else {
		$term_id = $res->justVar();
	}
	if($term_id){
		$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = 'pa_weight_attr' LIMIT 1", $term_id);
		if(!$res->justVar()){
			$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','pa_weight_attr')", $term_id);
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
	//

	// Габариты
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $gabarits);
	if(!$res->justVar()){
		$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $gabarits);
		$term_id = $res->insertId();
	} else {
		$term_id = $res->justVar();
	}
	if($term_id){
		$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = 'pa_gabarits' LIMIT 1", $term_id);
		if(!$res->justVar()){
			$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','pa_gabarits')", $term_id);
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

	// Высота вазы
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $height_vase);
	if(!$res->justVar()){
		$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $height_vase);
		$term_id = $res->insertId();
	} else {
		$term_id = $res->justVar();
	}
	if($term_id){
		$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = 'pa_height_vase' LIMIT 1", $term_id);
		if(!$res->justVar()){
			$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','pa_height_vase')", $term_id);
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
	//*/
/*
	// Высота пролета
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $height_flight);
	if(!$res->justVar()){
		$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $height_flight);
		$term_id = $res->insertId();
	} else {
		$term_id = $res->justVar();
	}
	if($term_id){
		$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = 'pa_height_flight' LIMIT 1", $term_id);
		if(!$res->justVar()){
			$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','pa_height_flight')", $term_id);
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

	// Высота столба
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $height_pole);
	if(!$res->justVar()){
		$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $height_pole);
		$term_id = $res->insertId();
	} else {
		$term_id = $res->justVar();
	}
	if($term_id){
		$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = 'pa_height_pole' LIMIT 1", $term_id);
		if(!$res->justVar()){
			$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','pa_height_pole')", $term_id);
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

	// Высота
	$res = $db->query("SELECT term_id FROM `wp_terms` WHERE `name` = '%s' LIMIT 1", $height);
	if(!$res->justVar()){
		$res = $db->query("INSERT INTO `wp_terms` (`name`,`slug`) VALUES ('%s','".rand(1000000,9999999)."')", $height);
		$term_id = $res->insertId();
	} else {
		$term_id = $res->justVar();
	}
	if($term_id){
		$res = $db->query("SELECT term_taxonomy_id FROM `wp_term_taxonomy` WHERE `term_id` = '%s' AND `taxonomy` = 'pa_height' LIMIT 1", $term_id);
		if(!$res->justVar()){
			$res = $db->query("INSERT INTO `wp_term_taxonomy` (`term_id`,`taxonomy`) VALUES ('%s','pa_height')", $term_id);
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
*/
}



?>