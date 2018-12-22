<?php
if ( ! function_exists( 'expedition_featured_slider_array' ) ) :
    /**
     * Featured Slider array creation
     *
     * @since Expedition 0.0.2
     *
     * @param string $from_slider
     * @return array
     */
    function expedition_featured_slider_array( $from_slider ){
        global $expedition_customizer_all_values;
        $expedition_feature_slider_number = absint( $expedition_customizer_all_values['expedition-featured-slider-number'] );
        $expedition_feature_slider_single_words = absint( $expedition_customizer_all_values['expedition-fs-single-words'] );
        $expedition_feature_slider_contents_array[0]['expedition-feature-slider-title'] = __('Explore Your Trip','expedition');
        $expedition_feature_slider_contents_array[0]['expedition-feature-slider-content'] = __("Let's go wherever you want!",'expedition');
        $expedition_feature_slider_contents_array[0]['expedition-feature-slider-link'] = '#';
        $expedition_feature_slider_contents_array[0]['expedition-feature-slider-image'] = get_template_directory_uri()."/assets/img/slider.jpg";
        $repeated_page = array('expedition-fs-pages-ids');
        $expedition_feature_slider_args = array();

        if ( 'from-category' ==  $from_slider ){
            $expedition_feature_slider_category = $expedition_customizer_all_values['expedition-featured-slider-category'];
            if( 0 != $expedition_feature_slider_category ){
                $expedition_feature_slider_args =    array(
                    'post_type' => 'post',
                    'cat' => $expedition_feature_slider_category,
                    'ignore_sticky_posts' => true
                );
            }
        }
        else{
            $expedition_feature_slider_posts = evision_customizer_get_repeated_all_value(6 , $repeated_page);
            $expedition_feature_slider_posts_ids = array();
            if( null != $expedition_feature_slider_posts ) {
                foreach( $expedition_feature_slider_posts as $expedition_feature_slider_post ) {
                    if( 0 != $expedition_feature_slider_post['expedition-fs-pages-ids'] ){
                        $expedition_feature_section_posts_ids[] = $expedition_feature_slider_post['expedition-fs-pages-ids'];
                    }
                }

                if( !empty( $expedition_feature_section_posts_ids )){
                    $expedition_feature_slider_args =    array(
                        'post_type' => 'page',
                        'post__in' => $expedition_feature_section_posts_ids,
                        'posts_per_page' => $expedition_feature_slider_number,
                        'orderby' => 'post__in'
                    );
                }

            }
        }
        if( !empty( $expedition_feature_slider_args )){
            // the query
            $expedition_fature_section_post_query = new WP_Query( $expedition_feature_slider_args );

            if ( $expedition_fature_section_post_query->have_posts() ) :
                $i = 0;
                while ( $expedition_fature_section_post_query->have_posts() ) : $expedition_fature_section_post_query->the_post();
                    $url ='';
                    if(has_post_thumbnail()){
                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'expedition-main-banner' );
                        $url = $thumb['0'];
                    }
                    $expedition_feature_slider_contents_array[$i]['expedition-feature-slider-title'] = get_the_title();
                    $expedition_feature_slider_contents_array[$i]['expedition-feature-slider-content'] = expedition_words_count( $expedition_feature_slider_single_words ,get_the_content());;
                    $expedition_feature_slider_contents_array[$i]['expedition-feature-slider-link'] = get_permalink();
                    $expedition_feature_slider_contents_array[$i]['expedition-feature-slider-image'] = $url;
                    $i++;
                endwhile;
                wp_reset_postdata();
            endif;
        }
        return $expedition_feature_slider_contents_array;
    }
endif;

if ( ! function_exists( 'expedition_featured_home_slider' ) ) :
    /**
     * Featured Slider
     *
     * @since expedition 0.0.2
     *
     * @param null
     * @return null
     *
     */
    function expedition_featured_home_slider() { 
        global $expedition_customizer_all_values;

        if( 1 != $expedition_customizer_all_values['expedition-feature-slider-enable'] ){
            return null;
        }
        $expedition_feature_slider_selection_options = $expedition_customizer_all_values['expedition-featured-slider-selection'];
        $expedition_slider_arrays = expedition_featured_slider_array( $expedition_feature_slider_selection_options );


        if( is_array( $expedition_slider_arrays )){
        $expedition_feature_slider_number = absint( $expedition_customizer_all_values['expedition-featured-slider-number'] );
        $expedition_feature_slider_mode = $expedition_customizer_all_values['expedition-fs-slider-mode'];
        $expedition_feature_slider_time = $expedition_customizer_all_values['expedition-fs-slider-time'];
        $expedition_feature_slider_pause_time = $expedition_customizer_all_values['expedition-fs-slider-pause-time'];
        $expedition_feature_enable_arrow = $expedition_customizer_all_values['expedition-fs-enable-arrow'];
        $expedition_feature_enable_pager = $expedition_customizer_all_values['expedition-fs-enable-pager'];
        $expedition_feature_enable_autoplay = $expedition_customizer_all_values['expedition-fs-enable-autoplay'];
        $expedition_feature_enable_title = $expedition_customizer_all_values['expedition-fs-enable-title'];
        $expedition_feature_enable_caption = $expedition_customizer_all_values['expedition-fs-enable-caption'];
        $expedition_feature_enable_search = $expedition_customizer_all_values['expedition-search-enable'];
    ?>

    <section class="wrapper main-slider wrapper-slider">
        <?php if( 1 == $expedition_feature_enable_arrow){ ?>
            <div class="controls">
                <a href="#" class="slide-prev" id="slide-prev"><i class="fa fa-angle-left"></i></a> 
                <a href="#" class="slide-next" id="slide-next"><i class="fa fa-angle-right"></i></a>
            </div>
        <?php }  ?>

        <div class="container-full">
            <div class="cycle-slideshow"
            data-cycle-fx=<?php echo esc_attr( $expedition_feature_slider_mode);?>
            data-cycle-speed="<?php echo (esc_attr( $expedition_feature_slider_time) * 1000)?>"
            data-cycle-carousel-fluid=true
            data-cycle-carousel-visible=1
            data-cycle-pause-on-hover="true"
            data-cycle-slides="> div"
            data-cycle-prev="#slide-prev"
            data-cycle-next="#slide-next"
            data-cycle-auto-height=container
            data-cycle-swipe=true
            data-cycle-swipe-fx=scrollHorz
            <?php if( 1 == $expedition_feature_enable_pager){ ?>
                data-cycle-pager="#slide-pager"
            <?php }  ?>
            <?php if( 1 != $expedition_feature_enable_autoplay){ ?>
                data-cycle-timeout=0
            <?php }  ?>
            <?php if(1 == $expedition_feature_enable_autoplay){ ?>
                data-cycle-timeout=<?php echo (esc_attr( $expedition_feature_slider_pause_time) * 1000)?>
            <?php }  ?>
            >
                <?php
                $i = 1;
                foreach( $expedition_slider_arrays as $expedition_slider_array ){
                    if( $expedition_feature_slider_number < $i){
                        break;
                    }
                    if(empty($expedition_slider_array['expedition-feature-slider-image'])){
                        $expedition_feature_slider_image = get_template_directory_uri().'/assets/img/no-image-1260_530.png';
                    }
                    else{
                        $expedition_feature_slider_image =$expedition_slider_array['expedition-feature-slider-image'];
                    }
                    ?>
                    <div class="slide-item">
                        <div class="container-full" style="background-image: url('<?php echo esc_url( $expedition_feature_slider_image )?>');">
                            <div class="thumb-overlay"></div>
                            <div class="row">
                                <div class="column-xsd-10 column-sd-10 column-md-6 column-xsd-offset-1 column-sd-offset-1 column-md-offset-3 banner-content">
                                    <?php if ((1 == $expedition_feature_enable_title) || (1 == $expedition_feature_enable_caption)){?>
                                        <div class="banner-content-holder">
                                            <div class="banner-content-inner">
                                                <?php if( 1 == $expedition_feature_enable_title) {
                                                    ?>
                                                        <h2 class="slider-title"><a href="<?php echo esc_url( $expedition_slider_array['expedition-feature-slider-link'] );?>"><?php echo esc_html( $expedition_slider_array['expedition-feature-slider-title'] );?></a></h2>
                                                    <?php
                                                }
                                                if( 1 == $expedition_feature_enable_caption){
                                                    ?>
                                                    <div class="text-content">
                                                        <?php echo wp_kses_post( $expedition_slider_array['expedition-feature-slider-content'] );?>
                                                    </div>
                                                    <?php
                                                }?>      
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                $i++;
                }
                ?>

            </div>
        </div>
        <div class="cycle-pager slide-pager" id="slide-pager"></div>
    </section>
    <?php if( 1 == $expedition_feature_enable_search){ ?>
        <section class="wrapper wrap-search">
            <div class="container">
                <div class="row">
                    <div class="column-xsd-12 column-sd-10 column-md-8 column-sd-offset-1 column-md-offset-2">
                        <div class="search-section">
                            <form role="search" method="get" id="searchform"
                                class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
                                <div class="search-input-holder">
                                    <label class="screen-reader-text" for="s"><?php __( 'Search for:', 'expedition' ); ?></label>
                                    <input class="search-field" type="text" placeholder="search for global & hit enter..." value="<?php echo get_search_query(); ?>" name="s" id="s" />
                                    <input class="search-submit" type="submit" name="search_by" value="all" hidden>
                                    <button class="catselect" type="submit" name="search_by" value="post"><?php echo esc_attr__( 'Search', 'expedition' ); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php }  ?>

    <?php
        }
    }
endif;
add_action( 'homepage', 'expedition_featured_home_slider', 10 );