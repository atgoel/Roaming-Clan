<?php
/**
 * Geolocation via Ajax
 *
 * @since   1.7.0
 * @version 1.7.13
 * @package WCPBC/Classes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Ajax Geolocation Class
 */
class WCPBC_Ajax_Geolocation {

	/**
	 * Init hooks
	 */
	public static function init() {
		if ( self::is_enabled() ) {
			add_filter( 'woocommerce_get_price_html', array( __CLASS__, 'price_html_wrapper' ), 0, 2 );
			add_action( 'wc_ajax_wcpbc_get_location', array( __CLASS__, 'get_customer_location' ) );
			add_filter( 'wc_price_based_country_ajax_geolocation_widget_content', array( __CLASS__, 'widget_content' ), 10, 2 );
		}
	}

	/**
	 * Is ajax geolocation enabled?
	 *
	 * @return boolean
	 */
	public static function is_enabled() {
		return 'yes' === get_option( 'wc_price_based_country_caching_support', 'no' );
	}

	/**
	 * Add a wrapper to html price
	 *
	 * @param string     $price HTML product price.
	 * @param WC_Product $product The product object.
	 */
	public static function price_html_wrapper( $price, $product ) {
		if ( is_callable( array( 'WC_Subscriptions_Product', 'is_subscription' ) ) && WC_Subscriptions_Product::is_subscription( $product ) ) {
			return $price;
		}

		return self::wrapper_price( $product, $price );
	}

	/**
	 * Retrun html with the wrapper
	 *
	 * @param WC_Product $product The product object.
	 * @param string     $price_html HTML product price.
	 */
	public static function wrapper_price( $product, $price_html ) {
		if ( is_cart() || is_account_page() || is_checkout() || is_customize_preview() ) {
			return $price_html;
		}

		$class      = defined( 'DOING_AJAX' ) && DOING_AJAX ? '' : ' loading';
		$product_id = version_compare( WC_VERSION, '3.0', '<' ) ? $product->id : $product->get_id();

		return sprintf( '<span class="wcpbc-price wcpbc-price-%2$s%1$s" data-product-id="%2$s">%3$s</span>', $class, $product_id, $price_html );
	}

	/**
	 * Return customer location and array of product prices
	 */
	public static function get_customer_location() {

		$data = array(
			'products' => array(),
			'areas'    => array(),
		);

		$postdata = wc_clean( $_POST ); // WPCS: CSRF ok.

		// Products.
		if ( ! empty( $postdata['ids'] ) && is_array( $postdata['ids'] ) ) {

			$product_ids = array_unique( array_map( 'absint', $postdata['ids'] ) );

			foreach ( $product_ids as $id ) {
				$_product = wc_get_product( $id );
				if ( $_product ) {
					$data['products'][ $id ] = apply_filters( 'wc_price_based_country_ajax_geolocation_product_data', array(
						'id'                    => $id,
						'price_html'            => $_product->get_price_html(),
						'display_price'         => wc_get_price_to_display( $_product ),
						'display_regular_price' => wc_get_price_to_display( $_product, array( 'price' => $_product->get_regular_price() ) ),
					), $_product, $id );
				}
			}
		}

		// Areas.
		if ( ! empty( $postdata['areas'] ) && is_array( $postdata['areas'] ) ) {

			foreach ( $postdata['areas'] as $type => $areas ) {

				foreach ( $areas as $id => $area ) {

					$content = apply_filters( 'wc_price_based_country_ajax_geolocation_' . $type . '_content', '', $area );

					if ( ! empty( $content ) ) {

						$data['areas'][] = array(
							'area'    => $type,
							'id'      => $id,
							'content' => $content,
						);
					}
				}
			}
		}

		wp_send_json( $data );
	}

	/**
	 * Return the widget content
	 *
	 * @param string $content The HTML widget content to return.
	 * @param array  $widget Widget data.
	 * @return string
	 */
	public static function widget_content( $content, $widget ) {

		$classname = self::get_widget_class_name( $widget['id'] );

		if ( class_exists( $classname ) ) {
			ob_start();

			the_widget( $classname, $widget['instance'], array(
				'before_widget' => '',
				'after_widget'  => '',
			) );

			$content = ob_get_clean();
		}

		return $content;
	}

	/**
	 * Return the widget class name from widget ID
	 *
	 * @param string $widget_id Widget ID.
	 * @return string
	 */
	private static function get_widget_class_name( $widget_id ) {
		$classname = str_replace( 'wcpbc', '', $widget_id );
		$classname = 'WCPBC_Widget' . implode( '_', array_map( 'ucfirst', explode( '_', $classname ) ) );
		return $classname;
	}
}

WCPBC_Ajax_Geolocation::init();
