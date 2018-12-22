<?php
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-enable-social-icons'] = '';
$expedition_customizer_defaults['expedition-default-banner-image'] = '';


$expedition_sections['expedition-header-options'] =
    array(
        'priority'       => 40,
        'title'          => __( 'Header Options', 'expedition' ),
        'panel'          => 'expedition-theme-options'
    );

$expedition_settings_controls['expedition-enable-social-icons'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-enable-social-icons'],
        ),
        'control' => array(
            'label'                 =>  __( 'Enable Social', 'expedition' ),
            'description'                 =>  __( 'Please add Social menus for enabling Social menus. Go to Menus for setting up', 'expedition' ),
            'section'               => 'expedition-header-options',
            'type'                  => 'checkbox',
            'priority'              => 30,
        )
    );

$expedition_settings_controls['expedition-default-banner-image'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-default-banner-image'],
        ),
        'control' => array(
            'label'                 =>  __( 'Default Banner Image', 'expedition' ),
            'description'           =>  __( 'Please note that this is for individual inner pages', 'expedition' ),
            'section'               => 'expedition-header-options',
            'type'                  => 'image',
            'priority'              => 50,
        )
    );