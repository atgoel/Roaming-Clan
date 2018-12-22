<?php
/**
 * Display notices in admin
 *
 * @since   1.7.0
 * @version 1.7.12
 * @package WCPBC/Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'WCPBC_Admin_Notices', false ) ) :

	/**
	 * WCPBC_Admin_Notices Class
	 */
	class WCPBC_Admin_Notices {

		/**
		 * Notices
		 *
		 * @var array
		 */
		private static $notices = array(
			'welcome' => array(
				'hide' => 'no',
			),
			'tracking' => array(
				'hide' => 'no',
			),
			'update_db' => array(
				'hide' => 'yes',
			),
			'updated' => array(
				'hide' => 'yes',
			),
			'request_review' => array(
				'hide'     => 'yes',
				'interval' => '+30 days',
			),
			'geolocation' => array(
				'hide' => 'no',
			),
			'geolocation_ajax' => array(
				'hide' => 'no',
			),
			'maxmind_geoip_database' => array(
				'hide' => 'no',
			),
			'incompatible_multicurrency' => array(
				'hide' => 'no',
			),
			'pro_csv_tool' => array(
				'hide' => 'no',
			),
			'updated_geoip' => array(
				'hide' => 'no',
			),
		);

		/**
		 * Init notices
		 */
		public static function init() {

			add_action( 'admin_init', array( __CLASS__, 'init_notices' ), 1 );
			add_action( 'admin_init', array( __CLASS__, 'hide_notice' ) );
			add_action( 'admin_head', array( __CLASS__, 'enqueue_notices' ) );
			add_action( 'wp_ajax_wcpbc_hide_notice', array( __CLASS__, 'ajax_hide_notice' ) );

			// Pro product types.
			add_action( 'woocommerce_bookings_after_bookings_pricing', array( __CLASS__, 'display_pro_product_type_supported' ) );
			add_action( 'woocommerce_product_options_general_product_data', array( __CLASS__, 'display_pro_product_type_supported' ), 11 );
			add_action( 'woocommerce_product_after_variable_attributes', array( __CLASS__, 'display_pro_product_type_supported') , 11 );

			// Product type not supported.
			add_action( 'woocommerce_product_options_general_product_data', array( __CLASS__, 'display_product_type_not_supported' ), 9 );
		}

		/**
		 * Init notices array
		 */
		public static function init_notices() {
			$store_notices = get_user_meta( get_current_user_id(), 'wc_price_based_country_admin_notices', true );
			self::$notices = wp_parse_args( empty( $store_notices ) ? array() : $store_notices, self::$notices );
		}

		/**
		 * Add notices to admin_notices hook
		 */
		public static function enqueue_notices() {
			if ( ! current_user_can( 'manage_woocommerce' ) ) {
				return;
			}

			foreach ( self::$notices as $key => $notice ) {

				if ( 'yes' === $notice['hide'] && ! isset( $notice['display_at'] ) && ! empty( $notice['interval'] ) ) {
					self::add_notice( $key, true );
				}

				if ( ! empty( $notice['display_at'] ) && time() > $notice['display_at'] ) {
					$notice['hide'] = 'no';
				}

				if ( 'no' === $notice['hide'] ) {
					add_action( 'admin_notices', array( __CLASS__, 'display_' . $key . '_notice' ) );
				}
			}
		}

		/**
		 * Add a notice to display
		 *
		 * @param string  $notice Notice ID.
		 * @param boolean $delay Delay the notice display?.
		 */
		public static function add_notice( $notice, $delay = false ) {
			if ( ! empty( self::$notices[ $notice ] ) ) {
				if ( empty( $delay ) ) {
					self::$notices[ $notice ]['hide'] = 'no';
				} elseif ( ! empty( self::$notices[ $notice ]['interval'] ) ) {
					self::$notices[ $notice ]['hide']       = 'yes';
					self::$notices[ $notice ]['display_at'] = strtotime( self::$notices[ $notice ]['interval'] );
				}

				update_user_meta( get_current_user_id(), 'wc_price_based_country_admin_notices', self::$notices );
			}
		}

		/**
		 * Add a custom notice
		 *
		 * @since 1.7.7
		 * @param string $message Notice text.
		 * @param string $type info|warning|error.
		 */
		public static function add_temp_notice( $message, $type = 'info' ) {
			if ( empty( self::$notices['temp'] ) ) {
				self::$notices['temp'] = array(
					'hide'    => 'no',
					'notices' => array(),
				);
			}

			self::$notices['temp']['notices'][] = array(
				'message' => $message,
				'type'    => $type,
			);
		}

		/**
		 * Remove a notice
		 *
		 * @param string $notice Notice ID.
		 */
		public static function remove_notice( $notice ) {

			self::$notices[ $notice ]['hide']       = 'yes';
			self::$notices[ $notice ]['interval']   = '';
			self::$notices[ $notice ]['display_at'] = '';

			update_user_meta( get_current_user_id(), 'wc_price_based_country_admin_notices', self::$notices );
		}

		/**
		 * Hide a notice via ajax.
		 */
		public static function ajax_hide_notice() {

			check_ajax_referer( 'pbc-hide-notice', 'security' );

			if ( isset( $_POST['notice'] ) ) {

				if ( ! current_user_can( 'manage_woocommerce' ) ) {
					wp_die( esc_html__( 'Cheatin&#8217; huh?', 'wc-price-based-country' ) );
				}

				$notice = sanitize_text_field( wp_unslash( $_POST['notice'] ) );

				if ( ! empty( $_POST['remind'] ) && 'yes' === $_POST['remind'] ) {
					self::add_notice( $notice, true );
				} else {
					self::remove_notice( $notice );
				}
			}

			wp_die();
		}

		/**
		 * Hide welcome notice and tracking notice.
		 */
		public static function hide_notice() {
			// Welcome notice.
			if ( ! empty( $_GET['welcome'] ) && ! empty( $_GET['page'] ) && $_GET['page'] == 'wc-settings' && ! empty( $_GET['_wpnonce'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'pbc-hide-notice' ) ) {
				self::remove_notice( 'welcome' );
			}

			// Tracking notices.
			if ( ! empty( $_GET['wcpbc_tracker_optin'] ) && wp_verify_nonce( $_GET['_wpnonce'], 'pbc-hide-notice' ) ) {

				$_tracker_optin = ( 'yes' === $_GET['wcpbc_tracker_optin'] ) ? 'yes' : 'no';

				update_option( 'wc_price_based_country_allow_tracking', $_tracker_optin );

				if ( 'yes' === $_tracker_optin ) {
					include_once WCPBC()->plugin_path() . 'includes/class-wcpbc-tracker.php';
					WCPBC_Tracker::send_tracking_data();
				}

				// Remove notice.
				self::remove_notice( 'tracking' );
			}
		}

		/**
		 * Display temporaly notices
		 *
		 * @since 1.7.8
		 */
		public static function display_temp_notice() {
			if ( empty( self::$notices['temp']['notices'] ) ) {
				return;
			}
			foreach ( self::$notices['temp']['notices'] as $notice ) {
				extract( $notice );
				include( dirname( __FILE__ ) . '/views/html-notice-default.php' );
			}
		}

		/**
		 * If we have just installed, show a welcome message
		 */
		public static function display_welcome_notice() {
			include( dirname( __FILE__ ) . '/views/html-notice-welcome.php' );
		}

		/**
		 * Update db admin notice
		 */
		public static function display_update_db_notice() {
			include( dirname( __FILE__ ) . '/views/html-notice-update-db.php' );
		}

		/**
		 * Updated admin notice
		 */
		public static function display_updated_notice() {
			include( dirname( __FILE__ ) . '/views/html-notice-updated.php' );
		}

		/**
		 * Request review notice
		 */
		public static function display_request_review_notice() {
			include( dirname( __FILE__ ) . '/views/html-notice-request-review.php' );
		}

		/**
		 * Display geolocation notice
		 */
		public static function display_geolocation_notice() {

			$is_settings_page = isset( $_GET['page'] ) && $_GET['page'] == 'wc-settings' && ( empty( $_GET['tab'] ) || 'general' === $_GET['tab'] );

			if ( ! $is_settings_page && ! in_array( get_option( 'woocommerce_default_customer_address' ) , array( 'geolocation', 'geolocation_ajax' ) ) ) {
				include( dirname( __FILE__ ) . '/views/html-notice-geolocation.php' );
			}
		}

		/**
		 * Display geolocation ajax notice
		 */
		public static function display_geolocation_ajax_notice() {

			$is_settings_page = isset( $_GET['page'] ) && $_GET['page'] == 'wc-settings' && ( empty( $_GET['tab'] ) || 'general' === $_GET['tab'] );

			if ( ! $is_settings_page && 'geolocation' !== get_option( 'woocommerce_default_customer_address' ) && 'yes' === get_option( 'wc_price_based_country_caching_support', 'no' ) ) {
				include( dirname( __FILE__ ) . '/views/html-notice-geolocation-ajax.php' );
			}
		}

		/**
		 * Update db admin notice
		 */
		public static function display_maxmind_geoip_database_notice() {
			if ( ! wcpbc_geoipdb_exists() ) {
				include dirname( __FILE__ ) . '/views/html-notice-maxmind-geoip-database.php';
			}
		}

		/**
		 * Incompatible Multicurrency notice
		 */
		public static function display_incompatible_multicurrency_notice() {
			global $woocommerce_wpml;

			$message = __( 'It looks like another multicurrency plugin is active on your site. %sPrice Based on Country will not work properly%s. We recomended you disable %s.', 'wc-price-based-country' );

			$plugins = array(
				'Alg_WC_Currency_Switcher'  => 'Currency Switcher for WooCommerce by Algoritmika Ltd',
				'WOOCS_STARTER' 		    => 'Currency Switcher for WooCommerce by realmag777',
				'WOOMULTI_CURRENCY_F' 		=> 'Woo Multi Currency by VillaTheme',
				'FMA_Multi_Currency'		=> 'FMA Woo Multi Currency by FME Addons',
				'BeRocket_CE'				=> 'Currency Exchange for WooCommerce by BeRocket'
			);

			foreach ( $plugins as $class_name => $plugin_name ) {
				if ( class_exists( $class_name ) ) {
					$message_text = sprintf( $message, '<span style="color:#a00;">', '</span>', '<strong>' . $plugin_name . '</strong>' );
					include( dirname( __FILE__ ) . '/views/html-notice-incompatible-multicurrency.php' );
				}
			}

			// woo-exchange-rate plugin
			if ( defined( 'WOOER_PLUGIN_URL' ) ) {
				$message_text = sprintf( $message, '<span style="color:#a00;">', '</span>', '<strong>Woo Exchange Rate by Pavel Kolomeitsev</strong>' );
				include( dirname( __FILE__ ) . '/views/html-notice-incompatible-multicurrency.php' );
			}

			if ( ! empty( $woocommerce_wpml->settings['enable_multi_currency'] ) ) {
				$message_text = sprintf( $message, '<span style="color:#a00;">', '</span>', '<a href="' . admin_url( 'admin.php?page=wpml-wcml&tab=multi-currency' ) . '">' . __( 'WooCommerce Multilingual multiple currencies option', 'wc-price-based-country' ) . '</a>' );
				include( dirname( __FILE__ ) . '/views/html-notice-incompatible-multicurrency.php' );
			}
		}

		/**
		 * Tracking notice
		 */
		public static function display_tracking_notice() {
			if ( get_option( 'wc_price_based_country_allow_tracking', false ) === false ) {
				include( dirname( __FILE__ ) . '/views/html-notice-tracking.php' );
			}
		}

		/**
		 * Pro Product type supported
		 */
		public static function display_pro_product_type_supported() {
			if (  wcpbc_is_pro() ) {
				return;
			}

			foreach ( wcpbc_product_types_supported( 'pro' ) as $type => $name ) {
				$utm_source = 'product-' . $type;
				include( dirname( __FILE__ ) . '/views/html-notice-pro-product-type.php' );
			}
		}

		/**
		 * Product type not supported notice
		 */
		public static function display_product_type_not_supported(){
			$supported_product_types = array_keys( wcpbc_product_types_supported() );

			foreach ( wc_get_product_types() as $value => $label ) {
				if ( ! in_array( $value, $supported_product_types ) ) {
					$notice = 'product_type_' . $value . '_not_supported';
					if ( empty( self::$notices[ $notice ]['hide'] ) || 'yes' !== self::$notices[ $notice ]['hide'] ) {
						include( dirname( __FILE__ ) . '/views/html-notice-product-type-not-supported.php' );
					}
				}
			}
		}

		/**
		 * Upgrade to Pro to import/export tool
		 */
		public static function display_pro_csv_tool_notice() {
			if ( wcpbc_is_pro() ) {
				return;
			}

			if ( ! empty( $_GET['post_type'] ) && $_GET['post_type'] == 'product' && ! empty( $_GET['page'] ) && in_array( $_GET['page'], array( 'product_importer', 'product_exporter' ) ) ) {
				$import_export = ( $_GET['page'] == 'product_importer' ? __( 'import', 'wc-price-based-country' ) : __( 'export', 'wc-price-based-country' ) );
				include( dirname( __FILE__ ) . '/views/html-notice-pro-csv-tool.php' );
			}
		}

		/**
		 * GeoIP database update result
		 */
		public static function display_updated_geoip_notice() {
			$updated_geoip = get_transient( 'wcpbc_updated_geoip' );
			if ( false !== $updated_geoip ) {
				delete_transient( 'wcpbc_updated_geoip' );

				if ( 'yes' === $updated_geoip ) {
					$message = 'GeoIP database updated';
					$type    = 'success';
					include dirname( __FILE__ ) . '/views/html-notice-default.php';
				} else {
					include dirname( __FILE__ ) . '/views/html-notice-unable-install-geoip.php';
				}
			}
		}

	}

	WCPBC_Admin_Notices::init();

endif;
