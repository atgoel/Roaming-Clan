<?php

/**
 * Class WOOMULTI_CURRENCY_F_Plugin_Woocommerce_Wholesale_Prices
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class WOOMULTI_CURRENCY_F_Plugin_Woocommerce_Wholesale_Prices {
	protected $settings;

	public function __construct() {

		$this->settings = new WOOMULTI_CURRENCY_F_Data();
		if ( $this->settings->get_enable() ) {
			add_filter( 'wwp_pass_wholesale_price_through_taxing', array( $this, 'wwp_pass_wholesale_price_through_taxing' ) );
		}

	}

	/**
	 * Integrate with Yith Product Bundles
	 * @return bool
	 */
	public function wwp_pass_wholesale_price_through_taxing( $wholesale_price ) {

		if ( $wholesale_price ) {
			$wholesale_price = wmc_get_price( $wholesale_price );
		}

		return $wholesale_price;
	}
}