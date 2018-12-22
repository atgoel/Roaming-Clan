<?php
if (!function_exists('expedition_home_popular_trip_array')) :
    /**
     * Popular Trips array creation
     *
     * @since Expedition 0.0.2
     *
     * @param string $from_popular_trips
     * @return array
     */
    function expedition_home_popular_trip_array($from_popular_trips){
        global $expedition_customizer_all_values;
        $expedition_popular_trip_number = absint( $expedition_customizer_all_values['expedition-home-popular-trip-number'] );

        $expedition_popular_trip_contents_array = array();
        $expedition_popular_trip_contents_array[0]['expedition-home-popular-trip-title'] = __('Popular Trip','expedition');
        $expedition_popular_trip_contents_array[0]['expedition-home-popular-trip-image'] = get_template_directory_uri()."/assets/img/no-image-270-370.png";
        $expedition_popular_trip_contents_array[0]['expedition-home-most-popular-trip-image'] = get_template_directory_uri()."/assets/img/sayer.jpg";
        $expedition_popular_trip_contents_array[0]['expedition-popular-trip-link'] = '#';
        $repeated_page = array('expedition-home-popular-trip-pages-ids');

        if ('from-category' == $from_popular_trips) {
            $expedition_popular_trip_category = $expedition_customizer_all_values['expedition-home-popular-trip-category'];
            if( 0 != $expedition_popular_trip_category ){
                $expedition_popular_trip_args = array(
                    'cat' => $expedition_popular_trip_category,
                    'post_type' => 'post',
                    'meta_key' => 'wpb_post_views_count', 
                    'orderby' => 'meta_value_num', 
                    'order' => 'DESC'
                );
            }

        }
        else {
            $expedition_popular_trip_posts = evision_customizer_get_repeated_all_value(6 , $repeated_page);
            $expedition_popular_trip_posts_ids = array();
            if (null != $expedition_popular_trip_posts) {
                foreach ($expedition_popular_trip_posts as $expedition_popular_trip_post) {
                    if (0 != $expedition_popular_trip_post['expedition-home-popular-trip-pages-ids']) {
                        $expedition_popular_trip_posts_ids[] = $expedition_popular_trip_post['expedition-home-popular-trip-pages-ids'];
                    }
                }
                if( !empty( $expedition_popular_trip_posts_ids )){
                    $expedition_popular_trip_args = array(
                        'post_type' => 'page',
                        'post__in' => $expedition_popular_trip_posts_ids,
                        'posts_per_page' => $expedition_popular_trip_number,
                        'orderby' => 'post__in'
                    );
                }
            }
        }
        // the query
        if( !empty( $expedition_popular_trip_args )){
            $expedition_popular_trip_contents_array = array();
            $expedition_popular_trip_post_query = new WP_Query($expedition_popular_trip_args);
            if ($expedition_popular_trip_post_query->have_posts()) :
                $i = 0;
                while ($expedition_popular_trip_post_query->have_posts()) : $expedition_popular_trip_post_query->the_post();
                    $thumb_image ='';
                    $thumb_popular_image = '';
                    if(has_post_thumbnail()){
                        $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'expedition-costume-medium' );
                        $thumb_image = $thumb['0'];
                        
                        $popular = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'expedition-costume-small' );
                        $thumb_popular_image = $popular['0'];
                    }
                    $expedition_popular_trip_contents_array[$i]['expedition-home-popular-trip-title'] = get_the_title();
                    $expedition_popular_trip_contents_array[$i]['expedition-popular-trip-link'] = get_permalink();
                    $expedition_popular_trip_contents_array[$i]['expedition-home-popular-trip-image'] = $thumb_image;
                    $expedition_popular_trip_contents_array[$i]['expedition-home-most-popular-trip-image'] = $thumb_popular_image;
                    $i++;
                endwhile;
                wp_reset_postdata();
            endif;
        }
        return $expedition_popular_trip_contents_array;
    }
endif;

if ( ! function_exists( 'expedition_popular_trip' ) ) :
    /**
     * About Section
     *
     * @since Expedition 0.0.2
     *
     * @param null
     * @return null
     *
     */
    function expedition_popular_trip() {
        global $expedition_customizer_all_values;
        $expedition_popular_trip_title = $expedition_customizer_all_values['expedition-home-popular-trip-main-title'];
        $expedition_popular_trip_sub_title = $expedition_customizer_all_values['expedition-home-popular-trip-sub-title'];
        $expedition_popular_trip_button_text = $expedition_customizer_all_values['expedition-home-popular-trip-button-text'];

        $expedition_popular_trip_selection_options = $expedition_customizer_all_values['expedition-home-popular-trip-selection'];
        $expedition_popular_trip_arrays = expedition_home_popular_trip_array($expedition_popular_trip_selection_options);
        if(1 == $expedition_customizer_all_values['expedition-home-popular-trip-section-enable']) {
            if (is_array($expedition_popular_trip_arrays)) {
                $expedition_popular_trip_number = absint( $expedition_customizer_all_values['expedition-home-popular-trip-number'] );?>
                <!-- start of popular trip section -->
                <section class="wrapper wrap-poptrip overhidden">
                    <div class="container">
                        <div class="row">
                            <div class="column-md-12">
                                <header class="title-section evision-animate slideInDown" data-wow-delay="0s">
                                    <h3><?php echo esc_html(  $expedition_popular_trip_sub_title); ?></h3>
                                    <h2><?php echo esc_html(  $expedition_popular_trip_title); ?></h2>
                                    <span class="title-divider"></span>
                                </header>
                            </div>
                        </div>
                        <div class="row">
                            <?php
                            $i = 0;
                            $count=1;
                            foreach( $expedition_popular_trip_arrays as $expedition_popular_trip_array ){
                                if (($expedition_popular_trip_number-1) < $i) {
                                    break;
                                }
                            ?>
                                <div class="column-md-3 column-sd-12 column-xsd-12 overhidden">
                                    <div class="block-section small-post evision-animate slideInDown" data-wow-delay="0.5s">
                                        <div class="block-container clearblock">
                                            <div class="thumb-overlay"></div>
                                            <div class="thumb-holder">
                                                <?php 
                                                    if(empty($expedition_popular_trip_array['expedition-home-popular-trip-image'])){
                                                        $expedition_popular_post_thumb_image = get_template_directory_uri().'/assets/img/no-image.jpg';
                                                    }
                                                    else{
                                                        $expedition_popular_post_thumb_image =$expedition_popular_trip_array['expedition-home-popular-trip-image'];
                                                    }
                                                ?>
                                                <img src="<?php echo esc_url($expedition_popular_post_thumb_image)?>">
                                            </div>
                                            <div class="block-overlay-content">
                                                <div class="vmiddle-holder">
                                                    <div class="vmiddle">
                                                        <h2 class="block-post-title"><a href="<?php echo esc_html($expedition_popular_trip_array['expedition-popular-trip-link']);?>"><?php echo esc_html( $expedition_popular_trip_array['expedition-home-popular-trip-title'] ); ?></a></h2>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="block-overlay-content block-overlay-hover">
                                                <div class="vmiddle-holder">
                                                    <div class="vmiddle">
                                                        <a class="line-btn" href="<?php echo esc_html($expedition_popular_trip_array['expedition-popular-trip-link']);?>" title="popular trip">
                                                            <?php echo esc_html( $expedition_popular_trip_button_text );?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php
                            if ($count%4==0) {
                                echo "<div class='clearblock'></div>";
                            }

                            $i++;
                            $count++;
                            }
                            ?>
                        </div>
                    </div>
                </section>
            <?php
            }
        }
    }
endif;
add_action( 'homepage', 'expedition_popular_trip', 20 );