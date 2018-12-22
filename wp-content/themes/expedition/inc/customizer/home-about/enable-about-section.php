<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values about options*/
$expedition_customizer_defaults['expedition-home-about-enable'] = 1;

/* Feature section Enable settings*/
$expedition_sections['expedition-home-about-button-options'] =
    array(
        'priority'       => 10,
        'title'          => __( 'Enable Option', 'expedition' ),
        'panel'          => 'expedition-home-about-panel',
    );

/*About section enable control*/
$expedition_settings_controls['expedition-home-about-enable'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-home-about-enable']
        ),
        'control' => array(
            'label'                 =>  __( 'Enable About Section', 'expedition' ),
            'description'           =>  __( 'Enable "About Section" on checked', 'expedition' ),
            'section'               => 'expedition-home-about-button-options',
            'type'                  => 'checkbox',
            'priority'              => 10,
            'active_callback'       => ''
        )
    );
