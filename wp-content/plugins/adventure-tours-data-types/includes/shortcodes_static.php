<?php
/**
 * Definition of shortcodes that generate own content based on own params/theme settings values.
 *
 * @author    Themedelight
 * @package   Themedelight/ATDTP
 * @version   2.2.5
 */

$shortoces_nl_escaper = ATDTP()->shortcodes_helper()->nl_escaper();
$sc_helper = ATDTP()->shortcodes_helper();

if ( ! shortcode_exists( 'row') && ! shortcode_exists( 'column' ) ) {
	ATDTP()->require_file( '/classes/ATDTP_Shortcodes_Row.php' );

	$sc_helper->add_shortcode( 'row', array( 'ATDTP_Shortcodes_Row', 'do_shortcode_row'), array(
		'name' => esc_html__( 'Columns', 'adventure-tours-data-types' ),
		'params' => array(
			'columns' => array(
				'value' => '2',
			),
			'css_class' => array(),
		),
	) );

	add_shortcode( 'column', array( 'ATDTP_Shortcodes_Row', 'do_shortcode_column') );

	if ( $shortoces_nl_escaper ) {
		$shortoces_nl_escaper->registerNestedShortcodes( 'row','column' );
	}
}

if ( ! shortcode_exists( 'faq_question_form' ) ) {
	ATDTP()->require_file( '/classes/ATDTP_Shortcodes_FAQ_Question_Form.php' );
	ATDTP_Shortcodes_FAQ_Question_Form::register( 'faq_question_form' );
}

if ( ! shortcode_exists( 'accordion' ) && ! shortcode_exists( 'accordion_item' ) ) {
	ATDTP()->require_file( '/classes/ATDTP_Shortcodes_Accordion.php' );

	$sc_helper->add_shortcode( 'accordion', array( 'ATDTP_Shortcodes_Accordion', 'accordion_do_shortcode' ), array(
		'name' => esc_html__( 'Accordion', 'adventure-tours-data-types' ),
		'params' => array(
			'content' => array(
				'type' => 'textarea',
				'value' => '[accordion_item title="Title 1" is_active="on"]Lorem ipsum 1[/accordion_item]' .
					'[accordion_item title="Title 2"]Lorem ipsum 2[/accordion_item]' .
					'[accordion_item title="Title 3"]Lorem ipsum 3[/accordion_item]',
			),
			'style' => array(
				'type' => 'dropdown',
				'value' => array(
					'with-shadow',
					'with-border',
				),
			),
			'css_class' => array(),
		),
	) );

	add_shortcode( 'accordion_item', array( 'ATDTP_Shortcodes_Accordion', 'accordion_item_do_shortcode' ) );
}

if ( ! shortcode_exists( 'tabs' ) && ! shortcode_exists( 'tab_item' ) ) {
	ATDTP()->require_file( '/classes/ATDTP_Shortcodes_Tabs.php' );

	$sc_helper->add_shortcode( 'tabs', array( 'ATDTP_Shortcodes_Tabs', 'tabs_do_shortcode' ), array(
		'name' => esc_html__( 'Tabs', 'adventure-tours-data-types' ),
		'params' => array(
			'content' => array(
				'type' => 'textarea',
				'value' => '[tab_item title="Title 1" is_active="on"]Lorem ipsum 1[/tab_item]' .
					'[tab_item title="Title 2"]Lorem ipsum 2[/tab_item]' .
					'[tab_item title="Title 3"]Lorem ipsum 3[/tab_item]',
			),
			'style' => array(
				'type' => 'dropdown',
				'value' => array(
					'with-shadow',
					'with-border',
				),
			),
			'css_class' => array(),
		),
	) );

	add_shortcode( 'tab_item', array( 'ATDTP_Shortcodes_Tabs', 'tab_item_do_shortcode' ) );
}

if ( ! shortcode_exists( 'title' ) ) {
	/**
	 * Title shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_title( $atts, $content=null ) {
		$atts = shortcode_atts( array(
			'text' => '',
			'subtitle' => '',
			'size' => 'big',
			'position' => 'left',
			'decoration' => 'on',
			'underline' => 'on',
			'style' => 'dark',
			'css_class' => '',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();

		$atts['decoration'] = $helper->attribute_is_true( $atts['decoration'] );
		$atts['underline'] = $helper->attribute_is_true( $atts['underline'] );

		return $helper->render_view( 'templates/shortcodes/title', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'title', 'atdtp_shortcode_title', array(
		'name' => esc_html__( 'Title', 'adventure-tours-data-types' ),
		'params' => array(
			'text' => array(),
			'subtitle' => array(),
			'size' => array(
				'type' => 'dropdown',
				'value' => array(
					'big',
					'small',
				),
			),
			'position' => array(
				'type' => 'dropdown',
				'value' => array(
					'left',
					'center',
				),
			),
			'decoration' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'underline' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'style' => array(
				'type' => 'dropdown',
				'value' => array(
					'dark',
					'light',
				),
			),
			'css_class' => array(),
		),
	) );
}

if ( ! shortcode_exists( 'social_icons' ) ) {
	/**
	 * Social icons shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_social_icons( $atts, $content=null ) {
		$atts = shortcode_atts( array(
			'title' => '',
			'facebook_url' => '',
			'twitter_url' => '',
			'googleplus_url' => '',
			'youtube_url' => '',
			'pinterest_url' => '',
			'linkedin_url' => '',
			'instagram_url' => '',
			'dribbble_url' => '',
			'tumblr_url' => '',
			'vk_url' => '',
			'tripadvisor_url' => '',
			'css_class' => '',
			'view' => '',
		), $atts );

		return ATDTP()->shortcodes_helper()->render_view( 'templates/shortcodes/social_icons', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'social_icons', 'atdtp_shortcode_social_icons', array(
		'name' => esc_html__( 'Social Icons', 'adventure-tours-data-types' ),
		'params' => array(
			'title' => array(
				'value' => 'We are social',
			),
			'facebook_url' => array(),
			'twitter_url' => array(),
			'googleplus_url' => array(),
			'youtube_url' => array(),
			'pinterest_url' => array(),
			'linkedin_url' => array(),
			'instagram_url' => array(),
			'dribbble_url' => array(),
			'tumblr_url' => array(),
			'vk_url' => array(),
			'tripadvisor_url' => array(),
			'css_class' => array(),
		),
	) );
}

if ( ! shortcode_exists( 'contact_info' ) ) {
	/**
	 * Contact info shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_contact_info( $atts, $content=null ) {
		$atts = shortcode_atts( array(
			'address' => '',
			'phone' => '',
			'mobile' => '',
			'email' => '',
			'skype' => '',
			'css_class' => '',
			'view' => '',
		), $atts );

		return ATDTP()->shortcodes_helper()->render_view( 'templates/shortcodes/contact_info', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'contact_info', 'atdtp_shortcode_contact_info', array(
		'name' => esc_html__( 'Contact Info', 'adventure-tours-data-types' ),
		'params' => array(
			'address' => array(),
			'phone' => array(),
			'mobile' => array(),
			'email' => array(),
			'skype' => array(),
			'css_class' => array(),
		),
	) );
}

if ( ! shortcode_exists( 'mailchimp_form' ) ) {
	/**
	 * MainChimp form shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_mailchimp_form( $atts, $content=null ) {
		$atts = shortcode_atts( array(
			'form_id' => '',
			'title' => '',
			'button_text' => '',
			'width_mode' => 'box-width',
			'bg_url' => '',
			'bg_repeat' => '',
			'css_class' => '',
			'view' => '',
		// to support version 5.4.X, should be removed in future
			'mailchimp_list_id' => '',
		), $atts );

		$atts['content'] = $content;

		return ATDTP()->shortcodes_helper()->render_view( 'templates/shortcodes/mailchimp_form', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'mailchimp_form', 'atdtp_shortcode_mailchimp_form', array(
		'name' => esc_html__( 'MailChimp Form', 'adventure-tours-data-types' ),
		'params' => array(
			'form_id' => array(
				'required' => true,
			),
			'button_text' => array(
				'value' => 'Submit',
			),
			'title' => array(),
			'content' => array(
				'type' => 'textarea',
			),
			'css_class' => array(),
			'width_mode' => array(
				'type' => 'dropdown',
				'value' => array(
					'box-width',
					'full-width',
				),
			),
			'bg_url' => array(
				'type' => 'attach_image_url',
			),
			'bg_repeat' => array(
				'type' => 'dropdown',
				'value' => array(
					'repeat',
					'no-repeat',
					'repeat-x',
					'repeat-y',
				),
			),
		),
	) );
}

if ( ! shortcode_exists( 'google_map' ) ) {
	/**
	 * Google map shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_google_map( $atts, $content=null ) {
		$atts = shortcode_atts( array(
			'address' => '',
			'coordinates' => '40.764324,-73.973057',
			'zoom' => '10',
			'height' => '400',
			'width_mode' => 'box-width',
			'css_class' => '',
			'view' => '',
		), $atts );

		return ATDTP()->shortcodes_helper()->render_view( 'templates/shortcodes/google_map', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'google_map', 'atdtp_shortcode_google_map', array(
		'name' => esc_html__( 'Google Map', 'adventure-tours-data-types' ),
		'params' => array(
			'address' => array(
				'description' => esc_html__( 'The address will show up when clicking on the map marker.', 'adventure-tours-data-types' ),
			),
			'coordinates' => array(
				'value' => '40.764324,-73.973057',
				'description' => esc_html__( 'Coordinates separated by comma.', 'adventure-tours-data-types' ),
				'required' => true,
			),
			'zoom' => array(
				'value' => 10,
				'description' => esc_html__( 'Number in range from 1 up to 21.', 'adventure-tours-data-types' ),
				'required' => true,
			),
			'height' => array(
				'value' => '400',
			),
			'width_mode' => array(
				'type' => 'dropdown',
				'value' => array(
					'box-width',
					'full-width',
				),
			),
			'css_class' => array(),
		),
	) );
}

if ( ! shortcode_exists( 'google_map_embed' ) ) {
	/**
	 * Renders [google_map_embed] shortcode.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_google_map_embed( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'src' => '',
			'height' => '',
			'css_class' => '',
			'view' => '',
		), $atts );

		return ATDTP()->shortcodes_helper()->render_view( 'templates/shortcodes/google_map_embed', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'google_map_embed', 'atdtp_shortcode_google_map_embed', array(
		'name' => esc_html__( 'Google Map Embed', 'adventure-tours-data-types' ),
		'params' => array(
			'src' => array(),
			'height' => array(
				'value' => '450',
			),
			'css_class' => array(),
		),
	) );
}

if ( ! shortcode_exists( 'icon_tick' ) ) {
	/**
	 * Icon tick (+/- check icon) shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_icon_tick( $atts, $content=null ) {
		$atts = shortcode_atts( array(
			'state' => 'on',
			'css_class' => '',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();

		$atts['state'] = $helper->attribute_is_true( $atts['state'] );

		return $helper->render_view( 'templates/shortcodes/icon_tick', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'icon_tick', 'atdtp_shortcode_icon_tick', array(
		'name' => esc_html__( 'Icon Tick', 'adventure-tours-data-types' ),
		'params' => array(
			'state' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'css_class' => array(),
		),
	) );
}

if ( ! shortcode_exists( 'timeline' ) ) {
	if ( $shortoces_nl_escaper ) {
		$shortoces_nl_escaper->registerNestedShortcodes( 'timeline','timeline_item' );
	}

	/**
	 * Timeline shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_timeline( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'css_class' => '',
			'view' => '',
		), $atts );

		$atts['content'] = $content;
		return ATDTP()->shortcodes_helper()->render_view( 'templates/shortcodes/timeline', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'timeline', 'atdtp_shortcode_timeline', array(
		'name' => esc_html__( 'Timeline', 'adventure-tours-data-types' ),
		'params' => array(
			'content' => array(
				'type' => 'textarea',
				'value' => '[timeline_item item_number="1" title="Day 1"]Lorem ipsum 1[/timeline_item]' .
					'[timeline_item item_number="2" title="Day 2"]Lorem ipsum 2[/timeline_item]',
			),
			'css_class' => array(),
		),
	) );
}

if ( ! shortcode_exists( 'timeline_item' ) ) {
	/**
	 * Timeline item shortcode rendering function.
	 * Used inside [timeline] shortcode to present information about tour agenda.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_timeline_item( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'item_number' => '',
			'title' => '',
			'view' => '',
		), $atts );

		$atts['content'] = $content;

		return ATDTP()->shortcodes_helper()->render_view( 'templates/shortcodes/timeline_item', $atts['view'], $atts );
	}

	add_shortcode( 'timeline_item', 'atdtp_shortcode_timeline_item' );
}

if ( ! shortcode_exists( 'icons_set' ) ) {
	/**
	 * Icons set shortcode rendering function.
	 * Container for set [icon_item] shortcodes.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_icons_set( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'row_size' => 3,
			'css_class' => '',
			'view' => '',
		), $atts );

		$GLOBALS['__tmp_icons_set'] = array();
		do_shortcode( $content );
		$atts['items'] = $GLOBALS['__tmp_icons_set'];
		unset( $GLOBALS['__tmp_icons_set'] );

		// need improve regexp - [^"]*, as this one does not allow to use " character in text attribute
		/*$items = array();
		if ( preg_match_all('`\[icon_item(?: icon="([^"]*)")?(?: text="([^"]*)")?\]`s', $content, $matches) ) {
			foreach ($matches[1] as $_item_index => $icon_class) {
				$item_text = $matches[2][$_item_index];
				if ( ! $item_text && ! $icon_class ) {
					continue;
				}
				$items[] = array(
					'icon_class' => $icon_class,
					'text' => $item_text,
				);
			}
		}*/

		return ATDTP()->shortcodes_helper()->render_view( 'templates/shortcodes/icons_set', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'icons_set', 'atdtp_shortcode_icons_set', array(
		'name' => esc_html__( 'Icons Set', 'adventure-tours-data-types' ),
		'params' => array(
			'row_size' => array(
				'type' => 'dropdown',
				'value' => array(
					'2',
					'3',
					'4',
				),
			),
			'content' => array(
				'type' => 'textarea',
				'value' => '[icon_item icon="td-earth" title="Item1"]text[/icon_item]' .
					'[icon_item icon="td-heart" title="Item2"]text[/icon_item]' .
					'[icon_item icon="td-lifebuoy" title="Item3"]text[/icon_item]',
			),
			'css_class' => array(),
		),
	) );
}

if ( ! shortcode_exists( 'icon_item' ) ) {
	/**
	 * Icon item shortcode rendering function.
	 * Used inside [icons_set] shortcode to preset set of icons.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_icon_item( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'icon' => '',
			'title' => '',
			'title_url' => '',
			'open_url_in_new_tab' => '',
		), $atts );
		$atts['content'] = $content;
		$GLOBALS['__tmp_icons_set'][] = $atts;
		return '';
	}

	add_shortcode( 'icon_item', 'atdtp_shortcode_icon_item' );
}

if ( ! shortcode_exists( 'gift_card' ) ) {
	/**
	 * Gift card shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_gift_card( $atts, $content = null) {
		$atts = shortcode_atts( array(
			'title' => '',
			'button_title' => '',
			'button_link' => '#',
			'css_class' => '',
			'view' => '',
		), $atts );

		$atts['content'] = $content;

		return ATDTP()->shortcodes_helper()->render_view( 'templates/shortcodes/gift_card', $atts['view'], $atts );
	}

	add_shortcode( 'gift_card', 'atdtp_shortcode_gift_card' );
}

if ( ! shortcode_exists( 'at_btn' ) ) {
	/**
	 * Button shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	*/
	function atdtp_shortcode_at_btn( $atts, $content = null) {
		$atts = shortcode_atts( array(
			'text' => '',
			'url' => '',
			'type' => '',
			'style' => 'default',
			'size' => 'large',
			'corners' => '',
			'light' => '',
			'transparent' => '',
			'icon_class' => '',
			'icon_align' => 'left',
			'css_class' => '',
			'view' => '',
		), $atts );

		$helper = $helper = ATDTP()->shortcodes_helper();

		$atts['light'] = $helper->attribute_is_true( $atts['light'] );
		$atts['transparent'] = $helper->attribute_is_true( $atts['transparent'] );
		$atts['content'] = $content;

		return $helper->render_view( 'templates/shortcodes/at_btn', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'at_btn', 'atdtp_shortcode_at_btn', array(
		'name' => esc_html__( 'Button', 'adventure-tours-data-types' ),
		'params' => array(
			'text' => array(),
			'url' => array(),
			'type' => array(
				'type' => 'dropdown',
				'value' => array(
					'link',
					'link in a new tab',
					'button',
					'submit',
				),
			),
			'css_class' => array(),
			'style' => array(
				'type' => 'dropdown',
				'value' => array(
					'',
					'primary',
					'secondary1',
					'secondary2',
				),
			),
			'size' => array(
				'type' => 'dropdown',
				'value' => array(
					'',
					'medium',
					'small',
				),
			),
			'corners' => array(
				'type' => 'dropdown',
				'value' => array(
					'',
					'rounded',
				),
			),
			'light' => array(
				'type' => 'dropdown',
				'value' => array(
					'off',
					'on',
				),
			),
			'transparent' => array(
				'type' => 'dropdown',
				'value' => array(
					'off',
					'on',
				),
			),
			'icon_class' => array(),
			'icon_align' => array(
				'type' => 'dropdown',
				'value' => array(
					'left',
					'right',
				),
			),
		),
	) );
}

if ( ! shortcode_exists( 'at_icon' ) ) {
	/**
	 * Renders [at_icon] shortcode.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdtp_shortcode_at_icon( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'icon' => '',
			'css_class' => '',
			'view' => '',
		), $atts );

		return ATDTP()->shortcodes_helper()->render_view( 'templates/shortcodes/at_icon', $atts['view'], $atts );
	}

	function vc_iconpicker_type_at_icon_shortocde_icons( $icons, $visual_composer_format = true ) {
		$icons_groups = ATDTP()->shortcodes_helper()->get_at_icon_shortcode_icons();

		if ( ! $icons_groups ) {
			return $icons;
		}

		if ( ! $visual_composer_format ) {
			return array_merge( $icons, $icons_groups );
		} else {
			$adoptet_list = array();
			foreach ( $icons_groups as $category => $group_set ) {
				$adoptet_set = array();
				foreach ( $group_set as $icon_class => $icon_label ) {
					$adoptet_set[][ $icon_class ] = $icon_label;
				}
				$adoptet_list[ $category ] = $adoptet_set;
			}

			return array_merge( $icons, $adoptet_list );
		}
	}
	add_filter( 'vc_iconpicker-type-adventuretours', 'vc_iconpicker_type_at_icon_shortocde_icons', 9, 2 );

	$sc_helper->add_shortcode( 'at_icon', 'atdtp_shortcode_at_icon', array(
		'name' => esc_html__( 'Adventure Tours Icon', 'adventure-tours-data-types' ),
		'params' => array(
			'icon' => array(
				'type' => 'iconpicker',
				'settings' => array(
					'emptyIcon' => false,
					'type' => 'adventuretours',
				),
				// hack for iconpicker selector, allows load icons list via ajax request
				'values' => 'at_get_adventuretours_icons',
			),
			'css_class' => array(),
		),
	) );

	function atdtp_shortcode_ajax_at_icon_get_icons_list() {
		echo wp_json_encode( array(
			'list' => apply_filters( 'vc_iconpicker-type-adventuretours', array(), false )
		) );

		exit();
	}
	add_action( 'wp_ajax_at_get_adventuretours_icons', 'atdtp_shortcode_ajax_at_icon_get_icons_list' );
}
