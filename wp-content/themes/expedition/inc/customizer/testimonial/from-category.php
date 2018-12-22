<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-home-testimonial-category'] = 0;

/*category selection*/
$expedition_sections['expedition-home-testimonial-category'] =
    array(
        'priority'       => 60,
        'title'          => __( 'Select From Category', 'expedition' ),
        'description'    => __( 'This option only work when you have selected "Category" in "Settings Options".', 'expedition' ),
        'panel'          => 'expedition-home-testimonial',
    );

/*creating setting control for expedition-home-testimonial-Category start*/
$expedition_settings_controls['expedition-home-testimonial-category'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-home-testimonial-category']
        ),
        'control' => array(
            'label'                 =>  __( 'Select Category For Testimonial', 'expedition' ),
            'section'               => 'expedition-home-testimonial-category',
            'type'                  => 'category_dropdown',
            'priority'              => 30,
            'active_callback'       => ''
        )
    );