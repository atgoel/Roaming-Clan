<?php
/**
 * Admin View: Notice - Geolocation
 *
 * @package WCPBC/Admin/Views
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="notice notice-warning notice-pbc pbc-is-dismissible">
	<a class="notice-dismiss pbc-hide-notice notice-pbc-close" data-nonce="<?php echo esc_attr( wp_create_nonce( 'pbc-hide-notice' ) ); ?>" data-notice="geolocation" href="#"><?php esc_html_e( 'Dismiss' ); ?></a>
	<?php // Translators: HTML tags. ?>
	<p><strong>WooCommerce Price Based on Country:</strong> <?php printf( esc_html__( 'Geolocation is required. Set %1$sDefault customer location%2$s to %3$sGeolocate%4$s.', 'wc-price-based-country' ), '<a href="' . esc_url( admin_url( 'admin.php?page=wc-settings' ) ) . '">', '</a>', '<strong><em>', '</em></strong>' ); ?></p>
</div>
