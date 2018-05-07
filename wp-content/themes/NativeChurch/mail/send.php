<?php
require($_SERVER["DOCUMENT_ROOT"].'/wp-includes/class.phpmailer.php');
mb_internal_encoding("UTF-8");
date_default_timezone_set('Europe/Moscow');

$action = $_REQUEST['action'];
$price = $_POST['price'];
$link = $_POST['link'];
$phone = $_POST['phone'];

$mail = new PHPMailer();
$mail->From = 'no-reply@pavelrai.ru';
$mail->FromName = "no-reply@pavelrai.ru";
$mail->AddAddress('7pavel7@pavelrai.ru, 7pavel7@mail.ru, cawatou@gmail.com, ds@aiggroup.ru');
//$mail->AddAddress('cawatou@gmail.com');
$mail->CharSet = "UTF-8";
$mail->IsHTML(true);

$n = file_get_contents('count.txt') + 1;
file_put_contents('count.txt', $n);


switch ($action){
    case 'agent':
        $mail->Subject = "сообщение с сайта №$n";
        $msg = "
            <p><b>Сообщение отправлено из формы 'Вызов агента'</b></p>
            <p><b>Имя: </b>".$_REQUEST['name']."</p>
            <p><b>Телефон: </b>".$_REQUEST['phone']."</p>";
        break;

    case 'question':
        $mail->Subject = "сообщение с сайта №$n";
        $msg = "
            <p><b>Сообщение отправлено из формы 'Заявка на консультацию'</b></p>
            <p><b>Имя: </b>".$_REQUEST['name']."</p>
            <p><b>Телефон: </b>".$_REQUEST['phone']."</p>";
        break;

    case 'bestprice':
        $mail->Subject = "сообщение с сайта №$n";
        $msg = "
            <p><b>Сообщение отправлено из формы 'Нашли дешевле?'</b></p>
            <p><b>Цена: </b>".$_REQUEST['price']."</p>
            <p><b>Ссылка: </b>".$_REQUEST['link']."</p>
            <p><b>Телефон: </b>".$_REQUEST['phone']."</p>";
        break;

    case 'contacts':
        $mail->Subject = "сообщение с сайта №$n";
        $msg = "
            <p><b>Сообщение отправлено из формы 'Контакты'</b></p>
            <p><b>Имя: </b>".$_REQUEST['name']."</p>
            <p><b>Почта: </b>".$_REQUEST['email']."</p>
            <p><b>Вопрос: </b>".$_REQUEST['comments']."</p>";
        break;

    case 'order':
        $mail->Subject = "сообщение с сайта №$n";
        $msg = "<p><b>Оформлен новый заказ</b></p>
            <p><b>Товары:</b><br>";

        for($i=0; ;$i++) {
            $key = 'item_'.$i;
            if($_REQUEST[$key]) $msg .= $_REQUEST[$key]."<br>";
            else break;
        }

        $msg .= "</p>";
        if($_REQUEST['extra_0']){
            $msg .= "<p><b>Услуги:</b><br>";
            for($i=0; ;$i++) {
                $key = 'extra_' . $i;
                if ($_REQUEST[$key]) $msg .= $_REQUEST[$key] . "<br>";
                else break;
            }
        }

        $msg .= "<p><b>Имя: </b>".$_REQUEST['name']."</p>
            <p><b>Почта: </b>".$_REQUEST['email']."</p>
            <p><b>Телефон: </b>".$_REQUEST['phone']."</p>";

        break;
}

$mail->Body = $msg;

if(!$mail->Send()){
    echo 'error';
} else {
    echo 'done';
}
exit;
?>