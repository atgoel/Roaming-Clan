<?php

if( ! function_exists( 'expedition_wp_head' ) ) :

    /**
     * expedition wp_head hook
     *
     * @since  expedition 0.0.2
     */
    function expedition_wp_head(){
      
        global $expedition_customizer_all_values;
        global $expedition_google_fonts;

        $expedition_primary_color_option = $expedition_customizer_all_values['expedition-primary-color'];
        $expedition_alternate_primary_color_option = $expedition_customizer_all_values['expedition-alternate-primary-color'];
        $expedition_site_identity_color_option = $expedition_customizer_all_values['expedition-site-identity-color'];
        $expedition_main_title_color_option = $expedition_customizer_all_values['expedition-main-title-color'];
        $expedition_main_sub_title_color_option = $expedition_customizer_all_values['expedition-main-sub-title-color'];
        $expedition_menu_color_option = $expedition_customizer_all_values['expedition-menu-color'];
        $expedition_text_over_image_color_option = $expedition_customizer_all_values['expedition-text-over-image-color'];
        $expedition_button_standard_color_option = $expedition_customizer_all_values['expedition-button-standard-color'];
        $expedition_button_border_color_option = $expedition_customizer_all_values['expedition-button-border-color'];
        $expedition_link_color_option = $expedition_customizer_all_values['expedition-link-color'];
        $expedition_primary_hover_color_option = $expedition_customizer_all_values['expedition-primary-hover-color'];
        $expedition_button_standard_hover_color_option = $expedition_customizer_all_values['expedition-button-standard-hover-color'];
        
        $expedition_bg_hearder_color_option = $expedition_customizer_all_values['expedition-bg-header-color'];
        $expedition_bg_popular_trip_color_option = $expedition_customizer_all_values['expedition-bg-popular-trip-color'];
        $expedition_bg_breadcrumb_color_option = $expedition_customizer_all_values['expedition-bg-breadcrumb-color'];
        $expedition_bg_testimonial_color_option = $expedition_customizer_all_values['expedition-bg-testimonial-color'];
        $expedition_bg_letest_post_color_option = $expedition_customizer_all_values['expedition-bg-letest-post-color'];
        $expedition_bg_footer_color_option = $expedition_customizer_all_values['expedition-bg-footer-color'];
        

        /*font settings*/
        $expedition_font_family_primary_option = $expedition_google_fonts[$expedition_customizer_all_values['expedition-font-family-Primary']];
        $expedition_font_family_site_identity_option = $expedition_google_fonts[$expedition_customizer_all_values['expedition-font-family-site-identity']];
        $expedition_font_family_title_option = $expedition_google_fonts[$expedition_customizer_all_values['expedition-font-family-title']];
        $expedition_font_family_subtitle_option = $expedition_google_fonts[$expedition_customizer_all_values['expedition-font-family-subtitle']];

        /*about section background image*/
        $expedition_home_about_posts = evision_customizer_get_repeated_all_value(1 , array('expedition-about-pages-ids'));
        $expedition_home_about_posts_ids = array();
        if (null != $expedition_home_about_posts) {
            foreach ($expedition_home_about_posts as $expedition_home_about_post) {
                if (0 != $expedition_home_about_post['expedition-about-pages-ids']) {
                    $expedition_home_about_posts_ids = $expedition_home_about_post['expedition-about-pages-ids'];
                }
            }
        }
        if (has_post_thumbnail($expedition_home_about_posts_ids)){
            $expedition_home_about_bg = wp_get_attachment_image_src( get_post_thumbnail_id($expedition_home_about_posts_ids), 'full' );
        }  
        else{
            $expedition_home_about_bg[0] = get_template_directory_uri()."/assets/img/about-bg.jpg";
        }
        /*end of about section*/

        $expedition_banner_image = $expedition_customizer_all_values['expedition-default-banner-image'];
        ?>
        <style type="text/css">
        /*=====COLOR OPTION=====*/

        /*Color*/
        /*----------------------------------*/

        /*Primary*/
        <?php
        if( !empty($expedition_primary_color_option) ){
        ?>
            section.wrapper-slider .slide-pager .cycle-pager-active,
            section.wrapper-slider .slide-pager .cycle-pager-active:visited,
            section.wrapper-slider .slide-pager .cycle-pager-active:hover,
            section.wrapper-slider .slide-pager .cycle-pager-active:focus,
            section.wrapper-slider .slide-pager .cycle-pager-active:active,
            .title-divider,
            .title-divider:visited,
            .block-overlay-hover,
            .block-overlay-hover:visited,
            #gmaptoggle,
            #gmaptoggle:visited,
            .evision-back-to-top,
            .evision-back-to-top:visited,
            .search-form .search-submit,
            .search-form .search-submit:visited,
            .widget_calendar tbody a,
            .widget_calendar tbody a:visited{
              background-color: <?php echo esc_attr( $expedition_primary_color_option );?>;
            }

            .widget-title,
            .widgettitle{
              border-color: <?php echo esc_attr( $expedition_primary_color_option );?>; /*#2e5077*/
            }

            @media screen and (min-width: 768px){
            .main-navigation li:hover > a:after,
            .main-navigation .current_page_item > a:after,
            .main-navigation .current-menu-item > a:after,
            .main-navigation .current_page_ancestor > a:after,
            .main-navigation li.active > a:after,
            .main-navigation li.active > a:after,
            .main-navigation li.active > a:after,
            .main-navigation li.current_page_parent a:after {
                background-color: <?php echo esc_attr( $expedition_primary_color_option );?>; 
              }
            }

            .latestpost-footer .moredetail a,
            .latestpost-footer .moredetail a:visited{
              color: <?php echo esc_attr( $expedition_primary_color_option );?>;
            }
        <?php
        }
        if( !empty($expedition_alternate_primary_color_option) ){
        ?>
            /*Alternate primary color*/
            .search-section button.catselect,
            .search-section button.catselect:visited{
              background-color: <?php echo esc_attr( $expedition_alternate_primary_color_option );?>;
            }
        <?php
        } 
        if( !empty($expedition_site_identity_color_option) ){
        ?>
            /*Site identity / logo & tagline*/
            .site-title a,
            .site-title a:visited,
            .site-description {
              color: <?php echo esc_attr( $expedition_site_identity_color_option );?>; /*#545C68*/
            }
        <?php
        } 
        if( !empty($expedition_main_title_color_option) ){
        ?>
            /*Main Titile*/
            .title-section h2,
            .latestpost-content h3 a,
            .latestpost-content h3 a:visited{
              color: <?php echo esc_attr( $expedition_main_title_color_option );?>;
            }
        <?php
        } 
        if( !empty($expedition_main_sub_title_color_option) ){
        ?>
            /*Main Sub Titile*/
            .title-section h3{
              color: <?php echo esc_attr( $expedition_main_sub_title_color_option );?>;
            }
        <?php
        } 
        if( !empty($expedition_menu_color_option) ){
        ?>
            /*Menu*/
            .main-navigation a {
              color: <?php echo esc_attr( $expedition_menu_color_option );?>; 
            }
        <?php
        } 
        if( !empty($expedition_text_over_image_color_option) ){
        ?>
            /*Text over image*/
            .wrapper-slider .slide-item .slider-title a,
            .wrapper-slider .slide-item .slider-title a:visited,
            .wrapper-slider .slide-item .container-full,
            .wrapper-slider .slide-item .text-content,
            .wrap-poptrip,
            h2.block-post-title a,
            .wrap-poptrip a.line-btn,
            .wrap-poptrip a.line-btn:visited,
            .wrap-info,
            .wrap-info .title-section h2,
            .wrap-info a.line-btn,
            .wrap-info a.line-btn:visited,
            .page-inner-title .entry-header .entry-title{
              color: <?php echo esc_attr( $expedition_text_over_image_color_option );?>; 
            }

            .wrapper-slider .slide-pager span,
            .wrapper-slider .slide-pager span:visited{
              background-color: <?php echo esc_attr( $expedition_text_over_image_color_option );?>;  
            }

            .testimonial-slider .banner-content-holder{
              border-color: <?php echo esc_attr( $expedition_text_over_image_color_option );?>;  
            }

            .testimonial-slider .thumb-holder > img:hover,
            .testimonial-slider .thumb-holder > img:focus{
              box-shadow: 0 0 0 3px <?php echo esc_attr( $expedition_text_over_image_color_option );?>; 
            }
        <?php
        } 
        if( !empty($expedition_button_standard_color_option) ){
        ?>
            /*Button standard*/
            button,
            a.btn,
            html input[type="button"],
            input[type="button"],
            input[type="reset"],
            input[type="submit"],
            button:visited,
            a.btn:visited,
            input[type="button"]:visited,
            input[type="reset"]:visited,
            input[type="submit"]:visited,
            .search-section button.pageselect,
            .search-section button.pageselect:visited {
              background: <?php echo esc_attr( $expedition_button_standard_color_option );?>;
            }
        <?php
        } 
        if( !empty($expedition_button_border_color_option) ){
        ?>
            /*Button border only*/
            a.line-btn,
            a.line-btn:visited{
              border-color: <?php echo esc_attr( $expedition_button_border_color_option );?>; 
            }
        <?php
        } 
        if( !empty($expedition_link_color_option) ){
        ?>
            /*Link color*/
            .posted-on a,
            .cat-links a,
            .tags-links a,
            .author a,
            .comments-link a,
            .edit-link a,
            .nav-links .nav-previous a,
            .nav-links .nav-next a {
              color: <?php echo esc_attr( $expedition_link_color_option );?>; 
            }
        <?php
        } 
        if( !empty($expedition_primary_hover_color_option) ){
        ?>
            /*Hover*/
            /*----------------------------------*/

            /*Primary hover*/
            a:hover,
              a:focus,
              a:active,
              h1 a:hover,
              h1 a:focus,
              h1 a:active,
              h2 a:hover,
              h2 a:focus,
              h2 a:active,
              h3 a:hover,
              h3 a:focus,
              h3 a:active,
              h4 a:hover,
              h4 a:focus,
              h4 a:active,
              h5 a:hover,
              h5 a:focus,
              h5 a:active,
              h6 a:hover,
              h6 a:focus,
              h6 a:active,
              .contact-widget ul li a:hover,
              .contact-widget ul li a:focus,
              .contact-widget ul li a:active,
              .contact-widget ul li a:hover i,
              .contact-widget ul li a:focus i,
              .contact-widget ul li a:active i,
              .site-title a:hover,
              .site-title a:focus,
              .site-title a:active,
              .main-navigation li:hover > a,
              .main-navigation li:focus > a,
              .main-navigation li:active > a,
              .main-navigation ul ul a:hover,
              .main-navigation ul ul a:focus,
              .main-navigation ul ul a:active,
              .wrapper-slider .slide-item .slider-title a:hover,
              .wrapper-slider .slide-item .slider-title a:focus,
              .wrapper-slider .slide-item .slider-title a:active,
              .latestpost-content h3 a:hover,
              .latestpost-content h3 a:focus,
              .latestpost-content h3 a:active,
              .latestpost-footer a:hover,
              .latestpost-footer a:focus,
              .latestpost-footer a:active,
              .latestpost-footer a:hover i,
              .latestpost-footer a:focus i,
              .latestpost-footer a:active i,
              .posted-on a:hover,
              .posted-on a:focus,
              .posted-on a:active,
              .cat-links a:hover,
              .cat-links a:focus,
              .cat-links a:active,
              .tags-links a:hover,
              .tags-links a:focus,
              .tags-links a:active,
              .author a:hover,
              .author a:focus,
              .author a:active,
              .comments-link a:hover,
              .comments-link a:focus,
              .comments-link a,
              .edit-link a:hover,
              .edit-link a:focus,
              .edit-link a:active,
              .nav-links .nav-previous a:hover,
              .nav-links .nav-previous a:focus,
              .nav-links .nav-previous a:active,
              .nav-links .nav-next a:hover,
              .nav-links .nav-next a:focus,
              .nav-links .nav-next a:active,
              .search-form .search-submit:hover,
              .search-form .search-submit:focus,
              .search-form .search-submit:active,
              .widget li a:hover,
              .widget li a:focus,
              .widget li a:active{
              color: <?php echo esc_attr( $expedition_primary_hover_color_option );?>; /*#DFB200*/
            }

            .wrapper-slider .controls .slide-prev i:hover,
            .wrapper-slider .controls .slide-prev i:focus,
            .wrapper-slider .controls .slide-prev i:active,
            .wrapper-slider .controls .slide-next i:hover,
            .wrapper-slider .controls .slide-next i:focus,
            .wrapper-slider .controls .slide-next i:active,
            .search-section button.catselect:hover,
            .search-section button.catselect:focus,
            .search-section button.catselect:active,
            .search-section button.pageselect:hover,
            .search-section button.pageselect:focus,
            .search-section button.pageselect:active,
            .wrapper-slider .slide-pager span:hover,
            .wrapper-slider .slide-pager span:focus,
            .wrapper-slider .slide-pager span:active,
            .latestpost-footer .moredetail a:hover,
            .latestpost-footer .moredetail a:focus,
            .latestpost-footer .moredetail a:active,
            .latestpost:hover:after,
            .latestpost:focus:after,
            .latestpost:active:after,
            #gmaptoggle:hover,
            #gmaptoggle:focus,
            #gmaptoggle:active,
            .widget_calendar tbody a:hover,
            .widget_calendar tbody a:focus,
            .widget_calendar tbody a:active{
              background-color: <?php echo esc_attr( $expedition_primary_hover_color_option );?>; /*#DFB200*/
            }

            .wrapper-slider .controls .slide-prev i:hover,
            .wrapper-slider .controls .slide-prev i:focus,
            .wrapper-slider .controls .slide-prev i:active,
            .wrapper-slider .controls .slide-next i:hover,
            .wrapper-slider .controls .slide-next i:focus,
            .wrapper-slider .controls .slide-next i:active,
            .nav-links .nav-previous a:hover,
            .nav-links .nav-previous a:focus,
            .nav-links .nav-previous a:active,
            .nav-links .nav-next a:hover,
            .nav-links .nav-next a:focus,
            .nav-links .nav-next a:active{
              border-color: <?php echo esc_attr( $expedition_primary_hover_color_option );?>;
            }
        <?php
        } 
        if( !empty($expedition_button_standard_hover_color_option) ){
        ?>
            /*Button standard*/
            button:hover,
            a.btn:hover,
            a.line-btn:hover,
            input[type="button"]:hover,
            input[type="reset"]:hover,
            input[type="submit"]:hover,
            button:focus,
            a.btn:focus,
            a.line-btn:focus,
            input[type="button"]:focus,
            input[type="reset"]:focus,
            input[type="submit"]:focus,
            button:active,
            a.btn:active,
            a.line-btn:active,
            input[type="button"]:active,
            input[type="reset"]:active,
            input[type="submit"]:active {
              background-color: <?php echo esc_attr( $expedition_button_standard_hover_color_option );?>;
            }

            a.line-btn:hover,
            a.line-btn:focus,
            a.line-btn:active{
              border-color: <?php echo esc_attr( $expedition_button_standard_hover_color_option );?>;
            }
            
        <?php
        } 
        if( !empty($expedition_bg_hearder_color_option) ){
        ?>
            /*Background Color*/
              /*Header*/
              .top-header,
              .site-header{
                background-color: <?php echo esc_attr( $expedition_bg_hearder_color_option );?>; 
              }
        <?php
        } 
        if( !empty($expedition_bg_popular_trip_color_option) ){
        ?>
              /*popular trip*/
              .wrap-poptrip{
                background-color: <?php echo esc_attr( $expedition_bg_popular_trip_color_option );?>; /*#fff*/
              }
        <?php
        } 
        if( !empty($expedition_bg_breadcrumb_color_option) ){
        ?> 
              .wrap-breadcrumb{
                background-color: <?php echo esc_attr( $expedition_bg_breadcrumb_color_option );?>; /*#1D3A5B*/
              }
        <?php
        } 
        if( !empty($expedition_bg_testimonial_color_option) ){
        ?> 
              /*info - Testimonial*/
              .wrap-info .sub-wrapper{
               background-color:  <?php echo esc_attr( $expedition_bg_testimonial_color_option );?>; /*#656565*/
              }
        <?php
        } 
        if( !empty($expedition_bg_letest_post_color_option) ){
        ?> 
              /*blog*/
              .wrap-latestpost{
                background-color: <?php echo esc_attr( $expedition_bg_letest_post_color_option );?>; /*#f1f1f1*/
              }
        <?php
        } 
        if( !empty($expedition_bg_footer_color_option) ){
        ?> 
          /*footer*/
          .site-footer{
            background-color: <?php echo esc_attr( $expedition_bg_footer_color_option );?>; /*#636B6B*/
          }

        <?php
        } 
        if( !empty($expedition_font_family_primary_option) ){
        /*=====FONT FAMILY OPTION=====*/
        ?> 
        /*Primary*/
          html, body, p, button, input, select, textarea, pre, code, kbd, tt, var, samp , .main-navigation a, search-input-holder .search-field{
          font-family: '<?php echo esc_attr( $expedition_font_family_primary_option ); ?>'; /*Lato*/
          }
        <?php
        } 

        if( !empty($expedition_font_family_site_identity_option) ){
        ?> 
          /*Site identity / logo & tagline*/
          .site-title a, .site-description {
          font-family: '<?php echo esc_attr( $expedition_font_family_site_identity_option ); ?>'; /*Lato*/
          }
        <?php
        } 
        if( !empty($expedition_font_family_title_option) ){
        ?> 
          /*Title*/
          h1, h1 a,
          h2, h2 a,
          h3, h3 a,
          h4, h4 a,
          h5, h5 a,
          h6, h6 a{
            font-family: '<?php echo esc_attr( $expedition_font_family_title_option ); ?>'; /*Lato*/
          }
        <?php
        } 
          if( !empty($expedition_font_family_subtitle_option) ){
          ?>
          /*Subtitle*/
          .title-section h3 {
            font-family: "<?php echo esc_attr( $expedition_font_family_subtitle_option ); ?>"; /*Cookie*/
          }
        <?php
        }
        /* about bg */
        if( !empty( $expedition_home_about_bg) ){
        ?>
        .sub-wrapper {
            background-image: url(<?php echo esc_url($expedition_home_about_bg[0]);?>);
        }
        .sub-wrapper.about-only{
          background-size: 100%;
        }

        .sub-wrapper.testimonial-only{
          background-image: none;
        }
        
        <?php
        }
        /* Banner Image */
        if( !empty( $expedition_banner_image ) ){
        ?>
        .page-inner-title {
         background-image: url(<?php echo esc_url($expedition_banner_image);?>);
        }
        <?php 
        }

        $expedition_custom_css = $expedition_customizer_all_values['expedition-custom-css'];
        $expedition_custom_css_output = '';
        if ( ! empty( $expedition_custom_css ) ) {
            $expedition_custom_css_output .= $expedition_custom_css;
        }
        echo $expedition_custom_css_output;/*escaping done above*/
        ?>
        </style>
    <?php
    }
endif;
add_action( 'wp_head', 'expedition_wp_head' );