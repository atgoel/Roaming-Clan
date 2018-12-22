<?php
/**
 * Implement Editor Styles
 *
 * @since Expedition 0.0.2
 *
 * @param null
 * @return null
 *
 */
add_action( 'init', 'expedition_add_editor_styles' );

if ( ! function_exists( 'expedition_add_editor_styles' ) ) :
    function expedition_add_editor_styles() {
        add_editor_style( 'editor-style.css' );
    }
endif;