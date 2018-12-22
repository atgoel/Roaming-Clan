<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*defaults values*/
$expedition_customizer_defaults['expedition-home-testimonial-enable'] = 1;

/*testimonialsetting*/
$expedition_sections['expedition-home-testimonial-enable-setting'] =
    array(
        'priority'       => 10,
        'title'          => __( 'Enable Options', 'expedition' ),
        'panel'          => 'expedition-home-testimonial',
    );

$expedition_settings_controls['expedition-home-testimonial-enable'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-home-testimonial-enable']
        ),
        'control' => array(
            'label'                 =>  __( 'Enable Testimonial', 'expedition' ),
            'description'           => __( 'Enable "Testimonial selection" on checked', 'expedition' ),
            'section'               => 'expedition-home-testimonial-enable-setting',
            'type'                  => 'checkbox',
            'priority'              => 50,
            'active_callback'       => ''
        )
    );