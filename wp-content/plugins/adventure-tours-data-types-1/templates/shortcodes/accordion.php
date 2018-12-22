<?php
/**
 * Shortcode [accordion] view.
 * For more detailed list see list of shortcode attributes.
 *
 * @var string $content
 * @var string $style
 * @var string $accordion_id
 * @var string $css_class
 * @var string $view
 *
 * @author    Themedelight
 * @package   Themedelight/AdventureTours
 * @version   1.2.0
 */

if ( ! $content ) {
	return;
}

printf(
	'<div class="panel-group%s" id="%s">%s</div>',
	$css_class ? ' ' . esc_attr( $css_class ) : '',
	esc_attr( $accordion_id ),
	do_shortcode( $content )
);
