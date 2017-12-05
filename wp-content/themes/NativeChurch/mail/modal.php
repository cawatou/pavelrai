<?php
mb_internal_encoding("UTF-8");
$name = $_POST['user_name'];
$phone = $_POST['user_phone'];
$name_2m = $_POST['user_name_2m'];
$phone_2m = $_POST['user_phone_2m'];
$mail_2m = $_POST['user_mail_2m'];
$msg_2m = $_POST['user_msg_2m'];
$name_3m = $_POST['user_name_3m'];
$phone_3m = $_POST['user_phone_3m'];
$model = $_POST['model'];

date_default_timezone_set('Europe/Moscow');
require($_SERVER["DOCUMENT_ROOT"].'/wp-includes/class.phpmailer.php');
$mail = new PHPMailer();
$mail->From = 'no-reply@pavelrai.ru';
$mail->FromName = "no-reply@pavelrai.ru";
$mail->AddAddress('7pavel7@pavelrai.ru, 7pavel7@mail.ru, cawatou@gmail.com');
//$mail->AddAddress('cawatou@gmail.com, dmitriy.a.smirnov@gmail.com');
$mail->CharSet = "UTF-8";
$mail->IsHTML(true);

$n = file_get_contents('count.txt') + 1;
file_put_contents('count.txt', $n);

if($name_2m){	
	$mail->Subject = "сообщение с сайта №$n";
	$msg = "
	<p><b>Сообщение отправлено из формы для связи</b></p>
	<p><b>От:</b> $name_2m</p>
	<p><b>Телефон:</b> $phone_2m</p>
	<p><b>E-mail:</b> $mail_2m</p>	
	<p><b>Сообщение:</b> $msg_2m</p>	
	";
}

if($name){	
	$mail->Subject = "сообщение с сайта №$n";	
	$msg = "
	<p><b>Сообщение отправлено из формы обратный звонок</b></p>
	<p><b>От:</b> $name</p>
	<p><b>Телефон:</b> $phone</p>
	";	
}

if($name_3m){	
	$mail->Subject = "сообщение с сайта №$n";
	$msg = "
	<p><b>Сообщение отправлено из формы узнать цену</b></p>
	<p><b>От:</b> $name_3m</p>
	<p><b>Телефон:</b> $phone_3m</p>
	<p><b>Модель:</b> $model</p>
	";	
}

$mail->Body = $msg;

if(!$mail->Send()){
	echo 'nosend';
} else {
	echo 'welldone';
}
exit;
?>