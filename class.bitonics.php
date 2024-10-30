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

class Bitonics
{
    private static $initiated = false;

    public static function init() {
        if ( !self::$initiated ) {
            self::init_hooks();
        }
    }

    /**
     * Initializes WordPress hooks
     */
    private static function init_hooks() {

        add_shortcode( 'bitonics', array( BITONICS_CLASS, 'bitonics_shortcode' ) );

        self::$initiated = true;

        $bitonics_link = get_option( 'bitonics_link' );
        if (strlen($bitonics_link) > 0) {
            wp_register_style( 'bitonics', $bitonics_link, array(), BITONICS_VERSION );
            wp_enqueue_style( 'bitonics' );
        }
    }

    public static function view( $name, array $args = array() ) {
        $args = apply_filters( 'bitonics_view_arguments', $args, $name );
        foreach ( $args AS $key => $val ) {
            $$key = $val;
        }
        load_plugin_textdomain( 'bitonics' );
        $file = BITONICS_PLUGIN_DIR . 'views/' . $name . '.php';
        include( $file );
    }

    /**
     * Bitonics shortcode [bitonics currency="BTC" showcode=false]
     */
    public static function bitonics_shortcode( $atts, $content = null ) {

        // Defaults
        $a = shortcode_atts( array(
            'currency' => 'BTC',
            'showcode' => get_option( 'bitonics_shortcode_showcode' ),
        ), $atts );

        if ( !empty($a['style']) ) {

        }

        $symbol = '<i class="bt bt-' . strtolower(trim($a['currency'])) . '" aria-hidden="true"></i>';

        if ($a['showcode'] === '1') {
            $return = $symbol . ' ' . strtoupper($a['currency']);
        } else {
            $return = $symbol;
        }
        
        $return .= ' ' . $content;

        return $return;
    }
}

