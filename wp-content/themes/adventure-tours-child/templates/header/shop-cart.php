<?php
/**
 * Shopping cart icon rendring templated.
 *
 * @author    Themedelight
 * @package   Themedelight/AdventureTours
 * @version   2.0.0
 */

if ( ! class_exists( 'WooCommerce' ) || ! adventure_tours_get_option( 'show_header_shop_cart' ) ) {
	return;
}

$cart_qty = WC()->cart->get_cart_contents_count();
?>
<div class="header__info__item header__info__item--delimiter header__info__item--shoping-cart">
	<a href="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>">
		<i class="fa fa-shopping-cart"></i>
		<?php if ( $cart_qty > 0 ) {
			echo '(' . esc_html( $cart_qty ) . ')';
		} ?>
	</a>
</div>

<div class="header__info__item header__info__item--delimiter">
	<?php if ( is_user_logged_in() ) {
		printf( '<a href="%s" title="%s" style="margin-right:15px;"><i class="fa fa-user"></i></a>', get_permalink( get_option('woocommerce_myaccount_page_id') ), 'My Account' );

		printf( '<a href="%s" title="%s"><i class="fa fa-sign-out"></i></a>', wp_logout_url(), 'Log out' );
	} else {
		printf( '<a href="%s" title="%s"><i class="fa fa-sign-in"></i></a>', wp_login_url(), 'Log in' );
		printf( '<a href="%s" title="%s" style="margin-left:15px;"><i class="fa fa-user-plus"></i></a>', wp_registration_url(), 'Sign up' );
	} ?>
</div>
