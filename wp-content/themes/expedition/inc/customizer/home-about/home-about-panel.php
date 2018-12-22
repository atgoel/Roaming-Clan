<?php
global $expedition_panels;
/*creating panel for About Section setting*/
$expedition_panels['expedition-home-about-panel'] =
    array(
        'title'          => __( 'Home/Front About Section', 'expedition' ),
        'priority'       => 170
    );


/*about section enable control */
require get_template_directory().'/inc/customizer/home-about/enable-about-section.php';

/*about selection button controlls */
require get_template_directory().'/inc/customizer/home-about/about-button-section.php';