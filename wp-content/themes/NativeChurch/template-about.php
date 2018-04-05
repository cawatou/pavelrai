<?php
/*
  Template Name: about
 */
get_header();
?>
<div class="page_content">
	<div class="container_content about_page">
        <?php the_content() ?>

        <div class="staff_block">
            <article>
                <h5><strong>Наш коллектив</strong></h5><br>
                <div class="box_staff col-sm-4">
                    <div class="grid-item staff-item">
                        <div class="grid-item-staff">
                            <div class="media-box">
                                <img src="/wp-content/themes/NativeChurch/images/face1.png" class="attachment-600x400 wp-post-image" alt="inga">						</div>
                            <div class="grid-content">
                                <strong>Инга Шульженко</strong>
                                <div class="meta-data">
                                    Финансовый директор
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box_staff col-sm-4">
                    <div class="grid-item staff-item">
                        <div class="grid-item-staff">
                            <div class="media-box">
                                <img src="/wp-content/themes/NativeChurch/images/face2.png" class="attachment-600x400 wp-post-image" alt="alexsandrzer">						</div>
                            <div class="grid-content">
                                <strong>Александр Зерюкин</strong>
                                <div class="meta-data">
                                    Исполнительный директор
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box_staff col-sm-4">
                    <div class="grid-item staff-item">
                        <div class="grid-item-staff">
                            <div class="media-box">
                                <img src="/wp-content/themes/NativeChurch/images/face3.png" class="attachment-600x400 wp-post-image" alt="elenae">						</div>
                            <div class="grid-content">
                                <strong>Елена  Евстропова</strong>
                                <div class="meta-data">
                                    Офис-менеджер
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box_staff col-sm-4">
                    <div class="grid-item staff-item">
                        <div class="grid-item-staff">
                            <div class="media-box">
                                <img src="/wp-content/themes/NativeChurch/images/face4.png" class="attachment-600x400 wp-post-image" alt="natalia">						</div>
                            <div class="grid-content">
                                <strong>Наталья Рай</strong>
                                <div class="meta-data">
                                    Начальник отдела установок
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box_staff col-sm-4">
                    <div class="grid-item staff-item">
                        <div class="grid-item-staff">
                            <div class="media-box">
                                <img src="/wp-content/themes/NativeChurch/images/face5.png" class="attachment-600x400 wp-post-image" alt="pavel">						</div>
                            <div class="grid-content">
                                <strong>Павел</strong>
                                <div class="meta-data">
                                    Ретушер-оператор
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="box_staff col-sm-4">
                    <div class="grid-item staff-item">
                        <div class="grid-item-staff">
                            <div class="media-box">
                                <img src="/wp-content/themes/NativeChurch/images/face6.png" class="attachment-600x400 wp-post-image" alt="olga">						</div>
                            <div class="grid-content">
                                <strong>Ольга</strong>
                                <div class="meta-data">
                                    Консультант
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </article>
        </div>



        <div class="gallery_work">
            <div class="gray_bg">&nbsp;</div>
            <p class="title">Сертификаты и награды</p>
            <?=do_shortcode( '[Best_Wordpress_Gallery id="55"]' )?>
            <ul class="pagination pagination_gal"></ul>
        </div>

        <?=q_form()?>
	</div>	
</div>
<?php get_footer(); ?>