<?php

if ( ! function_exists( 'expedition_home_about' ) ) :
    /**
     * About Section
     *
     * @since Expedition 0.0.2
     *
     * @param null
     * @return null
     *
     */
    function expedition_home_about() {
        global $expedition_home_about_bg;
        global $expedition_customizer_all_values;
        $repeated_page = array('expedition-about-pages-ids');
        $expedition_home_about_single_words = absint( $expedition_customizer_all_values['expedition-home-about-single-words'] );
        $expedition_home_about_posts = evision_customizer_get_repeated_all_value(1 , $repeated_page);
        $expedition_home_about_posts_ids = array();
        foreach ($expedition_home_about_posts as $expedition_home_about_post) {
            if (0 != $expedition_home_about_post['expedition-about-pages-ids']) {
                $expedition_home_about_posts_ids[] = $expedition_home_about_post['expedition-about-pages-ids'];
            }
        }
        if( !empty( $expedition_home_about_posts_ids )){
            $expedition_home_about_args = array(
                'post_type' => 'page',
                'post__in' => $expedition_home_about_posts_ids,
                'orderby' => 'post__in'
            );
        }
        if( (1 == $expedition_customizer_all_values['expedition-home-about-enable']) && (1 != $expedition_customizer_all_values['expedition-home-testimonial-enable']) ){
            $about_class="column-md-12";
        }
        else{
            $about_class="column-md-6";
        }
        if( 1 == $expedition_customizer_all_values['expedition-home-about-enable'] ){?>
            <div class="<?php echo esc_attr($about_class); ?> about-section evision-animate slideInLeft">
                <?php 
                if (!empty($expedition_home_about_args)) {
                    $home_about_query = new WP_Query($expedition_home_about_args);
                    while ($home_about_query->have_posts()): $home_about_query->the_post();?>
                        <header class="title-section">
                            <h2><?php the_title(); ?></h2>
                        </header>
                        <div class="herotext">
                            <?php 
                            $expedition_home_about_content_word_count = expedition_words_count( $expedition_home_about_single_words ,get_the_content());;?>
                            <p><?php echo wp_kses_post( $expedition_home_about_content_word_count );?></p>
                        </div>
                        <?php
                        $expedition_home_about_button_text = $expedition_customizer_all_values['expedition-home-about-button-text'];
                        if( !empty( $expedition_home_about_button_text ) ){
                            ?>
                            <div class="btn-container">
                                <a class="line-btn" href="<?php the_permalink();?>">
                                    <?php echo esc_html( $expedition_home_about_button_text );?>
                                </a>
                            </div>
                            <?php
                        }
                    endwhile;
                } 
                else { ?>
                    <header class="title-section">
                        <h2><?php echo __('About Us','expedition'); ?></h2>
                        <div class="herotext">
                            <p><?php echo __('Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry when an unknown to make a type specimen book.','expedition'); ?></p>
                        </div>
                        <div class="btn-container">
                            <a class="line-btn" href="#">
                               <?php echo __('Know More','expedition');;?>
                            </a>
                        </div>
                    </header>
                <?php }
                ?>

            </div>
        <?php
        }
    }
endif;
add_action( 'homepage-about-testimonial', 'expedition_home_about', 10 );

