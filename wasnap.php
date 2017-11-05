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

$controller = new \WaSnap\Controller;

/* activate */
register_activation_hook( __FILE__, array( $controller, 'activate' ) );

/* enqueue js and css */
add_action( 'init', array( $controller, 'init' ) );

/* capture form post */
add_action ( 'init', array( $controller, 'form_capture' ) );

/* register shortcode */
add_shortcode ( 'wasnap', array( $controller, 'short_code' ) );

/* admin stuff */
if (is_admin() )
{
	/* Add main menu and sub-menus */
	add_action( 'admin_menu', array( $controller, 'admin_menus') );

	/* register settings */
	add_action( 'admin_init', array( $controller, 'register_settings' ) );

	/* admin scripts */
	add_action( 'admin_init', array( $controller, 'admin_scripts' ) );

	/* add the settings page link */
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $controller, 'settings_link' ) );
}