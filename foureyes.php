<?php
/*
Plugin Name: FourEyes
Plugin URI: http://wordpress.org/plugins/foureyes/
Description: FourEyes survey plugin - Embed FourEyes surveys directly onto your Wordpress site.
Version: 1.0
Author: Sparklit Networks
Author URI: http://sparklit.com
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/
defined( 'ABSPATH' ) or die();

if ( ! defined( 'WP_PLUGIN_URL' ) ) define( 'WP_PLUGIN_URL', WP_CONTENT_URL. '/plugins' );
include_once(dirname(__FILE__) . '/FourEyes_Plugin.php');

// Wordpress Admin Hook
function foureyes_conf() {
	wp_enqueue_script('jquery');
	if ( function_exists('add_submenu_page') ) {
		add_submenu_page('plugins.php', __('FourEyes'), __('FourEyes'), 'manage_options', 'foureyes', 'foureyes_config');
	}

	add_filter('plugin_row_meta', 'foureyes_plugin_meta', 10, 2 );
}

// Set admin meta
function foureyes_plugin_meta($links, $file) {

	// create link
	if (basename($file,'.php') == 'foureyes') {
		return array_merge(
			$links,
			array(
				'<a href="plugins.php?page=foureyes">' . __('Configuration') . '</a>',
			)
		);
	}
	return $links;
}

// Wordpress Setup
function foureyes_config() {
	include(dirname(__FILE__).'/config.php');
}

add_action('admin_menu', 'foureyes_conf');
$FourEyes = FourEyes_Plugin::instance();
