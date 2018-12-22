<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-featured-slider-category'] = 0;

/*category selection*/
$expedition_sections['expedition-home-featured-slider-category'] =
    array(
        'priority'       => 50,
        'title'          => __( 'Select From Category', 'expedition' ),
        'description'    => __( 'This option only work when you have selected "Category" in "settings Option".', 'expedition' ),
        'panel'          => 'expedition-featured-slider',
    );



/*creating setting control for expedition-fs-Category start*/
$expedition_settings_controls['expedition-featured-slider-category'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-featured-slider-category']
        ),
        'control' => array(
            'label'                 =>  __( 'Select Category For Slider', 'expedition' ),
            'description'           =>  __( 'If you have oly choosen category then page you need to select one from here', 'expedition' ),
            'section'               => 'expedition-home-featured-slider-category',
            'type'                  => 'category_dropdown',
            'priority'              => 50,
            'active_callback'       => ''
        )
    );
