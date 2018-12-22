<?php
if (!function_exists('expedition_home_testimonial_array')) :
    /**
     * Featured Slider array creation
     *
     * @since Expedition 0.0.2
     *
     * @param string $from_testimonial
     * @return array
     */
    function expedition_home_testimonial_array($from_testimonial){
        global $expedition_customizer_all_values;
        $expedition_home_testimonial_number = absint( $expedition_customizer_all_values['expedition-home-testimonial-number'] );
        $expedition_home_testimonial_single_words = absint( $expedition_customizer_all_values['expedition-home-testimonial-single-words'] );

        $expedition_home_testimonial_contents_array = array();
        $expedition_home_testimonial_contents_array[0]['expedition-home-testimonial-title'] = __('Sayer Name','expedition');
        $expedition_home_testimonial_contents_array[0]['expedition-home-testimonial-content'] = __("The set doesn't moved. Deep don't fru it fowl gathering heaven days moving creeping under from i air. Set it fifth Meat was darkness. every bring in it.",'expedition');
        $expedition_home_testimonial_contents_array[0]['expedition-home-testimonial-image'] = get_template_directory_uri()."/assets/img/profile.jpg";
        $expedition_home_testimonial_contents_array[0]['expedition-home-testimonial-link'] = '#';
        $repeated_page = array('expedition-home-testimonial-pages-ids');

        if ('from-category' == $from_testimonial) {
            $expedition_home_testimonial_category = $expedition_customizer_all_values['expedition-home-testimonial-category'];
            if( 0 != $expedition_home_testimonial_category ){
                $expedition_home_testimonial_args = array(
                    'post_type' => 'post',
                    'cat' => $expedition_home_testimonial_category
                );
            }

        }
        else {
            $expedition_home_testimonial_posts = evision_customizer_get_repeated_all_value(6 , $repeated_page);
            $expedition_home_testimonial_posts_ids = array();
            if (null != $expedition_home_testimonial_posts) {
                foreach ($expedition_home_testimonial_posts as $expedition_home_testimonial_post) {
                    if (0 != $expedition_home_testimonial_post['expedition-home-testimonial-pages-ids']) {
                        $expedition_home_testimonial_posts_ids[] = $expedition_home_testimonial_post['expedition-home-testimonial-pages-ids'];
                    }
                }
                if( !empty( $expedition_home_testimonial_posts_ids )){
                    $expedition_home_testimonial_args = array(
                        'post_type' => 'page',
                        'post__in' => $expedition_home_testimonial_posts_ids,
                        'posts_per_page' => $expedition_home_testimonial_number,
                        'orderby' => 'post__in'
                    );
                }
            }
        }
        // the query
        if( !empty( $expedition_home_testimonial_args )){
            $expedition_home_testimonial_contents_array = array();
            $expedition_home_testimonial_post_query = new WP_Query($expedition_home_testimonial_args);
            if ($expedition_home_testimonial_post_query->have_posts()) :
                $i = 0;
                while ($expedition_home_testimonial_post_query->have_posts()) : $expedition_home_testimonial_post_query->the_post();
                    $thumb_image ='';
                    if(has_post_thumbnail()){
                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'thumbnail' );
                        $thumb_image = $thumb['0'];
                    }

                    $expedition_home_testimonial_contents_array[$i]['expedition-home-testimonial-title'] = get_the_title();
                    $expedition_home_testimonial_contents_array[$i]['expedition-home-testimonial-content'] = expedition_words_count( $expedition_home_testimonial_single_words ,get_the_content());
                    $expedition_home_testimonial_contents_array[$i]['expedition-home-testimonial-image'] = $thumb_image;
                    $expedition_home_testimonial_contents_array[$i]['expedition-home-testimonial-link'] = get_permalink();
                    $i++;
                endwhile;
                wp_reset_postdata();
            endif;
        }
        return $expedition_home_testimonial_contents_array;
    }
endif;

if ( ! function_exists( 'expedition_home_testimonial' ) ) :
    /**
     * About Section
     *
     * @since Expedition 0.0.2
     *
     * @param null
     * @return null
     *
     */
    function expedition_home_testimonial() {
        global $expedition_customizer_all_values;
        if( (1 == $expedition_customizer_all_values['expedition-home-testimonial-enable']) && (1 != $expedition_customizer_all_values['expedition-home-about-enable'])){
            $about_class="column-md-12";
        }
        else{
            $about_class="column-md-6";
        }
        $expedition_home_testimonial_selection_options = $expedition_customizer_all_values['expedition-home-testimonial-selection'];
        $expedition_testimonial_arrays = expedition_home_testimonial_array($expedition_home_testimonial_selection_options);
        if(1 == $expedition_customizer_all_values['expedition-home-testimonial-enable']) {
            if (is_array($expedition_testimonial_arrays)) {
                $expedition_home_testimonial_title = $expedition_customizer_all_values['expedition-home-testimonial-main-title'];
                $expedition_home_testimonial_number = absint( $expedition_customizer_all_values['expedition-home-testimonial-number'] );
                $expedition_home_testimonial_slider_mode = $expedition_customizer_all_values['expedition-home-testimonial-slider-mode'];
                $expedition_home_testimonial_slider_time = $expedition_customizer_all_values['expedition-home-testimonial-slider-time'];
                $expedition_home_testimonial_slider_pause_time = $expedition_customizer_all_values['expedition-home-testimonial-slider-pause-time'];
                $expedition_home_testimonial_slider_enable_control = $expedition_customizer_all_values['expedition-home-testimonial-enable-control'];
                $expedition_home_testimonial_enable_autoplay = $expedition_customizer_all_values['expedition-home-testimonial-enable-autoplay'];
                ?>
                <div class="<?php echo esc_attr($about_class); ?> testimonial-section evision-animate slideInRight">
                    <header class="title-section">
                        <h2><?php echo esc_html(  $expedition_home_testimonial_title); ?></h2>
                    </header>

                    <section class="wrapper wrapper-slider testimonial-slider evision-animate slideInRight">
                          <?php if( 1 == $expedition_home_testimonial_slider_enable_control){ ?>
                        <?php }  ?>
                        <div class="container-full">
                            <div class="cycle-slideshow"
                            data-cycle-swipe=true
                            data-cycle-swipe-fx=scrollHorz
                            data-cycle-manual-fx=<?php echo esc_attr( $expedition_home_testimonial_slider_mode);?>
                            data-cycle-manual-speed="<?php echo (esc_attr( $expedition_home_testimonial_slider_time) * 1000)?>"
                            data-cycle-carousel-fluid=true
                            data-cycle-carousel-visible=1
                            data-cycle-pause-on-hover="true"
                            data-cycle-slides="> div"
                            data-cycle-prev="#slide-prev-sub"
                            data-cycle-next="#slide-next-sub"
                            data-cycle-auto-height=container
                            <?php if( 1 == $expedition_home_testimonial_slider_enable_control){ ?>
                                data-cycle-pager="#slide-pager-sub"
                            <?php }  ?>
                            <?php if( 1 != $expedition_home_testimonial_enable_autoplay){ ?>
                                data-cycle-timeout=0
                            <?php }  ?>
                            <?php if(1 == $expedition_home_testimonial_enable_autoplay){ ?>
                                data-cycle-timeout=<?php echo (esc_attr( $expedition_home_testimonial_slider_pause_time) * 1000)?>
                            <?php }  ?>
                            >
                                <?php
                                $i = 1;
                                foreach( $expedition_testimonial_arrays as $expedition_testimonial_array ){
                                    if( $expedition_home_testimonial_number < $i){
                                        break;
                                    }
                                    if(empty($expedition_testimonial_array['expedition-feature-slider-image'])){
                                        $expedition_feature_testimonial_slider_image = get_template_directory_uri().'/assets/img/no-image.jpg';
                                    }
                                    else{
                                        $expedition_feature_testimonial_slider_image =$expedition_testimonial_array['expedition-feature-slider-image'];
                                    }
                                    ?>
                                    <div class="slide-item">
                                        <div class="container-full">
                                              <div class="banner-content">
                                                <div class="banner-content-holder">
                                                    <div class="thumb-holder">
                                                        <a href="<?php echo esc_url($expedition_testimonial_array['expedition-home-testimonial-link']);?>">
                                                            <img src="<?php echo esc_url( $expedition_testimonial_array['expedition-home-testimonial-image'] )?>" />
                                                        </a>
                                                    </div>
                                                    <div class="banner-content-inner">
                                                        <div class="text-content">
                                                          <?php echo wp_kses_post( $expedition_testimonial_array['expedition-home-testimonial-content'] ); ?>
                                                        </div>
                                                        <h3 class="slider-title"><a href="<?php echo esc_url($expedition_testimonial_array['expedition-home-testimonial-link']);?>"><?php echo esc_html( $expedition_testimonial_array['expedition-home-testimonial-title'] ); ?></a></h3>
                                                    </div>
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
                        <div class="cycle-pager slide-pager" id="slide-pager-sub"></div>
                    </section>
                </div>
            <?php
            }
        }
    }
endif;
add_action( 'homepage-about-testimonial', 'expedition_home_testimonial', 20 );