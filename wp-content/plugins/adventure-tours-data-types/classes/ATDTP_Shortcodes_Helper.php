<?php
/**
 * Shortcodes helper service.
 *
 * @author    Themedelight
 * @package   Themedelight/ATDTP
 * @version   2.2.1
 */

class ATDTP_Shortcodes_Helper
{
	/**
	 * @return ATDTP_Shortcodes_Nl_Escaper
	 */
	private $nl_escaper;

	protected $configs_set = array();

	public function __construct() {
		add_action( 'after_setup_theme', array( $this, 'action_register_shortcodes' ) );
		add_action( 'vc_before_init', array( $this, 'action_register_shortcodes' ) );

		if ( is_admin() ) {
			add_filter( 'adventure_tours_shortcodes_register_preload_list', array( $this, 'filter_preload_shortcodes_for_register') );
		}
	}

	private $register_done = false;

	/**
	 * Hook for 'after_setup_theme' event.
	 *
	 * @return void
	 */
	public function action_register_shortcodes() {
		if ( $this->register_done ) {
			return;
		}

		$this->register_done = true;

		ATDTP()->require_file( '/includes/shortcodes_static.php' );

		ATDTP()->require_file( '/includes/shortcodes_dynamic.php' );
	}

	/**
	 * @return ATDTP_Shortcodes_Nl_Escaper
	 */
	public function nl_escaper() {
		if ( ! $this->nl_escaper ) {
			ATDTP()->require_file( '/classes/ATDTP_Shortcodes_Nl_Escaper.php' );

			$this->nl_escaper = new ATDTP_Shortcodes_Nl_Escaper();
		}

		return $this->nl_escaper;
	}

	/**
	 * Renders view with specefies set of parameters.
	 *
	 * @param  string  $view    view name.
	 * @param  string  $postfix optional, view postfix.
	 * @param  array   $data            assoc array with variables that should be passed to view.
	 * @return string
	 */
	public function render_view( $view, $postfix = '', array $data = array() ) {
		static $__rfCache;
		if ( null === $__rfCache ) {
			$__rfCache = array();
		}
		$__cacheKey = $view . $postfix;
		if ( isset( $__rfCache[ $__cacheKey ] ) ) {
			$__viewFilePath = $__rfCache[ $__cacheKey ];
		} else {
			$__templateVariations = array();
			if ( $postfix ) {
				$__templateVariations[] = $view . '-' . $postfix . '.php';
			}
			$__templateVariations[] = $view . '.php';

			$__viewFilePath = locate_template( $__templateVariations );

			if ( ! $__viewFilePath ) {
				foreach ( $__templateVariations as $__templateVriant ) {
					$__curVariantPath = ATDTP_PATH . '/' . $__templateVriant;
					if ( file_exists( $__curVariantPath ) ) {
						$__viewFilePath = $__curVariantPath;
					}
				}
			}

			$__rfCache[ $__cacheKey ] = $__viewFilePath;
		}

		if ( ! $__viewFilePath ) {
			return '';
		}

		$__rfData = $data;

		unset( $view );
		unset( $postfix );
		unset( $data );

		if ( $__rfData ) {
			extract( $__rfData );
		}

		ob_start();
		include $__viewFilePath;
		return ob_get_clean();
	}

	/**
	 * Checks if values of the boolean attribute is true.
	 *
	 * @param  string $value
	 * @return boolean
	 */
	public function attribute_is_true( $value ) {
		if ( ! $value || in_array( $value, array( 'no','false', 'off' ) ) ) {
			return false;
		}
		return true;
	}

	/**
	 * Get shortcode identifier.
	 *
	 * @return integer
	 */
	public function generate_id(){
		static $id = 0;
		$id++;

		return $id;
	}

	/**
	 * Returns collection of tour category items based on attribute values used in shortcodes
	 * related to the tour categories rendering.
	 *
	 * @param  assoc $atts shorcode attributes.
	 * @return array
	 */
	public function get_tour_categories_collection( $atts ) {
		if ( ! $this->check( 'tour_category_taxonomy_exists' ) ) {
			return array();
		}

		$category_ids = empty( $atts['category_ids'] ) ? array() : explode( ',', $atts['category_ids'] );
		$orderby = ! empty( $atts['orderby'] ) ? sanitize_title( $atts['orderby'] ) : 'name';
		$order = ! empty( $atts['order'] ) ? sanitize_title( $atts['order'] ) : 'ASC';

		$categories_args = array(
			'orderby' => $orderby,
			'order' => $order,
			'hide_empty' => 0,
			'include' => $category_ids,
			'number' => (int) $atts['number'],
			'hierarchical' => 1,
			'taxonomy' => 'tour_category',
			'pad_counts' => 1,
		);

		if ( ! $category_ids ) {
			$categories_args['parent'] = (int) $atts['parent_id'];
		}

		$product_categories = get_categories( apply_filters( 'woocommerce_product_subcategories_args', $categories_args ) );

		if ($product_categories && ! empty( $atts['ignore_empty'] ) ) {
			$product_categories = wp_list_filter( $product_categories, array( 'count' => 0 ), 'NOT' );
		}

		if ( 'category__in' == $orderby && ! empty( $category_ids ) ) {
			$result_orderby_cateogry_in = array();

			foreach( $category_ids as $id ) {
				$result_orderby_cateogry_in[ trim( $id ) ] = '';
			}

			// strings are equal
			if ( 0 == strcasecmp( 'desc', $order ) ) {
				$result_orderby_cateogry_in = array_reverse( $result_orderby_cateogry_in, true );
			}

			foreach( $product_categories as $category ) {
				if ( isset( $result_orderby_cateogry_in[ $category->term_id ] ) ) {
					$result_orderby_cateogry_in[ $category->term_id ] = $category;
				}
			}

			if ( ! empty( $result_orderby_cateogry_in ) ) {
				foreach( $result_orderby_cateogry_in as $key => $val ) {
					if ( empty( $val ) ) {
						unset( $result_orderby_cateogry_in[ $key ] );
					}
				}

				return $result_orderby_cateogry_in;
			}
		}

		return $product_categories;
	}

	/**
	 * Returns collection of WC_Product_Tour instances based on attribute values used in shortcodes
	 * related to the tours rendering.
	 *
	 * @param  assoc $atts shorcode attributes.
	 * @return array
	 */
	public function get_tours_collection( $atts ) {
		$result = array();
		$items = $this->get_tours_query( $atts )->get_posts();

		foreach ( $items as $item ) {
			$result[] = wc_get_product( $item );
		}

		return $result;
	}

	/**
	 * Returns WP_Query instance based on attribute values used in shortcodes related to the tours rendering.
	 *
	 * @param  assoc $atts shorcode attributes.
	 * @return array
	 */
	public function get_tours_query( $atts ) {
		$number  = ! empty( $atts['number'] ) ? absint( $atts['number'] ) : '-1';
		$show    = ! empty( $atts['show'] ) ? sanitize_title( $atts['show'] ) : '';
		$orderby = ! empty( $atts['orderby'] ) ? sanitize_title( $atts['orderby'] ) : 'date';
		$order   = ! empty( $atts['order'] ) ? sanitize_title( $atts['order'] ) : 'DESC';

		$is_wc_loaded = $this->check( 'is_wc_loaded' );

		$query_args = array(
			'wc_query'       => 'tours', // tours query marker
			'posts_per_page' => $number,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'no_found_rows'  => 1,
			'order'          => $order,
			'meta_query'     => array(),
			'tax_query'      => array(
				'relation' => 'AND',
				$this->get_tour_tax_query(),
			),
		);

		if ( ! empty( $atts['tour_ids'] ) ) {
			$query_args['post__in'] = explode(',', $atts['tour_ids']);
		}

		// used for WC > 3.0.0
		$product_visibility_not_in = array();

		if ( empty( $atts['show_hidden'] ) && $is_wc_loaded ) {
			if ( $this->check( 'is_wc_older_than_30' ) ) {
				$visibility_meta = WC()->query->visibility_meta_query();
				if ( $visibility_meta ) {
					$query_args['meta_query'][] = $visibility_meta;
				}
			} else {
				$product_visibility_not_in[] = $this->get_product_visibility_term_ids( 'exclude-from-catalog' );
			}

			$query_args['post_parent']  = 0;
		}

		if ( ! empty( $atts['hide_free'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => '_price',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'DECIMAL',
			);
		}

		if ( $this->check( 'tour_category_taxonomy_exists' ) ) {
			if ( ! empty( $atts['tour_category_ids'] ) ) {
				$query_args['tax_query'][] = array(
					'taxonomy' => 'tour_category',
					'terms' => array_map( 'intval', explode( ',', $atts['tour_category_ids'] ) ),
					'field' => 'term_id',
					'operator' => ! empty( $atts['tour_category_ids_condition'] ) &&  $atts['tour_category_ids_condition'] == 'AND' ? 'AND' : 'IN',
				);
			} elseif ( ! empty( $atts['tour_category'] ) ) {
				$query_args['tax_query'][] = array(
					'taxonomy' => 'tour_category',
					'terms' => array_map( 'sanitize_title', explode( ',', $atts['tour_category'] ) ),
					'field' => 'slug',
					'operator' => 'IN',
				);
			}
		}

		if ( $is_wc_loaded ) {
			if ( $this->check( 'is_wc_older_than_30' ) ) {
				$stock_meta = WC()->query->stock_status_meta_query();
				if ( $visibility_meta ) {
					$query_args['meta_query'][] = $stock_meta;
				}
			} elseif ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
				$product_visibility_not_in[] = $this->get_product_visibility_term_ids( 'outofstock' );
			}

			if ( $product_visibility_not_in ) {
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_not_in,
					'operator' => 'NOT IN',
				);
			}
		}

		switch ( $show ) {
		case 'featured' :
			if ( $this->check( 'is_wc_older_than_30' ) ) {
				$query_args['meta_query'][] = array(
					'key'   => '_featured',
					'value' => 'yes'
				);
			} else {
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $this->get_product_visibility_term_ids( 'featured' ),
				);
			}
			break;

		case 'onsale' :
			if ( empty( $atts['tour_ids'] ) ) {
				$product_ids_on_sale    = $is_wc_loaded ? wc_get_product_ids_on_sale() : array();
				$product_ids_on_sale[]  = 0;
				$query_args['post__in'] = $product_ids_on_sale;
			}
			break;
		}

		switch ( $orderby ) {
		case 'price' :
			$query_args['meta_key'] = '_price';
			$query_args['orderby']  = 'meta_value_num';
			break;

		case 'sales' :
			$query_args['meta_key'] = 'total_sales';
			$query_args['orderby']  = 'meta_value_num';
			break;

		default :
			$query_args['orderby']  = $orderby;
		}

		$is_most_popular_query = $is_wc_loaded && $orderby == 'most_popular';
		if ( $is_most_popular_query ) {
			add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
		}

		$result_query = new WP_Query( $query_args );

		if ( $is_most_popular_query ) {
			remove_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );
		}

		return $result_query;
	}

	/**
	 * Returns collection of WC_Product instances based on attribute values used in shortcodes
	 * related to the products rendering.
	 *
	 * @param  assoc $atts shorcode attributes.
	 * @return array
	 */
	public function get_products_collection( $atts ) {
		$result = array();
		$items = $this->get_products_query( $atts )->get_posts();

		foreach ( $items as $item ) {
			$result[] = wc_get_product( $item );
		}

		return $result;
	}

	/**
	 * Returns WP_Query instance based on attribute values used in shortcodes related to the products rendering.
	 *
	 * @param  assoc $atts shorcode attributes.
	 * @return array
	 */
	public function get_products_query( $atts ) {
		$number  = ! empty( $atts['number'] ) ? absint( $atts['number'] ) : '-1';
		$show    = ! empty( $atts['show'] ) ? sanitize_title( $atts['show'] ) : '';
		$orderby = ! empty( $atts['orderby'] ) ? sanitize_title( $atts['orderby'] ) : 'date';
		$order   = ! empty( $atts['order'] ) ? sanitize_title( $atts['order'] ) : 'DESC';

		$is_wc_loaded = $this->check( 'is_wc_loaded' );

		$query_args = array(
			'posts_per_page' => $number,
			'post_status'    => 'publish',
			'post_type'      => 'product',
			'no_found_rows'  => 1,
			'order'          => $order,
			'meta_query'     => array(),
		);

		if ( ! empty( $atts['product_ids'] ) ) {
			$query_args['post__in'] = explode(',', $atts['product_ids']);
		}

		// used for WC > 3.0.0
		$product_visibility_not_in = array();

		if ( empty( $atts['show_hidden'] ) && $is_wc_loaded ) {
			if ( $this->check( 'is_wc_older_than_30' ) ) {
				$visibility_meta = WC()->query->visibility_meta_query();
				if ( $visibility_meta ) {
					$query_args['meta_query'][] = $visibility_meta;
				}
			} else {
				$product_visibility_not_in[] = $this->get_product_visibility_term_ids( 'exclude-from-catalog' );
			}

			$query_args['post_parent']  = 0;



			if ( $is_wc_loaded ) {
				$query_args['meta_query'][] = WC()->query->visibility_meta_query();
			}
			$query_args['post_parent']  = 0;
		}

		if ( ! empty( $atts['hide_free'] ) ) {
			$query_args['meta_query'][] = array(
				'key'     => '_price',
				'value'   => 0,
				'compare' => '>',
				'type'    => 'DECIMAL',
			);
		}

		if ( $this->check( 'product_cat_taxonomy_exists' ) ) {
			if ( ! empty( $atts['product_category_ids'] ) ) {
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_cat',
					'terms' => array_map( 'intval', explode( ',', $atts['product_category_ids'] ) ),
					'field' => 'term_id',
					'operator' => 'IN',
				);
			} elseif ( ! empty( $atts['product_category'] ) ) {
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_cat',
					'terms' => array_map( 'sanitize_title', explode( ',', $atts['product_category'] ) ),
					'field' => 'slug',
					'operator' => 'IN',
				);
			}
		}

		if ( $is_wc_loaded ) {
			$query_args['meta_query'][] = WC()->query->stock_status_meta_query();
			$query_args['meta_query']   = array_filter( $query_args['meta_query'] );
		}

		if ( $is_wc_loaded ) {
			if ( $this->check( 'is_wc_older_than_30' ) ) {
				$stock_meta = WC()->query->stock_status_meta_query();
				if ( $visibility_meta ) {
					$query_args['meta_query'][] = $stock_meta;
				}
			} elseif ( 'yes' === get_option( 'woocommerce_hide_out_of_stock_items' ) ) {
				$product_visibility_not_in[] = $this->get_product_visibility_term_ids( 'outofstock' );
			}

			if ( $product_visibility_not_in ) {
				$query_args['tax_query'][] = array(
					'taxonomy' => 'product_visibility',
					'field'    => 'term_taxonomy_id',
					'terms'    => $product_visibility_not_in,
					'operator' => 'NOT IN',
				);
			}
		}

		switch ( $show ) {
			case 'featured' :
				if ( $this->check( 'is_wc_older_than_30' ) ) {
					$query_args['meta_query'][] = array(
						'key'   => '_featured',
						'value' => 'yes'
					);
				} else {
					$query_args['tax_query'][] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'term_taxonomy_id',
						'terms'    => $this->get_product_visibility_term_ids( 'featured' ),
					);
				}
				break;

			case 'onsale' :
				if ( empty( $atts['product_ids'] ) ) {
					$product_ids_on_sale    = $is_wc_loaded ? wc_get_product_ids_on_sale() : array();
					$product_ids_on_sale[]  = 0;
					$query_args['post__in'] = $product_ids_on_sale;
				}
				break;
		}

		switch ( $orderby ) {
			case 'price' :
				$query_args['meta_key'] = '_price';
				$query_args['orderby']  = 'meta_value_num';
				break;

			case 'sales' :
				$query_args['meta_key'] = 'total_sales';
				$query_args['orderby']  = 'meta_value_num';
				break;

			default :
				$query_args['orderby']  = $orderby;
		}

		$is_most_popular_query = $is_wc_loaded && $orderby == 'most_popular';
		if ( $is_most_popular_query ) {
			add_filter( 'posts_clauses',  array( WC()->query, 'order_by_rating_post_clauses' ) );
		}

		$result_query = new WP_Query( $query_args );

		if ( $is_most_popular_query ) {
			remove_filter( 'posts_clauses', array( WC()->query, 'order_by_rating_post_clauses' ) );
		}

		return $result_query;
	}

	/**
	 * Builds tax query for filtering/excluding tours from WooCommerce product posts.
	 *
	 * @param boolean $invert
	 * @param boolean $rebuild
	 * @return assoc
	 */
	protected function get_tour_tax_query( $invert = false, $rebuild = false ) {
		static $cache;

		if ( null === $cache || $rebuild ) {
			$tax_name = 'product_type';
			$term_slug = 'tour';
			$tour_term = get_term_by( 'slug', $term_slug, $tax_name );

			if ( $tour_term ) {
				$cache = array(
					'taxonomy' => $tax_name,
					'field' => 'term_id',
					'terms' => array( $tour_term->term_id ),
					'operator' => 'IN',
				);
			} else {
				$cache = array(
					'taxonomy' => $tax_name,
					'field' => 'slug',
					'terms' => array( $term_slug ),
					'operator' => 'IN',
				);
			}
		}

		return !$invert ? $cache : array_merge( $cache, array(
			'operator' => 'NOT IN'
		) );
	}

	/**
	 * Makes different checks required for correct plugin working.
	 *
	 * @param  string $check_name check uniq. code.
	 * @return boolean
	 */
	protected function check( $check_name ) {
		$result = false;

		switch ( $check_name ) {
		case 'is_wc_loaded':
			$result = function_exists( 'WC' );
			break;
		case 'is_wc_older_than_30':
			$result = version_compare( WC_VERSION, '3.0.0', '<');
			break;
		case 'tour_category_taxonomy_exists':
			$result = taxonomy_exists( 'tour_category' );
			break;
		case 'product_cat_taxonomy_exists':
			$result = taxonomy_exists( 'product_cat' );
			break;
		}

		return $result;
	}

	protected function get_product_visibility_term_ids( $key = null ) {
		static $result;
		if ( null === $result ) {
			$result = wc_get_product_visibility_term_ids();
		}
		return $key ? $result[ $key ] : $result;
	}

	public function add_shortcode( $schorcode_name, $callback, $config ) {
		add_shortcode( $schorcode_name, $callback );
		$this->configs_set[ $schorcode_name ] = $config;
	}

	public function is_shortcode_registered( $name ) {
		return isset( $this->configs_set[ $name ] );
	}

	public function get_shortcodes_config() {
		return $this->configs_set;
	}

	public function get_order_values( $mode ) {
		$modes = array(
			'category_order' => array(
				'ASC',
				'DESC',
			),
			'category_orderby' => array(
				'name',
				'id',
				'slug',
				'count',
				'term_group',
				'category__in',
			),
			'article_order' => array(
				'DESC',
				'ASC',
			),
			'article_orderby' => array(
				'date',
				'title',
				'name',
				'modified',
				'rand',
				'comment_count',
				'post__in',
			),
			'product_orderby' => array(
				'price',
				'sales',
				'most_popular',
				'menu_order',
			),
		);

		if ( 'article_product_orderby' == $mode ) {
			return array_merge( $modes['article_orderby'], $modes['product_orderby'] );
		}

		return isset($modes[$mode] ) ? $modes[$mode] : array();
	}

	public function filter_preload_shortcodes_for_register( $set ) {
		$list = $this->get_shortcodes_config();

		if ( $list ) {
			foreach ( $list as $schortcode_name => $sc_config ) {
				$params = !empty( $sc_config['params'] ) ? $sc_config['params'] : array();
				foreach ( $params as $_p_name => &$_p_config ) {
					if ( empty( $_p_config['type'] ) ) {
						$_p_config['type'] = 'text';
					}

					switch( $_p_config['type'] ) {
					case 'dropdown':
						$_p_config['values'] = !empty( $_p_config['value'] ) ? $_p_config['value'] : array();
						if ( $_p_config['values'] ) {
							$_p_config['value'] = $_p_config['values'][0];
						}
						break;
					}

				}

				$set[ $schortcode_name ] = array(
					'name' => $this->filter_schortcode_name_for_register( $sc_config['name'], $schortcode_name ),
					'params' => $params
				);
			}

			$sc_categories = $this->get_shortcode_categories();
			if ( $sc_categories ) {
				$sorted = array();
				$right_order = array_keys( $sc_categories );
				foreach( $right_order as $current_schortcode ) {
					if ( !isset( $set[ $current_schortcode ] ) ) {
						continue;
					}

					$sorted[ $current_schortcode ] = $set[ $current_schortcode ];
					unset( $set[ $current_schortcode ] );
				}
				if ( $set ) {
					$sorted = array_merge( $sorted, $set );
				}
				return $sorted;
			}

		}

		return $set;
	}

	public function filter_schortcode_name_for_register( $name, $schortcode ) {
		$sc_category = $this->get_shortcode_categories();
		if ( !empty( $sc_category[ $schortcode ] ) ) {
			return $sc_category[ $schortcode ] . '.' . $name;
		}
		return $name;
	}

	public function get_shortcode_categories( $as_tree = false ) {
		static $tree, $sc_category = array();
		if ( null === $tree ) {
			$tree = array();

			$tree[ esc_html__( 'Typography', 'adventure-tours-data-types' ) ] = array(
				'title',
				'icon_tick',
				'at_btn',
				'at_icon',
			);

			// This shortcodes and category added in functions.php @see adveture_tours_init_tiny_mce_integration
			$tree[ esc_html__( 'Tables', 'adventure-tours-data-types' ) ] = array(
				'table',
				'tour_table',
			);

			$tree[ esc_html__( 'Tours', 'adventure-tours-data-types' ) ] = array(
				'tour_search_form',
				'tour_search_form_horizontal',
				'tour_category_images',
				'tour_category_icons',
				'tour_carousel',
				'tours_grid',
				'tours_list',
				'tour_reviews',
			);

			$tree[ esc_html__( 'Contact', 'adventure-tours-data-types' ) ] = array(
				'contact_info',
				'social_icons',
			);

			$tree[ esc_html__( 'External Services', 'adventure-tours-data-types' ) ] = array(
				'mailchimp_form',
				'google_map',
				'google_map_embed',
			);

			$tree[ esc_html__( 'Other', 'adventure-tours-data-types' ) ] = array(
				'latest_posts',
				'timeline',
				'icons_set',
				'product_carousel',
				'accordion',
				'tabs',
			);

			foreach ( $tree as $cat => $list ) {
				foreach ( $list as $_cur_shortcode ) {
					$sc_category[ $_cur_shortcode ] = $cat;
				}
			}
		}

		if ( $as_tree ) {
			return $tree;
		}
		return $sc_category;
	}

	/**
	 * Returns sets of icons. Name of the set should be defined via key.
	 * Each set is assoc where key is icon class, value is icon label.
	 *
	 * @example
	 * <pre>
	 * array(
	 *     'Collection 1' => array(
	 *         'icon icon-1' => 'Icon #1',
	 *         'icon icon-1' => 'Icon #2',
	 *     ),
	 *     'Set #2' => array(
	 *         'iset icon-1' => 'ISet icon #1',
	 *         'iset icon-2' => 'ISet icon #2',
	 *     ),
	 * )
	 * </pre>
	 *
	 * @return assoc
	 */
	public function get_at_icon_shortcode_icons() {
		return apply_filters( 'atdtp_get_at_icon_shortcode_icons', array() );
	}
}
