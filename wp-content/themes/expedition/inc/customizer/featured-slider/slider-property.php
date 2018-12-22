<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-fs-single-words'] = 30;
$expedition_customizer_defaults['expedition-fs-slider-mode'] = 'scrollHorz';
$expedition_customizer_defaults['expedition-fs-slider-time'] = 2;
$expedition_customizer_defaults['expedition-fs-slider-pause-time'] = 7;
$expedition_customizer_defaults['expedition-fs-enable-arrow'] = 0;
$expedition_customizer_defaults['expedition-fs-enable-pager'] = 0;
$expedition_customizer_defaults['expedition-fs-enable-autoplay'] = 1;
$expedition_customizer_defaults['expedition-fs-enable-title'] = 1;
$expedition_customizer_defaults['expedition-fs-enable-caption'] = 1;

/*fs options*/
$expedition_sections['expedition-fs-slider-options'] =
    array(
        'priority'       => 80,
        'title'          => __( 'Slider Property', 'expedition' ),
        'panel'          => 'expedition-featured-slider',
    );

$expedition_settings_controls['expedition-fs-single-words'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-fs-single-words']
        ),
        'control' => array(
            'label'                 =>  __( 'Single Slider- Number Of Words', 'expedition' ),
            'description'           =>  __( 'If you do not have selected from - Custom', 'expedition' ),
            'section'               => 'expedition-fs-slider-options',
            'type'                  => 'number',
            'priority'              => 5,
            'active_callback'       => ''
        )
    );

$expedition_settings_controls['expedition-fs-slider-mode'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-fs-slider-mode']
        ),
        'control' => array(
            'label'                 =>  __( 'Slider Mode', 'expedition' ),
            'section'               => 'expedition-fs-slider-options',
            'type'                  => 'select',
            'choices'               => array(
                'scrollHorz' => __( 'Default', 'expedition' ),
                'fade' => __( 'Fade', 'expedition' ),
                'fadeout' => __( 'Fade-Out', 'expedition' ),
            ),
            'priority'              => 10,
            'active_callback'       => ''
        )
    );
$expedition_settings_controls['expedition-fs-enable-arrow'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-fs-enable-arrow']
        ),
        'control' => array(
            'label'                 =>  __( 'Enable Arrow', 'expedition' ),
            'section'               => 'expedition-fs-slider-options',
            'type'                  => 'checkbox',
            'priority'              => 50,
            'active_callback'       => ''
        )
    );

$expedition_settings_controls['expedition-fs-enable-pager'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-fs-enable-pager']
        ),
        'control' => array(
            'label'                 =>  __( 'Enable Pager', 'expedition' ),
            'section'               => 'expedition-fs-slider-options',
            'type'                  => 'checkbox',
            'priority'              => 55,
            'active_callback'       => ''
        )
    );

$expedition_settings_controls['expedition-fs-enable-autoplay'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-fs-enable-autoplay']
        ),
        'control' => array(
            'label'                 =>  __( 'Enable Autoplay', 'expedition' ),
            'section'               => 'expedition-fs-slider-options',
            'type'                  => 'checkbox',
            'priority'              => 60,
            'active_callback'       => ''
        )
    );
