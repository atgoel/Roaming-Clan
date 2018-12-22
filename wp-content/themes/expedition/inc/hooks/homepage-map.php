<?php

if ( ! function_exists( 'expedition_home_map' ) ) :
    /**
     * Map Section
     *
     * @since Expedition 0.0.2
     *
     * @param null
     * @return null
     *
     */
    function expedition_home_map() {
    global $expedition_customizer_all_values;
    $expedition_map_iframe = $expedition_customizer_all_values['expedition-home-map-detail'];

        if( 1 != $expedition_customizer_all_values['expedition-home-map-enable'] ){
            return null;
        }
        ?>
        <section class="wrapper wrap-gmap">
            <div class="btn-container">
                <span id="gmaptoggle">
                    <i class="fa fa-arrow-circle-down"></i>
                </span>
            </div>
            <div id="gmaptoggle-container">
                <?php echo $expedition_map_iframe; ?>
            </div>
        </section>
        <?php
    }
endif;
add_action( 'homepage', 'expedition_home_map', 50 );