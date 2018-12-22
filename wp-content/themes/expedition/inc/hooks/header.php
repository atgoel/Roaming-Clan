<?php
if ( ! function_exists( 'expedition_set_global' ) ) :
/**
 * Setting global values for all saved customizer values
 *
 * @since Expedition 0.0.2
 *
 * @param null
 * @return null
 *
 */
function expedition_set_global() {
    /*Getting saved values start*/
    $GLOBALS['expedition_customizer_all_values'] = expedition_get_all_options(1);
}
endif;
add_action( 'expedition_action_before_head', 'expedition_set_global', 0 );

if ( ! function_exists( 'expedition_doctype' ) ) :
/**
 * Doctype Declaration
 *
 * @since Expedition 0.0.2
 *
 * @param null
 * @return null
 *
 */
function expedition_doctype() {
    ?>
    <!DOCTYPE html>
    <html <?php language_attributes(); ?>>
<?php
}
endif;
add_action( 'expedition_action_before_head', 'expedition_doctype', 10 );

if ( ! function_exists( 'expedition_before_wp_head' ) ) :
/**
 * Before wp head codes
 *
 * @since Expedition 0.0.2
 *
 * @param null
 * @return null
 *
 */
function expedition_before_wp_head() {
    ?>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="profile" href="http://gmpg.org/xfn/11">
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<?php
}
endif;
add_action( 'expedition_action_before_wp_head', 'expedition_before_wp_head', 10 );

if( ! function_exists( 'expedition_default_layout' ) ) :
    /**
     * Expedition default layout function
     *
     * @since  Expedition 0.0.2
     *
     * @param int
     * @return string
     */
    function expedition_default_layout( $post_id = null ){

        global $expedition_customizer_all_values,$post;
        $expedition_default_layout = $expedition_customizer_all_values['expedition-default-layout'];
        if( is_home()){
            $post_id = get_option( 'page_for_posts' );
        }
        if( null == $post_id && isset ( $post->ID ) ){
            $post_id = $post->ID;
        }
        $expedition_default_layout_meta = get_post_meta( $post_id, 'expedition-default-layout', true );

        if( false != $expedition_default_layout_meta ) {
            $expedition_default_layout = $expedition_default_layout_meta;
        }
        return $expedition_default_layout;
    }
endif;

if ( ! function_exists( 'expedition_body_class' ) ) :
/**
 * add body class
 *
 * @since Expedition 0.0.2
 *
 * @param null
 * @return null
 *
 */
function expedition_body_class( $expedition_body_classes ) {
    if(!is_front_page() || ( is_front_page() && 1 != expedition_if_all_disable())){
        $expedition_default_layout = expedition_default_layout();
        if( !empty( $expedition_default_layout ) ){
            if( 'left-sidebar' == $expedition_default_layout ){
                $expedition_body_classes[] = 'evision-left-sidebar';
            }
            elseif( 'right-sidebar' == $expedition_default_layout ){
                $expedition_body_classes[] = 'evision-right-sidebar';
            }
            elseif( 'both-sidebar' == $expedition_default_layout ){
                $expedition_body_classes[] = 'evision-both-sidebar';
            }
            elseif( 'no-sidebar' == $expedition_default_layout ){
                $expedition_body_classes[] = 'evision-no-sidebar';
            }
            else{
                $expedition_body_classes[] = 'evision-right-sidebar';
            }
        }
        else{
            $expedition_body_classes[] = 'evision-right-sidebar';
        }
    }
    return $expedition_body_classes;

}
endif;
add_action( 'body_class', 'expedition_body_class', 10, 1);

if ( ! function_exists( 'expedition_before_page_start' ) ) :
/**
 * intro loader
 *
 * @since Expedition 0.0.2
 *
 * @param null
 * @return null
 *
 */
function expedition_before_page_start() {
    global $expedition_customizer_all_values;
    /*intro loader*/
}
endif;
add_action( 'expedition_action_before', 'expedition_before_page_start', 10 );

if ( ! function_exists( 'expedition_page_start' ) ) :
/**
 * page start
 *
 * @since Expedition 0.0.2
 *
 * @param null
 * @return null
 *
 */
function expedition_page_start() {
?>
    <div id="page" class="site">
<?php
}
endif;
add_action( 'expedition_action_before', 'expedition_page_start', 15 );

if ( ! function_exists( 'expedition_skip_to_content' ) ) :
/**
 * Skip to content
 *
 * @since Expedition 0.0.2
 *
 * @param null
 * @return null
 *
 */
function expedition_skip_to_content() {
    ?>
    <a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'expedition' ); ?></a>
<?php
}
endif;
add_action( 'expedition_action_before_header', 'expedition_skip_to_content', 10 );

if ( ! function_exists( 'expedition_top_header_section' ) ) :
/**
 * Top header section
 *
 * @since Expedition 0.0.2
 *
 * @param null
 * @return null
 *
 */
function expedition_top_header_section() {
    global $expedition_customizer_all_values;
    ?>
    <section class="wrapper top-header">
        <div class="container">
            <div class="top-header-inner">
                <div class="row">
                    <div class="column-md-7 column-sd-12 column-xsd-12 rtl-fright">                        
                    </div>
                    <div class="column-md-5 column-sd-12 column-xsd-12 rtl-fleft">
                        <?php
                        $expedition_show_social = $expedition_customizer_all_values['expedition-enable-social-icons'];
                        if( has_nav_menu( 'social' ) && 1 == $expedition_show_social ){
                            ?>
                            <div class="social-widget evision-social-section social-icon-only">
                                <?php
                                wp_nav_menu( array(
                                    'theme_location' => 'social',
                                    'container' => false
                                ) );
                                ?>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php
}
endif;
add_action( 'expedition_action_top_header', 'expedition_top_header_section', 10 );


if ( ! function_exists( 'expedition_header' ) ) :
/**
 * Main header
 *
 * @since Expedition 0.0.2
 *
 * @param null
 * @return null
 *
 */
function expedition_header() {
    global $expedition_customizer_all_values;
    global $wp_version; 
    ?>
        <header id="masthead" class="wrapper site-header" role="banner">
            <div class="container">
                <div class="row">
                    <div class="column-md-4 column-sd-12 column-xsd-12 rtl-fright">
                        <div class="site-branding">
                            <?php if (version_compare($wp_version, '4.4.2', '<=')) { ?>
                                <?php if ( is_front_page() && is_home() ){
                                    if ( isset($expedition_customizer_all_values['expedition-logo']) && !empty($expedition_customizer_all_values['expedition-logo'])) :
                                        if ( is_front_page() && is_home() ){
                                            echo '<h1 class="site-title">';
                                        }
                                        else{
                                            echo '<p class="site-title">';
                                        }
                                        ?>
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                            <img class="header-logo" src="<?php echo esc_url($expedition_customizer_all_values['expedition-logo']); ?>" alt="<?php bloginfo( 'name' )?>">
                                        </a>
                                        <?php if ( is_front_page() && is_home() ){
                                            echo '</h1>';
                                        }
                                        else{
                                            echo '</p>';
                                        }
                                    ?>
                                    <?php else :
                                        if ( is_front_page() && is_home() ){
                                            echo '<h1 class="site-title">';
                                        }
                                        else{
                                            echo '<p class="site-title">';
                                        }
                                        ?>
                                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
                                            <?php
                                            if ( 1 == $expedition_customizer_all_values['expedition-enable-title'] ) :
                                                bloginfo( 'name' );
                                            endif;
                                            ?>
                                        </a>
                                            <?php
                                            if ( 1 == $expedition_customizer_all_values['expedition-enable-tagline'] ) :
                                                echo '<p class="site-description">'. get_bloginfo('description' ).'</p>';
                                            endif;
                                            ?>
                                        <?php if ( is_front_page() && is_home() ){
                                            echo '</h1>';
                                        }
                                        else{
                                            echo '</p>';
                                        }
                                    endif; ?>
                                <?php }
                                } 
                            else { 
                                expedition_the_custom_logo(); ?>
                                <?php if ( is_front_page() && is_home() ) : ?>
                                    <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                                <?php else : ?>
                                    <p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
                                <?php endif;

                                $description = get_bloginfo( 'description', 'display' );
                                if ( $description || is_customize_preview() ) : ?>
                                    <h2 class="site-description"><?php echo $description; ?></h2>
                                <?php endif; 
                            } 
                        ?>
                        </div><!-- .site-branding -->
                    </div>
                    <div class="column-md-8 column-sd-12 column-xsd-12 rtl-fleft">
                        <a href="#site-navigation" id="hamburger"><span></span></a>
                        <nav id="site-navigation" class="main-navigation" role="navigation">
                            <?php wp_nav_menu( array( 
                            'theme_location' => 'primary',
                            'container' => false,
                            ) ); ?>
                        </nav> 
                    </div>
                </div>
            </div>
        </header><!-- #masthead -->
    <?php
}
endif;
add_action( 'expedition_action_header', 'expedition_header', 10 );


if( ! function_exists( 'expedition_add_breadcrumb' ) ) :

/**
 * Breadcrumb
 *
 * @since Expedition 0.0.2
 *
 * @param null
 * @return null
 *
 */
    function expedition_add_breadcrumb(){
        global $expedition_customizer_all_values;
        // Bail if Breadcrumb disabled
        $breadcrumb_enable_breadcrumb = $expedition_customizer_all_values['expedition-enable-breadcrumb' ];
        if ( 1 != $breadcrumb_enable_breadcrumb ) {
            return;
        }
        // Bail if Home Page
        if ( is_front_page() ) {
            return;
        }
        echo '<div id="breadcrumb" class="wrapper wrap-breadcrumb"><div class="container">';
         expedition_simple_breadcrumb();
        echo '</div><!-- .container --></div><!-- #breadcrumb -->';
        return;
    }
endif;
add_action( 'expedition_action_after_title', 'expedition_add_breadcrumb', 10 );