<?php

/**
Copyright 2018 at Bitonics.net (email: info@bitonics.net)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.
This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

class Bitonics_Admin
{
    private static $initiated = false;

    public static function plugin_activation() {
        $bitonics_link = get_option( 'bitonics_link' );
        if ( $bitonics_link === false ) {
            $bitonics_link = BITONICS_LINK;
            update_option( 'bitonics_link', $bitonics_link);
        }
        $bitonics_shortcode_showcode = get_option( 'bitonics_shortcode_showcode' );
        if ( $bitonics_shortcode_showcode === false ) {
            $bitonics_shortcode_showcode = BITONICS_WIDGET_SHOW_CODE;
            update_option( 'bitonics_shortcode_showcode', $bitonics_shortcode_showcode);
        }
    }

    public static function plugin_deactivation() {

    }

    public static function init() {
        if ( !self::$initiated ) {
            self::init_hooks();
        }
    }

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {
        self::$initiated = true;

        wp_register_style( 'bitonics-admin', BITONICS_PLUGIN_URL .
            '_inc/css/bitonics-admin.min.css', array(), BITONICS_VERSION );
        wp_enqueue_style( 'bitonics-admin' );

        wp_register_script( 'bitonics-admin', BITONICS_PLUGIN_URL .
            '_inc/js/bitonics-admin.min.js', array( 'jquery' ), BITONICS_VERSION );
        wp_enqueue_script( 'bitonics-admin' );
        add_action( 'wp_ajax_nopriv_bitonics_ajax', array( BITONICS_CLASS_ADMIN, 'ajax' ) );
        add_action( 'wp_ajax_bitonics_ajax', array( BITONICS_CLASS_ADMIN, 'ajax' ) );

        add_action( 'admin_init', array( BITONICS_CLASS_ADMIN, 'register_settings' ) );
        add_action( 'admin_menu', array( BITONICS_CLASS_ADMIN, 'load_menu' ) );

        add_filter( 'plugin_action_links_' . plugin_basename( plugin_dir_path( __FILE__ ) . 'bitonics.php' ),
            array( BITONICS_CLASS_ADMIN, 'admin_plugin_settings_link' ) );

    }

    public static function register_settings() {
        register_setting( 'bitonics_options_group', 'bitonics_link' );
        register_setting( 'bitonics_options_group', 'bitonics_shortcode_showcode' );
    }

    public static function admin_plugin_settings_link( $links ) {
        $settings_link = '<a href="' . esc_url( self::get_page_url() ) . '">' . __( 'Settings', 'bitonics' ) . '</a>';
        array_unshift( $links, $settings_link );
        return $links;
    }

    public static function load_menu() {
        $hook = add_options_page( 'Bitonics', 'Bitonics', 'manage_options', 'bitonics', array( BITONICS_CLASS_ADMIN, 'bitonics_configuration_page' ) );
        add_action( "load-$hook", array( BITONICS_CLASS_ADMIN, 'admin_help' ) );
    }

    public static function bitonics_configuration_page() {
        call_user_func( BITONICS_CLASS . '::view', 'config' );
    }

    /**
     * Create Bitonics version of content
     */
    public static function bitonics_save_post( $post_id ) {

        return;

    }

    /**
     * Add help to the Bitonics page
     *
     * @return false if not the Bitonics page
     */
    public static function admin_help() {
        $current_screen = get_current_screen();
        if ( current_user_can( 'manage_options' ) ) {
            $current_screen->add_help_tab(
                array(
                    'id' => 'overview',
                    'title' => __( 'Overview', 'bitonics' ),
                    'content' =>
                        '<p><strong>' . esc_html__( 'Bitonics Overview', 'bitonics' ) . '</strong></p>' .
                        '<p>' . esc_html__( 'Bitonics lets you use cryptocurrencies icons in a intuitive and simple manner.', 'bitonics' ) 
                )
            );
            $current_screen->add_help_tab(
                array(
                    'id' => 'settings',
                    'title' => __( 'Settings', 'bitonics' ),
                    'content' =>
                        '<p><strong>' . esc_html__( 'Bitonics Settings', 'bitonics' ) . '</strong></p>' .
                        '<p><strong>' . esc_html__( 'Bitonics link', 'bitonics' ) . '</strong> - ' . esc_html__( 'Use this setting to reference the CSS file. Default: https://bitonics.net/vendor/bitonics/bitonics.min.css', 'bitonics' ) . '</p>',
                )
            );
            $current_screen->add_help_tab(
                array(
                    'id' => 'account',
                    'title' => __( 'Shortcode', 'bitonics' ),
                    'content' =>
                        '<p><strong>' . esc_html__( 'Bitonics Shortcode', 'bitonics' ) . '</strong></p>' .
                        '<p><strong>' . esc_html__( 'Show code', 'bitonics' ) . '</strong> - ' . esc_html__( 'When enabled this setting will result in adding the cryptocurrency code.', 'bitonics' ) . '</p>',
                )
            );
            $current_screen->set_help_sidebar(
                '<p><strong>' . esc_html__( 'For more information:' , 'bitonics' ) . '</strong></p>' .
                '<p><a href="' . BITONICS_HOME . 'faq.html" target="_blank">'     . esc_html__( 'Bitonics FAQ', 'bitonics' ) . '</a></p>' .
                '<p><a href="' . BITONICS_HOME . 'support.html" target="_blank">' . esc_html__( 'Bitonics Support', 'bitonics' ) . '</a></p>'
            );
        }
    }

    public static function get_page_url( $page = 'bitonics' ) {
        $args = array( 'page' => $page );
        $url = add_query_arg( $args, admin_url( 'options-general.php' ) );
        return $url;
    }

}