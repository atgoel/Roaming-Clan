<?php
/**
 * Helper for processing [row] and [column] shorcodes.
 *
 * @author    Themedelight
 * @package   Themedelight/ATDTP
 * @version   2.0.0
 */

class ATDTP_Shortcodes_Row
{
	/**
	 * List of aliases available for defition of the column width.
	 *
	 * @var assoc
	 */
	public static $colWidthAliases = array(
		'one' => 1,
		'two' => 2,
		'half' => 2,
		'three' => 3,
		'four' => 4,
		'five' => 5,
		'seven' => 7,
		'eight' => 8,
		'nine' => 9,
		'ten' => 10,
		'eleven' => 11,
		'twelve' => 12,
	);

	/**
	 * Determines max columns number.
	 *
	 * @var integer
	 */
	protected static $defaultGridSize = 12;

	/**
	 * Registers row and column renderers on specefied shortcode names.
	 *
	 * @param  string $row_shortcode_name    shortcode name that should be used for 'row'.
	 * @param  string $column_shortcode_name shortcode name that should be used for 'column'.
	 * @return boolean
	 */
	public static function register( $row_shortcode_name, $column_shortcode_name ) {
		$class = __CLASS__;

		$result = false;

		if ( $row_shortcode_name ) {
			add_shortcode( $row_shortcode_name, array( $class, 'do_shortcode_row') );
			$result = true;
		}

		if ( $column_shortcode_name ) {
			add_shortcode( $column_shortcode_name, array( $class, 'do_shortcode_column') );
			$result = true;
		}

		return $result;
	}

	/**
	 * Renders row shortcode.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	public static function do_shortcode_row( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'css_class' => '',
		), $atts );

		$rowClass = 'row' . ( $atts['css_class'] ? ' ' . $atts['css_class'] : '' );

		return '<div class="' . esc_attr( $rowClass ) . '">' . do_shortcode( $content ) . '</div>';
	}

	/**
	 * Renders column shortcode.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	public static function do_shortcode_column( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'width' => '',
			'css_class' => '',
			'add_mobile_spacer' => '',
		), $atts );

		$size_class = self::get_size_class_by_width_attribute( $atts['width'] );

		if ( $atts['css_class'] ) {
			$size_class .= ' ' . $atts['css_class'];
		}

		$spacer_html = ATDTP()->shortcodes_helper()->attribute_is_true( $atts['add_mobile_spacer'] )
			? '<div class="margin-top margin-bottom visible-sm visible-xs"></div>'
			: '';

		return '<div class="' . esc_attr( $size_class ) . '">' . $spacer_html . do_shortcode( $content ) . '</div>';
	}

	public static function convert_width_to_class( $width ) {
		return self::get_size_class_by_width_attribute( $width );
	}

	/**
	 * Converts column width attribute into related css class.
	 *
	 * @param  string  $width
	 * @param  string  $perfix    css column class prefix.
	 * @param  integer $default   default width value.
	 * @param  string  $delimiter
	 * @return string
	 */
	protected static function get_size_class_by_width_attribute( $width, $perfix = 'col-md-', $default = 1, $delimiter = '/' ) {
		$sizeIndex = 0;
		if ( $width ) {
			$parts = explode( $delimiter, $width );

			$defaultGridSize = self::$defaultGridSize;
			$size = self::convert_string_to_number( $parts[0], $defaultGridSize );

			$base = ! empty( $parts[1] ) ? self::convert_string_to_number( $parts[1], $defaultGridSize ) : $defaultGridSize;
			if ( $size > 0 && $base > 0 ) {
				$multyIndex = $base < $defaultGridSize ? $defaultGridSize / $base : 1;
				$sizeIndex = $multyIndex * $size;
			}
		}

		return $perfix . ($sizeIndex > 0 ? $sizeIndex : $default);
	}

	/**
	 * Converts width attribute value into number.
	 *
	 * @param  string $textNumber   number/string alias (see $colWidthAliases option).
	 * @param  int    $defaultValue value that should be used if $textNumber is empty.
	 * @return mixed
	 */
	protected static function convert_string_to_number( $textNumber, $defaultValue = null ) {
		if ( ! $textNumber ) {
			return $defaultValue;
		}

		if ( is_numeric( $textNumber ) ) {
			return $textNumber;
		}

		return isset( self::$colWidthAliases[$textNumber] ) ? self::$colWidthAliases[$textNumber] : $defaultValue;
	}
}
