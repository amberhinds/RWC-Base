<?php
/**
 * RWC Base.
 *
 * This file adds navigation functions.
 *
 * @package RWC Base
 * @author  Road Warrior Creative
 * @license GPL-2.0-or-later
 * @link    https://roadwarriorcreative.com/
 */

// Repositions primary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_nav' );
add_action( 'genesis_header', 'genesis_do_nav', 12 );

// Removes output of primary navigation right extras.
remove_filter( 'genesis_nav_items', 'genesis_nav_right', 10, 2 );
remove_filter( 'wp_nav_menu_items', 'genesis_nav_right', 10, 2 );

add_filter( 'wp_nav_menu_items', 'theme_menu_extras', 10, 2 );
/**
 * Filter menu items, appending either a search form or today's date.
 *
 * @param string   $menu HTML string of list items.
 * @param stdClass $args Menu arguments.
 *
 * @return string Amended HTML string of list items.
 */
function theme_menu_extras( $menu, $args ) {
	//* Change 'primary' to 'secondary' to add extras to the secondary navigation menu
	if ( 'primary' !== $args->theme_location )
		return $menu;
	ob_start();
	get_search_form();
	$search = ob_get_clean();
	$menu  .= '<li class="menu-item search"><a href="#" class="search-toggle"><i class="fas fa-search"></i></a>' . $search . '</li>';
	return $menu;
}

// Repositions the secondary navigation menu.
remove_action( 'genesis_after_header', 'genesis_do_subnav' );
add_action( 'genesis_footer', 'genesis_do_subnav', 5 );

add_filter( 'wp_nav_menu_args', 'rwc_base_secondary_menu_args' );
/**
 * Reduces secondary navigation menu to one level depth.
 *
 * @since 2.2.3
 *
 * @param array $args Original menu options.
 * @return array Menu options with depth set to 1.
 */
function rwc_base_secondary_menu_args( $args ) {

	if ( 'secondary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;
	return $args;

}

/**
 * Defines responsive menu settings.
 *
 * @since 2.3.0
 */
function rwc_base_responsive_menu_settings() {

	$settings = array(
		'mainMenu'         => __( 'Menu', 'rwc-base' ),
		'menuIconClass'    => 'dashicons-before dashicons-menu',
		'subMenu'          => __( 'Submenu', 'rwc-base' ),
		'subMenuIconClass' => 'dashicons-before dashicons-arrow-down-alt2',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
			),
			'others'  => array(),
		),
	);

	return $settings;

}

?>