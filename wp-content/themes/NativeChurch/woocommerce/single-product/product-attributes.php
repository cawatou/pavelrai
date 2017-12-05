<?php
/**
 * Product attributes
 *
 * Used by list_attributes() in the products class
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.1.3
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$has_row    = false;
$alt        = 1;
$attributes = $product->get_attributes();
ob_start();
?>
<table class="shop_attributes">	
	<?php if ( $product->enable_dimensions_display() ) : ?>
		<?php if ( $product->has_weight() ) : $has_row = true; ?>
			<tr class="<?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
				<th><?php _e( 'Weight', 'woocommerce' ) ?></th>
				<td class="product_weight"><?php echo $product->get_weight() . ' ' . esc_attr( get_option( 'woocommerce_weight_unit' ) ); ?></td>
			</tr>
		<?php endif; ?>
		<?php if ( $product->has_dimensions() ) : $has_row = true; ?>
			<tr class="<?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
				<th><?php _e( 'Dimensions', 'woocommerce' ) ?></th>
				<td class="product_dimensions"><?php echo $product->get_dimensions(); ?></td>
			</tr>
		<?php endif; ?>
	<?php endif; ?>
	<?php foreach ( $attributes as $attribute ) :
		if ( empty( $attribute['is_visible'] ) || ( $attribute['is_taxonomy'] && ! taxonomy_exists( $attribute['name'] ) ) ) {
			continue;
		} else {
			$has_row = true;
		}
		?>
		<tr class="<?php if ( ( $alt = $alt * -1 ) == 1 ) echo 'alt'; ?>">
			<th><?php echo wc_attribute_label( $attribute['name'] ); ?></th>
			<td><?php
				if ( $attribute['is_taxonomy'] ) {
					$values = wc_get_product_terms( $product->id, $attribute['name'], array( 'fields' => 'names' ) );
					echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
				} else {
					// Convert pipes to commas and display values
					$values = array_map( 'trim', explode( WC_DELIMITER, $attribute['value'] ) );
					echo apply_filters( 'woocommerce_attribute', wpautop( wptexturize( implode( ', ', $values ) ) ), $attribute, $values );
				}
			?></td>
		</tr>
	<?php endforeach; ?>
	

<?php 
	// Получение id родительской категории товара
	$cat = get_the_terms( $post->ID, 'product_cat' );	
	$key = key($cat);
	$parent_category = $cat[$key]->parent;
	//print_r($parent_category);
?>

</table>

<h2>Сроки изготовления</h2>
<table class="shop_attributes">
	<tbody>
		<tr class="alt">
			<th>Срок изготовления</th>
			<?if(key($cat) == 743):?>
				<td><p>от 30 дней</p></td>
			<?else:?>
				<td><p>10-14 дней</p></td>
			<?endif?>
		</tr>
	</tbody>
</table>


<?php
// Исключаем все Вазы, Ограды, Столы и лавочки
if($parent_category!==337 && $parent_category!==253 && $parent_category!==495 && $parent_category!==498 && $parent_category!==501 && $parent_category!==504 && $parent_category!==505 && $parent_category!==506) :?>
	<?if(key($cat) != 743):?>
		<h2>Комплектация памятника</h2>
		<table class='shop_attributes'>
			<tbody>
				<tr>
					<th>Памятник комплектуется цветником</th>
					<td><p>бесплатно</p></td>
				</tr>
				<tr class='alt'>
					<th>Комплектация памятника накрывной плитой</th>
					<td><p>5 985 руб.</p></td>
				</tr>
			</tbody>
		</table>
	<?endif?>
	<h2>Художественные работы на памятнике</h2>
	<table class='shop_attributes'>
		<tbody>
			<tr>
				<th>Портрет на памятнике</th>
				<td><p>3 600 руб.</p></td>
			</tr>
			<tr class='alt'>
				<th>Биографические данные</th>
				<td><p>950 руб.</p></td>
			</tr>
			<tr>
				<th>Слова эпитафии</th>
				<td><p>10 рублей 1 знак</p></td>
			</tr>
			<tr class='alt'>
				<th>Крест на памятнике</th>
				<td><p>200 рублей</p></td>
			</tr>
		</tbody>
	</table>

	<?if(key($cat) != 743):?>
		<h2>Установка памятника</h2>
		<table class='shop_attributes'>
			<tbody>
				<tr>
					<th>Установка памятника в металлическую рамку</th>
					<td><p>3 600 руб.</p></td>
				</tr>
				<tr>
					<th>Установка памятника на плиту «Миниракушка»</th>
					<td><p>3 600 руб.</p></td>
				</tr>
				<tr class='alt'>
					<th>Установка памятника на плиту "Подиум"</th>
					<td><p>4 900 руб.</p></td>
				</tr>
				<tr>
					<th>Установка памятника на плиту "Ракушка"</th>
					<td><p>10 800 руб.</p></td>
				</tr>
				<tr class='alt'>
					<th>Установка памятника на фундамент 'Стандарт'</th>
					<td><p>18 565 руб.</p></td>
				</tr>
				<tr class='alt'>
					<th>Установка памятника на плиту «Греция»</th>
					<td><p>5 500 руб.</p></td>
				</tr>
			</tbody>
		</table>
	<?else:?>
		<h2>Установка памятника</h2>
		<p>Установка памятника зависит от его размеров, сложности монтажа и расчитывается индивидуально. К примеру памятник высотой 110 см в одиночном не сложном исполнении стоит 3600 рублей и производится двумя специалистами в течении часа.</p>
		<p>Иногда гранитный монумент монтируется 2 недели командой из шести человек. Стоимость такой работы описывается в заключенном договоре на изготовление и расчитывается п остроительным нормам.</p>
	<?endif?>

	<h2>Доставка памятника</h2>
	<table class='shop_attributes'>
		<tbody>
			<tr>
				<th>Доставка по Уссурийску</th>
				<td><p>800 руб.</p></td>
			</tr>
			<tr class='alt'>
				<th>Доставка Борисовка, Михайловка, Воздвиженка, Новоникольск</th>
				<td><p>800 руб.</p></td>
			</tr>
			<tr>
				<th>Доставка Владивосток</th>
				<td><p>4 500 руб.</p></td>
			</tr>
			<tr class='alt'>
				<th>Доставка Славянка</th>
				<td><p>6 750 руб.</p></td>
			</tr>
			<tr>
				<th>Доставка Сибирцево</th>
				<td><p>3 150 руб.</p></td>
			</tr>
			<tr class='alt'>
				<th>Доставка Покровка, Алексеевка, Раздольное, Галенки</th>
				<td><p>1 800 руб.</p></td>
			</tr>
			<tr>
				<td colspan='2' style='padding: 8px'>
					<p>Доставка в любой населенный пункт - 1 руб. - 1 километр в одну сторону. Пример расчета : Уссурийск - Владивосток 100км ( 45р * 100км = 4500 руб.)</p>
				</td>
			</tr>
			<tr class='alt'>
				<th>Доставка по России</th>
				<td><p>от 3 000 руб.</p></td>
			</tr>
			<tr>
				<th>Хранение на складе</th>
				<td><p>Бесплатно</p></td>
			</tr>
		</tbody>
	</table>

	<!--h2>Доставка и установка</h2>
	<table class='shop_attributes'>
		<tbody>
			<tr>
				<th>Установка памятника</th>
				<td><p>от 2.500 руб.</p></td>
			</tr>
			<tr class='alt'>
				<th>Доставка по Приморью</th>
				<td><p>от 2000 руб.</p></td>
			</tr>
			<tr>
				<th>Доставка по России</th>
				<td><p>от 3.000 руб.</p></td>
			</tr>
			<tr class='alt'>
				<th>Хранение на складе</th>
				<td><p>Бесплатно</p></td>
			</tr>
		</tbody>
	</table-->
<?endif?>

<?php
if ( $has_row ) {
	echo ob_get_clean();
} else {
	ob_end_clean();
}