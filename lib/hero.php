<?php
/**
 * RWC Base
 *
 * This file adds the hero section to the RWC Base Theme.
 *
 * @package   RWC Base
 * @author    Road Warrior Creative
 * @link      https://roadwarriorcreative.com/
 * @license   GPL-3.0-or-later
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

add_filter( 'genesis_attr_entry', 'rwc_base_entry_attr' );
/**
 * Add itemref attribute to link entry-title.
 *
 * Since the entry-title is repositioned outside of the entry article, we need
 * to add some additional microdata so that it is still picked up as a part
 * of the entry. By adding the itemref attribute, we are telling search
 * engines to check the hero-section element for additional elements.
 *
 * @since  1.0.0
 *
 * @link   https://www.w3.org/TR/microdata/#dfn-itemref
 *
 * @param  array $atts Entry attributes.
 *
 * @return array
 */
function rwc_base_entry_attr( $atts ) {

	if ( is_singular() && did_action( 'genesis_before_entry' ) && ! did_action( 'genesis_after_entry' ) ) {

		$atts['itemref'] = 'hero-section';

	}

	return $atts;

}

add_action( 'genesis_before', 'rwc_base_hero_section_setup' );
/**
 * Set up hero section.
 *
 * Removes and repositions the title on all possible types of pages. Wrapped
 * up into one function so it can easily be unhooked from genesis_before.
 *
 * @since 1.0.0
 *
 * @return void
 */
function rwc_base_hero_section_setup() {

	// Remove default hero section.
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_open', 5 );
	remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
	remove_action( 'genesis_entry_header', 'genesis_entry_header_markup_close', 15 );
	remove_action( 'genesis_before_loop', 'genesis_do_posts_page_heading' );
	remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_open', 5, 3 );
	remove_action( 'genesis_archive_title_descriptions', 'genesis_do_archive_headings_close', 15, 3 );
	remove_action( 'genesis_before_loop', 'genesis_do_date_archive_title' );
	remove_action( 'genesis_before_loop', 'genesis_do_blog_template_heading' );
	remove_action( 'genesis_before_loop', 'genesis_do_taxonomy_title_description', 15 );
	remove_action( 'genesis_before_loop', 'genesis_do_author_title_description', 15 );
	remove_action( 'genesis_before_loop', 'genesis_do_cpt_archive_title_description' );
	remove_action( 'genesis_before_loop', 'genesis_do_search_title' );
	remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
	remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );

	// Add custom hero section.
	add_action( 'rwc_base_hero_section', 'genesis_do_posts_page_heading' );
	add_action( 'rwc_base_hero_section', 'genesis_do_date_archive_title' );
	add_action( 'rwc_base_hero_section', 'genesis_do_taxonomy_title_description' );
	add_action( 'rwc_base_hero_section', 'genesis_do_author_title_description' );
	add_action( 'rwc_base_hero_section', 'genesis_do_cpt_archive_title_description' );

	// Remove search results and shop page titles.
	add_filter( 'woocommerce_show_page_title', '__return_null' );
	add_filter( 'genesis_search_title_output', '__return_false' );

}

add_action( 'genesis_before_content', 'rwc_base_remove_404_title' );
/**
 * Remove default title of 404 pages.
 *
 * @since  1.0.0
 *
 * @return void
 */
function rwc_base_remove_404_title() {

	if ( is_404() ) {

		add_filter( 'genesis_markup_entry-title_open', '__return_false' );
		add_filter( 'genesis_markup_entry-title_content', '__return_false' );
		add_filter( 'genesis_markup_entry-title_close', '__return_false' );

	}

}

add_action( 'be_title_toggle_remove', 'rwc_base_genesis_title_toggle' );
/**
 * Integrate with Genesis Title Toggle plugin
 *
 * @since  1.0.0
 *
 * @author Bill Erickson
 * @link   https://www.billerickson.net/code/genesis-title-toggle-theme-integration
 *
 * @return void
 */
function rwc_base_genesis_title_toggle() {

	remove_action( 'rwc_base_hero_section', 'rwc_base_page_title', 10 );
	remove_action( 'rwc_base_hero_section', 'rwc_base_page_excerpt', 20 );

}

add_action( 'rwc_base_hero_section', 'rwc_base_page_title', 10 );
/**
 * Display title in hero section.
 *
 * Works out the correct title to display in the hero section on a per page
 * basis. Also adds the entry title back in to the entry inside the loop.
 *
 * @since  1.0.0
 *
 * @return void
 */
function rwc_base_page_title() {

	// Add post titles back inside posts loop.
	if ( is_home() || is_archive() || is_category() || is_tag() || is_tax() || is_search() || is_page_template( 'page_blog.php' ) ) {

		add_action( 'genesis_entry_header', 'genesis_do_post_title', 2 );

	}

	if ( class_exists( 'WooCommerce' ) && is_shop() ) {

		genesis_markup( array(
			'open'    => '<h1 %s>',
			'close'   => '</h1>',
			'content' => get_the_title( wc_get_page_id( 'shop' ) ),
			'context' => 'entry-title',
		) );

	} elseif ( 'posts' === get_option( 'show_on_front' ) && is_home() ) {

		genesis_markup( array(
			'open'    => '<h1 %s>',
			'close'   => '</h1>',
			'content' => apply_filters( 'rwc_base_latest_posts_title', __( 'Latest Posts', 'rwc-base' ) ),
			'context' => 'entry-title',
		) );

	} elseif ( is_404() ) {

		genesis_markup( array(
			'open'    => '<h1 %s>',
			'close'   => '</h1>',
			'content' => apply_filters( 'genesis_404_entry_title', __( 'Not found, error 404', 'rwc-base' ) ),
			'context' => 'entry-title',
		) );

	} elseif ( is_search() ) {

		genesis_markup( array(
			'open'    => '<h1 %s>',
			'close'   => '</h1>',
			'content' => apply_filters( 'genesis_search_title_text', __( 'Search results for: ', 'rwc-base' ) ) . get_search_query(),
			'context' => 'entry-title',
		) );

	} elseif ( is_page_template( 'page_blog.php' ) ) {

		do_action( 'genesis_archive_title_descriptions', get_the_title(), '', 'posts-page-description' );
	
	}elseif(is_post_type_archive('tribe_events')){
		
		genesis_markup( array(
			'open'    => '<h1 %s>',
			'close'   => '</h1>',
			'content' => 'Events',
			'context' => 'entry-title',
		) );

	} elseif ( is_single() || is_singular() ) {

		genesis_do_post_title();

	}

}

add_action( 'rwc_base_hero_section', 'rwc_base_page_excerpt', 20 );
/**
 * Display page excerpt.
 *
 * Prints the correct excerpt on a per page basis. If on the WooCommerce shop
 * page then the products result count is be displayed instead of the page
 * excerpt. Also, if on a single product then no excerpt will be output.
 *
 * @since  1.0.0
 *
 * @return void
 */
function rwc_base_page_excerpt() {

	if ( class_exists( 'WooCommerce' ) && is_shop() ) {

		woocommerce_result_count();

	} elseif ( is_home() ) {

		$id = get_option( 'page_for_posts' );

		if ( has_excerpt( $id ) ) {

			printf( '<p itemprop="description">%s</p>', do_shortcode( get_the_excerpt( $id ) ) );

		}
	} elseif ( is_search() ) {

		$id = get_page_by_path( 'search' );

		if ( has_excerpt( $id ) ) {

			printf( '<p itemprop="description">%s</p>', do_shortcode( get_the_excerpt( $id ) ) );

		}
	} elseif ( is_404() ) {

		$id = get_page_by_path( 'error-404' );

		if ( has_excerpt( $id ) ) {

			printf( '<p itemprop="description">%s</p>', do_shortcode( get_the_excerpt( $id ) ) );

		}
	} elseif ( ( is_single() || is_singular() ) && ! is_singular( 'product' ) && has_excerpt() ) {

		printf( '<p itemprop="description">%s</p>', do_shortcode( get_the_excerpt() ) );

	}
}

add_filter( 'genesis_attr_hero-section', 'rwc_base_hero_section_attr' );
/**
 * Callback for dynamic Genesis 'genesis_attr_$context' filter.
 *
 * Add custom attributes for the custom filter.
 *
 * @since  1.0.0
 *
 * @param  array $attr The element attributes.
 *
 * @return array
 */
function rwc_base_hero_section_attr( $attr ) {

	$attr['id']   = 'hero-section';
	$attr['role'] = 'banner';

	return $attr;

}

add_action( 'genesis_before_content_sidebar_wrap', 'rwc_base_hero_section' );
/**
 * Display the hero section.
 *
 * Conditionally outputs the opening and closing hero section markup and runs
 * rwc_base_hero_section which all of our header functions are hooked to.
 *
 * @since  1.0.0
 *
 * @return void
 */
function rwc_base_hero_section() {

	// Output hero section markup.
	genesis_markup( array(
		'open'    => '<section %s><div class="wrap">',
		'context' => 'hero-section',
	) );

	/**
	 * Do hero section hook.
	 *
	 * @hooked rwc_base_page_title - 10
	 * @hooked rwc_base_page_excerpt - 20
	 * @hooked genesis_do_posts_page_heading
	 * @hooked genesis_do_date_archive_title
	 * @hooked genesis_do_blog_template_heading
	 * @hooked genesis_do_taxonomy_title_description
	 * @hooked genesis_do_author_title_description
	 * @hooked genesis_do_cpt_archive_title_description
	 */
	do_action( 'rwc_base_hero_section' );

	// Output hero section markup.
	genesis_markup( array(
		'close'   => '</div></section>',
		'context' => 'hero-section',
	) );

}