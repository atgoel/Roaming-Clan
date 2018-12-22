<?php
/**
 * Shortcode [icon_tick] view.
 * For more detailed list see list of shortcode attributes.
 *
 * @var boolean $state
 * @var string  $css_class
 * @var string  $view
 *
 * @author    Themedelight
 * @package   Themedelight/AdventureTours
 * @version   1.2.0
 */

if ( $css_class ) {
	$css_class = ' ' . $css_class;
}

if ( $state ) {
	echo '<i class="fa fa-check at-icon-tick at-icon-tick--on' . ( $css_class ? ' ' . esc_attr( $css_class ) : '' ) . '"></i>';
} else {
	echo '<i class="fa fa-times at-icon-tick at-icon-tick--off' . ( $css_class ? ' ' . esc_attr( $css_class ) : '' ) . '"></i>';
}
