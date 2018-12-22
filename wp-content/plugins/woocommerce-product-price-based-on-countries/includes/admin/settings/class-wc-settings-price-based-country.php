<?php
/**
 * WooCommerce Price Based Country settings page
 *
 * @version 1.7.12
 * @package WCPBC/Admin
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! class_exists( 'WC_Settings_Price_Based_Country' ) ) :

	/**
	 * WC_Settings_Price_Based_Country Class
	 */
	class WC_Settings_Price_Based_Country extends WC_Settings_Page {

		/**
		 * Constructor.
		 */
		public function __construct() {

			$this->id    = 'price-based-country';
			$this->label = __( 'Zone Pricing', 'wc-price-based-country' );

			add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
			add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
			add_action( 'woocommerce_sections_' . $this->id, array( $this, 'show_zone_messages' ), 5 );
			add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
			add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );

			// Table list row actions.
			self::regions_list_row_actions();
		}

		/**
		 * Get sections
		 *
		 * @return array
		 */
		public function get_sections() {
			$sections = array(
				''      => __( 'General options', 'wc-price-based-country' ),
				'zones' => __( 'Zones', 'wc-price-based-country' ),
			);

			return apply_filters( 'wc_price_based_country_get_sections', $sections );
		}

		/**
		 * Get settings array
		 *
		 * @return array
		 */
		public function get_settings() {
			$settings = apply_filters( 'wc_price_based_country_settings', array(
				array(
					'title' => __( 'General Options', 'woocommerce' ),
					'type'  => 'title',
					'desc'  => '',
					'id'    => 'general_options',
				),

				array(
					'title'    => __( 'Price Based On', 'wc-price-based-country' ),
					'desc'     => __( 'This controls which address is used to refresh products prices on checkout.' ),
					'id'       => 'wc_price_based_country_based_on',
					'default'  => 'billing',
					'type'     => 'select',
					'class'    => 'wc-enhanced-select',
					'desc_tip' => true,
					'options'  => array(
						'billing'  => __( 'Customer billing country', 'wc-price-based-country' ),
						'shipping' => __( 'Customer shipping country', 'wc-price-based-country' ),
					),
				),

				array(
					'title'   => __( 'Shipping', 'wc-price-based-country' ),
					'desc'    => __( 'Apply exchange rates to shipping cost.', 'wc-price-based-country' ),
					'id'      => 'wc_price_based_country_shipping_exchange_rate',
					'default' => 'no',
					'type'    => 'checkbox',
				),

				array(
					'title'    => __( 'Caching support', 'wc-price-based-country' ),
					'desc'     => __( 'Load products price in background.', 'wc-price-based-country' ),
					'id'       => 'wc_price_based_country_caching_support',
					'default'  => 'no',
					'type'     => 'checkbox',
					// translators: HTML tags.
					'desc_tip' => sprintf( __( 'This fired an AJAX request per page (%1$sread more%2$s).' ), '<a target="_blank" rel="noopener noreferrer" href="https://www.pricebasedcountry.com/docs/getting-started/geolocation-cache-support/?utm_source=settings&utm_medium=banner&utm_campaign=Docs">', '</a>' ),
				),

				array(
					'title'    => __( 'Test mode', 'wc-price-based-country' ),
					'desc'     => __( 'Enable test mode', 'wc-price-based-country' ),
					'id'       => 'wc_price_based_country_test_mode',
					'default'  => 'no',
					'type'     => 'checkbox',
					// translators: HTML tags.
					'desc_tip' => sprintf( __( 'Enable test mode to show pricing for a specific country (%1$sHow to test%2$s).', 'wc-price-based-country' ), '<a target="_blank" rel="noopener noreferrer" href="https://www.pricebasedcountry.com/docs/getting-started/testing/?utm_source=settings&utm_medium=banner&utm_campaign=Docs">', '</a>' ),
				),

				array(
					'title'   => __( 'Test country', 'wc-price-based-country' ),
					'id'      => 'wc_price_based_country_test_country',
					'default' => wc_get_base_location(),
					'type'    => 'select',
					'class'   => 'chosen_select',
					'options' => WC()->countries->countries,
					'desc'    => __( 'If test mode is enabled, a demo store notice will be displayed.', 'wc-price-based-country' ),
				),

				array(
					'type' => 'sectionend',
					'id'   => 'general_options',
				),
			));

			return $settings;
		}

		/**
		 * Output the settings
		 */
		public function output() {
			global $current_section;

			ob_start();

			if ( 'zones' === $current_section ) {
				self::regions_output();

			} elseif ( 'license' === $current_section && class_exists( 'WCPBC_License_Settings' ) ) {
				WCPBC_License_Settings::output_fields();

			} else {
				$settings = $this->get_settings( $current_section );
				WC_Admin_Settings::output_fields( $settings );
			}

			$output = ob_get_clean();

			if ( wcpbc_is_pro() ) {
				echo $output; // phpcs:ignore WordPress.Security.EscapeOutput
			} else {
				self::output_ads( $output );
			}
		}

		/**
		 * Output the settings with ads
		 *
		 * @param string $output The setting page.
		 */
		public function output_ads( $output ) {
			?>
			<div class="wc-price-based-country-setting-wrapper-ads">
				<div class="wc-price-based-country-setting-content"><?php echo $output; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
				<div class="wc-price-based-country-setting-sidebar"><?php include dirname( __FILE__ ) . '/views/html-addons-banner.php'; ?></div>
			</div>
			<?php
		}


		/**
		 * Save settings
		 */
		public function save() {
			global $current_section;

			if ( 'zones' === $current_section && ( isset( $_GET['edit_region'] ) || isset( $_GET['add_region'] ) ) ) {

				self::regions_save();

			} elseif ( 'zones' === $current_section && ( ( ! empty( $_POST['action'] ) && 'remove' === $_POST['action'] ) || ( ! empty( $_POST['action2'] ) && 'remove' === $_POST['action2'] ) ) ) { // phpcs:ignore WordPress.CSRF.NonceVerification.NoNonceVerification

				self::regions_delete_bulk();

			} elseif ( 'license' === $current_section && class_exists( 'WCPBC_License_Settings' ) ) {

				WCPBC_License_Settings::save_fields();

			} elseif ( 'zones' !== $current_section ) {
				// Save settings.
				$settings = $this->get_settings();
				WC_Admin_Settings::save_fields( $settings );

				update_option( 'wc_price_based_country_timestamp', time() );

				// Update WooCommerce Default Customer Address.
				if ( 'geolocation_ajax' === get_option( 'woocommerce_default_customer_address' ) && 'yes' === get_option( 'wc_price_based_country_caching_support', 'no' ) ) {
					update_option( 'woocommerce_default_customer_address', 'geolocation' );
				}
			}
		}

		/**
		 * Output zone update message
		 */
		public function show_zone_messages() {
			global $current_section;
			if ( 'zones' === $current_section && ! empty( $_GET['edit_region'] ) && ! empty( $_GET['updated'] ) ) {
				?>
				<div id="message" class="updated inline">
					<p>
						<strong><?php esc_html_e( 'Zone updated successfully.', 'wc-price-based-country' ); ?></strong>
					</p>
					<p>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=wc-settings&tab=price-based-country&section=zones' ) ); ?>">&larr; <?php esc_html_e( 'Back to Zones', 'wc-price-based-country' ); ?></a>
						<a style="margin-left:15px;" href="<?php echo esc_url( admin_url( 'admin.php?page=wc-settings&tab=price-based-country&section=zones&add_region=1' ) ); ?>"><?php esc_html_e( 'Add a new zone', 'wc-price-based-country' ); ?></a>
					</p>
				</div>
				<?php
			}
		}

		/**
		 * Regions Page output
		 */
		private static function regions_output() {

			$GLOBALS['hide_save_button'] = true;

			if ( isset( $_GET['add_region'] ) || isset( $_GET['edit_region'] ) ) {
				$region_key        = isset( $_GET['edit_region'] ) ? wc_clean( wp_unslash( $_GET['edit_region'] ) ) : null;
				$region            = self::get_regions_data( $region_key );
				$allowed_countries = self::get_allowed_countries( $region_key );
				include dirname( __FILE__ ) . '/views/html-regions-edit.php';
			} else {
				self::regions_table_list_output();
			}
		}

		/**
		 * Regions table list output
		 */
		private static function regions_table_list_output() {

			include_once WCPBC()->plugin_path() . 'includes/admin/class-wcpbc-admin-regions-table-list.php';

			echo '<h3>' . esc_html__( 'Zones', 'wc-price-based-country' ) . ' <a href="' . esc_url( admin_url( 'admin.php?page=wc-settings&tab=price-based-country&section=zones&add_region=1' ) ) . '" class="add-new-h2">' . esc_html__( 'Add Zone', 'wc-price-based-country' ) . '</a></h3>';

			$keys_table_list = new WCPBC_Admin_Regions_Table_List();
			$keys_table_list->prepare_items();
			$keys_table_list->views();
			$keys_table_list->display();
		}

		/**
		 * Get region data
		 *
		 * @param string $key Zone ID.
		 * @param array  $values Array of values to add to the region data.
		 * @return array
		 */
		private static function get_regions_data( $key, $values = false ) {

			$region = apply_filters( 'wc_price_based_country_default_region_data', array(
				'name'               => '',
				'countries'          => array(),
				'currency'           => wcpbc_get_base_currency(),
				'empty_price_method' => '',
				'exchange_rate'      => '1',
			));

			$regions = get_option( 'wc_price_based_country_regions', array() );

			if ( array_key_exists( $key, $regions ) ) {
				$region = wp_parse_args( $regions[ $key ], $region );
			}

			if ( is_array( $values ) ) {
				$region                  = array_intersect_key( $values, $region );
				$region['exchange_rate'] = isset( $region['exchange_rate'] ) ? wc_format_decimal( $region['exchange_rate'] ) : 0;
			}

			return $region;
		}

		/**
		 * Get allowed countries
		 *
		 * @param string $selected_key The selected country code.
		 * @return array
		 */
		private static function get_allowed_countries( $selected_key ) {

			$regions              = get_option( 'wc_price_based_country_regions', array() );
			$countries_in_regions = array();

			foreach ( $regions as $key => $region ) {
				if ( $key !== $selected_key ) {
					$countries_in_regions = array_merge( $region['countries'], $countries_in_regions );
				}
			}

			if ( 'specific' === get_option( 'woocommerce_allowed_countries' ) ) {
				$allowed_countries = array_diff( get_option( 'woocommerce_specific_allowed_countries' ), $countries_in_regions );
			} else {
				$allowed_countries = array_diff( array_keys( WC()->countries->countries ), $countries_in_regions );
			}

			wcpbc_maybe_asort_locale( $allowed_countries );

			return $allowed_countries;
		}

		/**
		 * Get a unique slug that indentify a region
		 *
		 * @param string $new_slug New slug.
		 * @param array  $slugs All ID of the regions.
		 * @return array
		 */
		private static function get_unique_slug( $new_slug, $slugs ) {

			$seqs = array();

			foreach ( $slugs as $slug ) {
				$slug_parts = explode( '-', $slug, 2 );
				if ( $slug_parts[0] === $new_slug && ( count( $slug_parts ) === 1 || is_numeric( $slug_parts[1] ) ) ) {
					$seqs[] = isset( $slug_parts[1] ) ? $slug_parts[1] : 0;
				}
			}

			if ( $seqs ) {
				rsort( $seqs );
				$new_slug = $new_slug . '-' . ( $seqs[0] + 1 );
			}

			return $new_slug;
		}

		/**
		 * Check if an addon added error by WC_Admin_Settings::add_error
		 *
		 * @since 1.7.12
		 * @return boolean
		 */
		private static function has_errors() {

			ob_start();
			WC_Admin_Settings::show_messages();
			$messages   = ob_get_clean();
			$has_errors = false !== strpos( $messages, 'class="error inline"' );

			return $has_errors;
		}

		/**
		 * Validate region data
		 *
		 * @param array $fields Array of fields to validate.
		 * @return boolean
		 */
		private static function validate_region_fields( $fields ) {

			$valid = false;

			if ( empty( $fields['name'] ) ) {
				WC_Admin_Settings::add_error( __( 'Zone name is required.', 'wc-price-based-country' ) );

			} elseif ( ! isset( $fields['countries'] ) || empty( $fields['countries'] ) ) {
				WC_Admin_Settings::add_error( __( 'Add at least one country to the list.', 'wc-price-based-country' ) );

			} elseif ( empty( $fields['exchange_rate'] ) || '0' == $fields['exchange_rate'] ) {
				WC_Admin_Settings::add_error( __( 'Exchange rate must be nonzero.', 'wc-price-based-country' ) );

			} elseif ( ! self::has_errors() ) {
				$valid = true;
			}

			return apply_filters( 'wc_price_based_country_admin_region_fields_validate', $valid, $fields ) && $valid;
		}

		/**
		 * Save region
		 */
		private static function regions_save() {

			$region_key = isset( $_GET['edit_region'] ) ? wc_clean( wp_unslash( $_GET['edit_region'] ) ) : null;

			do_action( 'wc_price_based_country_before_region_data_save' );

			$region = self::get_regions_data( $region_key, wc_clean( $_POST ) ); // WPCS: CSRF ok.

			if ( self::validate_region_fields( $region ) ) {

				$regions = get_option( 'wc_price_based_country_regions', array() );

				if ( is_null( $region_key ) ) {

					$region_key = self::get_unique_slug( sanitize_key( sanitize_title( $region['name'] ) ), array_keys( $regions ) );
				}

				$regions[ $region_key ] = $region;

				update_option( 'wc_price_based_country_regions', $regions );

				update_option( 'wc_price_based_country_timestamp', time() );

				// Sync product prices with exchange rate.
				wcpbc_sync_exchange_rate_prices( $region_key, $region['exchange_rate'] );

				// Redirect to display a notice.
				if ( version_compare( WC_VERSION, '2.6', '>=' ) ) {
					wp_safe_redirect( admin_url( 'admin.php?page=wc-settings&tab=price-based-country&section=zones&edit_region=' . $region_key . '&updated=1' ) );
				}
			}
		}

		/**
		 * Regions table list row actions
		 */
		private static function regions_list_row_actions() {
			if ( isset( $_GET['remove_region'] ) &&
				isset( $_GET['page'] ) && 'wc-settings' == $_GET['page'] &&
				isset( $_GET['tab'] ) && 'price-based-country' == $_GET['tab'] &&
				isset( $_GET['section'] ) && 'zones' == isset( $_GET['section'] )
				) {

				self::regions_delete();
			}
		}

		/**
		 * Delete region
		 */
		private static function regions_delete() {

			if ( empty( $_GET['_wpnonce'] ) || ! wp_verify_nonce( $_GET['_wpnonce'], 'wc-price-based-country-remove-region' ) ) { // WPCS: input var ok, sanitization ok.
				wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'woocommerce' ) );
			}

			$region_key = ! empty( $_GET['remove_region'] ) ? wc_clean( wp_unslash( $_GET['remove_region'] ) ) : '';
			$regions    = get_option( 'wc_price_based_country_regions', array() );

			if ( isset( $regions[ $region_key ] ) ) {

				unset( $regions[ $region_key ] );
				self::regions_delete_post_meta( $region_key );

				update_option( 'wc_price_based_country_regions', $regions );
				update_option( 'wc_price_based_country_timestamp', time() );

				WC_Admin_Settings::add_message( __( 'Zone have been deleted.', 'wc-price-based-country' ) );
			}
		}

		/**
		 * Bulk delete regions
		 */
		private static function regions_delete_bulk() {
			if ( empty( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'woocommerce-settings' ) ) { // WPCS: input var ok, sanitization ok.
				wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'woocommerce' ) );
			}

			$region_keys = ! empty( $_POST['region_key'] ) ? wc_clean( wp_unslash( $_POST['region_key'] ) ) : false;
			$regions     = get_option( 'wc_price_based_country_regions', array() );

			if ( is_array( $region_keys ) ) {

				foreach ( $region_keys as $region_key ) {
					if ( isset( $regions[ $region_key ] ) ) {
						unset( $regions[ $region_key ] );
						self::regions_delete_post_meta( $region_key );
					}
				}

				update_option( 'wc_price_based_country_regions', $regions );
				update_option( 'wc_price_based_country_timestamp', time() );
			}
		}

		/**
		 * Delete postmeta data
		 *
		 * @param string $region_key Zone ID.
		 */
		private static function regions_delete_post_meta( $region_key ) {
			global $wpdb;

			$meta_keys = wcpbc_get_overwrite_meta_keys();
			array_push( $meta_keys, '_price_method', '_sale_price_dates' );

			foreach ( $meta_keys as $meta_key ) {
				$wpdb->delete( $wpdb->postmeta, array( 'meta_key' => '_' . $region_key . $meta_key ) );
			}
		}
	}

endif;

return new WC_Settings_Price_Based_Country();
