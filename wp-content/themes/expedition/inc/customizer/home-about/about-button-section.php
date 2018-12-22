<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values about options*/
$expedition_customizer_defaults['expedition-home-about-page'] = 0;
$expedition_customizer_defaults['expedition-home-about-single-words'] = 30;
$expedition_customizer_defaults['expedition-home-about-button-text'] = __('Know More','expedition');;

/* Feature section Enable settings*/
$expedition_sections['expedition-home-about-section-settings'] =
    array(
        'priority'       => 30,
        'title'          => __( 'Section Settings', 'expedition' ),
        'panel'          => 'expedition-home-about-panel',
    );


/*creating setting control for expedition-home-about-page start*/
$expedition_repeated_settings_controls['expedition-home-about-page'] =
    array(
        'repeated' => 1,
        'expedition-about-pages-ids' => array(
            'setting' =>     array(
                'default'              => $expedition_customizer_defaults['expedition-home-about-page'],
            ),
            'control' => array(
                'label'                 =>  __( 'Select Page For About Section', 'expedition' ),
                'description'           => '',
                'section'               => 'expedition-home-about-section-settings',
                'type'                  => 'dropdown-pages',
                'priority'              => 0
            )
        ),
        'expedition-about-pages-divider' => array(
            'control' => array(
                'section'               => 'expedition-about-selection-setting',
                'type'                  => 'message',
                'priority'              => 60,
                'description'           => '<br /><hr />'
            )
        )
    );

/*About Button Text control*/
$expedition_settings_controls['expedition-home-about-button-text'] =
array(
    'setting' =>     array(
        'default'              => $expedition_customizer_defaults['expedition-home-about-button-text']
    ),
    'control' => array(
        'label'                 =>  __( 'About Section Button Text', 'expedition' ),
        'section'               => 'expedition-home-about-section-settings',
        'type'                  => 'text',
        'priority'              => 60,
        'active_callback'       => ''
    )
);

