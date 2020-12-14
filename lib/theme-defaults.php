<?php
/**
 * RWC Base.
 *
 * This file adds the default theme settings to the RWC Base Theme.
 *
 * @package RWC Base
 * @author  Road Warrior Creative
 * @license GPL-2.0-or-later
 * @link    https://roadwarriorcreative.com/
 */

add_filter( 'simple_social_default_styles', 'rwc_base_social_default_styles' );
/**
 * Set Simple Social Icon defaults.
 *
 * @since 1.0.0
 *
 * @param array $defaults Social style defaults.
 * @return array Modified social style defaults.
 */
function rwc_base_social_default_styles( $defaults ) {

	$args = array(
		'alignment'              => 'alignleft',
		'background_color'       => '#f5f5f5',
		'background_color_hover' => '#333333',
		'border_radius'          => 3,
		'border_width'           => 0,
		'icon_color'             => '#333333',
		'icon_color_hover'       => '#ffffff',
		'size'                   => 40,
	);

	$args = wp_parse_args( $args, $defaults );

	return $args;

}

add_action( 'after_setup_theme', 'genesis_child_gutenberg_support' );
/**
 * Adds Gutenberg opt-in features and styling.
 *
 * @since 2.7.0
 */
function genesis_child_gutenberg_support() { // phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedFunctionFound -- using same in all child themes to allow action to be unhooked.
	require_once get_stylesheet_directory() . '/lib/gutenberg/init.php';
}

add_action( 'wp_enqueue_scripts', 'rwc_base_enqueue_scripts_styles' );
/**
 * Enqueues scripts and styles.
 *
 * @since 1.0.0
 */
function rwc_base_enqueue_scripts_styles() {

	wp_enqueue_style(
		'rwc-base-fonts',
		'//fonts.googleapis.com/css?family=Source+Sans+Pro:400,400i,600,700',
		array(),
		CHILD_THEME_VERSION
	);

	wp_enqueue_style( 'dashicons' );

	wp_enqueue_style(
		'rwc-font-awesome',
		'https://use.fontawesome.com/releases/v5.7.0/css/all.css',
		array(),
		CHILD_THEME_VERSION
	);

	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '-min';
	wp_enqueue_script(
		'rwc-base-responsive-menu',
		get_stylesheet_directory_uri() . "/assets/js/responsive-menus{$suffix}.js",
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

	wp_localize_script(
		'rwc-base-responsive-menu',
		'genesis_responsive_menu',
		rwc_base_responsive_menu_settings()
	);

	wp_enqueue_script(
		'rwc-base',
		get_stylesheet_directory_uri() . '/assets/js/rwc-base.js',
		array( 'jquery' ),
		CHILD_THEME_VERSION,
		true
	);

}

// Adds image sizes.
add_image_size( 'sidebar-featured', 75, 75, true );
add_image_size( 'medium-square', 300, 300, true );

// Make custom sizes selectable from WordPress admin.
function custom_image_sizes( $size_names ) {
	$new_sizes = array(
		'medium-square' => __( 'Medium Square'),
	);
	return array_merge( $size_names, $new_sizes );
}
add_filter( 'image_size_names_choose', 'custom_image_sizes' );

/*
Add excerpt to pages
*/
add_post_type_support( 'page', 'excerpt' );

// Enable support for custom header image or video.
add_theme_support( 'custom-header', array(
	'header-selector'    => '.hero-section',
	'default-image'      => get_stylesheet_directory_uri() . '/assets/images/hero.jpg',
	'header-text'        => true,
	'default-text-color' => '#2a3139',
	'width'              => 1280,
	'height'             => 720,
	'flex-height'        => true,
	'flex-width'         => true,
	'uploads'            => true,
	'video'              => true,
	'wp-head-callback'   => 'rwc_base_custom_header',
) );

/**
 * Generate custom search form
 *
 * @param string $form Form HTML.
 * @return string Modified form HTML.
 */
function rwc_my_search_form( $form ) {
    $form = '<form class="search-form" role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
    <div>
    <label class="screen-reader-text" for="s">' . __( 'Search for:' ) . '</label>
    <input class="search-form-input" type="search" value="' . get_search_query() . '" name="s" id="s" />
    <input class="search-form-submit" type="submit" id="searchsubmit" value="'. esc_attr__( 'Search' ) .'" />
    </div>
    </form>';
 
    return $form;
}
add_filter( 'get_search_form', 'rwc_my_search_form' );

// Custom Template Redirects
/*function rwc_custom_redirects() {
 
	if ( is_front_page() ) {
		wp_redirect( home_url( '/dashboard/' ) );
		die;
	}

	if ( is_page('contact') ) {
		wp_redirect( home_url( '/new-contact/' ) );
		die;
	}
 
}
add_action( 'template_redirect', 'rwc_custom_redirects' );*/
