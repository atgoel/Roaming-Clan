<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values popular trip options*/
$expedition_customizer_defaults['expedition-home-popular-trip-section-enable'] = 1;

/* popular section Enable settings*/
$expedition_sections['expedition-home-popular-trip-section-enable-options'] =
    array(
        'priority'       => 10,
        'title'          => __( 'Enable Option', 'expedition' ),
        'panel'          => 'expedition-popular-trip-panel',
    );

/*popular section enable control*/
$expedition_settings_controls['expedition-home-popular-trip-section-enable'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-home-popular-trip-section-enable']
        ),
        'control' => array(
            'label'                 =>  __( 'Enable Popular Trip', 'expedition' ),
            'section'               => 'expedition-home-popular-trip-section-enable-options',
        	'description'    		=> __( 'Enable "Popular Trips Selection" on checked' , 'expedition' ),
            'type'                  => 'checkbox',
            'priority'              => 10,
            'active_callback'       => ''
        )
    );