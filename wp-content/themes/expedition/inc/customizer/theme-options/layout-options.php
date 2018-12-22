<?php
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-default-layout'] = 'right-sidebar';
$expedition_customizer_defaults['expedition-number-of-words'] = 30;
$expedition_customizer_defaults['expedition-single-post-image-align'] = 'Full';



$expedition_sections['expedition-layout-options'] =
    array(
        'priority'       => 20,
        'title'          => __( 'Layout Options', 'expedition' ),
        'panel'          => 'expedition-theme-options',
    );

/*layout-options option responsive lodader start*/
$expedition_settings_controls['expedition-default-layout'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-default-layout'],
        ),
        'control' => array(
            'label'                 =>  __( 'Default Layout', 'expedition' ),
            'description'           =>  __( 'Layout for all archives, single posts and pages', 'expedition' ),
            'section'               => 'expedition-layout-options',
            'type'                  => 'select',
            'choices'               => array(
                'right-sidebar' => __( 'Content - Primary Sidebar', 'expedition' ),
                'left-sidebar' => __( 'Primary Sidebar - Content', 'expedition' ),
                'no-sidebar' => __( 'No Sidebar', 'expedition' )
            ),
            'priority'              => 20,
            'active_callback'       => ''
        )
    );


$expedition_settings_controls['expedition-number-of-words'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-number-of-words']
        ),
        'control' => array(
            'label'                 =>  __( 'Number Of Words For Excerpt', 'expedition' ),
            'description'           =>  __( 'This will controll the excerpt length on listing page', 'expedition' ),
            'section'               => 'expedition-layout-options',
            'type'                  => 'number',
            'priority'              => 30,
            'active_callback'       => ''
        )
    );
