<?php
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-custom-css'] = '';

$expedition_sections['expedition-custom-css'] =
    array(
        'priority'       => 120,
        'title'          => __( 'Custom CSS', 'expedition' ),
        'panel'          => 'expedition-theme-options'
    );

$expedition_settings_controls['expedition-custom-css'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-custom-css'],
        ),
        'control' => array(
            'label'                 =>  __( 'Custom CSS', 'expedition' ),
            'section'               => 'expedition-custom-css',
            'type'                  => 'textarea',
            'priority'              => 40,
        )
    );