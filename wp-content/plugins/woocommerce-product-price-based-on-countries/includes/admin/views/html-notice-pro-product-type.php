<?php
/**
 * Admin View: Notice - Pro Product type supported
 *
 * @package WCPBC/Admin/Views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<p <?php echo ( empty( $type ) ? '' : 'style="display:none;" ' ); ?>class="wc-price-based-country-upgrade-notice <?php echo ( empty( $type ) ? 'show' : 'wc-pbc-show-if-' . esc_attr( $type ) ); ?>">
	<?php // Translators: HTML tags. ?>
	<?php printf( esc_html__( '%1$sUpgrade to Price Based on Country Pro to enable compatibility with %2$s%3$s.', 'wc-price-based-country' ), '<a target="_blank" href="' . esc_url( 'https://www.pricebasedcountry.com/pricing/?utm_source=' . $utm_source . '&utm_medium=banner&utm_campaign=Get_Pro' ) . '">', esc_html( $name ), '</a>' ); ?>
</p>
