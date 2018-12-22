<?php
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-enable-back-to-top'] = 1;

$expedition_sections['expedition-back-to-top-options'] =
    array(
        'priority'       => 80,
        'title'          => __( 'Back To Top Options', 'expedition' ),
        'panel'          => 'expedition-theme-options'
    );

$expedition_settings_controls['expedition-enable-back-to-top'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-enable-back-to-top'],
        ),
        'control' => array(
            'label'                 =>  __( 'Enable Back To Top', 'expedition' ),
            'section'               => 'expedition-back-to-top-options',
            'type'                  => 'checkbox',
            'priority'              => 50,
        )
    );