<?php

global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;
global $wp_version;

if (version_compare($wp_version, '4.4.2', '<=')) {
    /*defaults values*/
    $expedition_customizer_defaults['expedition-logo'] = '';
    $expedition_customizer_defaults['expedition-title-tagline-message'] = sprintf( __( '%s If you do not have a logo %s', 'expedition' ), '<span class="customize-control-title">','</span>' );
    $expedition_customizer_defaults['expedition-enable-title'] = 1;
    $expedition_customizer_defaults['expedition-enable-tagline'] = 1;

    /*creating setting control*/
    $expedition_settings_controls['expedition-logo'] =
        array(
            'setting' =>     array(
                'default'              => $expedition_customizer_defaults['expedition-logo'],
            ),
            'control' => array(
                'label'                 =>  __( 'Logo', 'expedition' ),
                'section'               => 'title_tagline',
                'type'                  => 'image',
                'priority'              => 70,
                'description'           =>  __( 'Recommended logo size 165*50', 'expedition' ),
                'active_callback'       => ''
            )
        );

    /*enable option for enable tagline in header*/
    $expedition_settings_controls['expedition-title-tagline-message'] =
        array(
            'control' => array(
                'description'           =>  $expedition_customizer_defaults['expedition-title-tagline-message'],
                'section'               => 'title_tagline',
                'type'                  => 'message',
                'priority'              => 75,
                'active_callback'       => ''
            )
        );
    /*enable option for enable tagline in header*/
    $expedition_settings_controls['expedition-enable-title'] =
        array(
            'setting' =>     array(
                'default'              => $expedition_customizer_defaults['expedition-enable-title'],
            ),
            'control' => array(
                'label'                 =>  __( 'Enable Title', 'expedition' ),
                'section'               => 'title_tagline',
                'type'                  => 'checkbox',
                'priority'              => 80,
                'active_callback'       => ''
            )
        );
    $expedition_settings_controls['expedition-enable-tagline'] =
        array(
            'setting' =>     array(
                'default'              => $expedition_customizer_defaults['expedition-enable-tagline'],
            ),
            'control' => array(
                'label'                 =>  __( 'Enable Tagline', 'expedition' ),
                'section'               => 'title_tagline',
                'type'                  => 'checkbox',
                'priority'              => 90,
                'active_callback'       => ''
            )
        );
}
