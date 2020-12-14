<?php
/**
 * RWC Base.
 *
 * This file adds the required helper functions used in the RWC Base Theme.
 *
 * @package RWC Base
 * @author  Road Warrior Creative
 * @license GPL-2.0-or-later
 * @link    https://roadwarriorcreative.com/
 */

/**
 * Gets default link color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 2.2.3
 *
 * @return string Hex color code for link color.
 */
function rwc_base_customizer_get_default_link_color() {

	return '#0073e5';

}

/**
 * Gets default accent color for Customizer.
 * Abstracted here since at least two functions use it.
 *
 * @since 2.2.3
 *
 * @return string Hex color code for accent color.
 */
function rwc_base_customizer_get_default_accent_color() {

	return '#0073e5';

}

/**
 * Calculates if white or gray would contrast more with the provided color.
 *
 * @since 2.2.3
 *
 * @param string $color A color in hex format.
 * @return string The hex code for the most contrasting color: dark grey or white.
 */
function rwc_base_color_contrast( $color ) {

	$hexcolor = str_replace( '#', '', $color );
	$red      = hexdec( substr( $hexcolor, 0, 2 ) );
	$green    = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue     = hexdec( substr( $hexcolor, 4, 2 ) );

	$luminosity = ( ( $red * 0.2126 ) + ( $green * 0.7152 ) + ( $blue * 0.0722 ) );

	return ( $luminosity > 128 ) ? '#333333' : '#ffffff';

}

/**
 * Generates a lighter or darker color from a starting color.
 * Used to generate complementary hover tints from user-chosen colors.
 *
 * @since 2.2.3
 *
 * @param string $color A color in hex format.
 * @param int    $change The amount to reduce or increase brightness by.
 * @return string Hex code for the adjusted color brightness.
 */
function rwc_base_color_brightness( $color, $change ) {

	$hexcolor = str_replace( '#', '', $color );

	$red   = hexdec( substr( $hexcolor, 0, 2 ) );
	$green = hexdec( substr( $hexcolor, 2, 2 ) );
	$blue  = hexdec( substr( $hexcolor, 4, 2 ) );

	$red   = max( 0, min( 255, $red + $change ) );
	$green = max( 0, min( 255, $green + $change ) );
	$blue  = max( 0, min( 255, $blue + $change ) );

	return '#' . dechex( $red ) . dechex( $green ) . dechex( $blue );

}

/**
 * Custom header image callback.
 *
 * Loads custom header or featured image depending on what is set on a per
 * page basis. If a featured image is set for a page, it will override
 * the default header image. It also gets the image for custom post
 * types by looking for a page with the same slug as the CPT e.g
 * the Portfolio CPT archive will pull the featured image from
 * a page with the slug of 'portfolio', if the page exists.
 *
 * @since  1.1.0
 *
 * @return string
 */
function rwc_base_custom_header() {
	$id  = '';
	$url = '';

	if ( class_exists( 'WooCommerce' ) && is_shop() ) {
		$id = wc_get_page_id( 'shop' );

	} elseif ( is_post_type_archive() ) {
		$id = get_page_by_path( get_query_var( 'post_type' ) );
		$id = $id->ID && has_post_thumbnail( $id->ID ) ? $id->ID : false;

	} elseif ( is_category() ) {
		$id = get_page_by_title( 'category-' . get_query_var( 'category_name' ), OBJECT, 'attachment' );

	} elseif ( is_tag() ) {
		$id = get_page_by_title( 'tag-' . get_query_var( 'tag' ), OBJECT, 'attachment' );

	} elseif ( is_tax() ) {
		$id = get_page_by_title( 'term-' . get_query_var( 'term' ), OBJECT, 'attachment' );

	} elseif ( is_front_page() ) {
		$id = get_option( 'page_on_front' );

	} elseif ( 'posts' === get_option( 'show_on_front' ) && is_home() ) {
		$id = get_option( 'page_for_posts' );

	} elseif ( is_search() ) {
		$id = get_page_by_path( 'search' );

	} elseif ( is_404() ) {
		$id = get_page_by_path( 'error' );

	} elseif ( is_singular() ) {
		$id = get_the_id();
	}

	if ( is_object( $id ) ) {
		$url = wp_get_attachment_image_url( $id->ID, 'hero' );

	} elseif ( $id ) {
		$url = get_the_post_thumbnail_url( $id, 'hero' );
	}

	$rwc_cpt_featured_img = genesis_get_cpt_option( 'rwc_cpt_featured_img' );
	if($rwc_cpt_featured_img){
		$url = $rwc_cpt_featured_img;
	}

	if ( ! $url ) {
		$url = get_header_image();
	}

	if ( $url ) {
		$selector = get_theme_support( 'custom-header', 'header-selector' );

		return printf( '<style id="hero-section" type="text/css">' . esc_attr( $selector ) . '{background-image:url(%s)}</style>' . "\n", esc_url( $url ) );

	} else {
		return '';
	}
}
