<?php
global $expedition_panels;
/*creating panel for fonts-setting*/
$expedition_panels['expedition-theme-options'] =
    array(
        'title'          => __( 'Theme Options', 'expedition' ),
        'priority'       => 200
    );

/*layout options */
require get_template_directory().'/inc/customizer/theme-options/layout-options.php';

/*footer options */
require get_template_directory().'/inc/customizer/theme-options/footer.php';

/*header options */
require get_template_directory().'/inc/customizer/theme-options/header.php';

/*Breadcrumb section */
require get_template_directory().'/inc/customizer/theme-options/breadcrumb.php';

/*Back to top */
require get_template_directory().'/inc/customizer/theme-options/back-to-top.php';

/*custom css options */
require get_template_directory().'/inc/customizer/theme-options/custom-css.php';

/*search selection for slider section */
require get_template_directory().'/inc/customizer/theme-options/search-options.php';
