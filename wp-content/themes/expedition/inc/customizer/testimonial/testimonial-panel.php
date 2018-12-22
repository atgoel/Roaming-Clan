<?php
global $expedition_panels;
/*creating panel for fonts-setting*/
$expedition_panels['expedition-home-testimonial'] =
    array(
        'title'          => __( 'Home/Front Testimonial Section', 'expedition' ),
        'priority'       => 175
    );
/*enable testimonial options */
require get_template_directory().'/inc/customizer/testimonial/enable-testimonial.php';

/*testimonial selection from category options */
require get_template_directory().'/inc/customizer/testimonial/from-category.php';

/*testimonial options */
require get_template_directory().'/inc/customizer/testimonial/testimonial-options.php';
