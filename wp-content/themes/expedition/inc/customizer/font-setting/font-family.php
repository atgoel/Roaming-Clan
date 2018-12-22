<?php
global $expedition_panels;
global $expedition_sections;
global $expedition_settings_controls;
global $expedition_repeated_settings_controls;
global $expedition_customizer_defaults;

/*creating panel for fonts-setting*/
$expedition_panels['expedition-fonts'] =
    array(
        'title'          => __( 'Font Setting', 'expedition' ),
        'priority'       => 43
    );

/*font array*/
global $expedition_google_fonts;
$expedition_google_fonts = array(
    'ABeeZee:400,400italic' => 'ABeeZee',
    'Archivo+Narrow:400,400italic,700' => 'Archivo Narrow',
    'Cookie' => 'Cookie',
    'Exo +2:400,300,400italic,600,700,900' => 'Exo 2',
    'Lato:400,300,400italic,900,700' => 'Lato',
    'Nunito:400,300,700' => 'Nunito',
    'Open+Sans:400,400italic,600,700' => 'Open Sans',
    'Satisfy' => 'Satisfy',
    'Shadows+Into+Light' => 'Shadows Into Light',
    'Signika:400,300,700' => 'Signika',
    'Six+Caps' => 'Six Caps',
    'Tangerine:400,700' => 'Tangerine',
    'Varela+Round' => 'Varela Round',
    'Vollkorn:400,400italic,700' => 'Vollkorn',
    'Voltaire' => 'Voltaire',
);

/*defaults values*/
$expedition_customizer_defaults['expedition-font-family-Primary'] = 'Lato:400,300,400italic,900,700';
$expedition_customizer_defaults['expedition-font-family-site-identity'] = 'Lato:400,300,400italic,900,700';
$expedition_customizer_defaults['expedition-font-family-title'] = 'Lato:400,300,400italic,900,700';
$expedition_customizer_defaults['expedition-font-family-subtitle'] = 'Cookie';


/*section*/
$expedition_sections['expedition-family'] =
    array(
        'priority'       => 20,
        'title'          => __( 'Font Family', 'expedition' ),
        'panel'          => 'expedition-fonts',
    );

/*setting - controls*/
$expedition_settings_controls['expedition-font-family-Primary'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-font-family-Primary'],
            
        ),
        'control' => array(
            'label'                 => __( 'Body ( paragraph ) Primary', 'expedition' ),
            'description'           => __( 'change primary font family', 'expedition' ),
            'section'               => 'expedition-family',
            'type'                  => 'select',
            'choices'               => $expedition_google_fonts,
            'priority'              => 5,
            'active_callback'       => ''
        )
    );

$expedition_settings_controls['expedition-font-family-site-identity'] =
    array(
        'setting' =>     array(
            'default'              => $expedition_customizer_defaults['expedition-font-family-site-identity'],
            
        ),
        'control' => array(
            'label'                 => __( 'Site Identity/Logo', 'expedition' ),
            'description'           => __( 'Site Identity font family', 'expedition' ),
            'section'               => 'expedition-family',
            'type'                  => 'select',
            'choices'               => $expedition_google_fonts,
            'priority'              => 10,
            'active_callback'       => ''
        )
    );
