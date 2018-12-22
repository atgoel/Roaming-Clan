<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-home-testimonial-main-title'] =  __('TESTIMONIALS','expedition');
$expedition_customizer_defaults['expedition-home-testimonial-number'] = 4;
$expedition_customizer_defaults['expedition-home-testimonial-single-words'] = 30;
$expedition_customizer_defaults['expedition-home-testimonial-selection'] = 'from-category';
$expedition_customizer_defaults['expedition-home-testimonial-slider-mode'] = 'scrollHorz';
$expedition_customizer_defaults['expedition-home-testimonial-slider-time'] = 2;
$expedition_customizer_defaults['expedition-home-testimonial-slider-pause-time'] = 7;
$expedition_customizer_defaults['expedition-home-testimonial-enable-control'] = 1;
$expedition_customizer_defaults['expedition-home-testimonial-enable-autoplay'] = 1;


/*testimonial options*/
$expedition_sections['expedition-home-testimonial-options'] =
    array(
        'priority'       => 30,
        'title'          => __( 'Settings Options', 'expedition' ),
        'panel'          => 'expedition-home-testimonial',
    );

/*Testimonial Title control*/
$expedition_settings_controls['expedition-home-testimonial-main-title'] =
array(
    'setting' =>     array(
        'default'              => $expedition_customizer_defaults['expedition-home-testimonial-main-title']
    ),
    'control' => array(
        'label'                 =>  __( 'Main Title', 'expedition' ),
        'section'               => 'expedition-home-testimonial-options',
        'type'                  => 'text',
        'priority'              => 5,
        'active_callback'       => ''
    )
);

/*No of Testimonial needed*/
$expedition_settings_controls['expedition-home-testimonial-number'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-home-testimonial-number']
        ),
        'control' => array(
            'label'                 =>  __( 'Number Of Testimonial/s', 'expedition' ),
            'description'           => __( 'Choose number of Testimonial to be displayed', 'expedition' ),
            'section'               => 'expedition-home-testimonial-options',
            'type'                  => 'select',
            'choices'               => array(
                1 => __( '1', 'expedition' ),
                2 => __( '2', 'expedition' ),
                3 => __( '3', 'expedition' ),
            ),
            'priority'              => 10,
            'active_callback'       => ''
        )
    );
