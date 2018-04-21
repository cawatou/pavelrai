<?require_once $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
/*
Template Name: cart_extra
*/
$cat_id = $_REQUEST['id'];
$pictures = get_posts("post_type=product&numberposts=100&product_cat=picture&orderby='ID'&order='ASC'");
$lables = get_posts("post_type=product&numberposts=100&product_cat=lable");
$rains = get_posts("post_type=product&numberposts=100&product_cat=antirain");?>
<p class="close modal_close">X</p>
<div class="wrap_services">
    <h3>Дополнительные услуги</h3>
    <div class="col-md-12 service_extra">
        <p><strong>1. Выбрать портрет</strong></p>

        <div class="col-md-3 checked">
            <div class="col-md-1"><input type="radio" name="picture" checked/></div>
            <div class="col-md-10"><label>Без портрета</label></div>
        </div>

        <?foreach($pictures as $k => $picture):
            $category = explode(',', $picture->post_content);
            if(in_array($cat_id, $category)):
                $tax = get_post_custom( $picture->ID );?>
                <div class="col-md-3">
                    <div class="col-md-1"><input type="radio" name="picture" /></div>
                    <div class="col-md-10">
                        <label><?=$picture->post_title?></label>
                        <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                    </div>
                </div>
            <?endif?>
        <?endforeach?>
    </div>
    <div class="col-md-12 service_extra">
        <p><strong>2. Выбрать вид ФИО и дат</strong></p>

        <div class="col-md-3 checked">
            <div class="col-md-1"><input type="radio" name="lable" checked/></div>
            <div class="col-md-10"><label>Без ФИО и дат</label></div>
        </div>

        <?foreach($lables as $k => $lable):
            $tax = get_post_custom( $lable->ID );?>
            <div class="col-md-3">
                <div class="col-md-1"><input type="radio" name="lable" /></div>
                <div class="col-md-10">
                    <label><?=$lable->post_title?></label>
                    <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                </div>
            </div>
        <?endforeach?>
    </div>
    <div class="col-md-12 service_extra">
        <p><strong>3. Выбрать покрытие "Антидождь"</strong></p>
        <p>Для быстрого и эффективного избавления от плесени на природных и формованных камнях</p>
        <p>а также для удаления пятен от птичьего помета и иных органических загрязнений</p>

        <div class="col-md-3 checked">
            <div class="col-md-1"><input type="radio" name="rain" checked/></div>
            <div class="col-md-10"><label>Без покрытия</label></div>
        </div>

        <?foreach($rains as $k => $rain):
            $tax = get_post_custom( $rain->ID );?>
            <div class="col-md-3">
                <div class="col-md-1"><input type="radio" name="rain" /></div>
                <div class="col-md-10">
                    <label><?=$rain->post_title?></label>
                    <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                </div>
            </div>
        <?endforeach?>

    </div>
    <div class="col-md-12 service_extra">
        <div class="col-md-6">
            <p><strong>Итого  <span class="modal_total">0</span> &#8381;</strong></p>
        </div>
        <div class="col-md-6">
            <a class="btn modal_close">Продолжить</a>
        </div>
    </div>
</div>