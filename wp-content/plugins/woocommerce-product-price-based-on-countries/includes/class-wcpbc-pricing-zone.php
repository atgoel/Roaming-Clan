<?php
/**
 * Represents a single pricing zone
 *
 * @since   1.7.0
 * @version 1.7.13
 * @package WCPBC/Classes
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WCPBC_Pricing_Zone
 */
class WCPBC_Pricing_Zone {

	/**
	 * Zone Data
	 *
	 * @var array
	 */
	protected $data = array();

	/**
	 * Constructor for zones.
	 *
	 * @param array $data Pricing zone attributes as array.
	 */
	public function __construct( $data = null ) {

		$this->data = wp_parse_args( $data, array(
			'zone_id'       => '',
			'name'          => '',
			'countries'     => array(),
			'currency'      => get_option( 'woocommerce_currency' ),
			'exchange_rate' => '1',
		) );
	}

	/**
	 * Get zone data.
	 *
	 * @return array
	 */
	public function get_data() {
		return $this->data;
	}

	/**
	 * Gets a prop for a getter method.
	 *
	 * @since 1.7.9
	 * @param  string $prop Name of prop to get.
	 * @return mixed
	 */
	protected function get_prop( $prop ) {
		return isset( $this->data[ $prop ] ) ? $this->data[ $prop ] : false;
	}

	/**
	 * Get zone id.
	 *
	 * @return string
	 */
	public function get_zone_id() {
		return $this->get_prop( 'zone_id' );
	}

	/**
	 * Get zone name.
	 *
	 * @return string
	 */
	public function get_name() {
		return $this->get_prop( 'name' );
	}

	/**
	 * Get countries.
	 *
	 * @return array
	 */
	public function get_countries() {
		return $this->get_prop( 'countries' );
	}

	/**
	 * Get zone currency.
	 *
	 * @return string
	 */
	public function get_currency() {
		return $this->get_prop( 'currency' );
	}

	/**
	 * Get exchange rate.
	 *
	 * @return float
	 */
	public function get_exchange_rate() {
		return floatval( $this->get_prop( 'exchange_rate' ) );
	}

	/**
	 * Get a meta key based on zone ID
	 *
	 * @param string $meta_key Metadata key.
	 * @return string
	 */
	public function get_postmetakey( $meta_key = '' ) {
		return '_' . $this->get_zone_id() . $meta_key;
	}

	/**
	 * Get a meta value based on zone ID
	 *
	 * @param int    $post_id Post ID.
	 * @param string $meta_key Metadata key.
	 * @return mixed
	 */
	public function get_postmeta( $post_id, $meta_key ) {
		return get_post_meta( $post_id, $this->get_postmetakey( $meta_key ), true );
	}

	/**
	 * Update meta value based on zone ID
	 *
	 * @param int    $post_id Post ID.
	 * @param string $meta_key Metadata key.
	 * @param string $meta_value Metadata value.
	 * @return int|bool
	 */
	public function set_postmeta( $post_id, $meta_key, $meta_value ) {
		return update_post_meta( $post_id, $this->get_postmetakey( $meta_key ), $meta_value );
	}

	/**
	 * Product price by exchange rate?
	 *
	 * @param int $post_id Post ID.
	 * @return bool
	 */
	public function is_exchange_rate_price( $post_id ) {
		$metavalue = $this->get_postmeta( $post_id, '_price_method' );
		return empty( $metavalue ) || 'exchange_rate' === $metavalue;
	}

	/**
	 * Set product price by exchange
	 *
	 * @since 1.7.9
	 * @param int  $post_id Post ID.
	 * @param bool $by_exchange_rate TRUE: exchange rate price. FALSE: manual price.
	 */
	public function set_exchange_rate_price( $post_id, $by_exchange_rate = true ) {
		$value = $by_exchange_rate ? 'exchange_rate' : 'manual';
		$this->set_postmeta( $post_id, '_price_method', $value );
	}

	/**
	 * Set product price manual
	 *
	 * @since 1.7.9
	 * @param int $post_id Post ID.
	 */
	public function set_manual_price( $post_id ) {
		$this->set_exchange_rate_price( $post_id, false );
	}

	/**
	 * Return a price calculate by exchange rate
	 *
	 * @param float $price The base price to convert.
	 * @param bool  $round Must be the price round?.
	 * @return float
	 */
	public function get_exchange_rate_price( $price, $round = true ) {
		if ( empty( $price ) ) {
			$value = $price;
		} else {
			$value = $this->by_exchange_rate( $price );
			if ( $round ) {
				$value = $this->round( $value );
			}
		}

		return $value;
	}

	/**
	 * Apply the exchange rate to an amount
	 *
	 * @since 1.7.9
	 * @param float $amount Amount to apply the exchange rate.
	 * @return float
	 */
	protected function by_exchange_rate( $amount ) {
		return floatval( $amount ) * $this->get_exchange_rate();
	}

	/**
	 * Return product price calculate by exchange rate
	 *
	 * @param int    $post_id Post ID.
	 * @param string $meta_key Metadata key.
	 * @param bool   $round Must be the price round?.
	 * @return float
	 */
	public function get_exchange_rate_price_by_post( $post_id, $meta_key, $round = true ) {
		$base_price = get_post_meta( $post_id, $meta_key, true );
		return $this->get_exchange_rate_price( $base_price, $round );
	}

	/**
	 * Get product price
	 *
	 * @param int    $post_id Post ID.
	 * @param string $meta_key Metadata key.
	 * @return mixed
	 */
	public function get_postprice( $post_id, $meta_key ) {
		$zone_price = $this->get_postmeta( $post_id, $meta_key );

		if ( $this->is_exchange_rate_price( $post_id ) ) {

			$_price = strval( $this->get_exchange_rate_price_by_post( $post_id, $meta_key, false ) );

			if ( $_price !== $zone_price ) {
				$zone_price = $_price;
				$this->set_postmeta( $post_id, $meta_key, $_price );
			}
			$zone_price = $this->round( $zone_price );
		}

		return $zone_price;
	}

	/**
	 * Round a price
	 *
	 * @param float $price Amount to round.
	 * @param float $num_decimals Number of decimals.
	 * @return float
	 */
	protected function round( $price, $num_decimals = '' ) {
		if ( wcpbc_empty_nozero( $num_decimals ) ) {
			$num_decimals = wc_get_price_decimals();
		}

		$value = $price;

		if ( ! empty( $value ) ) {
			$value = round( $value, $num_decimals );
		}
		return $value;
	}

	/**
	 * Return an amount in the shop base currency
	 *
	 * @since 1.7.4
	 *
	 * @param float $amount Amount to convert to base currency.
	 * @return float
	 */
	public function get_base_currency_amount( $amount ) {
		$amount = floatval( $amount );
		return ( $amount / $this->get_exchange_rate() );
	}

	/**
	 * Getter implementation by __call magic method
	 *
	 * @since 1.7.0
	 *
	 * @param string $method Method.
	 * @param array  $parameters Parameters.
	 *
	 * @return mixed
	 */
	public function __call( $method, $parameters ) {
		$prop = str_replace( 'get_', '', $method );
		if ( 'get_' === substr( $method, 0, 4 ) && array_key_exists( $prop, $this->data ) && empty( $parameters ) ) {
			return $this->get_prop( $prop );
		}
	}
}
