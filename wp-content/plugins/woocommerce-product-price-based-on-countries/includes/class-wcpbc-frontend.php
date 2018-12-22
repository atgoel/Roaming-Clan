<?php
/**
 * WooCommerce Price Based Country Front-End
 *
 * @version 1.7.8
 * @package WCPBC/Classes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * WCPBC_Frontend Class
 */
class WCPBC_Frontend {

	/**
	 * Hook actions and filters
	 */
	public static function init() {

		add_filter( 'woocommerce_customer_default_location_array', array( __CLASS__, 'test_default_location' ) );
		add_action( 'wc_price_based_country_before_frontend_init', array( __CLASS__, 'set_customer_country' ), 20 );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'load_scripts' ), 20 );
		add_action( 'wp_footer', array( __CLASS__, 'test_store_message' ) );
	}

	/**
	 * Return Test country as default location
	 *
	 * @param array $location Country and state default location.
	 * @return array
	 */
	public static function test_default_location( $location ) {
		if ( get_option( 'wc_price_based_country_test_mode', 'no' ) === 'yes' && get_option( 'wc_price_based_country_test_country' ) ) {
			$location = wc_format_country_state_string( get_option( 'wc_price_based_country_test_country' ) );
		}
		return $location;
	}

	/**
	 * Set the customer country before the frontend pricing is loaded
	 *
	 * @since 1.7.8
	 */
	public static function set_customer_country() {

		if ( isset( $_GET['pay_for_order'] ) && ! empty( $_GET['key'] ) ) {
			// Pay for order page.
			self::pay_for_order_country( wc_clean( wp_unslash( $_GET['key'] ) ) );

		} elseif ( ! empty( $_REQUEST['wcpbc-manual-country'] ) ) {
			// request param.
			wcpbc_set_woocommerce_country( wc_clean( wp_unslash( $_REQUEST['wcpbc-manual-country'] ) ) );
			add_action( 'send_headers', array( __CLASS__, 'init_session' ), 10 );

		} elseif ( defined( 'WC_DOING_AJAX' ) && WC_DOING_AJAX && isset( $_GET['wc-ajax'] ) && 'update_order_review' === $_GET['wc-ajax'] ) {
			// checkout page.
			self::checkout_country();

		} elseif ( ! empty( $_POST['calc_shipping_country'] ) && self::verify_shipping_calculator_nonce() ) { // WPCS: CSRF ok.
			// Shipping calculator.
			self::calculate_shipping_country();

		}
	}

	/**
	 * Set customer country when customer arrives to the pay for order page
	 *
	 * @param string $order_key Key of the order.
	 * @since 1.7.8
	 */
	private static function pay_for_order_country( $order_key ) {
		$order_id = wc_get_order_id_by_order_key( $order_key );
		if ( $order_id ) {
			$billing_country  = get_post_meta( $order_id, '_billing_country', true );
			$shipping_country = get_post_meta( $order_id, '_shipping_country', true );
			if ( $billing_country ) {
				wcpbc_set_wc_biling_country( $billing_country );
				WC()->customer->set_shipping_country( $billing_country );
			}
			if ( $shipping_country ) {
				WC()->customer->set_shipping_country( $shipping_country );
			}

			add_action( 'send_headers', array( __CLASS__, 'init_session' ), 10 );
		}
	}

	/**
	 * Update WooCommerce Customer country on checkout
	 */
	private static function checkout_country() {

		check_ajax_referer( 'update-order-review', 'security' );

		$country   = isset( $_POST['country'] ) ? wc_clean( wp_unslash( $_POST['country'] ) ) : false;
		$s_country = isset( $_POST['s_country'] ) ? wc_clean( wp_unslash( $_POST['s_country'] ) ) : false;

		if ( $country ) {
			wcpbc_set_wc_biling_country( $country );
		}

		if ( wc_ship_to_billing_address_only() ) {
			if ( $country ) {
				WC()->customer->set_shipping_country( $country );
			}
		} else {
			if ( $s_country ) {
				WC()->customer->set_shipping_country( $s_country );
			}
		}
	}

	/**
	 * Verify the shipping calculator nonce
	 *
	 * @since 1.7.6
	 * @return boolan
	 */
	private static function verify_shipping_calculator_nonce() {

		$nonce_value = ! empty( $_REQUEST['woocommerce-shipping-calculator-nonce'] ) ? $_REQUEST['woocommerce-shipping-calculator-nonce'] : ''; // @codingStandardsIgnoreLine.
		if ( empty( $nonce_value ) && ! empty( $_REQUEST['_wpnonce'] ) ) {
			$nonce_value = $_REQUEST['_wpnonce']; // @codingStandardsIgnoreLine.
		}
		return wp_verify_nonce( $nonce_value, 'woocommerce-shipping-calculator' ) || wp_verify_nonce( $nonce_value, 'woocommerce-cart' );
	}

	/**
	 * Update WooCommerce Customer country on calculate shipping
	 */
	private static function calculate_shipping_country() {

		$country = isset( $_POST['calc_shipping_country'] ) ? wc_clean( wp_unslash( $_POST['calc_shipping_country'] ) ) : ''; // WPCS: input var ok, CSRF ok, sanitization ok.
		if ( $country ) {
			wcpbc_set_wc_biling_country( $country );
			WC()->customer->set_shipping_country( $country );
		}
	}

	/**
	 * Init customer session and refresh cart totals
	 *
	 * @since 1.7.0
	 * @access public
	 */
	public static function init_session() {
		if ( ! WC()->session->has_session() ) {
			WC()->session->set_customer_session_cookie( true );
		}

		// Refresh cart total.
		$cart_content_total = version_compare( WC_VERSION, '3.2', '<' ) ? WC()->cart->cart_contents_total : WC()->cart->get_cart_contents_total();
		if ( $cart_content_total ) {
			WC()->cart->calculate_totals();
		}
	}

	/**
	 * Add scripts
	 */
	public static function load_scripts() {

		if ( ! did_action( 'before_woocommerce_init' ) ) {
			return;
		}

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		$params = array(
			'wc_ajax_url'      => WC_AJAX::get_endpoint( '%%endpoint%%' ),
			'ajax_geolocation' => ! ( ! WCPBC_Ajax_Geolocation::is_enabled() || is_cart() || is_account_page() || is_checkout() || is_customize_preview() ) ? '1' : '0',
			'country'          => wcpbc_get_woocommerce_country(),
		);

		$deps = ( '1' === $params['ajax_geolocation'] && wcpbc_is_pro() ? array( 'wc-cart-fragments', 'wc-price-based-country-pro-frontend' ) : array( 'wc-cart-fragments' ) );

		wp_register_script( 'wc-price-based-country-frontend', WCPBC()->plugin_url() . 'assets/js/wcpbc-frontend' . $suffix . '.js', $deps, WCPBC()->version, true );
		wp_localize_script( 'wc-price-based-country-frontend', 'wc_price_based_country_frontend_params', $params );
		wp_enqueue_script( 'wc-price-based-country-frontend' );
		if ( '1' === $params['ajax_geolocation'] ) {
			wp_enqueue_style( 'wc-price-based-country-frontend', WCPBC()->plugin_url() . 'assets/css/frontend.css', array(), WCPBC()->version );
		}
	}

	/**
	 * Print test store message
	 */
	public static function test_store_message() {
		if ( 'no' === get_option( 'wc_price_based_country_test_mode', 'no' ) ) {
			return;
		}

		$test_country = get_option( 'wc_price_based_country_test_country' );

		if ( $test_country && ! empty( WC()->countries->countries[ $test_country ] ) ) {
			$country = WC()->countries->countries[ $test_country ];
			// translators: HTML tags.
			echo esc_html( '<p class="demo_store">' . sprintf( __( '%1$sPrice Based Country%2$s test mode enabled for testing %3$s. You should do tests on private browsing mode. Browse in private with %4$sFirefox%5$s, %6$sChrome%7$s and %8$sSafari%9$s', 'wc-price-based-country' ), '<strong>', '</strong>', $country, '<a href="https://support.mozilla.org/en-US/kb/private-browsing-use-firefox-without-history">', '</a>', '<a href="https://support.google.com/chrome/answer/95464?hl=en">', '</a>', '<a href="https://support.apple.com/kb/ph19216?locale=en_US">', '</a>' ) . '</p>' );
		}
	}

}

WCPBC_Frontend::init();
