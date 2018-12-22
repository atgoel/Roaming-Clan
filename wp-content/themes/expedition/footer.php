<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 *
 * @package eVision themes
 * @subpackage Expedition
 * @since Expedition 0.0.2
 */


/**
 * expedition_action_after_content hook
 * @since Expedition 0.0.2
 *
 * @hooked null
 */
do_action( 'expedition_action_after_content' );

/**
 * expedition_action_before_footer hook
 * @since Expedition 0.0.2
 *
 * @hooked expedition_before_footer - 10
 */
do_action( 'expedition_action_before_footer' );

/**
 * expedition_action_footer hook
 * @since Expedition 0.0.2
 *
 * @hooked expedition_footer - 10
 */
do_action( 'expedition_action_footer' );

/**
 * expedition_action_after_footer hook
 * @since Expedition 0.0.2
 *
 * @hooked null
 */
do_action( 'expedition_action_after_footer' );

/**
 * expedition_action_after hook
 * @since Expedition 0.0.2
 *
 * @hooked expedition_page_end - 10
 */
do_action( 'expedition_action_after' );
?>
<?php wp_footer(); ?>
</body>
</html>