<?php
if( ! function_exists( 'expedition_excerpt_length' ) ) :

    /**
     * Excerpt length
     *
     * @since  Amazing Blog 0.0.2
     *
     * @param null
     * @return int
     */
    function expedition_excerpt_length( $length ){
        global $expedition_customizer_all_values;
        $excerpt_length = $expedition_customizer_all_values['expedition-number-of-words'];
        if ( empty( $excerpt_length) ) {
            $excerpt_length = $length;
        }
        return esc_attr( $excerpt_length );

    }

endif;
add_filter( 'excerpt_length', 'expedition_excerpt_length', 999 );