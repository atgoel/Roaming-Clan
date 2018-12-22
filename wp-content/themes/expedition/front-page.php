<?php
/**
 * The front-page template file.
 * @package Expedition
 */

get_header();
/**
 * expedition_action_front_page hook
 * @since Expedition 0.0.2
 *
 * @hooked expedition_action_front_page -  10
 * @sub_hooked expedition_action_front_page -  10
 */
do_action( 'expedition_action_front_page' );

get_footer();