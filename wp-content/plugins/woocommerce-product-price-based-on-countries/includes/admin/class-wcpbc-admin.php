<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * WCPBC_Admin
 *
 * WooCommerce Price Based Country Admin
 *
 * @class 		WCPBC_Admin
 * @version		1.7.9
 * @author 		oscargare
 * @category	Class
 */
class WCPBC_Admin {

	/**
	 * Hook actions and filters
	 */
	public static function init(){

		add_action( 'init', array( __CLASS__, 'includes' ) );
		add_action( 'init', array( __CLASS__, 'update_geoip_database' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'admin_styles' ) );
		add_action( 'woocommerce_coupon_options', array( __CLASS__, 'coupon_options' ) );
		add_action( 'woocommerce_coupon_options_save', array( __CLASS__, 'coupon_options_save' ) );
		add_action( 'woocommerce_system_status_report', array( __CLASS__, 'system_status_report' ) );
		add_action( 'update_option_woocommerce_specific_allowed_countries', array( __CLASS__, 'update_allowed_countries' ), 10, 3 );
		add_action( 'woocommerce_order_item_add_action_buttons', array( __CLASS__, 'order_item_add_action_buttons' ) );
		add_filter( 'woocommerce_get_settings_pages', array( __CLASS__, 'settings_price_based_country' ) );
		add_filter( 'woocommerce_paypal_supported_currencies', array( __CLASS__, 'paypal_supported_currencies' ) );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public static function includes() {

		include_once('class-wcpbc-admin-product-data.php');
		include_once('class-wcpbc-admin-report.php');

		do_action('wc_price_based_country_admin_init');
	}

	/**
	 * Update the GeoIP database
	 *
	 * @since 1.7.7
	 * @version 1.7.12 Do a safe redirect to remove the get parameter.
	 */
	public static function update_geoip_database() {
		if ( ! empty( $_GET['wcpbc_update_geoip_database'] ) && current_user_can( 'manage_woocommerce' ) && check_admin_referer( 'wcpbc-update-geoipdb', 'wcpbc_update_geoip_database' ) && is_callable( array( 'WC_Geolocation', 'update_database' ) ) ) {
			WC_Geolocation::update_database();
			set_transient( 'wcpbc_updated_geoip', wcpbc_geoipdb_exists() ? 'yes' : 'no' );
			wp_safe_redirect( wp_get_referer() ? remove_query_arg( array( 'wcpbc-update-geoipdb', 'trashed', 'untrashed', 'deleted', 'ids' ), wp_get_referer() ) : admin_url( 'admin.php?page=wc-settings&tab=price-based-country' ) );
			exit;
		}
	}

	/**
	 * Update countries of zones when the option allowed countries is updated
	 * *
	 * @param mixed  $old_value The old option value.
     * @param mixed  $value     The new option value.
     * @param string $option    Option name.
	 */
	public static function update_allowed_countries( $old_value, $allowed_countries, $option ) {
		if ( 'specific' === get_option('woocommerce_allowed_countries') ) {

			$zones = get_option( 'wc_price_based_country_regions', array() );
			foreach (  $zones as $key => $zone ) {
				$zones[$key][ 'countries' ] = array_intersect( $zone[ 'countries' ], $allowed_countries );
				if ( empty( $zones[$key][ 'countries' ] ) )	{
					unset( $zones[ $key ] );
				}
			}

			update_option( 'wc_price_based_country_regions', $zones );
		}
	}

	/**
	 * Add Price Based Country settings tab to woocommerce settings
	 */
	public static function settings_price_based_country( $settings ) {

		$settings[] = include( 'settings/class-wc-settings-price-based-country.php' );

		return $settings;
	}

	/**
	 * PayPal supported currencies
	 *
	 * @since 1.6.4
	 */
	public static function paypal_supported_currencies( $paypal_currencies ){

		$base_currency = wcpbc_get_base_currency();

		if ( ! in_array( $base_currency, $paypal_currencies ) ) {
			foreach ( WCPBC()->get_regions() as $zone ) {
				if ( in_array( $zone['currency'], $paypal_currencies ) ) {
					$paypal_currencies[] = $base_currency;
					break;
				}
			}
		}

		return $paypal_currencies;
	}

	/**
	 * Enqueue styles.
	 *
	 * @since 1.6
	 */
	public static function admin_styles() {
		// Register admin styles
		wp_enqueue_style( 'wc-price-based-country-admin-styles', WCPBC()->plugin_url() . '/assets/css/admin.css', array(), WCPBC()->version );
	}

	/**
	 * Enqueue scripts.
	 */
	public static function admin_scripts( ) {

		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

		// Register scripts
		wp_register_script( 'wc-price-based-country-admin', WCPBC()->plugin_url() . 'assets/js/wcpbc-admin' . $suffix . '.js', array( 'jquery' ), WCPBC()->version, true );
		wp_localize_script( 'wc-price-based-country-admin', 'wc_price_based_country_admin_params', array(
			'ajax_url'				 	 => admin_url( 'admin-ajax.php' ),
			'product_type_supported' 	 => array_keys( wcpbc_product_types_supported() ),
			'i18n_delete_zone_alert' 	 => __( 'Are you sure?', 'wc-price-based-country' ),
			'i18n_caching_support_alert' => __( 'You must clear cache after enabling this option.', 'wc-price-based-country' ),
		) );
		wp_enqueue_script( 'wc-price-based-country-admin' );
	}


	/**
	 * Display coupon amount options.
	 *
	 * @since 1.6
	 */
	public static function coupon_options(){
		woocommerce_wp_checkbox( array( 'id' => 'zone_pricing_type', 'cbvalue' => 'exchange_rate', 'label' => __( 'Calculate amount by exchange rate', 'wc-price-based-country' ), 'description' => __( 'Check this box if for the countries defined in zone pricing the coupon amount should be calculated using exchange rate.', 'wc-price-based-country' ) ) );
	}

	/**
	 * Save coupon amount options.
	 *
	 * @since 1.6
	 */
	public static function coupon_options_save( $post_id ){
		$type = get_post_meta( $post_id, 'discount_type' , true );
		$zone_pricing_type = in_array( $type, array( 'fixed_cart', 'fixed_product' ) ) && isset( $_POST['zone_pricing_type'] ) ? 'exchange_rate' : 'nothig';
		update_post_meta( $post_id, 'zone_pricing_type', $zone_pricing_type ) ;
	}

	/**
	 * Add plugin info to WooCommerce System Status Report
	 *
	 * @since 1.6.3
	 */
	public static function system_status_report(){
		include_once( 'views/html-admin-page-status-report.php' );
	}

	/**
	 * Display load country pricing button
	 *
	 * @since 1.7.9
	 * @param WC_Order $order
	 */
	public static function order_item_add_action_buttons( $order ){
		if ( ! wcpbc_is_pro() && version_compare( WC_VERSION, '3.0', '>=' ) && $order->is_editable() ) {
			echo '<button type="button" class="button wcpbc-upgrade-pro-popup">' . __( 'Load country pricing', 'wc-price-based-country-pro' ) . '</button>';
			add_action( 'admin_footer', array( __CLASS__, 'upgrade_pro_popup' ) );
		}
	}

	/**
	 * Output the variable bulk edit popup
	 *
	 * @since 1.7.9
	 */
	public static function upgrade_pro_popup(){
		add_thickbox();
		?>
			<div id="wcpbc-upgrade-pro-popup-content" style="display:none;">
				<h3 style="margin: 1em 0; font-size: 1.3em;">
					<?php
					if ( get_post_type() == 'product' ) {
					   _e( 'Do you want to bulk edit the prices of the variations?', 'wc-price-based-country' );
					   $utm_source = 'bulk-edit';
					} else {
					   _e( 'Do you need to add orders manually?', 'wc-price-based-country' );
					   $utm_source = 'edit-order';
					}
				   ?>
			   </h3>
				<p><?php _e( sprintf( 'Great news: you can, with %sPrice Based on Country Pro!%s', '<a href="https://www.pricebasedcountry.com/pricing/?utm_source=bulk-edit&utm_medium=banner&utm_campaign=Get_Pro">', '</a>' ), 'wc-price-based-country' ); ?></p>
				<p><?php _e( 'Other benefits of Pro version:', 'wc-price-based-country' ); ?></p>
				<ul>
					<li><span class="feature_text"><?php _e( 'Automatic updates of exchange rates.', 'wc-price-based-country' ); ?></span></li>
				   	<li><span class="feature_text"><?php _e( 'Round up to nearest.', 'wc-price-based-country' ); ?></span></li>
				   	<li><span class="feature_text"><?php _e( 'Currency switcher widget.', 'wc-price-based-country' ); ?></span></li>
				   	<li><span class="feature_text"><?php _e( 'Support for the import/export WooCommerce tool.', 'wc-price-based-country' ); ?></span></li>
					<li><span class="feature_text"><?php _e( 'Support to WooCommerce Subscriptions.', 'wc-price-based-country' ); ?></span></li>
					<li><span class="feature_text"><?php _e( 'Support to WooCommerce Product Add-ons.', 'wc-price-based-country' ); ?></span></li>
					<li><span class="feature_text"><?php _e( 'No ads!', 'wc-price-based-country' ); ?></span></li>
				</ul>
				<p><a target="_blank" rel="noopener noreferrer" class="button button-primary" href="https://www.pricebasedcountry.com/pricing/?utm_source=<?php echo $utm_source; ?>&utm_medium=banner&utm_campaign=Get_Pro"><?php _e( 'Upgrade to Price Based on Country Pro now!', 'wc-price-based-country' ); ?></a></p>
			</div>
		<?php
   }


}

WCPBC_Admin::init();
