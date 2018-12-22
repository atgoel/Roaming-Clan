<?php
/**
 * Visual Composer plugin integration helper.
 *
 * @author    Themedelight
 * @package   Themedelight/ATDTP
 * @version   2.1.7
 */

class ATDTP_Shortcodes_Visual_Composer
{
	/**
	 * @var string
	 */
	public $shortcodes_category_name = 'Adventure Tours';

	/**
	 * @var string
	 */
	public $shortcode_templates_prefix = 'Adventure Tours - ';

	/**
	 * @var ATDTP_Shortcodes_VC_Content_Normilizer
	 */
	public $content_normilizer;

	/**
	 * @var ATDTP_Shortcodes_Helper
	 */
	public $shortcodes_helper;

	/**
	 * @var boolean
	 */
	private $inited = false;

	public function __construct() {
		add_filter( 'vc_before_init', array( $this, 'init' ), 15 );
	}

	/**
	 * @return ATDTP_Shortcodes_Helper
	 */
	public function get_schortcodes_helper() {
		if ( ! $this->shortcodes_helper ) {
			$this->shortcodes_helper = ATDTP()->shortcodes_helper();
		}
		return $this->shortcodes_helper;
	}

	public function init() {
		if ( $this->inited ) {
			return false;
		}

		$this->inited = true;

		if ( is_admin() ) {
			$normalizer_config = array(
				'normilize_mode_active' => true,
				'replacement_mode_active' => $this->get_schortcodes_helper()->is_shortcode_registered( 'row' ),
			);

			if ( ! empty( $normalizer_config['replacement_mode_active'] ) || ! empty( $normalizer_config['normilize_mode_active'] ) ) {
				ATDTP()->require_file( '/classes/ATDTP_Shortcodes_VC_Content_Normilizer.php' );
				$this->content_normilizer = new ATDTP_Shortcodes_VC_Content_Normilizer( $normalizer_config );
			}

			__atdtp_define_visual_composer_container_classes();
		}

		$this->register_shortcode_params();
		$this->register_shortcodes();

		add_action( 'vc_load_default_templates_action', array( $this, 'add_page_tamplates' ) );

		return true;
	}

	protected function register_shortcodes() {
		$config = $this->get_schortcodes_helper()->get_shortcodes_config();

		foreach ( $config as $schorcode_name => $sc_config ) {
			$params = array();

			if ( !empty( $sc_config['params'] ) ) {
				foreach ( $sc_config['params'] as $_param_name => $_param ) {
					$_param['heading'] = $_param['param_name'] = $_param_name;
					if ( empty( $_param['type'] ) ) {
						$_param['type'] = 'textfield';
					}
					if ( ! empty( $_param['value'] ) && ! isset( $_param['save_always'] ) ) {
						$_param['save_always'] = true;
					}
					$params[] = $_param;
				}
			}

			$sc_config['base'] = $schorcode_name;
			$sc_config['category'] = $this->shortcodes_category_name;
			$sc_config['params'] = $params;

			$sc_config = $this->filter_shortcode_config( $sc_config, $schorcode_name );

			if ( $sc_config ) {
				vc_map( $sc_config );
			}
		}
	}

	protected function register_shortcode_params() {
		add_shortcode_param(
			'attach_image_url',
			array( $this, 'shortcode_param_attach_image_url' ),
			ATDTP()->get_plugin_url() . '/assets/js/visual-composer-shortcode-param-attach-image-url.js'
		);
	}

	public function shortcode_param_attach_image_url( $settings, $value ) {
		$output = '';
		$output .= '<style>' .
			'#attach-image-url{overflow:hidden;}' .
			'#attach-image-url .attach-image-url__storage{width:80%; float:left}' .
			'#attach-image-url .attach-image-url__add-img{height:36px;width:20%; float:right}' .
		'</style>';

		$additional_classes = $settings['param_name'] . ' ' . $settings['type'];

		$output .= '<div id="attach-image-url">' .
			'<input type="text" class="wpb_vc_param_value attach-image-url__storage ' . esc_attr( $additional_classes ) . '" name="' . esc_attr( $settings['param_name'] ) . '" value="' . esc_url( $value ) . '"/>' .
			'<button class="attach-image-url__add-img">' . esc_html__( 'Select image', 'adventure-tours-data-types' ) . '</button>' .
		'</div>';

		return $output;
	}

	public function add_page_tamplates() {
		$helper = $this->get_schortcodes_helper();
		vc_add_default_templates( array(
			'name' => $this->shortcode_templates_prefix . esc_html__( 'Home page', 'adventure-tours-data-types' ),
			'content' => $helper->render_view( 'templates/vc-pages/home' ),
		) );

		vc_add_default_templates( array(
			'name' => $this->shortcode_templates_prefix . esc_html__( 'Contact page', 'adventure-tours-data-types' ),
			'content' => $helper->render_view( 'templates/vc-pages/contact' ),
		) );
	}

	protected function filter_shortcode_config( $sc_config, $schorcode_name ) {
		$need_remove_content_param = false;

		switch ( $schorcode_name ) {
		case 'icons_set':
			$need_remove_content_param = true;

			$item_schorcode_name = 'icon_item';
			$sc_config = array_merge( $sc_config, array(
				'as_parent' => array( 'only' => $item_schorcode_name ),
				'content_element' => true,
				'show_settings_on_create' => false,
				'is_container' => true,
				'js_view' => 'VcColumnView',
			) );

			$item_config = array(
				'name' => __( 'Icon item', 'adventure-tours-data-types' ),
				'base' => $item_schorcode_name,
				'content_element' => true,
				'as_child' => array( 'only' => $schorcode_name ),
				'params' => array(
					array(
						'heading' => 'icon',
						'param_name' => 'icon',
						'type' => 'iconpicker',
						'settings' => array(
							'emptyIcon' => false,
							'type' => 'adventuretours',
						),
						// hack for iconpicker selector, allows load icons list via ajax request
						'values' => 'at_get_adventuretours_icons',
					),
					array(
						'type' => 'textfield',
						'heading' => 'title',
						'param_name' => 'title',
					),
					array(
						'type' => 'textfield',
						'heading' => 'title_url',
						'param_name' => 'title_url',
					),
					array(
						'type' => 'textarea', // 'textarea_html',
						'heading' => 'text',
						'param_name' => 'content',
					)
				)
			);

			vc_map( $item_config );
			break;

		case 'timeline':
			$need_remove_content_param = true;
			$item_schorcode_name = 'timeline_item';

			$sc_config = array_merge( $sc_config, array(
				'as_parent' => array( 'only' => $item_schorcode_name ),
				'content_element' => true,
				'show_settings_on_create' => false,
				'is_container' => true,
				'js_view' => 'VcColumnView',
			) );

			$item_config = array(
				'name' => __( 'Timeline item', 'adventure-tours-data-types'),
				'base' => $item_schorcode_name,
				'content_element' => true,
				'as_child' => array( 'only' => $schorcode_name ),
				'params' => array(
					array(
						'type' => 'textfield',
						'heading' => 'number',
						'param_name' => 'item_number',
					),
					array(
						'type' => 'textfield',
						'heading' => 'title',
						'param_name' => 'title',
					),
					array(
						'type' => 'textarea', // 'textarea_html',
						'heading' => 'text',
						'param_name' => 'content',
					)
				)
			);
			vc_map( $item_config );
			break;
		}

		// removing unused parameter from params list
		if ( $need_remove_content_param && ! empty( $sc_config['params'] ) ) {
			foreach ( $sc_config['params'] as $_p_key => $_p_info ) {
				if ( 'content' === $_p_info['param_name'] ) {
					unset( $sc_config['params'][ $_p_key ] );
					break;
				}
			}
		}

		return $sc_config;
	}
}

// Defines classes required for VC to process 'nested' shortcodes
function __atdtp_define_visual_composer_container_classes(){
	if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
		class WPBakeryShortCode_Icons_Set extends WPBakeryShortCodesContainer
		{
		}

		class WPBakeryShortCode_Timeline extends WPBakeryShortCodesContainer
		{
		}
	}

	if ( class_exists( 'WPBakeryShortCode' ) ) {
		class WPBakeryShortCode_Icon_Item extends WPBakeryShortCode
		{
		}

		class WPBakeryShortCode_Timeline_Item extends WPBakeryShortCode
		{
		}
	}
}
