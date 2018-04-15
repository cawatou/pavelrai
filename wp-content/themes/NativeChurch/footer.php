<? // Выводим галерею "Наши работы"0
$path = explode('/', $_SERVER['REQUEST_URI']);
//echo '<pre>'.print_r($path, 1).'</pre>';
$show_works = true;
if($path[0] == '' && $path[1] == '') $show_works = false;
if(in_array('cart', $path)) $show_works = false;
if(in_array('shop', $path)) $show_works = false;
if(in_array('checkout', $path)) $show_works = false;


if($show_works):?>
	        </div>
	    </div>
	</div>
    <?=works_carousel()?>
<?endif?>

<footer class="site-footer-bottom">
    <p>© Память времени, 2001-<?=date(Y)?>.</p>
	<div class="container">
		<div class="row">
			<div class="col-md-6">

			</div>	
			<div class="col-md-6">
                    <div class="col-md-4 header_contacts footer_email">
                        <a href="mailto:7pavelrai@mail.ru" class="email footer_email">7pavelrai@mail.ru</a>
                    </div>
                    <div class="col-md-4">
                        <p class="phone footer_phone"> +7 914 711-28-20 </p>
                    </div>
                    <div class="col-md-4 header_contacts">


                        <a class="footer_tel" href="/vse-uslugi/vyzov-agenta/">
                            <span>Вызов менеджера</span>
                        </a>
                    </div>
			</div>
		</div>
	</div>
</footer>

</div>
<!-- End Boxed Body -->
<?php wp_footer(); ?>
<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter27253784 = new Ya.Metrika({id:27253784,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/27253784" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->

<div id="modal_1" class="modal modal_window">
	<span class="modal_close">X</span>
	<form method="post">
		<input type="text" id="user_name" class="required_filds user_name" placeholder="Введите Ваше имя"/><br/>
		<input type="text" id="user_phone" class="required_filds" placeholder="Введите Ваш телефон" /><br/>
		<input class="btn btn-primary snd_btn" type="submit" name="submit" value="Подать заявку">
	</form>
</div>

<div id="modal_2" class="modal modal_window">
	<span class="modal_close">X</span>
	<form method="post">
		<input type="text" id="user_name_2m" class="required_filds user_name" placeholder="Введите Ваше имя"/><br/>
		<input type="text" id="user_phone_2m" class="required_filds" placeholder="Введите Ваш телефон" /><br/>
		<input type="text" id="user_mail_2m" class="required_filds" placeholder="Введите Ваш email" /><br/>
		<p>Дополнительные пожелания:</p>
		<textarea id="user_msg_2m" class="required_filds msg_modal"></textarea>
		<input class="btn btn-primary snd_btn" type="submit" value="Подать заявку">							
	</form>
</div>

<div id="modal_3" class="modal modal_window">
	<span class="modal_close">X</span>
	<form method="post">
		<input type="text" id="user_name_3m" class="required_filds user_name" placeholder="Введите Ваше имя"/><br/>
		<input type="text" id="user_phone_3m" class="required_filds" placeholder="Введите Ваш телефон или email" /><br/>
		<input class="btn btn-primary snd_btn" type="submit" name="submit" value="Подать заявку">
	</form>
</div>

<div id="modal_4" class="modal">
	<span class="modal_close">X</span>
	<div class="alert alert-success">Ваша заявка отправлена. <br/>Мы свяжемся с вами в ближайшее время.</div>
</div>

<div id="modal_contact" class="modal">
    <form method="post" id="contactform" name="contactform" class="contact-form" action="<?php echo get_template_directory_uri() ?>/mail/contact.php">
        <span class="modal_close">x</span>
        <div class="col-md-12">
            <p class="title">Задать вопрос</p>

            <div class="col-md-4">
                <p>Имя</p>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" id="name" name="name"  class="form-control input-lg" placeholder="Имя">
            </div>

           <div class="col-md-4">
                <p>Телефон</p>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" id="phone" name="phone" class="form-control input-lg" placeholder="Телефон">
                <input type ="hidden" name ="image_path" id="image_path" value ="<?php echo get_template_directory_uri() ?>">
                <input id="admin_email" name="admin_email" type="hidden" value ="<?php echo $admin_email; ?>">
                <input id="subject" name="subject" type="hidden" value ="<?php echo $subject_email; ?>">
            </div>

           <div class="col-md-4">
                <p>Почта</p>
            </div>
            <div class="col-md-8 form-group">
                <input type="email" id="email" name="email"  class="form-control input-lg" placeholder="Email">
            </div>

           <div class="col-md-4">
                <p>Вопрос</p>
            </div>
            <div class="col-md-8 form-group">
                <textarea cols="6" rows="7" id="comments" name="comments" class="form-control input-lg" placeholder="Ваш вопрос"></textarea>
            </div>

            <input id="submit" name="submit" type="submit" class="btn btn-primary btn-lg pull-right" value="Задать вопрос">
        </div>
    </form>
</div>

<div id="overlay"></div>
</body>
</html>