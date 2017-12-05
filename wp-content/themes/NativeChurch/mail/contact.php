<?php
// - grab wp load, wherever it's hiding -
include "../../../../wp-config.php";
if(!$_POST) exit;
// Email address verification, do not edit.
function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}
$name     = $_POST['name'];
$email    = $_POST['email'];
$phone    = $_POST['phone'];
$comments = $_POST['comments'];
if(trim($name) == '') {
	echo '<div class="alert alert-error">'.__('Введите ваше имя.','framework').'</div>';
	exit();
} else if(trim($email) == '') {
	echo '<div class="alert alert-error">'.__('Введите ваш email.','framework').'</div>';
	exit();
} else if(!isEmail($email)) {
	echo '<div class="alert alert-error">'.__('Введите реально существующий email.','framework').'</div>';
	exit();
} else if(trim($phone) == '') {
	echo '<div class="alert alert-error">'.__('Введите ваш контактный телефон.','framework').'</div>';
	exit();
} else if(trim($comments) == '') {
	echo '<div class="alert alert-error">'.__('Введите ваше сообщение.','framework').'</div>';
	exit();
}
if(get_magic_quotes_gpc()) {
	$comments = stripslashes($comments);
}

	date_default_timezone_set('Europe/Moscow');
	require($_SERVER["DOCUMENT_ROOT"].'/wp-includes/class.phpmailer.php');
	$mail = new PHPMailer();
	$mail->From = 'no-reply@pavelrai.ru';
	$mail->FromName = "no-reply@pavelrai.ru";
	$mail->AddAddress('7pavel7@mail.ru,aim@aiggroup.ru');
	$mail->Subject  =  "Сообщение с сайта pavelrai.ru";
	$mail->CharSet = "UTF-8";
	$mail->IsHTML(true);

	$msg = "
	<p><b>Сообщение с сайта pavelrai.ru</b></p>
	<p>------------------------------------------</p>


	<p><b>От:</b> $name</p>
	<p><b>Телефон:</b> $phone</p>
	<p><b>E-mail:</b> $email</p>
	
	
	<p><b>Сообщение:</b></p>
	<p>------------------------------------------</p>
	<p>$comments</p>
	<p>------------------------------------------</p>
	";

	$mail->Body = $msg;

	if(!$mail->Send()){
		echo '<div class="alert alert-error">'.nosend.'</div>';
	} else {
		echo '<div class="alert alert-success">Ваше сообщение отправлено</div>';

	}
	exit;
?>
