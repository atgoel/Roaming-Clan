<?php
/**
 * @package WordPress
 * @subpackage KLEO
 * @author SeventhQueen <themesupport@seventhqueen.com>
 * @since 1.6
 */

/* Dynamic styles */
require_once( KLEO_LIB_DIR . '/plugin-buddypress/dynamic.php' );

if ( bp_is_active('notifications') ) {
    require_once( KLEO_LIB_DIR . '/plugin-buddypress/menu-notifications.php' );
}

if ( bp_is_active('messages') ) {
	require_once( KLEO_LIB_DIR . '/plugin-buddypress/menu-messages.php' );
}


/***************************************************
:: Catch AJAX requests
 ***************************************************/

add_action( 'wp_ajax_kleo_bp_ajax_call', 'kleo_bp_ajax_call' );

function kleo_bp_ajax_call() {
	
	$response = array();
	$response = apply_filters( 'kleo_bp_ajax_call', $response );
	
	if ( ! empty( $response ) ) {
		echo json_encode( $response );
	}
	exit;
}

/* Localize refresh interval to JavaScript app.js */
add_filter( 'kleo_localize_app', 'kleo_bp_notif_refresh_int' );
function kleo_bp_notif_refresh_int( $data ) {
	$data['bpAjaxRefresh'] = sq_option( 'bp_notif_interval', 20000 );
	
	return $data;
}

/* BuddyPress Avatar in menu item */
add_filter('kleo_nav_menu_items', 'kleo_add_user_avatar_nav_item' );
function kleo_add_user_avatar_nav_item( $menu_items ) {
    $menu_items[] = array(
        'name' => __( 'My Account', 'kleo_framework' ),
        'slug' => 'user_avatar',
        'link' => '#',
    );

    return $menu_items;
}

add_filter('kleo_setup_nav_item_user_avatar' , 'kleo_setup_user_avatar_nav');
function kleo_setup_user_avatar_nav( $menu_item ) {

    add_filter( 'walker_nav_menu_start_el_user_avatar', 'kleo_menu_user_avatar', 10, 4 );
    add_filter( 'walker_nav_menu_start_el_li_user_avatar', 'kleo_menu_user_avatar_li', 10, 4 );

    return $menu_item;
}
if ( ! function_exists( 'kleo_menu_user_avatar' ) ) {
    /**
     * Render user avatar menu item
     *
     * @param string $item_output
     * @param  array $item
     * @param  integer $depth
     * @param  object $args
     * @return string
     */
    function kleo_menu_user_avatar( $item_output, $item, $depth, $args ) {

        $output = '';

        if ( is_user_logged_in() ) {

            $url = bp_loggedin_user_domain();

            $attr_title = strip_tags( $item->attr_title );
            $output .= '<a title="' . bp_get_loggedin_user_fullname() . '" class="kleo-bp-user-avatar' . ( $args->has_children && in_array($depth, array(0,1)) ? ' js-activated' : '' ) . '" href="' . $url . '" title="' . $attr_title .'">'
                .  '<img src="' . esc_attr( bp_get_loggedin_user_avatar(array('width' => 25, 'height' => 25, 'html' => false)) ) . '" class="kleo-rounded" alt="">' . ($item->attr_title != '' ? ' ' . $item->attr_title : '');

            $output .= ( $args->has_children && in_array($depth, array(0,1))) ? ' <span class="caret"></span></a>' : '</a>';

            return $output;
        } elseif ( $args->has_children && in_array( $depth, array( 0, 1 ) ) ) {
            return $item_output;
        } else {
            return '';
        }
    }
}

function kleo_menu_user_avatar_li( $item_output, $item, $depth, $args ) {
    $output = '';
    if ( is_user_logged_in() || ($args->has_children && in_array( $depth, array( 0, 1 ) )) ) {
        $output = $item_output;
    }
    return $output;
}



/* Fix for members search form placeholder */
add_filter( 'bp_directory_members_search_form', 'kleo_bp_fix_members_placeholder' );

function kleo_bp_fix_members_placeholder( $html ) {
    if ( isset($_GET['s']) && $_GET['s'] != '' ) {
        $html = str_replace('placeholder', 'value', $html);
    }

    return $html;
}



/* Display BuddyPress Member Types Filters in Members Directory */

add_action( 'bp_members_directory_member_types', 'kleo_bp_member_types_tabs' );
function kleo_bp_member_types_tabs() {
    if( ! bp_get_current_member_type() ){
        $member_types = bp_get_member_types( array(), 'objects' );
        if( $member_types ) {
            foreach ( $member_types as $member_type ) {
                if ( $member_type->has_directory == 1 ) {
                    echo '<li id="members-' . esc_attr($member_type->name) . '" class="bp-member-type-filter">';
                    echo '<a href="' . bp_get_members_directory_permalink() . 'type/' . $member_type->directory_slug . '/">' . sprintf('%s <span>%d</span>', $member_type->labels['name'], kleo_bp_count_member_types($member_type->name)) . '</a>';
                    echo '</li>';
                }
            }
        }
    }
}



add_filter( 'bp_modify_page_title', 'kleo_bp_members_type_directory_page_title', 9, 4 );
function kleo_bp_members_type_directory_page_title( $title, $original_title, $sep, $seplocation  ) {
    $member_type = bp_get_current_member_type();
    if( bp_is_directory() && $member_type ){
        $member_type = bp_get_member_type_object( $member_type );
        if( $member_type ) {
            global $post;
            $post->post_title = $member_type->labels['name'];
            $title = $member_type->labels['name'] . " " . $sep . " " . $original_title;
        }
    }
    return $title;
}



add_filter( 'bp_get_total_member_count', 'kleo_bp_get_total_member_count_member_type' );
function kleo_bp_get_total_member_count_member_type(){
    $count = bp_core_get_active_member_count();
    $member_type = bp_get_current_member_type();
    if( bp_is_directory() && $member_type ){
        $count = kleo_bp_count_member_types( $member_type );
    }
    return $count;
}



add_filter( 'bp_get_total_friend_count', 'kleo_bp_get_total_friend_count_member_type' );
function kleo_bp_get_total_friend_count_member_type(){
    $user_id = get_current_user_id();
    $count = friends_get_total_friend_count( $user_id );
    $member_type = bp_get_current_member_type();
    if( bp_is_directory() && $member_type ){
        global $bp, $wpdb;
        $friends =  $wpdb->get_results("SELECT count(1) as count FROM {$bp->friends->table_name} bpf
        LEFT JOIN {$wpdb->term_relationships} tr ON (bpf.initiator_user_id = tr.object_id || bpf.friend_user_id = tr.object_id )
        LEFT JOIN {$wpdb->terms} t ON t.term_id = tr.term_taxonomy_id
        WHERE t.slug = '" . $member_type . "' AND (bpf.initiator_user_id = $user_id || bpf.friend_user_id = $user_id ) AND tr.object_id != $user_id AND bpf.is_confirmed = 1", ARRAY_A);
        $count = 0;
        if( isset( $friends['0']['count'] ) && is_numeric( $friends['0']['count'] ) ){
            $count = $friends['0']['count'];
        }
    }
    return $count;
}



function kleo_bp_count_member_types( $member_type = '' ) {
    if ( ! bp_is_root_blog() ) {
        switch_to_blog( bp_get_root_blog_id() );
    }
    global $wpdb;
    $sql = array(
        'select' => "SELECT t.slug, tt.count FROM {$wpdb->term_taxonomy} tt LEFT JOIN {$wpdb->terms} t",
        'on'     => 'ON tt.term_id = t.term_id',
        'where'  => $wpdb->prepare( 'WHERE tt.taxonomy = %s', 'bp_member_type' ),
    );
    $members_count = $wpdb->get_results( join( ' ', $sql ) );
    $members_count = wp_filter_object_list( $members_count, array( 'slug' => $member_type ), 'and', 'count' );
    $members_count = array_values( $members_count );
    if( isset( $members_count[0] ) && is_numeric( $members_count[0] ) ) {
        $members_count = $members_count[0];
    }else{
        $members_count = 0;
    }
    restore_current_blog();
    return $members_count;
}



add_filter( 'bp_before_has_members_parse_args', 'kleo_bp_set_has_members_type_arg', 10, 1 );
function kleo_bp_set_has_members_type_arg( $args ) {
    $member_type = bp_get_current_member_type();
    $member_types = bp_get_member_types(array(), 'names');
    if ( isset( $args['scope'] ) && !isset( $args['member_type'] ) && in_array( $args['scope'], $member_types ) ) {
        if( $member_type ) {
            unset( $args['scope'] );
        }else{
            $args['member_type'] = $args['scope'];
        }
    }
    return $args;
}

add_action( 'bp_before_member_header_meta', 'kleo_bp_profile_member_type_label' );
function kleo_bp_profile_member_type_label() {
    $member_type = bp_get_member_type( bp_displayed_user_id() );
    if ( empty( $member_type ) ) {
        return;
    }
    $member_type_object = bp_get_member_type_object( $member_type );
    if($member_type_object){
        $member_type_label = '<p class="kleo_bp_profile_member_type_label">' . esc_html( $member_type_object->labels['singular_name'] ) . '</p>';
        echo apply_filters('kleo_bp_profile_member_type_label', $member_type_label);
    }
}


/* Get current Buddypress page */
function kleo_bp_get_page_id() {
    $current_page_id = NULL;
    $page_array = get_option('bp-pages');

    if (bp_is_register_page()) { /* register page */
        $current_page_id = $page_array['register'];
    } elseif( bp_is_members_directory() ) { /* members directory */
        $current_page_id = $page_array['members'];
    } elseif ( bp_is_activity_directory() ) { /* activity directory */
        $current_page_id = $page_array['activity'];
    } elseif ( bp_is_groups_directory() ) { /* groups directory */
        $current_page_id = $page_array['groups'];
    } elseif ( bp_is_activation_page() ) { /* activation page */
        $current_page_id = $page_array['activate'];
    }
    return $current_page_id;
}


/* Get current Buddypress page */
function kleo_bp_get_component_id() {
    $current_page_id = NULL;
    $page_array = get_option('bp-pages');

    if (bp_is_register_page()) { /* register page */
        $current_page_id = $page_array['register'];
    } elseif( bp_is_members_component() || bp_is_user() ) { /* members component */
        $current_page_id = $page_array['members'];
    } elseif ( bp_is_activity_directory() ) { /* activity directory */
        $current_page_id = $page_array['activity'];
    } elseif ( bp_is_groups_directory() || bp_is_group_single() ) { /* groups directory */
        $current_page_id = $page_array['groups'];
    } elseif ( bp_is_activation_page() ) { /* activation page */
        $current_page_id = $page_array['activate'];
    }
    return $current_page_id;
}


function kleo_bp_header() {

    $current_page_id = kleo_bp_get_page_id();
    if ( ! $current_page_id ) {
        return;
    }

    $page_header = get_cfield( 'header_content', $current_page_id );
    if( $page_header != '' ) {
        echo '<section class="kleo-bp-header container-wrap main-color">';
        echo do_shortcode( html_entity_decode($page_header) );
        echo '</section>';
    }
}



function kleo_bp_bottom() {

    $current_page_id = kleo_bp_get_page_id();
    if ( ! $current_page_id ) {
        return;
    }

    $page_bottom = get_cfield( 'bottom_content', $current_page_id );
    if( $page_bottom != '' ) {
        echo '<section class="kleo-bp-bottom">';
        echo do_shortcode( $page_bottom );
        echo '</section>';
    }
}


if ( ! function_exists( 'kleo_bp_page_options' ) ) {
    /**
     * Set Buddypress page layout based of individual page settings
     */
    function kleo_bp_page_options() {

        $current_page_id = kleo_bp_get_page_id();

        if ( ! $current_page_id ) {
            return false;
        }

        $topbar_status = get_cfield('topbar_status', $current_page_id);
        //Top bar
        if (isset($topbar_status)) {
            if ($topbar_status === '1') {
                add_filter( 'kleo_show_top_bar', function() { return 1; } );
            } elseif ($topbar_status === '0') {
                add_filter( 'kleo_show_top_bar', '__return_zero' );
            }
        }
        //Header and Footer settings
        if (get_cfield('hide_header', $current_page_id) == 1) {
            remove_action('kleo_header', 'kleo_show_header');
        }
        if (get_cfield('hide_footer', $current_page_id) == 1) {
            add_filter('kleo_footer_hidden', '__return_true' );
        }
        if (get_cfield('hide_socket', $current_page_id) == 1) {
            remove_action('kleo_after_footer', 'kleo_show_socket');
        }

        //Custom logo
        if (get_cfield('logo', $current_page_id)) {
            global $kleo_custom_logo;
            $kleo_custom_logo = get_cfield('logo', $current_page_id);
	        add_filter('kleo_logo', function() use ( $kleo_custom_logo ) {
		        return $kleo_custom_logo;
	        });
        }

        //Transparent menu
        if (get_cfield('transparent_menu', $current_page_id)) {
	        add_filter( 'body_class', function( $classes ) {
		        $classes[] = 'navbar-transparent';
		        return $classes;
	        });
        }

        //Remove shop icon
        if (get_cfield('hide_shop_icon', $current_page_id) && get_cfield('hide_shop_icon', $current_page_id) == 1) {
            remove_filter('wp_nav_menu_items', 'kleo_woo_header_cart', 9);
            remove_filter('kleo_mobile_header_icons', 'kleo_woo_mobile_icon', 10);
        }
        //Remove search icon
        if (get_cfield('hide_search_icon', $current_page_id) && get_cfield('hide_search_icon', $current_page_id) == 1) {
            remove_filter('wp_nav_menu_items', 'kleo_search_menu_item', 200, 2);
        }
    }
}

if ( bp_is_blog_page() ) {
	add_filter( 'body_class', 'kleo_bp_body_classes' );
}

function kleo_bp_body_classes( $classes = array() ) {
	if ( 'light' == sq_option( 'bp_icons_style', 'normal' ) ) {
		//check if on group or on profile page
		if ( bp_is_user() || ( bp_is_single_item() && bp_is_groups_component() ) ) {
			$classes[] = 'bp-light-icons';
		}
	}
	
	if ( sq_option( 'bp_nav_overlay', 0 ) == 1 ) {
		$classes[] = 'bp-overlay-menu';
	}

	return $classes;
}


function kleo_bp_set_custom_menu( $args = '' ) {

	if ( 'primary' != $args['theme_location'] && 'secondary' != $args['theme_location'] ) {
		return $args;
	}

    $page_id = kleo_bp_get_component_id();

    if( $page_id ) {

	    if ( 'primary' == $args['theme_location'] ) {
		    $menuslug = get_cfield( 'page_menu', $page_id );

		    if ( ! empty( $menuslug ) && $menuslug != 'default' && is_nav_menu( $menuslug ) ) {
			    $args['menu'] = $menuslug;
		    }

	    } elseif ( 'secondary' == $args['theme_location'] ) {

		    $sec_menuslug = get_cfield( 'page_menu_secondary', $page_id );

		    if ( ! empty( $sec_menuslug ) && $sec_menuslug != 'default' && is_nav_menu( $sec_menuslug ) ) {
			    $args['menu'] = $sec_menuslug;
		    }

        }

    }

    return $args;
} // END function kleo_set_custom_menu($args = '')



if ( ! function_exists( 'bp_groups_front_template_part' ) ) {
    /**
     * Output the contents of the current group's home page.
     *
     * You should only use this when on a single group page.
     *
     * @since 2.4.0
     */
    function bp_groups_front_template_part()
    {
        $located = bp_groups_get_front_template();

        if (false !== $located) {
            $slug = str_replace('.php', '', $located);

            /**
             * Let plugins adding an action to bp_get_template_part get it from here
             *
             * @param string $slug Template part slug requested.
             * @param string $name Template part name requested.
             */
            do_action('get_template_part_' . $slug, $slug, false);

            load_template($located, true);

        } else if (bp_is_active('activity')) {
            bp_get_template_part('groups/single/activity');

        } else if (bp_is_active('members')) {
            bp_groups_members_template_part();
        }

        return $located;
    }
}



/* Buddypress cover compatibility */

function kleo_bp_cover_image_css( $settings = array() ) {
    /**
     * If you are using a child theme, use bp-child-css
     * as the theme handel
     */
    $theme_handle = 'bp-parent-css';

    $settings['theme_handle'] = $theme_handle;
    $settings['width']  = 1400;
    $settings['height'] = 440;

    /**
     * Then you'll probably also need to use your own callback function
     * @see the previous snippet
     */
    //$settings['callback'] = 'your_theme_cover_image_callback';


    return $settings;
}
add_filter( 'bp_before_xprofile_cover_image_settings_parse_args', 'kleo_bp_cover_image_css', 10, 1 );
add_filter( 'bp_before_groups_cover_image_settings_parse_args', 'kleo_bp_cover_image_css', 10, 1 );


function kleo_bp_cover_html() {

    if( ! bp_displayed_user_use_cover_image_header() ) {
        return;
    }

    global $bp;

    $output = '<div class="profile-cover-inner"></div>';

    if ( bp_is_my_profile() || is_super_admin() ) {

        $output .= '<div class="profile-cover-action">';
        $output .= '<a href="' . bp_displayed_user_domain() . $bp->profile->slug . '/change-cover-image/" class="button">' . __( "Change Cover", "kleo_framework" ) . '</a>';
        $output .= '</div>';
    }

    echo $output;
}

function kleo_bp_group_cover_html() {

    if ( ! bp_group_use_cover_image_header() ) {
        return;
    }

	$output = '<div class="profile-cover-inner"></div>';

    if ( is_user_logged_in() ) {

        $user_ID = get_current_user_id();
        $group_id = bp_get_current_group_id();

        if (groups_is_user_mod($user_ID, $group_id) || groups_is_user_admin($user_ID, $group_id)) {

            $message = __("Change Cover", 'bpcp');

            $group = groups_get_group( array( 'group_id' => $group_id ) );
            $group_permalink = trailingslashit(bp_get_root_domain() . '/' . bp_get_groups_root_slug() . '/' . $group->slug . '/');


            $output .= '<div class="profile-cover-action">';
            $output .= '<a href="' . trailingslashit($group_permalink . 'admin/group-cover-image') . '" class="button">' . $message . '</a>';
            $output .= '</div>';
        }
    }

    echo $output;
}

if ( version_compare( BP_VERSION, '2.4', '>=' ) ) {
    add_action('bp_before_member_header', 'kleo_bp_cover_html', 20);
    add_action('bp_before_group_header', 'kleo_bp_group_cover_html', 20);
}

/* BP DOCS compatibility */
add_filter( 'bp_docs_allow_comment_section', '__return_true', 100 );



/* Remove shortcodes from activity view */
add_filter( 'bp_get_activity_content_body','kleo_bp_activity_filter', 1 );
function kleo_bp_activity_filter( $content ) {
    $content = preg_replace("/\[(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?/s",'', $content);
    return $content;
}

/* BuddyPress 3.0 compat */
if ( 'legacy' !== get_option( '_bp_theme_package_id' ) && false == apply_filters( 'bp_30_disable_compat', false ) ) {
	update_option( '_bp_theme_package_id', 'legacy' );
}


add_action( 'init', function() {
	if ( bp_is_user() && sq_option('bp_profile_sidebar') ) {
		add_filter( 'kleo_sidebar_name', function() {
			return sq_option( 'bp_profile_sidebar' );
		});
	}
	if ( bp_is_group() && sq_option('bp_group_sidebar') ) {
		add_filter( 'kleo_sidebar_name', function() {
			return sq_option( 'bp_group_sidebar' );
		});
	}

});
