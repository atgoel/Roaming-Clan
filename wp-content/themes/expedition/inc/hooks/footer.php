<?php
if ( ! function_exists( 'expedition_before_footer' ) ) :
    /**
     * Footer content
     *
     * @since Expedition 0.0.2
     *
     * @param null
     * @return false | void
     *
     */
    function expedition_before_footer() {
    ?>
    </div>
    </div><!-- #content -->
    <?php
    }
endif;
add_action( 'expedition_action_before_footer', 'expedition_before_footer', 10 );

if ( ! function_exists( 'expedition_footer' ) ) :
    /**
     * Footer content
     *
     * @since Expedition 0.0.2
     *
     * @param null
     * @return null
     *
     */
    function expedition_footer() {
        global $expedition_customizer_all_values;
        ?>
        <!-- *****************************************
             Footer section starts
    ****************************************** -->
        <footer id="colophon" class="wrapper site-footer" role="contentinfo">
                <div class="container copyright">
                    <?php
                    if(isset($expedition_customizer_all_values['expedition-copyright-text'])){
                        echo wp_kses_post( $expedition_customizer_all_values['expedition-copyright-text'] );
                    }
                    ?>
                </div>
                 <!--<div class="site-info">
                    <a href="<?php echo esc_url( 'https://wordpress.org'); ?>" target = "_blank"><?php printf( esc_html__( 'Proudly powered by %s', 'expedition' ), 'WordPress' ); ?></a>
                    <span class="sep"> | </span>
                    <?php printf( esc_html__( 'Theme: %1$s by %2$s', 'expedition' ), 'Expedition', '<a href="http://evisionthemes.com/" target = "_blank" rel="designer">eVisionThemes </a>' ); ?>
                </div><!-- .site-info -->-->
            </footer><!-- #colophon -->
        <!-- *****************************************
                 Footer section ends
        ****************************************** -->
    <?php
    }
endif;
add_action( 'expedition_action_footer', 'expedition_footer', 10 );

if ( ! function_exists( 'expedition_page_end' ) ) :
    /**
     * Page end
     *
     * @since Expedition 0.0.2
     *
     * @param null
     * @return null
     *
     */
    function expedition_page_end() {
    global $expedition_customizer_all_values;
        ?>
        </div><!-- #page -->
    <?php
     if( isset( $expedition_customizer_all_values['expedition-enable-back-to-top'] )  && 1 == $expedition_customizer_all_values['expedition-enable-back-to-top']) {
        ?>
            <a class="evision-back-to-top" href="#page"><i class="fa fa-angle-up"></i></a>
        <?php
        }
    }
endif;
add_action( 'expedition_action_after', 'expedition_page_end', 10 );