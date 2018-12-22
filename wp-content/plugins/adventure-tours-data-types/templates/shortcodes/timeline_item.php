<?php
/**
 * Shortcode [timeline_item] view.
 * For more detailed list see list of shortcode attributes.
 *
 * @var string $item_number
 * @var string $title
 * @var string $content
 * @var string $view
 *
 * @author    Themedelight
 * @package   Themedelight/AdventureTours
 * @version   1.0.0
 */

?>
<div class="at-timeline__item">
	<div class="at-timeline__item__icon"><?php echo esc_html( $item_number ); ?></div>
	<div class="at-timeline__item__content">
		<?php if ( $title ) {
			printf( '<h3 class="at-timeline__item__title">%s</h3>', esc_html( $title ) );
		} ?>
		<?php if ( $content ) {
			printf( '<div class="at-timeline__item__description">%s</div>', do_shortcode( $content ) );
		} ?>
	</div>
</div>
