<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}

if ( !class_exists( 'WP_Avatar_Manager_Core' ) ) :

    /**
     * WP_Avatar_Manager_Core.
     *
     * Core Event Handler.
     *
     * @class    WP_Avatar_Manager_Core
     * @package  WP_Avatar_Manager/Classes
     * @category Class
     * @author   khokansardar
     */
    class WP_Avatar_Manager_Core {

        /**
         * Constructor for the core class. Hooks in methods.
         */
        public function __construct() {
            add_filter( 'get_avatar_url', array( $this, 'wpam_get_avatar_url' ), 99, 3 );
        }

        public function wpam_get_avatar_url( $url, $id_or_email, $args ) {
            // Return with default if setting is not active
            if ( ! get_option( 'wpam_override_default_avatar' ) ) return $url;

            // We have a custom avatar
            if ( get_option( 'wpam_custom_avatar_id' ) ) {
                $custom_avatar_id = absint( get_option( 'wpam_custom_avatar_id' ) );
                return wp_get_attachment_image_url( $custom_avatar_id );
            }

            return $url;

            // Process the user identifier.
            // if ( is_numeric( $id_or_email ) ) {
            //     $user = get_user_by( 'id', absint( $id_or_email ) );
            // } elseif ( is_string( $id_or_email ) ) {
            //     if ( strpos( $id_or_email, '@md5.gravatar.com' ) ) {
            //         // MD5 hash.
            //         list( $email_hash ) = explode( '@', $id_or_email );
            //     } else {
            //         // Email address.
            //         $email = $id_or_email;
            //     }
            // } elseif ( $id_or_email instanceof WP_User ) {
            //     // User object.
            //     $user = $id_or_email;
            // } elseif ( $id_or_email instanceof WP_Post ) {
            //     // Post object.
            //     $user = get_user_by( 'id', (int) $id_or_email->post_author );
            // } elseif ( $id_or_email instanceof WP_Comment ) {

            //     if ( ! empty( $id_or_email->user_id ) ) {
            //         $user = get_user_by( 'id', (int) $id_or_email->user_id );
            //     }
            //     if ( ( ! $user || is_wp_error( $user ) ) && ! empty( $id_or_email->comment_author_email ) ) {
            //         $email = $id_or_email->comment_author_email;
            //     }
            // }
        }
        
    }

endif; // class_exists

return new WP_Avatar_Manager_Core();
