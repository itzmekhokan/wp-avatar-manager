<?php

/**
 * WP_Avatar_Manager setup
 *
 * @package WP_Avatar_Manager
 * @since   1.0.0
 */

defined('ABSPATH') || exit;

/**
 * Main WP_Avatar_Manager Class.
 *
 * @class WP_Avatar_Manager
 */
final class WP_Avatar_Manager {

    /**
     * WP_Avatar_Manager version.
     *
     * @var string
     */
    public $version = '1.0.0';
    
    /**
     * Instance of admin class.
     *
     * @var WP_Avatar_Manager_Admin
     */
    public $admin = null;

    /**
     * The single instance of the class.
     *
     * @var   WP_Avatar_Manager
     * @since 1.0.0
     */
    protected static $instance = null;

    /**
     * Main WP_Avatar_Manager Instance.
     *
     * Ensures only one instance of WP_Avatar_Manager is loaded or can be loaded.
     *
     * @since  1.0.0
     * @static
     * @see    WP_Avatar_Manager()
     * @return WP_Avatar_Manager - Main instance.
     */
    public static function instance() {
        if ( is_null( self::$instance ) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    /**
     * WP_Avatar_Manager Constructor.
     */
    public function __construct() {
        $this->define_constants();
        add_action( 'plugins_loaded', array( $this, 'load_classes' ), 9 );
        add_action( 'init', array( $this, 'init' ) );
        add_action( 'activated_plugin', array( $this, 'activated_plugin' ) );
        add_action( 'deactivated_plugin', array( $this, 'deactivated_plugin' ) );
        do_action( 'wp_avatar_manager_loaded' );
    }

    /**
     * Define WPAM Constants.
     */
    private function define_constants() {
        if ( ! defined( 'WPAM_ABSPATH' ) )
            define( 'WPAM_ABSPATH', dirname(WPAM_PLUGIN_FILE) . '/' );
        if ( ! defined( 'WPAM_BASENAME' ) )
            define( 'WPAM_BASENAME', plugin_basename(WPAM_PLUGIN_FILE) );
        if (! defined( 'WPAM_VERSION' ) )
            define( 'WPAM_VERSION', $this->version );
    }

    /**
     * Include required core files used in admin and on the frontend.
     */
    public function includes() {
        /**
         * Core classes and functions.
         */
        // include_once WPAM_ABSPATH . 'includes/wc-featured-listing-functions.php';
        include_once WPAM_ABSPATH . 'includes/class-wpam-core.php';

        if ( is_admin() ) {
            $this->admin = include_once WPAM_ABSPATH . 'includes/class-wpam-admin.php';
        }
        // if ( ( !is_admin() || defined('DOING_AJAX') ) && !defined('DOING_CRON') ) {
        //     include_once WPAM_ABSPATH . 'includes/class-wc-featured-listing-frontend.php';
        // }
        
    }

    /**
     * Initialises.
     */
    public function init() {
        // Set up localisation.
        $this->load_plugin_textdomain();
    }

    /**
     * Load Localisation files.
     */
    public function load_plugin_textdomain() {
        $locale = is_admin() && function_exists('get_user_locale') ? get_user_locale() : get_locale();
        $locale = apply_filters( 'plugin_locale', $locale, 'wp-avatar-manager' );

        unload_textdomain( 'wp-avatar-manager' );
        load_textdomain( 'wp-avatar-manager', WP_LANG_DIR . '/wp-avatar-manager/wp-avatar-manager-' . $locale . '.mo');
        load_plugin_textdomain( 'wp-avatar-manager', false, plugin_basename( dirname (WPAM_PLUGIN_FILE ) ) . '/languages' );
    }

    /**
     * Instantiate classes when WP_Avatar_Manager is activated
     */
    public function load_classes() {
        // all systems ready - GO!
        $this->includes();
    }
    
    /**
     * Get the plugin url.
     *
     * @return string
     */
    public function plugin_url() {
        return untrailingslashit( plugins_url( '/', WPAM_PLUGIN_FILE ) );
    }

    /**
     * Get the plugin path.
     *
     * @return string
     */
    public function plugin_path() {
        return untrailingslashit( plugin_dir_path( WPAM_PLUGIN_FILE ) );
    }
    
    /**
     * Ran when any plugin is activated.
     *
    */
    public function activated_plugin( $filename ) {
      
    }
    
    /**
     * Ran when any plugin is deactivated.
     *
    */
    public function deactivated_plugin( $filename ) {
        
    }

}
