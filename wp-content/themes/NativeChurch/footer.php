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
                        <a href="mailto:7pavel7@mail.ru" class="email footer_email">7pavel7@mail.ru</a>
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


<div id="modal_contact" class="modal">
    <form method="post" id="contactform" name="contactform" class="contact-form" action="<?php echo get_template_directory_uri() ?>/mail/contact.php">
        <span class="modal_close">x</span>
        <div class="col-md-12">
            <p class="title">Задать вопрос</p>

            <div class="col-md-4">
                <p>Имя</p>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" id="name" name="name"  class="form-control input-lg newreq_field" placeholder="Имя">
            </div>

           <div class="col-md-4">
                <p>Телефон</p>
            </div>
            <div class="col-md-8 form-group">
                <input type="text" id="phone" name="phone" class="form-control input-lg newreq_field" placeholder="Телефон">
            </div>

           <div class="col-md-4">
                <p>Почта</p>
            </div>
            <div class="col-md-8 form-group">
                <input type="email" id="email" name="email"  class="form-control input-lg newreq_field" placeholder="Email">
            </div>

           <div class="col-md-4">
                <p>Вопрос</p>
            </div>
            <div class="col-md-8 form-group">
                <textarea cols="6" rows="7" id="comments" name="comments" class="form-control input-lg newreq_field" placeholder="Ваш вопрос"></textarea>
            </div>

            <input type="hidden" name="action" value="contacts">

            <input id="submit" name="submit" type="submit" class="btn btn-primary btn-lg pull-right" value="Задать вопрос">
        </div>
    </form>
</div>

<div id="modal_bestprice" class="modal">
    <form method="post" id="bestpriceform" name="contactform" class="contact-form" action="<?php echo get_template_directory_uri() ?>/mail/bestprice.php">
        <span class="modal_close">x</span>
        <div class="">
            <p class="title">Нашли дешевле? Снизим цену!</p>
            <p class="descr">Если у конкурента цена ниже - вернем разницу!</p>
            <div class="form-group">
                <input type="text" name="price"  class="form-control input-lg newreq_field" placeholder="Цена товара в другой сети">
            </div>

            <div class="form-group">
                <input type="text" name="link"  class="form-control input-lg newreq_field" placeholder="Ссылка на найденый товар">
            </div>

            <div class="form-group">
                <input type="text" name="phone"  class="form-control input-lg newreq_field" placeholder="Ваш телефон">
            </div>

            <input type="hidden" name="action" value="bestprice">

            <input class="submit_btn" name="submit" type="submit" class="btn btn-primary btn-lg pull-right" value="Отправить">
        </div>
    </form>
</div>

<div id="modal_addcart" class="modal">
     <span class="modal_close">x</span>
    <p class="title">Товар добавлен в корзину!</p>
    <input class="submit_btn continue_btn" type="button" class="btn btn-primary btn-lg pull-right" value="Продолжить покупки">
    <input class="submit_btn cart_btn" type="button" class="btn btn-primary btn-lg pull-right" value="В корзину">
</div>

<div id="modal_extra" class="modal_window modal ffox_extra">

</div>

<div id="modal_fence" class="modal">

    <span class="modal_close">x</span>

    <div class="col-md-12">
        <p class="title">Калькулятор стоимости оградки</p>
        <div class="col-md-4">
            <p class="fence_title"></p>
        </div>
        <div class="col-md-8">
            <p>Цена за м.п.: <span class="fence_price" data-price=""></span> &#8381;</p>
        </div>
    </div>

    <div class="separateFence"></div>

    <div class="col-md-12">
        <p>Укажите размеры сторон:</p>
        <div class="col-md-4">   
            <span>Длина</span>
            <input class='l_fence' type="text" value="">
            <span>м</span>
        </div>
        <div class="col-md-4">
            <span>Ширина</span>
            <input class="w_fence" type="text" value="">
            <span>м</span>
        </div>
        <div class="col-md-4 perim">
            <span>Периметр</span> <span class="quantity"></span>
        </div>
    </div>

    <div class="col-md-12 calc_total">
        <span>Стоимость</span>
        <span class="total_price">0</span>  &#8381;
    </div>

    <a class="button add_to_cart_button fence_btn">Купить</a>

</div>

<div id="modal_success" class="modal">
    <span class="modal_close">X</span>
    <div class="alert alert-success">Ваша заявка принята</div>
</div>

<div id="overlay"></div>
</body>
</html>