<?php
/**
 * Definition of shortcodes that generate own content based on data stored in DB.
 *
 * @author    Themedelight
 * @package   Themedelight/ATDTP
 * @version   2.1.8
 */

$sc_helper = ATDTP()->shortcodes_helper();

if ( ! shortcode_exists( 'latest_posts' ) ) {
	/**
	 * Latest posts shorcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdpt_shortcode_latest_posts( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'title' => '',
			'title_underline' => 'on',
			'post_ids' => '',
			'number' => 1,
			'category' => '',
			'translate' => '1',
			'read_more_text' => esc_html__( 'Read more', 'adventure-tours-data-types' ),
			'words_limit' => 25,
			'ignore_sticky_posts' => '1',
			'orderby' => 'date',
			'order' => 'DESC',
			'css_class' => '',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();
		$atts['ignore_sticky_posts'] = $helper->attribute_is_true( $atts['ignore_sticky_posts'] );

		$query_arguments = array(
			'post_type' => 'post',
			'post__in' => ! empty( $atts['post_ids'] ) ? explode( ',', $atts['post_ids'] ) : '',
			'posts_per_page' => $atts['number'] > 0 ? $atts['number'] : -1,
			'orderby' => sanitize_title( $atts['orderby'] ),
			'order' => sanitize_title( $atts['order'] ),
			'tax_query' => array(),
			'ignore_sticky_posts' => $atts['ignore_sticky_posts'],
		);

		if ( ! empty( $atts['category'] ) ) {
			$query_arguments['tax_query'][] = array(
				'taxonomy' => 'category',
				'terms' => array_map( 'sanitize_title', explode( ',', $atts['category'] ) ),
				'field' => 'slug',
				'operator' => 'IN',
			);
		}

		/*
		if ( $helper->attribute_is_true( $atts['translate'] ) ) {
			$queryArguments = apply_filters( 'widget_posts_args', $query_arguments );
		}
		*/

		$query = new Wp_Query( $query_arguments );
		$atts['title_underline'] = $helper->attribute_is_true( $atts['title_underline'] );
		$atts['items'] = $query->get_posts();

		return $helper->render_view( 'templates/shortcodes/latest_posts', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'latest_posts', 'atdpt_shortcode_latest_posts', array(
		'name' => esc_html__( 'Latest Posts', 'adventure-tours-data-types' ),
		'params' => array(
			'title' => array(
				'value' => 'Latest Posts',
			),
			'title_underline' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'category' => array(
				'description' => esc_html__( 'Filter items from specific category (enter category slug).', 'adventure-tours-data-types' ),
			),
			'post_ids' => array(
				'description' => esc_html__( 'Specify exact ids of items that should be displayed separated by comma.', 'adventure-tours-data-types' ),
			),
			'number' => array(
				'value' => '1',
			),
			'read_more_text' => array(
				'value' => 'Read more',
			),
			'words_limit' => array(
				'value' => '25',
			),
			'ignore_sticky_posts' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			/*'translate' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),*/
			'order' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'article_order' ),
			),
			'orderby' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'article_orderby' ),
			),
			'css_class' => array(),
		),
	) );
}

if ( ! shortcode_exists( 'tour_search_form' ) ) {
	/**
	 * Tour search form shorcode rendering function.
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdpt_shortcode_tour_search_form( $atts, $content = null) {
		$atts = shortcode_atts( array(
			'title' => '',
			'note' => '',
			'css_class' => '',
			'hide_text_field' => '',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();
		$atts['hide_text_field'] = $helper->attribute_is_true( $atts['hide_text_field'] );

		return $helper->render_view( 'templates/shortcodes/tour_search_form', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'tour_search_form', 'atdpt_shortcode_tour_search_form', array(
		'name' => esc_html__( 'Tour Search Form', 'adventure-tours-data-types' ),
		'params' => array(
			'title' => array(),
			'note' => array(),
			'css_class' => array(),
			'hide_text_field' => array(
				'type' => 'dropdown',
				'value' => array(
					'off',
					'on',
				),
			),
		),
	) );
}

if ( ! shortcode_exists( 'tour_search_form_horizontal' ) ) {
	/**
	 * Tour search form horizontal shorcode rendering function.
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	*/
	function atdpt_shortcode_tour_search_form_horizontal( $atts, $content = null) {
		$atts = shortcode_atts( array(
			'title' => '',
			'note' => '',
			'style' => '',
			'css_class' => '',
			'hide_text_field' => '',
			'button_align' => '',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();
		$atts['hide_text_field'] = $helper->attribute_is_true( $atts['hide_text_field'] );

		return $helper->render_view( 'templates/shortcodes/tour_search_form_horizontal', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'tour_search_form_horizontal', 'atdpt_shortcode_tour_search_form_horizontal', array(
		'name' => esc_html__( 'Tour Search Form Horizontal', 'adventure-tours-data-types' ),
		'params' => array(
			'title' => array(),
			'note' => array(),
			'style' => array(
				'type' => 'dropdown',
				'value' => array(
					'default',
					'style1',
					'style2',
					'style3',
					'style4',
				),
			),
			'css_class' => array(),
			'hide_text_field' => array(
				'type' => 'dropdown',
				'value' => array(
					'off',
					'on',
				),
			),
			'button_align' => array(
				'type' => 'dropdown',
				'value' => array(
					'full',
					'left',
					'right',
					'center',
				),
			),
		),
	) );
}

if ( ! shortcode_exists( 'tour_category_images' ) ) {
	/**
	 * Tour category shortcode shorcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdpt_shortcode_tour_category_images( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'title' => '',
			'title_underline' => 'on',
			'sub_title' => '',
			'parent_id' => '',
			'ignore_empty' => 1,
			'category_ids' => '',
			'slides_number' => 4,
			'number' => '',
			'autoplay' => '',
			'css_class' => '',
			'orderby' => 'name',
			'order' => 'ASC',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();

		$atts['title_underline'] = $helper->attribute_is_true( $atts['title_underline'] );
		$atts['ignore_empty'] = $helper->attribute_is_true( $atts['ignore_empty'] );
		$atts['items'] = $helper->get_tour_categories_collection( $atts );

		return $helper->render_view( 'templates/shortcodes/tour_category_images', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'tour_category_images', 'atdpt_shortcode_tour_category_images', array(
		'name' => esc_html__( 'Tour Category Images', 'adventure-tours-data-types' ),
		'params' => array(
			'title' => array(),
			'title_underline' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'sub_title' => array(),
			'parent_id' => array(),
			'ignore_empty' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'category_ids' => array(
				'description' => esc_html__( 'Specify exact ids of items that should be displayed separated by comma.', 'adventure-tours-data-types' ),
			),
			'slides_number' => array(
				'value' => '4',
			),
			'number' => array(),
			'autoplay' => array(
				'value' => '',
				'description' => esc_html__( 'Auto sliding interval in seconds.', 'adventure-tours-data-types' ),
			),
			'css_class' => array(),
			'order' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'category_order' ),
			),
			'orderby' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'category_orderby' ),
			),
		),
	) );
}

if ( ! shortcode_exists( 'tour_category_icons' ) ) {
	/**
	 * Tour category shortcode that presents each tour category with related icon.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdpt_shortcode_tour_category_icons( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'title' => '',
			'title_underline' => 'on',
			'sub_title' => '',
			'parent_id' => '',
			'bg_url' => '',
			'ignore_empty' => 1,
			'category_ids' => '',
			'slides_number' => 5,
			'number' => '',
			'autoplay' => '',
			'css_class' => '',
			'orderby' => 'name',
			'order' => 'ASC',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();

		$atts['title_underline'] = $helper->attribute_is_true( $atts['title_underline'] );
		$atts['ignore_empty'] = $helper->attribute_is_true( $atts['ignore_empty'] );
		$atts['items'] = $helper->get_tour_categories_collection( $atts );

		return $helper->render_view( 'templates/shortcodes/tour_category_icons', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'tour_category_icons', 'atdpt_shortcode_tour_category_icons', array(
		'name' => esc_html__( 'Tour Category Icons', 'adventure-tours-data-types' ),
		'params' => array(
			'title' => array(),
			'title_underline' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'sub_title' => array(),
			'parent_id' => array(),
			'bg_url' => array(
				'type' => 'attach_image_url',
				'description' => esc_html__( 'Select image that should be used as background.', 'adventure-tours-data-types' ),
			),
			'ignore_empty' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'category_ids' => array(
				'description' => esc_html__( 'Specify exact ids of items that should be displayed separated by comma.', 'adventure-tours-data-types' ),
			),
			'slides_number' => array(
				'value' => '5',
			),
			'number' => array(),
			'autoplay' => array(
				'value' => '',
				'description' => esc_html__( 'Auto sliding interval in seconds.', 'adventure-tours-data-types' ),
			),
			'css_class' => array(),
			'order' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'category_order' ),
			),
			'orderby' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'category_orderby' ),
			),
		),
	) );
}

if ( ! shortcode_exists( 'tour_carousel' ) ) {
	/**
	 * Tour carousel shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdpt_shortcode_tour_carousel( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'title' => '',
			'title_underline' => 'on',
			'sub_title' => '',
			'image_size' => 'thumb_tour_listing_small',
			'image_size_mobile' => 'thumb_tour_medium',
			'bg_url' => '',
			'arrow_style' => 'light',
			'description_words_limit' => 20,
			'tour_category' => '',
			'tour_category_ids' => '',
			'tour_category_ids_condition' => '',
			'show_categories' => 'on',
			'tour_ids' => '',
			'show' => '',
			'slides_number' => 3,
			'number' => '',
			'autoplay' => '',
			'css_class' => '',
			'orderby' => 'date',
			'order' => 'DESC',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();

		$atts['title_underline'] = $helper->attribute_is_true( $atts['title_underline'] );
		$atts['items'] = $helper->get_tours_collection( $atts );
		$atts['show_categories'] = $helper->attribute_is_true( $atts['show_categories'] );

		return $helper->render_view( 'templates/shortcodes/tour_carousel', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'tour_carousel', 'atdpt_shortcode_tour_carousel', array(
		'name' => esc_html__( 'Tours Carousel', 'adventure-tours-data-types' ),
		'params' => array(
			'title' => array(),
			'title_underline' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'sub_title' => array(),
			'description_words_limit' => array(
				'value' => '20'
			),
			'tour_category' => array(
				'description' => esc_html__( 'Filter items from specific tour category (enter category slug).', 'adventure-tours-data-types' ),
			),
			'tour_category_ids' => array(
				'description' => esc_html__( 'Specify tour categories ID\'s (separated by comma) of items that you want to display.', 'adventure-tours-data-types' ),
			),
			'tour_category_ids_condition' => array(
				'type' => 'dropdown',
				'value' => array(
					'IN',
					'AND',
				),
			),
			'tour_ids' => array(
				'description' => esc_html__( 'Specify exact ids of items that should be displayed separated by comma.', 'adventure-tours-data-types' ),
			),
			'show' => array(
				'type' => 'dropdown',
				'value' => array(
					'',
					'featured',
					'onsale',
				),
			),
			'slides_number' => array(
				'value' => '3',
			),
			'number' => array(),
			'autoplay' => array(
				'value' => '',
				'description' => esc_html__( 'Auto sliding interval in seconds.', 'adventure-tours-data-types' ),
			),
			'css_class' => array(),
			'show_categories' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'bg_url' => array(
				'type' => 'attach_image_url',
				'description' => esc_html__( 'Select image that should be used as background.', 'adventure-tours-data-types' ),
			),
			'arrow_style' => array(
				'type' => 'dropdown',
				'value' => array(
					'light',
					'dark',
				),
			),
			'order' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'article_order' ),
			),
			'orderby' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'article_product_orderby' ),
			),
		),
	) );
}

if ( ! shortcode_exists( 'product_carousel' ) ) {
	/**
	 * Product carousel shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdpt_shortcode_product_carousel( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'title' => '',
			'title_underline' => 'on',
			'sub_title' => '',
			'image_size' => 'thumb_tour_listing_small',
			'image_size_mobile' => 'thumb_tour_medium',
			'bg_url' => '',
			'arrow_style' => 'light',
			'description_words_limit' => 20,
			'product_category' => '',
			'product_category_ids' => '',
			'product_ids' => '',
			'show' => '',
			'slides_number' => 3,
			'number' => '',
			'autoplay' => '',
			'css_class' => '',
			'orderby' => 'date',
			'order' => 'DESC',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();

		$atts['title_underline'] = $helper->attribute_is_true( $atts['title_underline'] );
		$atts['items'] = $helper->get_products_collection( $atts );

		return $helper->render_view( 'templates/shortcodes/product_carousel', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'product_carousel', 'atdpt_shortcode_product_carousel', array(
		'name' => esc_html__( 'Products Carousel', 'adventure-tours-data-types' ),
		'params' => array(
			'title' => array(),
			'title_underline' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'sub_title' => array(),
			'description_words_limit' => array(
				'value' => '20'
			),
			'product_category' => array(
				'description' => esc_html__( 'Filter items from specific product category (enter category slug).', 'adventure-tours-data-types' ),
			),
			'product_category_ids' => array(
				'description' => esc_html__( 'Specify product categories ID\'s (separated by comma) of items that you want to display.', 'adventure-tours-data-types' ),
			),
			'product_ids' => array(
				'description' => esc_html__( 'Specify exact ids of items that should be displayed separated by comma.', 'adventure-tours-data-types' ),
			),
			'show' => array(
				'type' => 'dropdown',
				'value' => array(
					'',
					'featured',
					'onsale',
				),
			),
			'slides_number' => array(
				'value' => '3',
			),
			'number' => array(),
			'autoplay' => array(
				'value' => '',
				'description' => esc_html__( 'Auto sliding interval in seconds.', 'adventure-tours-data-types' ),
			),
			'css_class' => array(),
			'bg_url' => array(
				'type' => 'attach_image_url',
				'description' => esc_html__( 'Select image that should be used as background.', 'adventure-tours-data-types' ),
			),
			'arrow_style' => array(
				'type' => 'dropdown',
				'value' => array(
					'light',
					'dark',
				),
			),
			'order' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'article_order' ),
			),
			'orderby' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'article_product_orderby' ),
			),
		),
	) );
}

if ( ! shortcode_exists( 'tours_grid' ) ) {
	/**
	 * Tours grid shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdpt_shortcode_tours_grid( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'title' => '',
			'title_underline' => 'on',
			'sub_title' => '',
			'image_size' => 'thumb_tour_listing_small',
			'image_size_mobile' => '',
			'btn_more_text' => esc_html__( 'View more', 'adventure-tours-data-types' ),
			'btn_more_link' => '',
			'price_style' => '',
			'description_words_limit' => 20,
			'tour_category' => '',
			'tour_category_ids' => '',
			'tour_category_ids_condition' => '',
			'show_categories' => 'on',
			'tour_ids' => '',
			'show' => '',
			'number' => '4',
			'columns' => '',
			'css_class' => '',
			'orderby' => 'date',
			'order' => 'DESC',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();

		$atts['title_underline'] = $helper->attribute_is_true( $atts['title_underline'] );
		$atts['show_categories'] = $helper->attribute_is_true( $atts['show_categories'] );
		$atts['items'] = $helper->get_tours_collection( $atts );

		return $helper->render_view( 'templates/shortcodes/tours_grid', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'tours_grid', 'atdpt_shortcode_tours_grid', array(
		'name' => esc_html__( 'Tours Grid', 'adventure-tours-data-types' ),
		'params' => array(
			'title' => array(),
			'title_underline' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'sub_title' => array(),
			'description_words_limit' => array(
				'value' => '20'
			),
			'tour_category' => array(
				'description' => esc_html__( 'Filter items from specific tour category (enter category slug).', 'adventure-tours-data-types' ),
			),
			'tour_category_ids' => array(
				'description' => esc_html__( 'Specify tour categories ID\'s (separated by comma) of items that you want to display.', 'adventure-tours-data-types' ),
			),
			'tour_category_ids_condition' => array(
				'type' => 'dropdown',
				'value' => array(
					'IN',
					'AND',
				),
			),
			'tour_ids' => array(
				'description' => esc_html__( 'Specify exact ids of items that should be displayed separated by comma.', 'adventure-tours-data-types' ),
			),
			'show' => array(
				'type' => 'dropdown',
				'value' => array(
					'',
					'featured',
					'onsale',
				),
			),
			'number' => array(
				'value' => '4',
			),
			'columns' => array(),
			'css_class' => array(),
			'price_style' => array(
				'type' => 'dropdown',
				'value' => array(
					'default',
					'highlighted',
				),
			),
			'show_categories' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'btn_more_text' => array(
				'value' => 'View more',
			),
			'btn_more_link' => array(),
			'order' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'article_order' ),
			),
			'orderby' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'article_product_orderby' ),
			),
		),
	) );

	// For backward compatibility
	if ( ! shortcode_exists( 'tour_list' ) ) {
		add_shortcode( 'tour_list', 'atdpt_shortcode_tours_grid' );
	}
}

if ( ! shortcode_exists( 'tours_list' ) ) {
	/**
	 * Tours list shortcode rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	*/
	function atdpt_shortcode_tours_list( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'title' => '',
			'title_underline' => 'on',
			'sub_title' => '',
			'image_size' => 'thumb_tour_box',
			'image_size_mobile' => '',
			'btn_more_text' => esc_html__( 'View more', 'adventure-tours-data-types' ),
			'btn_more_link' => '',
			'description_words_limit' => 20,
			'tour_category' => '',
			'tour_category_ids' => '',
			'tour_category_ids_condition' => '',
			'show_categories' => 'on',
			'tour_ids' => '',
			'show' => '',
			'number' => '4',
			'css_class' => '',
			'orderby' => 'date',
			'order' => 'DESC',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();

		$atts['title_underline'] = $helper->attribute_is_true( $atts['title_underline'] );
		$atts['show_categories'] = $helper->attribute_is_true( $atts['show_categories'] );
		$atts['items'] = $helper->get_tours_collection( $atts );

		return $helper->render_view( 'templates/shortcodes/tours_list', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'tours_list', 'atdpt_shortcode_tours_list', array(
		'name' => esc_html__( 'Tours List', 'adventure-tours-data-types' ),
		'params' => array(
			'title' => array(),
			'title_underline' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'sub_title' => array(),
			'description_words_limit' => array(
				'value' => '20'
			),
			'tour_category' => array(
				'description' => esc_html__( 'Filter items from specific tour category (enter category slug).', 'adventure-tours-data-types' ),
			),
			'tour_category_ids' => array(
				'description' => esc_html__( 'Specify tour categories ID\'s (separated by comma) of items that you want to display.', 'adventure-tours-data-types' ),
			),
			'tour_category_ids_condition' => array(
				'type' => 'dropdown',
				'value' => array(
					'IN',
					'AND',
				),
			),
			'tour_ids' => array(
				'description' => esc_html__( 'Specify exact ids of items that should be displayed separated by comma.', 'adventure-tours-data-types' ),
			),
			'show' => array(
				'type' => 'dropdown',
				'value' => array(
					'',
					'featured',
					'onsale',
				),
			),
			'number' => array(
				'value' => '4',
			),
			'css_class' => array(),
			'show_categories' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'btn_more_text' => array(
				'value' => 'View more',
			),
			'btn_more_link' => array(),
			'order' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'article_order' ),
			),
			'orderby' => array(
				'type' => 'dropdown',
				'value' => $sc_helper->get_order_values( 'article_product_orderby' ),
			),
		),
	) );
}

if ( ! shortcode_exists( 'tour_reviews' ) ) {
	/**
	 * Tour reviews shortcode (renders latest reviews related to tours) rendering function.
	 *
	 * @param  array  $atts     shortcode attributes.
	 * @param  string $content  shortcode content text.
	 * @return string
	 */
	function atdpt_shortcode_tour_reviews( $atts, $content = null ) {
		$atts = shortcode_atts( array(
			'title' => '',
			'title_underline' => 'on',
			'tour_id' => '',
			'number' => '2',
			'words_limit' => '',
			'css_class' => '',
			'orderby' => 'comment_date_gmt',
			'order' => 'DESC',
			'view' => '',
		), $atts );

		$helper = ATDTP()->shortcodes_helper();

		$atts['title_underline'] = $helper->attribute_is_true( $atts['title_underline'] );
		$atts['reviews'] = get_comments( array(
			'post_id' => (int) $atts['tour_id'],
			'number' => (int) $atts['number'],
			'status' => 'approve',
			'post_status' => 'publish',
			'post_type' => 'product',
			'orderby' => sanitize_title( $atts['orderby'] ),
			'order' => sanitize_title( $atts['order'] ),
			// Filtering only ratings related to tours.
			'meta_key' => 'is_tour_rating',
			'meta_value' => '1',
		) );

		return $helper->render_view( 'templates/shortcodes/tour_reviews', $atts['view'], $atts );
	}

	$sc_helper->add_shortcode( 'tour_reviews', 'atdpt_shortcode_tour_reviews', array(
		'name' => esc_html__( 'Tour Reviews', 'adventure-tours-data-types' ),
		'params' => array(
			'title' => array(),
			'title_underline' => array(
				'type' => 'dropdown',
				'value' => array(
					'on',
					'off',
				),
			),
			'tour_id' => array(
				'value' => '',
			),
			'number' => array(
				'value' => '2',
			),
			'words_limit' => array(
				'value' => '',
			),
			'css_class' => array(),
			'order' => array(
				'type' => 'dropdown',
				'value' => array(
					'DESC',
					'ASC',
				),
			),
			'orderby' => array(
				'type' => 'dropdown',
				'value' => array(
					'comment_date_gmt',
					'comment_author',
					'comment_post_ID',
				),
			),
		),
	) );
}
