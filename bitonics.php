<?php
/**
Plugin Name:        Bitonics
Plugin URI:         https://bitonics.net/
Description:        The iconic font and CSS toolkit for cryptocurrencies
Version:            1.0.3
Author:             Bitonics
Author URI:         https://wordpress.org/support/users/bitonics/
First authors:      Magnus Betten
Main contributors:  Eric Lash and Eddie Adams
Text Domain:        bitonics
Domain Path:        /languages
License:            GPL
License URI:        https://www.gnu.org/licenses/gpl-2.0.html

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

defined('ABSPATH') or die();

function bitonics_textdomain() {
    load_plugin_textdomain( 'bitonics', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
}
add_action( 'plugins_loaded', 'bitonics_textdomain' );

define( 'BITONICS_VERSION', '1.0.2' );
define( 'BITONICS_MINIMUM_WP_VERSION', '3.3.0' );
define( 'BITONICS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'BITONICS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BITONICS_CACHE', BITONICS_PLUGIN_DIR . 'cache/' );
define( 'BITONICS_HOME', 'https://bitonics.net/' );
define( 'BITONICS_CLASS', 'Bitonics' );
define( 'BITONICS_WIDGET_TITLE', 'Powered by Bitonics' );
define( 'BITONICS_WIDGET_LOGO_COLOR', '#2C3E50' );
define( 'BITONICS_WIDGET_CMD_CODE', 'bitcoin' );
define( 'BITONICS_CLASS_ADMIN', 'Bitonics_Admin' );
define( 'BITONICS_LINK', 'https://bitonics.net/vendor/bitonics/bitonics.min.css' );
define( 'BITONICS_WIDGET_SHOW_CODE', '1' );
define( 'BITONICS_API_HOST', 'https://bitonics.net/' );
define( 'BITONICS_CDN', 'https://bitoncis.net/vendor/bitonics/wordpress/plugins/bitonics/cdn/' );

register_activation_hook( __FILE__, array( BITONICS_CLASS_ADMIN, 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( BITONICS_CLASS_ADMIN, 'plugin_deactivation' ) );

require_once( BITONICS_PLUGIN_DIR . 'class.bitonics.php' );
if ( !is_admin() ) {
    add_action( 'init', array( BITONICS_CLASS, 'init' ) );
}

if ( is_admin() ) {
    require_once( BITONICS_PLUGIN_DIR . 'class.bitonics-admin.php' );
    add_action( 'init', array( BITONICS_CLASS, 'init' ) );
    add_action( 'init', array( BITONICS_CLASS_ADMIN, 'init' ) );
}

require_once( BITONICS_PLUGIN_DIR . 'widgets.php' );