<?php


if ( ! function_exists( 'expedition_home_blog' ) ) :
    /**
     * blog Slider
     *
     * @since Expedition 0.0.2
     *
     * @param null
     * @return null
     *
     */
    function expedition_home_blog() {
        global $expedition_customizer_all_values;
        $expedition_numbers_of_words = absint( $expedition_customizer_all_values['expedition-number-of-words'] );

        $expedition_home_blog_title = $expedition_customizer_all_values['expedition-home-blog-title'];
        $expedition_home_blog_sub_title = $expedition_customizer_all_values['expedition-home-blog-sub-title'];
        $expedition_home_blog_number = $expedition_customizer_all_values['expedition-home-blog-number'];
        $expedition_home_blog_column = $expedition_customizer_all_values['expedition-home-blog-column'];
        $expedition_home_blog_button_text = $expedition_customizer_all_values['expedition-home-blog-button-text'];
        $expedition_home_blog_button_link = $expedition_customizer_all_values['expedition-home-blog-button-link'];
        if( 1 != $expedition_customizer_all_values['expedition-home-blog-enable'] ){
            return null;
        }
        ?>

        <section class="wrapper wrap-latestpost">
            <div class="container overhidden">
                <div class="row">
                    <div class="column-md-12">
                        <header class="title-section evision-animate slideInDown" data-wow-delay="0s">
                            <h3><?php echo esc_html( $expedition_home_blog_sub_title );?></h3>
                            <h2><?php echo esc_html( $expedition_home_blog_title );?></h2>
                            <span class="title-divider"></span>
                        </header>
                    </div>
                </div>
            </div>
        
            <div class="container overhidden">
                <div class="row">
                    <?php
                    $expedition_home_about_args = array(
                        'post_type' => 'post',
                        'posts_per_page' => absint( $expedition_home_blog_number ),
                    );
                    $expedition_home_about_post_query = new WP_Query($expedition_home_about_args);
                    if ($expedition_home_about_post_query->have_posts()) :
                        $clearfix = 1;
                        $data_delay = 0;
                        $i=1;
                        while ($expedition_home_about_post_query->have_posts()) : $expedition_home_about_post_query->the_post();
                            if(has_post_thumbnail()){
                                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'full' );
                                $url = $thumb['0'];
                            }
                            else{
                                $url = get_template_directory_uri().'/assets/img/no-image.jpg';
                            }
                            $data_wow_delay = 'data-wow-delay='.$data_delay.'s';
                            ?>
                            <div class= "column-md-4"> 
                                <div class="latestpost evision-animate slideInDown" <?php echo esc_attr( $data_wow_delay );?>>
                                    <div class="latestpost-thumb">
                                        <a href="<?php the_permalink();?>">
                                            <img src="<?php echo esc_url( $url ); ?>" alt="<?php the_title_attribute();?>">
                                        </a>
                                    </div>

                                    <div class="latestpost-content">
                                        <h3>
                                            <a href="<?php the_permalink();?>">
                                                <?php the_title_attribute(); ?>
                                            </a>
                                        </h3>
                                        <?php 
                                        if ( has_excerpt() ) {
                                            the_excerpt();
                                        } else {
                                            $content_blog = get_the_content();
                                            echo expedition_words_count( $expedition_numbers_of_words, $content_blog );
                                        }
                                        ?>
                                    </div>
                                    <div class="latestpost-footer">
                                        <span>
                                            <?php 
                                            $archive_day   = get_the_time('d');
                                            ?>
                                            <a href="<?php echo get_day_link('', '', $archive_day); ?>"><i class="fa fa-calendar"></i> <?php echo get_the_date();?></a>
                                        </span>
                                        <span>
                                            <a href="<?php the_permalink(); ?>">
                                                <i class="fa fa-comment"></i> 
                                                <?php
                                                    $commentscount = get_comments_number();
                                                    if($commentscount == 1): $commenttext = 'comment'; endif;
                                                    if($commentscount > 1 || $commentscount == 0): $commenttext = 'comments'; endif;
                                                    echo $commentscount.' '.$commenttext;
                                                ?>
                                            </a>
                                        </span>
                                        <span class="moredetail"><a href="<?php the_permalink(); ?>" title="view more"><i class="fa fa-angle-right"></i></a></span>
                                    </div>
                                </div>
                            </div>
                            <?php if($i == $expedition_home_blog_column){
                                echo '<div class="clear"></div>';
                            }
                            $i++?>
                        <?php endwhile; ?>
                        
                        <?php endif; wp_reset_postdata(); 
                    ?>
                    <?php
                    if( !empty ( $expedition_home_blog_button_text ) ){
                        ?>
                        <div class="clear"></div>
                        <div class="btn-container">
                            <a class="btn" href="<?php echo esc_url( $expedition_home_blog_button_link );?>">
                                <?php echo esc_html( $expedition_home_blog_button_text );?>
                            </a>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </section>

        <?php
    }
endif;
add_action( 'homepage', 'expedition_home_blog', 40 );