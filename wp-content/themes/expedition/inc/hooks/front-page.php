<?php
/**
 * check if all sections of front page disable
 *
 * @since Expedition 0.0.2
 */
if ( ! function_exists( 'expedition_if_all_disable' ) ) :
    function expedition_if_all_disable() {
        global $expedition_customizer_all_values;
        if(
            1 != $expedition_customizer_all_values['expedition-feature-slider-enable'] &&
            1 != $expedition_customizer_all_values['expedition-home-popular-trip-section-enable'] &&
            1 != $expedition_customizer_all_values['expedition-home-about-enable'] &&
            1 != $expedition_customizer_all_values['expedition-home-testimonial-enable'] &&
            1 != $expedition_customizer_all_values['expedition-home-blog-enable'] &&
            1 != $expedition_customizer_all_values['expedition-home-map-enable']
        )
        {
            return 0;
        }
        else{
            return 1;
        }
    }
endif;
if ( ! function_exists( 'expedition_front_page' ) ) :
    /**
     * Before main content
     *
     * @since Expedition 0.0.2
     *
     * @param null
     * @return null
     *
     */
    function expedition_front_page() {
        if ( 'posts' == get_option( 'show_on_front' ) ) {
            include( get_home_template() );
        }
            elseif( 1 == expedition_if_all_disable()){
                /**
                 * homepage hook
                 * @since Expedition 0.0.2
                 *
                 * @hooked expedition_featured_slider -  10
                 * @hooked expedition_popular_trip -  20
                 * @hooked expedition_homepage_about_testimonial -  30
                 * @hooked expedition_home_blog -  40
                 * @hooked expedition_home_map -  50
                 */
                do_action('homepage');
            }
        else {
            include( get_home_template() );
        }

    }
endif;
add_action( 'expedition_action_front_page', 'expedition_front_page', 10 );