<?php
/**
 * Plugin Name: WP Avatar Manager
 * Plugin URI:
 * Description: A toolkit used to manage default WordPress avatar or gravatar.
 * Version: 1.0.0
 * Author: khokansardar
 * Author URI: https://itzmekhokan.wordpress.com/
 * Text Domain: wp-avatar-manager
 * Domain Path: /languages/
 * Requires at least: 4.4
 * Requires PHP: 7.2
 * Tested up to: 5.2
 *
 * @package WP_Avatar_Manager
 */

defined( 'ABSPATH' ) || exit; // Exit if accessed directly.

// Define WPAM_PLUGIN_FILE.
if ( ! defined( 'WPAM_PLUGIN_FILE' ) ) {
	define( 'WPAM_PLUGIN_FILE', __FILE__ );
}

// Include the main WP_Avatar_Manager class.
if ( ! class_exists( 'WP_Avatar_Manager' ) ) {
	include_once dirname( __FILE__ ) . '/includes/class-wp-avatar-manager.php';
}

/**
 * Main instance of WP_Avatar_Manager.
 *
 * Return the main instance of WP_Avatar_Manager to prevent the need to use globals.
 *
 * @since  1.0.0
 * @return WP_Avatar_Manager
 */
function WPAM() {
	return WP_Avatar_Manager::instance();
}

// Set Global instance.
$GLOBALS['wp_avatar_manager'] = WPAM();
