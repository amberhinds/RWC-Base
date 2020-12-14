<?php
/**
 * RWC Base.
 *
 * This file adds functions to the RWC Base Theme.
 *
 * @package RWC Base
 * @author  Road Warrior Creative
 * @license GPL-2.0-or-later
 * @link    https://roadwarriorcreative.com/
 */

// Starts the engine.
require_once get_template_directory() . '/lib/init.php';

// Defines the child theme (do not remove).
define( 'CHILD_THEME_NAME', 'Road Warrior Creative - Base Theme' );
define( 'CHILD_THEME_URL', 'https://roadwarriorcreative.com/' );
define( 'CHILD_THEME_VERSION', '1.0.0' );

// Sets up the Theme.
require_once get_stylesheet_directory() . '/lib/theme-defaults.php';

// Adds helper functions.
require_once get_stylesheet_directory() . '/lib/helper-functions.php';

// Adds image upload and color select to Customizer.
require_once get_stylesheet_directory() . '/lib/customize.php';

// Includes Customizer CSS.
require_once get_stylesheet_directory() . '/lib/output.php';

// Adds WooCommerce support.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-setup.php';

// Adds the required WooCommerce styles and Customizer CSS.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-output.php';

// Adds the Genesis Connect WooCommerce notice.
require_once get_stylesheet_directory() . '/lib/woocommerce/woocommerce-notice.php';

// Navigation
require_once get_stylesheet_directory() . '/lib/navigation.php';

// Load Hero Section
require_once get_stylesheet_directory() . '/lib/hero.php';

// Genesis Changes
require_once get_stylesheet_directory() . '/lib/genesis-changes.php';

// Admin Branding
require_once get_stylesheet_directory() . '/lib/admin-branding.php';