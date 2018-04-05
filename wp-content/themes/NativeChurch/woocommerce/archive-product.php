<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 * @author     WooThemes
 * @package    WooCommerce/Templates
 * @version     2.1.8
 */
get_header();
$variable_post_id = get_option('woocommerce_shop_page_id');
$pageOptions = imic_page_design($variable_post_id); //page design options ?>
    <div class="container">
        <div class="row">
            <?php if (have_posts()): ?>
                <div class="<?php echo $pageOptions['class']; ?> product-archive">
                    <!-- Products Listing -->
                    <?php
                    /**
                     * woocommerce_before_main_content hook
                     *
                     * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
                     * @hooked woocommerce_breadcrumb - 20
                     */
                    do_action('woocommerce_before_main_content'); ?>
                    <?php do_action('woocommerce_archive_description'); ?>
                    <?php if (have_posts()) : ?>
                        <?php
                        /**
                         * woocommerce_before_shop_loop hook
                         *
                         * @hooked woocommerce_result_count - 20
                         * @hooked woocommerce_catalog_ordering - 30
                         */
                        do_action('woocommerce_before_shop_loop');
                        ?>
                        <?php woocommerce_product_loop_start(); ?>
                        <?php woocommerce_product_subcategories(); ?>
                        <?php while (have_posts()) : the_post(); ?>
                            <?php wc_get_template_part('content', 'product'); ?>
                        <?php endwhile; // end of the loop. ?>
                        <?php woocommerce_product_loop_end(); ?>
                        <?php
                        /**
                         * woocommerce_after_shop_loop hook
                         *
                         * @hooked woocommerce_pagination - 10
                         */
//				do_action( 'woocommerce_after_shop_loop' );
                        ?>

                    <?php elseif (!woocommerce_product_subcategories(array('before' => woocommerce_product_loop_start(false), 'after' => woocommerce_product_loop_end(false)))) : ?>
                        <?php wc_get_template('loop/no-products-found.php'); ?>
                    <?php endif; ?>
                    <?php
                    /**
                     * woocommerce_after_main_content hook
                     *
                     * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
                     */
                    do_action('woocommerce_after_main_content');
                    ?>
                    <?php
                    123 /shop-category/care/monument/
                    pagination();
                    ?>

                    <?// Вывод ссылок на подкатегории Гранитных монументов
                    if($_SERVER['REQUEST_URI'] == '/shop-category/care/monument/'):?>
                        <div class="monument_content">
                        <h5>Создание гранитного монумента может состоять из нескольких этапов:</h5>
                        <p>1. Зачастую клиент приходит с уже готовых решением. Но иногда ему требуется помощь. В таком
                            случае, ему пригодятся наши <a href="/blagoustroistvo/granitnye-monumenty/eskizy/">эскизы</a>.</p>
                        <p>2. Конструктор по выбранному эскизу создает так называемую <a href="/blagoustroistvo/granitnye-monumenty/kompyuternyj-3d-dizajn/">3D-модель гранитного монумента</a>,
                            то есть пространственную модель памятника в компьютерной графике.</p>
                        <p>3. Обсуждение материалов, используемых в работе. <a href="">Выбор материалов</a>.</p>

                        <p><strong>Стоимость изготовления зависит от следующих факторов:</strong></p>
                        <p>— количество и тип материалов, используемых в проекте;</p>
                        <p>— объем и сложность обработки (скульптурные работы, сколы, пропилы, формы,
                        барельефы и прочее);</p>
                        <p>— Художественные элементы, используемые в проекте (рисунки, кованые цветы);</p>
                        <p>— Сложность монтажных работ.</p>


                        <p>В среднем изготовление мемориального комплекса занимает 2-3 месяца. Точный срок и стоимость мы
                        сообщим в самом начале сотрудничества.</p>

                    </div>
                    <?endif?>
                </div>
                <?php
            else:
                wc_get_template('loop/no-products-found.php');
            endif; ?>

        </div>
    </div>
<?php get_footer(); ?>