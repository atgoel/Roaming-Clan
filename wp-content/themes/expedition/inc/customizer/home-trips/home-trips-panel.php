<?php
global $expedition_panels;
/*creating panel for populat trip setting*/
$expedition_panels['expedition-popular-trip-panel'] =
    array(
        'title'          => __( 'Home/Front Popular Trip', 'expedition' ),
        'priority'       => 160
    );


/*popular trip section enable control */
require get_template_directory().'/inc/customizer/home-trips/enable-trip-section.php';

/*popular trip section settings and controlls */
require get_template_directory().'/inc/customizer/home-trips/settings-trip-section.php';

/*popular trip selection from category controlls */
require get_template_directory().'/inc/customizer/home-trips/trips-from-category.php';
