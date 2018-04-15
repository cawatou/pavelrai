<?php
require($_SERVER["DOCUMENT_ROOT"].'/wp-includes/class.phpmailer.php');
mb_internal_encoding("UTF-8");
date_default_timezone_set('Europe/Moscow');

$price = $_POST['price'];
$link = $_POST['link'];
$phone = $_POST['phone'];

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
	<p><b>Сообщение отправлено из формы 'Нашли дешевле?'</b></p>
	<p><b>Цена:</b> $price</p>
	<p><b>Ссылка:</b> $link</p>
	<p><b>Телефон:</b> $phone</p>		
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