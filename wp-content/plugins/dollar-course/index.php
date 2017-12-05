<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
<?require_once $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
$posts = $wpdb->get_row("SELECT value FROM dollar_course WHERE id = '1' LIMIT 0,1");
$value = $posts->value;
?>
<br>
<p>Укажите в поле ниже цену в рублях , равную 1$</p>
<form id="add_dollar_course">
	<input id="dollar_value" type="'text" value="<?=$value?>" placeholder="Введите значение" name="dollar_value">
	<input type="submit" value="Установить">
</form>
<p id="success" style="color: green; display: none;">Курс доллара установлен</p>
<p id="error" style="color: red; display: none;">Произошла ошибка</p>
<script>
$('#add_dollar_course').on('submit', function(event){
	event.preventDefault();
	$.ajax({
		type: 'POST',
		url: '/ajax/add_dollar_course.php',
		data: $('#add_dollar_course').serialize(),
		success: function (data) {
			if(data == 'done'){
				$('#success').css('display', 'block');
			}else{
				$('#error').css('display', 'block');
			}
		}
	});
});
</script>
