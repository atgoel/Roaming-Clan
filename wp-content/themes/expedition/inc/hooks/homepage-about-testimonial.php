<?php

if ( ! function_exists( 'expedition_home_about_testimonial' ) ) :
    /**
     * About and Testimonial Section
     *
     * @since Expedition 0.0.2
     *
     * @param null
     * @return null
     *
     */
    function expedition_home_about_testimonial() {
    global $expedition_customizer_all_values;
        if( (1 != $expedition_customizer_all_values['expedition-home-about-enable']) && (1 != $expedition_customizer_all_values['expedition-home-testimonial-enable']) ){
            return null;
        }

        else{
        ?>
            <section class="wrapper wrap-info">
                <?php
                if( (1 != $expedition_customizer_all_values['expedition-home-testimonial-enable']) ){
                    $about_div = __('about-only','expedition');
                }
                elseif ((1 != $expedition_customizer_all_values['expedition-home-about-enable'])) {
                    $about_div = __('testimonial-only','expedition');
                }
                else{
                    $about_div= '';
                }?>
                <div class="thumb-overlay"></div>
                <div class="sub-wrapper <?php echo $about_div; ?>">
                    <div class="container">
                        <div class="row">
                            <?php 
                                /**
                                 * homepage about and testimonial section hook
                                 * @since expedition 0.0.2
                                 *
                                 * @hooked expedition_homepage_about -  10
                                 * @hooked expedition_homepage_testimonial -  20
                                 */
                                do_action('homepage-about-testimonial');
                            ?>
                        </div>
                    </div>
                </div>
            </section>
        <?php
        }
    }
endif;
add_action( 'homepage', 'expedition_home_about_testimonial', 30 );