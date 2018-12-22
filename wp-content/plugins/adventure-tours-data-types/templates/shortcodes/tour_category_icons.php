<?php
/**
 * Shortcode [tour_category_icons] view.
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
<div class="at-tours-type-icons<?php if ( $css_class ) { echo esc_attr( ' ' . $css_class ); } ?>">
	<?php if ( $title || $sub_title ) {
		echo do_shortcode( '[title text="' . addslashes( $title ) . '" subtitle="' . addslashes( $sub_title ) . '" size="big" position="center" decoration="on" underline="' . addslashes( $title_underline ) . '" style="light"]' );
	} ?>
	<div class="at-tours-type-icons__container">
		<?php foreach ( $items as $item ) { ?>
			<?php
			//TODO need change: $icon_class = (TourHelper)::get_tour_category_icon_class( $item->term_id );
			$icon_class = '';
			$detail_url = get_term_link( $item->slug, 'tour_category' );
			?>
			<div class="at-tours-type-icons__item">
				<a href="<?php echo esc_url( $detail_url ); ?>" class="at-tours-type-icons__item__container">
					<span class="at-tours-type-icons__item__content">
						<?php if ( $icon_class ) { ?>
							<i class="<?php echo esc_attr( $icon_class ); ?>"></i>
						<?php } ?>
						<?php echo esc_html( $item->name ); ?>
					</span>
				</a>
			</div>
		<?php } ?>
	</div>
</div>
