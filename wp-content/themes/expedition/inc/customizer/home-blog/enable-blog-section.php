<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-home-blog-enable'] = 1;

/*aboutoptions*/
$expedition_sections['expedition-home-blog-enable'] =
    array(
        'priority'       => 180,
        'title'          => __( 'Enable Option', 'expedition' ),
        'panel'          => 'expedition-home-blog-panel',
    );


$expedition_settings_controls['expedition-home-blog-enable'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-home-blog-enable']
        ),
        'control' => array(
            'label'                 =>  __( 'Enable Blog', 'expedition' ),
            'description'           => __( 'Enable "Blog Section" on checked' , 'expedition' ),
            'section'               => 'expedition-home-blog-enable',
            'type'                  => 'checkbox',
            'priority'              => 10,
            'active_callback'       => ''
        )
    );