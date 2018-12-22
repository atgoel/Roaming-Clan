<?php
/**
 * evision themes init file
 *
 * @package eVision themes
 * @subpackage expedition
 * @since expedition 0.0.2
 */

/**
 * Customizer additions.
 */
require get_template_directory().'/inc/customizer/customizer.php';

/**
 * Include Functions
 */

require get_template_directory().'/inc/function/words-count.php';

require get_template_directory().'/inc/function/breadcrumb.php';

require get_template_directory() . '/inc/function/header-logo.php';

/**
* Include sidebar widgets
*/
require get_template_directory().'/inc/sidebar-widget-init.php';

/**
 * Include Hooks
 */

 require get_template_directory().'/inc/hooks/wp-head.php';

 require get_template_directory().'/inc/hooks/header.php';
 
 require get_template_directory().'/inc/hooks/footer.php';

 require get_template_directory().'/inc/hooks/front-page.php';
 
 require get_template_directory().'/inc/hooks/homepage-slider.php';
 
 require get_template_directory().'/inc/hooks/homepage-popular-trip.php';

 require get_template_directory().'/inc/hooks/homepage-about-testimonial.php';
 
 require get_template_directory().'/inc/hooks/homepage-about.php';
 
 require get_template_directory().'/inc/hooks/homepage-testimonial.php';
 
 require get_template_directory().'/inc/hooks/homepage-blog.php';
 
 require get_template_directory().'/inc/hooks/excerpt.php';
 
 require get_template_directory().'/inc/hooks/init.php';

