<?php

/**
 * Plugin Name: Washington State SNAP Education
 * Plugin URI: https://wasnap-ed.org
 * Description: A custom plugin for Washington State SNAP Education
 * Author: Tony DeStefano
 * Version: 0.0.1
 * Text Domain: wasnap
 *
 * Copyright 2016 Spokane WordPress Development
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 *
 */

require_once ( 'classes/WaSnap/Controller.php' );
require_once ( 'classes/WaSnap/Util.php' );
require_once ( 'classes/WaSnap/Provider.php' );
require_once ( 'classes/WaSnap/ProviderTable.php' );

$wasnap_controller = new \WaSnap\Controller;

/* activate */
register_activation_hook( __FILE__, array( $wasnap_controller, 'activate' ) );

/* enqueue js and css */
add_action( 'init', array( $wasnap_controller, 'init' ) );

/* capture form post */
add_action( 'init', array( $wasnap_controller, 'form_capture' ) );

/* register shortcode */
add_shortcode( 'wasnap', array( $wasnap_controller, 'short_code' ) );

/* add role */
add_action( 'init', array( $wasnap_controller, 'add_role' ) );

/* admin stuff */
if (is_admin() )
{
	/* Add main menu and sub-menus */
	add_action( 'admin_menu', array( $wasnap_controller, 'admin_menus') );

	/* register settings */
	add_action( 'admin_init', array( $wasnap_controller, 'register_settings' ) );

	/* admin scripts */
	add_action( 'admin_init', array( $wasnap_controller, 'admin_scripts' ) );

	/* add the settings page link */
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $wasnap_controller, 'settings_link' ) );

    /* extra user fields */
    add_action( 'show_user_profile', array( $wasnap_controller, 'extra_profile_fields' ) );
    add_action( 'edit_user_profile', array( $wasnap_controller, 'extra_profile_fields' ) );
    add_action( 'personal_options_update', array( $wasnap_controller, 'save_extra_profile_fields' ) );
    add_action( 'edit_user_profile_update', array( $wasnap_controller, 'save_extra_profile_fields' ) );
}