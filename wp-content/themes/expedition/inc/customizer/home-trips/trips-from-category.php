<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values popular trip options*/
$expedition_customizer_defaults['expedition-home-popular-trip-category'] = 0;


/*category selection*/
$expedition_sections['expedition-home-popular-trip-category'] =
    array(
        'priority'       => 60,
        'title'          => __( 'Select From Category', 'expedition' ),
        'description'    => __( 'This option only work when you have selected "Category" in "settings Option".', 'expedition' ),
        'panel'          => 'expedition-popular-trip-panel',
    );


/*creating setting control for popular trip Category start*/
$expedition_settings_controls['expedition-home-popular-trip-category'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-home-popular-trip-category']
        ),
        'control' => array(
            'label'                 =>  __( 'Select Category For Popular Trips', 'expedition' ),
            'section'               => 'expedition-home-popular-trip-category',
            'type'                  => 'category_dropdown',
            'priority'              => 60,
            'active_callback'       => ''

        )
    );
