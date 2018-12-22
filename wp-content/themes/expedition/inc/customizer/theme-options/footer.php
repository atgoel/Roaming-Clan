<?php
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-copyright-text'] = __('Copyright &copy; All right reserved','expedition');

$expedition_sections['expedition-footer-options'] =
    array(
        'priority'       => 60,
        'title'          => __( 'Footer Options', 'expedition' ),
        'panel'          => 'expedition-theme-options'
    );


$expedition_settings_controls['expedition-copyright-text'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-copyright-text'],
        ),
        'control' => array(
            'label'                 =>  __( 'Copyright Text', 'expedition' ),
            'section'               => 'expedition-footer-options',
            'type'                  => 'text_html',
            'priority'              => 20,
        )
    );