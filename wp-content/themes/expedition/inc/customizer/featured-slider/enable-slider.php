<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values feature trip options*/
$expedition_customizer_defaults['expedition-feature-slider-enable'] = 1;

/*feature slider enable setting*/
$expedition_sections['expedition-feature-section-enable-setting'] =
    array(
        'priority'       => 10,
        'title'          => __( 'Enable Options', 'expedition' ),
        'panel'          => 'expedition-featured-slider',
    );

/*Feature section enable control*/
$expedition_settings_controls['expedition-feature-slider-enable'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-feature-slider-enable']
        ),
        'control' => array(
            'label'                 =>  __( 'Enable Feature Slider', 'expedition' ),
            'section'               => 'expedition-feature-section-enable-setting',
        	'description'    		=> __( 'Enable "Feature slider" on checked' , 'expedition' ),
            'type'                  => 'checkbox',
            'priority'              => 10,
            'active_callback'       => ''
        )
    );