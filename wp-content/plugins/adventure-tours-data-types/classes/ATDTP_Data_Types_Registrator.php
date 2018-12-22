<?php
/**
 * Registers custom post types and taxonomies.
 *
 * @author    Themedelight
 * @package   Themedelight/ATDTP
 * @version   2.1.4
 */

class ATDTP_Data_Types_Registrator
{
	/**
	 * Determines post type used for tour items.
	 *
	 * @see register_tour_category
	 * @var string
	 */
	private $tour_post_type = 'product';

	/**
	 * Internal flag that determines if plugin has been inited.
	 *
	 * @var boolean
	 */
	private $inited = false;

	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'init' ) );
	}

	/**
	 * Callback for init event.
	 *
	 * @return void
	 */
	public function init() {
		if ( $this->inited ) {
			return;
		}
		$this->inited = true;

		$this->register_tour_category();
		$this->register_media_categories();
		$this->register_faq();
		$this->register_at_header_section();
	}

	/**
	 * Registers 'tour_category' taxonomy tour post type.
	 *
	 * @return void
	 */
	protected function register_tour_category() {
		register_taxonomy( 'tour_category', $this->tour_post_type, array(
			'label' => esc_html__( 'Tour Categories', 'adventure-tours-data-types' ),
			'singular_name' => esc_html__( 'Tour Category', 'adventure-tours-data-types' ),
			'hierarchical' => true,
			'capabilities' => array(
				'manage_terms' => 'manage_product_terms',
				'edit_terms'   => 'edit_product_terms',
				'delete_terms' => 'delete_product_terms',
				'assign_terms' => 'assign_product_terms',
			),
			'rewrite' => array(
				'slug' => defined( 'ATDTP_TOUR_CATEGORY_SLUG' ) ? ATDTP_TOUR_CATEGORY_SLUG : 'tour-category',
				'with_front' => defined( 'ATDTP_TOUR_CATEGORY_SLUG_WITH_FRONT' ) ? ATDTP_TOUR_CATEGORY_SLUG_WITH_FRONT : true,
			),
			'show_in_nav_menus' => true,
		) );
	}

	/**
	 * Registers 'madia_category' taxonomy for attachments.
	 *
	 * @return void
	 */
	protected function register_media_categories() {
		register_taxonomy( 'media_category', 'attachment', array(
			'labels' => array(
				'name' => esc_html__( 'Media Categories', 'adventure-tours-data-types' ),
				'singular_name' => esc_html__( 'Media Category', 'adventure-tours-data-types' ),
			),
			'hierarchical' => true,
			'show_admin_column' => true,
			'query_var' => false,
		) );
	}

	/**
	 * Registers 'faq' custom post type and 'faq_category' taxonomy.
	 *
	 * @return void
	 */
	protected function register_faq() {
		register_post_type( 'faq', array(
			'label' => esc_html__( 'FAQs', 'adventure-tours-data-types' ),
			'labels' => array(
				'add_new' => esc_html__( 'Add New Question', 'adventure-tours-data-types' ),
				'edit_item' => esc_html__( 'Edit Question', 'adventure-tours-data-types' ),
			),
			'exclude_from_search' => true,
			'publicly_queryable' => true,
			'public' => true,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'has_archive' => false,
			'menu_icon' => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/ico-faq.png',
			'menu_position' => 9,
			'rewrite' => array(
				'slug' => 'faq',
				'with_front' => false,
			),
			'supports' => array(
				'title',
				'editor',
				'page-attributes',
			),
		));

		register_taxonomy( 'faq_category', 'faq', array(
			'hierarchical' => true,
			'label' => esc_html__( 'FAQ Categories', 'adventure-tours-data-types' ),
			'singular_name' => esc_html__( 'FAQ Category', 'adventure-tours-data-types' ),
			'rewrite' => true,
			'query_var' => true,
			'show_in_nav_menus' => true,
		));
	}

	protected function register_at_header_section() {
		register_post_type( 'at_header_section', array(
			'label' => esc_html__( 'Header Sections', 'adventure-tours-data-types' ),
			'labels' => array(
				'add_new' => esc_html__( 'Add New Section', 'adventure-tours-data-types' ),
				'edit_item' => esc_html__( 'Edit Section', 'adventure-tours-data-types' ),
			),
			'public' => false,
			'exclude_from_search' => true,
			'publicly_queryable' => false,
			'has_archive' => false,
			'query_var' => false,
			'rewrite' => false,
			'show_ui' => true,
			'show_in_nav_menus' => false,
			'menu_icon' => plugin_dir_url( dirname( __FILE__ ) ) . 'assets/images/ico-header-section.png',
			'menu_position' => 9,
			'supports' => array(
				'title',
			),
		));
	}
}
