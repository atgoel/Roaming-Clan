<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-home-blog-title'] = __('NEWS & ARTICLES','expedition');
$expedition_customizer_defaults['expedition-home-blog-sub-title'] = __('Stay update with our','expedition');
$expedition_customizer_defaults['expedition-home-blog-number'] = 3;
$expedition_customizer_defaults['expedition-home-blog-column'] = 3;

/*aboutoptions*/
$expedition_sections['expedition-home-blog-options'] =
    array(
        'priority'       => 180,
        'title'          => __( 'Section settings', 'expedition' ),
        'panel'          => 'expedition-home-blog-panel',
    );


$expedition_settings_controls['expedition-home-blog-title'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-home-blog-title']
        ),
        'control' => array(
            'label'                 =>  __( 'Main Title', 'expedition' ),
            'description'           =>  __( 'Enable "Blog Section" on checked', 'expedition' ),
            'section'               => 'expedition-home-blog-options',
            'type'                  => 'text',
            'priority'              => 20,
            'active_callback'       => ''
        )
    );

$expedition_settings_controls['expedition-home-blog-sub-title'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-home-blog-sub-title']
        ),
        'control' => array(
            'label'                 =>  __( 'Sub Title', 'expedition' ),
            'section'               => 'expedition-home-blog-options',
            'type'                  => 'text',
            'priority'              => 30,
            'active_callback'       => ''
        )
    );