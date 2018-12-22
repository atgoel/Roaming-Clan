<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-home-blog-button-text'] = __('Browse More','expedition');
$expedition_customizer_defaults['expedition-home-blog-button-link'] = home_url( '/blog' );

/*aboutoptions*/
$expedition_sections['expedition-home-blog-option-button'] =
    array(
        'priority'       => 180,
        'title'          => __( 'Buttton settings', 'expedition' ),
        'panel'          => 'expedition-home-blog-panel',
    );

$expedition_settings_controls['expedition-home-blog-button-link'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-home-blog-button-link']
        ),
        'control' => array(
            'label'                 =>  __( 'Browse All Button Link', 'expedition' ),
            'section'               => 'expedition-home-blog-option-button',
            'type'                  => 'url',
            'priority'              => 70,
            'active_callback'       => ''
        )
    );