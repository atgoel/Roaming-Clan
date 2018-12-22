<?php
/*
Plugin Name: Goels' Slider
URI: https://1stwebdesigner.com/wordpress-plugin-development/#plugin-basic-template
Description: Slider Test
*/

function goel_slider_activation() {
	
}
register_activation_hook(__FILE__, 'goel_slider_activation');
function goel_slider_deactivation() {
	
}
register_deactivation_hook(__FILE__, 'goel_slider_deactivation');

/*
add_action('wp_enqueue_scripts', 'goel_scripts');

function goel_scripts(){
	
	wp_enqueue_scripts('jquery');
	wp_register_script('slidesjs_core', plugins_url('js/jquery.slides.min.js', __FILE__),array("jquery"));
    wp_enqueue_script('slidesjs_core');

wp_register_script('slidesjs_init', plugins_url('js/slidesjs.initialize.js', __FILE__));
wp_enqueue_script('slidesjs_init');

}
*/

add_action('wp_enqueue_scripts', 'fwds_styles');
function fwds_styles() {

wp_register_style('slidesjs_example', plugins_url('css/example.css', __FILE__));
wp_enqueue_style('slidesjs_example');
wp_register_style('slidesjs_fonts', plugins_url('css/font-awesome.min.css', __FILE__));
wp_enqueue_style('slidesjs_fonts');

}

add_shortcode("goel_slider", "goel_display_slider");
function goel_display_slider() {

$plugins_url = plugins_url();

echo '<div class="container">
  <div id="slides">
    <img src="'.plugins_url( 'img/example-slide-1.jpg' , __FILE__ ).'" />
    <img src="'.plugins_url( 'img/example-slide-2.jpg' , __FILE__ ).'" />
    <img src="'.plugins_url( 'img/example-slide-3.jpg' , __FILE__ ).'" />
    <img src="'.plugins_url( 'img/example-slide-4.jpg' , __FILE__ ).'" />
    <a href="#" class="slidesjs-previous slidesjs-navigation"><i class="icon-chevron-left icon-large"></i></a>
    <a href="#" class="slidesjs-next slidesjs-navigation"><i class="icon-chevron-right icon-large"></i></a>
  </div>
</div>';
}
?>