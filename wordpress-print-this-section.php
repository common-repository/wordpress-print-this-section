<?php
/*
Plugin Name: WordPress Print This Section
Plugin URI: http://twodeuces.com
Description: This plugin allows wordpress authors add a shortcode to print out a specific section of their post in a simple clean format.
Version: 2.0.4
Author: Scott Hair
Author URI: http://twodeuces.com
License: GPL2
*/

/*  Copyright 2010 Two Deuces Entertainment Inc & Scott Hair  (email : twodeuces@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/*
* Inspiration for this plugin came from the WP-Print Plugin by Lester 'GaMerZ' Chan. A great deal of credit is
* owed to him as the plugin was and still is a great teaching tool for my development. I used some of the concepts
* to create my plugin that prints only certain sections of the post or page instead of the whole thing. Many of the
* options of the original plugin have been stripped out to meet the needs of this plugin and keep it as small as
* possible. Where possible I included acknowledgement notes where code came from or was inspired by others.
*/

/*
Changelog
2.0.4 - Eliminated re-write rules since they were conflicting with default permalink structure. Instead went with simple template redirection.
2.0.3 - Corrected Versioning tags.
2.0.2 - Added Multi-section print this capability.
2.0.1 - Major Version rehaul. Updated to OOP. Introduced print page redirection, output cusom print page. Also reduced functionality to allow
        only one print this section per page for this version. We plan on restoring multi section print capabilities in later revisions.
1.0.1 - Added Print Page Meta data and admin options. Correct minor markup error.
0.1.1 - Added documentation and admin notes.
0.1 	- Initial Release (Apr 29, 2010)
*/


/*******
* Check for object name conflicts. If one does not exists then load the required class file and instantiate an object.
* - Also defines plugin directory and url constants for later use.
* - Actions and filters are initialized here.
*******/

if ( !class_exists( "WP_Print_This_Plugin" ) ) {

	/* Define the path and url of the plugins directory. */
	define( 'WPPTS_PLUGIN_DIR', WP_PLUGIN_DIR . '/wordpress-print-this-section' );
	define( 'WPPTS_PLUGIN_URL', plugins_url( $path = '/wordpress-print-this-section' ) );
        define( 'WPPTS_PLUGIN_VER', '2.0.4' );

        /* Define what version of the database structure is current, if needed. */

	/* Load required object files.  */
        require_once( WPPTS_PLUGIN_DIR . '/php/class-wp-print-this-plugin.php' );

        /* Define global scope for required objects */
        global $print_this_plugin;
        global $print_this_counter;
        $print_this_counter = 1;

        /* Instantiate new objects */
        if ( class_exists( "WP_Print_This_Plugin" ) ) {
		$print_this_plugin = new WP_Print_This_Plugin();
	}

        // Initialize the admin panel
	if ( !function_exists( "print_this_admin_panel" ) ) {
            function print_this_admin_panel() {
		global $print_this_plugin;
		if ( !isset( $print_this_plugin ) ) {
                    return;
		}
                if ( function_exists( 'add_options_page' ) ) {
                    $page = add_options_page( 'Print This Options', 'Print This', 'manage_options', 'print-this-settings', array( &$print_this_plugin, 'print_admin_page' ) );
                    add_action( "admin_head-$page", array( &$print_this_plugin, 'add_admin_header_code' ) );
                }
            }
	}


	/*******
	* This section is used to set our actions and filters.
	* - Keep in mind, more action and filter hooks could be added in the class file.
	*******/
	if ( isset($print_this_plugin) ) {
		// Activation Hook
                
		// Actions
                add_action( 'init', array( &$print_this_plugin, 'load_textdomain' ) );
                add_action( 'admin_menu', 'print_this_admin_panel' );
                add_action( 'template_redirect', array( &$print_this_plugin, 'print_this' ), 5 );
                add_action( 'wp_head', array( &$print_this_plugin, 'add_print_this_header_code' ) );
               

		// Filters
                add_filter( 'query_vars', array( &$print_this_plugin, 'add_print_this_query_vars' ) );
                add_filter( 'mce_external_plugins', array( &$print_this_plugin, 'add_print_this_tinymce_plugin' ) );
                add_filter( 'mce_buttons', array( &$print_this_plugin, 'register_print_this_button' ) );

		// Deactivation Hook

		// Add Shortcodes
                add_shortcode( 'print_this', array( &$print_this_plugin, 'print_this_shortcode' ) );

	}
}
?>
