<?php
/**
 * Helper for processing [accordion] and [accordion_item] shortcodes.
 *
 * @author    Themedelight
 * @package   Themedelight/ATDTP
 * @version   2.1.0
 */

class ATDTP_Shortcodes_Accordion
{
	public static $accordion_view = 'templates/shortcodes/accordion';

	public static $id_prefix = 'ataccordion';

	public static $accordion_item_view = 'templates/shortcodes/accordion_item';

	protected static $cur_id = 0;

	protected static $cur_item_id = 0;

	public static function register( $accordion_shortcode_name, $accordion_item_shortcode_name ) {
		$class = get_class();
		$result = false;

		if ( $accordion_shortcode_name ) {
			add_shortcode( $accordion_shortcode_name, array( $class, 'accordion_do_shortcode' ) );
			$result = true;
		}

		if ( $accordion_item_shortcode_name ) {
			add_shortcode( $accordion_item_shortcode_name, array( $class, 'accordion_item_do_shortcode' ) );
			$result = true;
		}

		return $result;
	}

	public static function accordion_do_shortcode( $atts, $content = null ) {
		$atts =  shortcode_atts( array(
			'style' => '',
			'css_class' => '',
			'view' => '',
		), $atts );

		$atts['accordion_id'] = self::get_accordion_id( true );
		$atts['content'] = $content;

		return ATDTP()->shortcodes_helper()->render_view( self::$accordion_view, $atts['view'], $atts );
	}

	public static function accordion_item_do_shortcode( $atts, $content ) {
		$atts = shortcode_atts( array(
			'title' => '',
			'is_active' => '',
			'css_class' => '',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();

		$atts['is_active'] = $helper->attribute_is_true( $atts['is_active'] );
		$atts['accordion_id'] = self::get_accordion_id();
		$atts['item_id'] = self::get_accordion_item_next_id();
		$atts['content'] = $content;

		return $helper->render_view( self::$accordion_item_view, $atts['view'], $atts );
	}

	protected static function get_accordion_id( $generate_new = false ) {
		if ( $generate_new ) {
			self::$cur_item_id = 0;
			self::$cur_id++;
		}

		return self::$id_prefix . self::$cur_id;
	}

	protected static function get_accordion_item_next_id() {
		return self::get_accordion_id() . '_' . ++self::$cur_item_id;
	}
}
