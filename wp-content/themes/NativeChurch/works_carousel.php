<?$dir = $_SERVER['DOCUMENT_ROOT'].'/wp-content/uploads/photo-gallery/main';
$files = scandir($dir);
?>

<div id="our_works" class="carousel_block">
    <p class="title">Наши работы</p>
    <div class="owl-carousel ">
        <?foreach($files as $img):
            $check = explode('.', $img);
            if(count($check) == 2 && $check[0] != ''):?>
                <a href="/wp-content/uploads/photo-gallery/main/<?=$img?>" class="zoom" data-rel="prettyPhoto[works-gallery]">
                    <img src="/wp-content/uploads/photo-gallery/main/<?=$img?>" alt="">
                </a>
            <?endif?>
        <?endforeach?>
    </div>
    <img class='left_arr' src="/wp-content/themes/NativeChurch/images/left_arr.png" />
    <img class='right_arr' src="/wp-content/themes/NativeChurch/images/right_arr.png" />
</div>