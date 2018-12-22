<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-featured-slider-number'] = 2;
$expedition_customizer_defaults['expedition-featured-slider-selection'] = 'from-category';

/*feature slider setting*/
$expedition_sections['expedition-featured-slider-selection-setting'] =
    array(
        'priority'       => 20,
        'title'          => __( 'Settings Options', 'expedition' ),
        'panel'          => 'expedition-featured-slider',
    );

/*No of feature slider selection*/
$expedition_settings_controls['expedition-featured-slider-number'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-featured-slider-number']
        ),
        'control' => array(
            'label'                 =>  __( 'Number Of Slider', 'expedition' ),
            'section'               => 'expedition-featured-slider-selection-setting',
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