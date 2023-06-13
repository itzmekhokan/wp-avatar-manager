<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WP_Avatar_Manager_Admin' ) ) :

    /**
     * WP_Avatar_Manager_Admin.
     *
     * Backend Event Handler.
     *
     * @class    WP_Avatar_Manager_Admin
     * @package  WP_Avatar_Manager/Classes
     * @category Class
     * @author   khokansardar
     */
    class WP_Avatar_Manager_Admin {
        
        /**
         * Constructor for the admin class. Hooks in methods.
         */
        public function __construct() {
            add_action( 'admin_enqueue_scripts', array( $this, 'wpam_admin_enqueue_scripts' ) );
            add_action( 'admin_init', array( $this, 'add_settings_field_to_setting_discussion_admin_page' ) );
            add_filter( 'plugin_action_links_' . WPAM_BASENAME, array( $this, 'wpam_plugin_action_links' ) );
        }

        public function wpam_admin_enqueue_scripts() {
            $screen = get_current_screen();
            if ( $screen && 'options-discussion' === $screen->id ) {
                // WordPress media uploader scripts
                if ( ! did_action( 'wp_enqueue_media' ) ) {
                    wp_enqueue_media();
                }
                wp_enqueue_style( 
                    'admin_settings', 
                    WPAM()->plugin_url() . '/assets/css/admin-settings.css', 
                    '', 
                    WPAM_VERSION, 
                );
                wp_enqueue_script( 
                    'settings_media_handler', 
                    WPAM()->plugin_url() . '/assets/js/settings-media-handler.js', 
                    array( 'jquery' ), 
                    WPAM_VERSION, 
                    true 
                );

            }
        }

        public function wpam_plugin_action_links( $links ) {
            if ( ! is_array( $links ) ) {
                return $links;
            }
        	
            $links['settings'] = sprintf( '<a href="%s"> %s </a>',
                esc_url( admin_url( 'options-discussion.php' ) ),
                __( 'Settings', 'wp-avatar-manager' )
            );

            return $links;
        }
        
        /**
         * Add settings in woocommerce settings product
         *
         * @access public
         * @since 1.0.0
         * @return array $settings
         */
        public function add_settings_field_to_setting_discussion_admin_page() {

            add_settings_field(
                'wpam_override_default_avatar',
                esc_attr__( 'Override avatar', 'wp-avatar-manager' ),
                array( $this, 'callback_wpam_override_default_avatar' ),
                'discussion',
                'avatars',
            );
            add_settings_field(
                'wpam_custom_avatar_id',
                esc_attr__( 'Upload avatar', 'wp-avatar-manager' ),
                array( $this, 'callback_wpam_custom_avatar_id' ),
                'discussion',
                'avatars',
            );

            register_setting( 'discussion', 'wpam_override_default_avatar' );
            register_setting( 'discussion', 'wpam_custom_avatar_id' );
	    }

        public function callback_wpam_override_default_avatar() {
            printf(
                '<label for="wpam_override_default_avatar"><input type="checkbox" id="wpam_override_default_avatar" name="wpam_override_default_avatar" value="1" %s />%s</label>',
                checked( get_option( 'wpam_override_default_avatar' ), 1, false ),
                esc_attr__( 'Override default avatar with Avatar Manager', 'wp-avatar-manager' )
            );
        }

        public function callback_wpam_custom_avatar_id() {
            $image_id = get_option( 'wpam_custom_avatar_id' );
            $image = wp_get_attachment_image_url( $image_id, 'medium' );
            $class = ( $image ) ? 'active' : 'none';
            ?>
            <span class="wpam-uploaded-img-wrapper <?php echo esc_attr( $class ); ?>">
                <a href="" class="wpam-upload-wrap" >
                    <img class="wpam-upload-url" src="<?php echo esc_url( $image ) ?>" />
                </a>
                <a href="" class="wpam-remove-image">Remove image</a>
            </span>
            <a href="" class="button wpam-upload-image" <?php echo ( $image ) ? 'style="display:none;"' : ''; ?>>Upload image</a>
            <input type="hidden" class="wpam-upload-id" name="wpam_custom_avatar_id" value="<?php echo absint( $image_id ) ?>">
            
            <?php
        }
    }

endif; // class_exists

return new WP_Avatar_Manager_Admin();
