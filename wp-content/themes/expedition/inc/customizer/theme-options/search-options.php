<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values search options*/
$expedition_customizer_defaults['expedition-search-enable'] = 1;

/*fs search enable setting*/
$expedition_sections['expedition-search-enable-setting'] =
    array(
        'priority'       => 90,
        'title'          => __( 'Search Options', 'expedition' ),
        'panel'          => 'expedition-theme-options',
    );

/*fs search enable controlls*/
$expedition_settings_controls['expedition-search-enable'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-search-enable']
        ),
        'control' => array(
            'label'                 =>  __( 'Enable Search', 'expedition' ),
            'section'               => 'expedition-search-enable-setting',
            'type'                  => 'checkbox',
            'priority'              => 50,
            'active_callback'       => ''
        )
    );