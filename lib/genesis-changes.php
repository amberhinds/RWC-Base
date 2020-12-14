<?php

// Adds support for HTML5 markup structure.
add_theme_support( 'html5', genesis_get_config( 'html5' ) );

// Adds support for accessibility.
add_theme_support( 'genesis-accessibility', genesis_get_config( 'accessibility' ) );

// Adds viewport meta tag for mobile browsers.
add_theme_support( 'genesis-responsive-viewport' );

// Adds custom logo in Customizer > Site Identity.
add_theme_support( 'custom-logo', genesis_get_config( 'custom-logo' ) );

//* Enable the superfish script
add_filter( 'genesis_superfish_enabled', '__return_true' );

// Renames primary and secondary navigation menus.
add_theme_support( 'genesis-menus', genesis_get_config( 'menus' ) );

// Adds support for after entry widget.
add_theme_support( 'genesis-after-entry-widget-area' );

// Adds support for 3-column footer widgets.
add_theme_support( 'genesis-footer-widgets', 3 );

// Removes header right widget area.
unregister_sidebar( 'header-right' );

// Removes secondary sidebar.
unregister_sidebar( 'sidebar-alt' );

// Displays custom logo.
add_action( 'genesis_site_title', 'the_custom_logo', 0 );

// Removes site layouts.
genesis_unregister_layout( 'content-sidebar-sidebar' );
genesis_unregister_layout( 'sidebar-content-sidebar' );
genesis_unregister_layout( 'sidebar-sidebar-content' );

//* Remove Genesis menu link
remove_theme_support( 'genesis-admin-menu' );

//* Display author box on single posts
add_filter( 'get_the_author_genesis_author_box_single', '__return_true' );

// Register above header widget area.
genesis_register_sidebar( array(
 'id' => 'above-header',
 'name' => __( 'Above Header', 'rwc-base' ),
 'description' => __( 'Above header widget area.', 'rwc-base' ),
));

add_action( 'genesis_before_header', 'above_header' );
/**
* Add above header widget area.
*/
function above_header(){
	genesis_widget_area( 'above-header', array(
		'before' => '<div class="above-header">',
		'after' => '</div>',
	));
}

add_filter( 'genesis_author_box_gravatar_size', 'rwc_base_author_box_gravatar' );
/**
 * Modifies size of the Gravatar in the author box.
 *
 * @since 2.2.3
 *
 * @param int $size Original icon size.
 * @return int Modified icon size.
 */
function rwc_base_author_box_gravatar( $size ) {

	return 90;

}

add_filter( 'genesis_comment_list_args', 'rwc_base_comments_gravatar' );
/**
 * Modifies size of the Gravatar in the entry comments.
 *
 * @since 2.2.3
 *
 * @param array $args Gravatar settings.
 * @return array Gravatar settings with modified size.
 */
function rwc_base_comments_gravatar( $args ) {

	$args['avatar_size'] = 60;
	return $args;

}

add_filter("get_avatar" , "disable_comment_avatar" , 1, 5);
/**
* Disable avatars on comments only
*/
function disable_comment_avatar($avatar, $id_or_email, $size, $default, $alt){
	global $in_comment_loop;
	if(isset($in_comment_loop)){
		if($in_comment_loop == true){
			return;
		}
		else{
			return $avatar;
		}
	}
	else{
		return $avatar;
	}
}

//* Add post navigation (requires HTML5 theme support)
add_action( 'genesis_entry_footer', 'genesis_prev_next_post_nav' );

//* Change the footer text
add_filter('genesis_pre_get_option_footer_text', 'rwc_base_footer_creds_filter');
function rwc_base_footer_creds_filter( $creds ) {
	$creds = '[footer_copyright] ' . get_bloginfo( 'name' ) . ' &middot; Website by <a href="https://roadwarriorcreative.com/?utm_source=client_website" title="Road Warrior Creative" rel="nofollow" target="_blank">Road Warrior Creative</a>';
	return $creds;
}

add_action( 'genesis_theme_settings_metaboxes', 'rwc_base_remove_metaboxes' );
/**
 * Removes output of unused admin settings metaboxes.
 *
 * @since 2.6.0
 *
 * @param string $_genesis_admin_settings The admin screen to remove meta boxes from.
 */
function rwc_base_remove_metaboxes( $_genesis_admin_settings ) {

	remove_meta_box( 'genesis-theme-settings-header', $_genesis_admin_settings, 'main' );
	remove_meta_box( 'genesis-theme-settings-nav', $_genesis_admin_settings, 'main' );

}

add_filter( 'genesis_customizer_theme_settings_config', 'rwc_base_remove_customizer_settings' );
/**
 * Removes output of header and front page breadcrumb settings in the Customizer.
 *
 * @since 2.6.0
 *
 * @param array $config Original Customizer items.
 * @return array Filtered Customizer items.
 */
function rwc_base_remove_customizer_settings( $config ) {

	unset( $config['genesis']['sections']['genesis_header'] );
	unset( $config['genesis']['sections']['genesis_breadcrumbs']['controls']['breadcrumb_front_page'] );
	return $config;

}

add_action( 'genesis_entry_content', 'rwc_show_featured_image_single_posts', 9 );
/**
* Display Featured Image in single Posts.
*
*/
function rwc_show_featured_image_single_posts() {
		if ( ! is_singular( 'post' ) ) {
			return;
		}

		$image_args = array(
				'size' => 'large',
				'attr' => array(
				'class' => 'aligncenter',
			),
		);

		genesis_image( $image_args );
}

/**
* Use H1 for site title on home page
*/
function rwc_site_title_h1_home_page( $wrap ) {
	return is_front_page() ? 'h1' : $wrap;
}
add_filter( 'genesis_site_title_wrap', 'rwc_site_title_h1_home_page' );

//* Move featured image above entry title in archives.
/*remove_action( 'genesis_entry_content', 'genesis_do_post_image', 8 );
add_action( 'genesis_entry_header', 'genesis_do_post_image', 8 );*/


//add_action('genesis_before_loop', 'rwc_custom_testimonial_loop');
/*
 * Custom testimonial archive loop.
 */
function rwc_custom_testimonial_loop() {
	if ( ! is_post_type_archive('testimonial') ) {
		return;
	}

	/** Replace the home loop with our custom **/
	remove_action( 'genesis_loop', 'genesis_do_loop' );
	add_action( 'genesis_loop', 'rwc_custom_loop' );

	/** Custom  loop **/
	function rwc_custom_loop() {

	}

}


//add_action('genesis_before_loop', 'rwc_custom_testimonial_single');
/*
 * Custom Testimonial Single.
 */
function rwc_custom_testimonial_single() {
	if ( ! is_singular('testimonial') ) {
		return;
	}

	// Remove Actions
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
	remove_action( 'genesis_entry_content', 'genesis_do_post_content' );
	remove_action( 'genesis_entry_footer', 'genesis_post_meta' );

	// Add Actions
	add_action('genesis_entry_header', 'rwc_custom_entry_header');
	add_action( 'genesis_entry_content', 'rwc_custom_entry_content' );
	add_action( 'genesis_entry_footer', 'rwc_custom_entry_footer' );
	
	// Entry Header
	function rwc_custom_entry_header() {
	}

	// Entry Content
	function rwc_custom_entry_content(){
	}

	// Entry Footer
	function rwc_custom_entry_footer(){
	}

}

?>