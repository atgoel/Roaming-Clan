<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values feature trip options*/
$expedition_customizer_defaults['expedition-home-popular-trip-main-title'] = __('POPULAR TRIPS','expedition');
$expedition_customizer_defaults['expedition-home-popular-trip-sub-title'] = __('Take a look at our','expedition');
$expedition_customizer_defaults['expedition-home-popular-trip-number'] = 8;
$expedition_customizer_defaults['expedition-home-popular-trip-selection'] = 'from-category';
$expedition_customizer_defaults['expedition-home-popular-trip-button-text'] = __('Know More','expedition');


/* Popular Trips settings*/
$expedition_sections['expedition-home-popular-trip-main-section'] =
    array(
        'priority'       => 50,
        'title'          => __( 'Settings Options', 'expedition' ),
        'panel'          => 'expedition-popular-trip-panel',

    );


/*Popular Trip Title control*/
$expedition_settings_controls['expedition-home-popular-trip-main-title'] =
array(
    'setting' =>     array(
        'default'              => $expedition_customizer_defaults['expedition-home-popular-trip-main-title']
    ),
    'control' => array(
        'label'                 =>  __( 'Main Title', 'expedition' ),
        'section'               => 'expedition-home-popular-trip-main-section',
        'type'                  => 'text',
        'priority'              => 20,
        'active_callback'       => ''
    )
);

/*Popular Trip Sub Title control*/
$expedition_settings_controls['expedition-home-popular-trip-sub-title'] =
array(
    'setting' =>     array(
        'default'              => $expedition_customizer_defaults['expedition-home-popular-trip-sub-title']
    ),
    'control' => array(
        'label'                 =>  __( 'Sub Title', 'expedition' ),
        'section'               => 'expedition-home-popular-trip-main-section',
        'type'                  => 'text',
        'priority'              => 30,
        'active_callback'       => ''
    )
);
