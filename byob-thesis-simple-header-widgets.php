<?php
/*
 Plugin Name: BYOB Thesis Simple Header Widgets
 Plugin URI: http://www.byobwebsite.com/plugins/byob-thesis-simple-header-widgets/
 Description: This plugin allows the user to add one or two widget areas to the Thesis Header.  It can replace the default Thesis header options or it can use them and add a widget area.<strong>It requires the Thesis theme version 1.8 or higher</strong>
 Version: 1.9.2
 Author: Rick Anderson
 Author URI: http://www.byobwebsite.com/
 License: GPLv2
 Date: August 21, 2012
 */

/*  Copyright 2012 Rick Anderson - email rick@byobwebsite.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// ------------------------------------------------------------------------
// PLUGIN PREFIX:                                                          
// ------------------------------------------------------------------------


// 'byobtshw_' prefix is derived from [byob][t]hesis [s]imple [h]eader [w]idgets

// ------------------------------------------------------------------------
// REGISTER HOOKS & CALLBACK FUNCTIONS:                                    
// ------------------------------------------------------------------------

if(is_admin()){
    require_once 'byobtshw_delete_plugin.php';
    require_once 'admin/byobtshw_admin.php';
    require_once 'admin/byobtshw_admin_help.php';
    require_once 'admin/byobtshw_options.php';
}

require_once 'includes/byobtshw_write_css.php';
require_once 'includes/byobtshw_sidebars.php';
require_once 'includes/byobtshw_header_html.php';

define( 'BYOBTSHW_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'BYOBTSHW_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

include_once( get_template_directory() . '/lib/admin/fonts.php' );


// ------------------------------------------------------------------------
// REGISTER HOOKS & CALLBACK FUNCTIONS:                                    
// ------------------------------------------------------------------------


// Set-up Hooks
register_activation_hook(__FILE__, 'byobtshw_plugin_startup');
register_deactivation_hook(__FILE__, 'byobtshw_deactivate');
register_uninstall_hook(__FILE__, 'byobtshw_delete_plugin_options');
add_action('admin_init', 'byobtshw_init' );
add_action('admin_menu', 'byobtshw_add_options_page');

load_plugin_textdomain( 'byobtshw', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/');


// --------------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: register_deactivation_hook(__FILE__, 'byobtshw_deactivate')
// --------------------------------------------------------------------------------------

// Delete the CSS file stuff when plugin deactivated
function byobtshw_deactivate() {
    
    // Delete CSS from byob-custom.css
    byobtshw_delete_css();
}


// ------------------------------------------------------------------------------
// CALLBACK FUNCTION FOR: register_activation_hook(__FILE__, 'byobtshw_plugin_startup')
// ------------------------------------------------------------------------------

// Check WordPress and Thesis Versions
function byobtshw_plugin_startup() {
    global $wp_version;
    global $thesis;
    
    /* Checks WP version */

    if(version_compare($wp_version, "3.0", "<")){   //Check for WP version at least 2.9
        deactivate_plugins(basename (__FILE__));
        wp_die (__('This plugin requires WordPress version 3.0 or higher.', 'byobtshw'));
    }

    /* Checks for Thesis */

    $theme_name = get_current_theme();   
    $pos = strrpos($theme_name, "Thesis");
    if ($pos === false){
        deactivate_plugins(basename (__FILE__));
        wp_die (__('This plugin only works with the <strong>Thesis Theme</strong> version 1.8 or higher.', 'byobtshw'));

    }
    
    /* Checks Thesis version */
    
    $thesis_theme_version = thesis_version();
    if ($thesis_theme_version < '1.8'){
        deactivate_plugins(basename (__FILE__));
        wp_die (__('This plugin requires Thesis 1.8 or higher.', 'byobtshw'));
    }
    
    /* Sets Options Defaults */
    
    byobtshw_plugin_option_defaults();
       
}
