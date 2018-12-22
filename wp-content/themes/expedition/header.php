<?php
/**
 * The default template for displaying header
 *
 * @package eVision themes
 * @subpackage Expedition
 * @since Expedition 0.0.2
 */

/**
 * expedition_action_before_head hook
 * @since Expedition 0.0.2
 *
 * @hooked expedition_set_global -  0
 * @hooked expedition_doctype -  10
 */
do_action( 'expedition_action_before_head' );?>
<head>

	<?php
	/**
	 * expedition_action_before_wp_head hook
	 * @since Expedition 0.0.2
	 *
	 * @hooked expedition_before_wp_head -  10
	 */
	do_action( 'expedition_action_before_wp_head' );

	wp_head();

	/**
	 * expedition_action_after_wp_head hook
	 * @since Expedition 0.0.2
	 *
	 * @hooked null
	 */
	do_action( 'expedition_action_after_wp_head' );
	?>

</head>

<body <?php body_class(); ?>>

<?php
/**
 * expedition_action_before hook
 * @since Expedition 0.0.2
 *
 * @hooked expedition_page_start - 15
 */
do_action( 'expedition_action_before' );

/**
 * expedition_action_before_header hook
 * @since Expedition 0.0.2
 *
 * @hooked expedition_skip_to_content - 10
 */
do_action( 'expedition_action_before_header' );

/**
 * expedition_action_top_header hook
 * @since Expedition 0.0.2
 *
 * @hooked expedition_action_top_header - 10
 */
do_action( 'expedition_action_top_header' );

/**
 * expedition_action_header hook
 * @since Expedition 0.0.2
 *
 * @hooked expedition_after_header - 10
 */
do_action( 'expedition_action_header' );

/**
 * expedition_action_before_content hook
 * @since Expedition 0.0.2
 *
 * @hooked null
 */
do_action( 'expedition_action_before_content' );
?>
