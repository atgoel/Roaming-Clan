<?php
/**
 * Shortcode [tour_category_images] view.
 * For more detailed list see list of shortcode attributes.
 *
 * @var string  $title
 * @var boolean $title_underline
 * @var string  $sub_title
 * @var string  $bg_url
 * @var boolean $ignore_empty
 * @var string  $category_ids
 * @var string  $css_class
 * @var string  $parent_id
 * @var string  $slides_number
 * @var string  $number
 * @var string  $autoplay
 * @var string  $order
 * @var string  $orderby
 * @var string  $view
 * @var string  $items
 *
 * @author    Themedelight
 * @package   Themedelight/AdventureTours
 * @version   2.1.3
 */

if ( ! $items ) {
	return;
}
?>
<div class="at-tours-type<?php if ( $css_class ) { echo esc_attr( ' ' . $css_class ); } ?>">
	<?php if ( $title || $sub_title ) {
		echo do_shortcode('[title text="' . addslashes( $title ) . '" subtitle="' . addslashes( $sub_title ) . '" size="big" position="center" decoration="on" underline="' . addslashes( $title_underline ) . '" style="dark"]');
	} ?>
	<div class="at-tours-type__container">
		<?php foreach ( $items as $item ) { ?>
			<?php $detail_url = get_term_link( $item->slug, 'tour_category' ); ?>
			<div class="at-tours-type__item">
				<a href="<?php echo esc_url( $detail_url ); ?>" class="at-tours-type__item__image"><?php // TODO need change: adventure_tours_render_category_thumbnail( $item ); ?></a>
				<div class="at-tours-type__item__title"><a href="<?php echo esc_url( $detail_url ); ?>"><?php echo esc_html( $item->name ); ?></a></div>
			</div>
		<?php } ?>
	</div>
</div>
