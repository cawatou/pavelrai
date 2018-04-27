<?require_once $_SERVER['DOCUMENT_ROOT'].'/wp-load.php';
/*
Template Name: cart_extra
*/
$product_id = $_REQUEST['id'];
$cat_id = $_REQUEST['cat_id'];
$pictures = get_posts("post_type=product&numberposts=1000&product_cat=picture&orderby='ID'&order='ASC'");
$lables = get_posts("post_type=product&numberposts=1000&product_cat=lable");
$rains = get_posts("post_type=product&numberposts=1000&product_cat=antirain");
$installs = get_posts("post_type=product&numberposts=1000&product_cat=install");
$uninstalls = get_posts("post_type=product&numberposts=1000&product_cat=uninstall");?>

<p class="close modal_close">X</p>
<div class="wrap_services">
    <h3>Дополнительные услуги</h3>
    <div class="col-md-12 service_extra">
        <p><strong>1. Выбрать портрет</strong></p>

        <div class="col-md-3 checked">
            <div class="col-md-1">
                <span class="radio-span"></span>
                <input type="radio" name="picture" checked/>
            </div>
            <div class="col-md-10"><label>Без портрета</label></div>
        </div>

        <?foreach($pictures as $k => $picture):
            $category = explode(',', $picture->post_content);
            if(in_array($cat_id, $category)):
                $tax = get_post_custom( $picture->ID );?>
                <div class="col-md-3" data-id="<?=$picture->ID?>" data-price="<?=$tax['_price'][0]?>">
                    <div class="col-md-1">
                        <span class="radio-span"></span>
                        <input type="radio" name="picture" />
                    </div>
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
            <div class="col-md-1">
                <input type="radio" name="lable" checked/>
                <span class="radio-span"></span>
            </div>
            <div class="col-md-10"><label>Без ФИО и дат</label></div>
        </div>

        <?foreach($lables as $k => $lable):
            $category = explode(',', $lable->post_content);
            if(in_array($cat_id, $category)):
                $tax = get_post_custom( $lable->ID );?>
                <div class="col-md-3" data-id="<?=$lable->ID?>" data-price="<?=$tax['_price'][0]?>">
                    <div class="col-md-1">
                        <input type="radio" name="lable" />
                        <span class="radio-span"></span>
                    </div>
                    <div class="col-md-10">
                        <label><?=$lable->post_title?></label>
                        <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                    </div>
                </div>
            <?endif?>
        <?endforeach?>
    </div>


    <div class="col-md-12 service_extra">
        <p><strong>3. Установка памятника</strong></p>

        <div class="col-md-3 checked">
            <div class="col-md-1">
                <input type="radio" name="install" checked/>
                <span class="radio-span"></span>
            </div>
            <div class="col-md-10"><label>Без установки</label></div>
        </div>

        <?foreach($installs as $k => $install):
            $category = explode(',', $install->post_content);
            if(in_array($cat_id, $category)):
                $tax = get_post_custom( $install->ID );?>
                <div class="col-md-3" data-id="<?=$install->ID?>" data-price="<?=$tax['_price'][0]?>">
                    <div class="col-md-1">
                        <input type="radio" name="install" />
                        <span class="radio-span"></span>
                    </div>
                    <div class="col-md-10">
                        <label><?=$install->post_title?></label>
                        <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                    </div>
                </div>
            <?endif?>
        <?endforeach?>
    </div>


    <div class="col-md-12 service_extra">
        <p><strong>4. Нужен ли вам демонтаж памятника?</strong></p>

        <div class="col-md-3 checked">
            <div class="col-md-1">
                <input type="radio" name="uninstall" checked/>
                <span class="radio-span"></span>
            </div>
            <div class="col-md-10">
                <label>Не требуется</label>
                <p class="price">Бесплатно</p>
            </div>
        </div>

        <?foreach($uninstalls as $k => $uninstall):
            $category = explode(',', $uninstall->post_content);
            if(in_array($cat_id, $category)):
                $tax = get_post_custom( $uninstall->ID );?>
                <div class="col-md-3" data-id="<?=$uninstall->ID?>" data-price="<?=$tax['_price'][0]?>">
                    <div class="col-md-1">
                        <input type="radio" name="uninstall" />
                        <span class="radio-span"></span>
                    </div>
                    <div class="col-md-10">
                        <label><?=$uninstall->post_title?></label>
                        <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                    </div>
                </div>
            <?endif?>
        <?endforeach?>
    </div>


    <div class="col-md-12 service_extra">
        <p><strong>5. Выбрать покрытие "Антидождь"</strong></p>
        <p>Для быстрого и эффективного избавления от плесени на природных и формованных камнях</p>
        <p>а также для удаления пятен от птичьего помета и иных органических загрязнений</p>

        <div class="col-md-3 checked">
            <div class="col-md-1">
                <input type="radio" name="rain" checked/>
                <span class="radio-span"></span>
            </div>
            <div class="col-md-10"><label>Без покрытия</label></div>
        </div>

        <?foreach($rains as $k => $rain):
            $category = explode(',', $rain->post_content);
            if(in_array($cat_id, $category)):
                $tax = get_post_custom( $rain->ID );?>
                <div class="col-md-3" data-id="<?=$rain->ID?>" data-price="<?=$tax['_price'][0]?>">
                    <div class="col-md-1">
                        <input type="radio" name="rain" />
                        <span class="radio-span"></span>
                    </div>
                    <div class="col-md-10">
                        <label><?=$rain->post_title?></label>
                        <p class="price"><?=number_format($tax['_price'][0], 0, '', ' ')?> &#8381;</p>
                    </div>
                </div>
            <?endif?>
        <?endforeach?>

    </div>


    <div class="col-md-12 service_extra">
        <div class="col-md-6">
            <p><strong>Итого: <span class="modal_total">0</span> &#8381;</strong></p>
        </div>
        <div class="col-md-6">
            <!--a class="btn modal_close">Продолжить</a-->
            <a class="btn accept_extra">Продолжить</a>
        </div>
    </div>
</div>
<input type="hidden" id="product_id" value="<?=$product_id?>">
<input type="hidden" id="extra_id" value="">