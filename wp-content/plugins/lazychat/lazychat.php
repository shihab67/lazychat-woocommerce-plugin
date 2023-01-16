<?php

/**
 * Plugin Name: LazyChat
 * Plugin URI: https://lazychat.io
 * Description: Sync data in your LazyChat App
 * Version: 1.0
 * Requires at least: 5.2
 * Requires PHP: 7.3
 * Author: Sayedur Rahman
 * Author URI: https://sayedurrahman.com/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI: https://example.com/my-plugin/
 * Text Domain: lswp
 * Domain Path: /languages
 */

/*
LazyChat WooCommerce is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

LazyChat WooCommerce is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with LazyChat WooCommerce. If not, see https://lazychat.io.
*/

defined('ABSPATH') || exit;

session_start();

// Constants
define('LCWP_PATH', plugin_dir_path(__FILE__));
define('LCWP_URI', plugin_dir_url(__FILE__));
define('LAZYCHAT_URL', 'http://chatbot.test');
define('PUSHER_APP_KEY', '68cdc42e480c1f64420d');
define('PUSHER_APP_HOST', '127.0.0.1');

// Check if WooCommerce is active
if (!in_array('woocommerce/woocommerce.php', apply_filters('active_plugins', get_option('active_plugins')))) {
	function lazychat_fail_wc_not_active()
	{
		/* translators: %s+: WooCommerce plugin name */
		$message      = sprintf(esc_html__('LazyChat WooCommerce requires %s+ to be installed and active.', 'lazychat'), 'WooCommerce');
		$html_message = sprintf('<div class="error">%s</div>', wpautop($message));
		echo wp_kses_post($html_message);
	}
	add_action('admin_notices', 'lazychat_fail_wc_not_active');
	return;
}
// Check if Wordpress version is supported
else if (version_compare(get_bloginfo('version'), '5.2', '<')) {
	function lazychat_fail_php_version()
	{
		/* translators: %s+: WP version */
		$message      = sprintf(esc_html__('LazyChat WooCommerce requires WordPress version %s+. 
							Because you are using an earlier version, 
							the plugin is currently NOT RUNNING.', 'lazychat'), '5.2');
		$html_message = sprintf('<div class="error">%s</div>', wpautop($message));
		echo wp_kses_post($html_message);
	}
	add_action('admin_notices', 'lazychat_fail_php_version');
	return;
}
// Check if PHP version is supported
else if (version_compare(PHP_VERSION, '7.3', '<')) {
	function lazychat_fail_php_version()
	{
		/* translators: %s+: PHP version */
		$message      = sprintf(esc_html__('LazyChat WooCommerce requires PHP version %s+. 
							Because you are using an earlier version, 
							the plugin is currently NOT RUNNING.', 'lazychat'), '7.3');
		$html_message = sprintf('<div class="error">%s</div>', wpautop($message));
		echo wp_kses_post($html_message);
	}
	add_action('admin_notices', 'lazychat_fail_php_version');
	return;
} else {
	if (!class_exists('LSWP_core')) {
		class LSWP_core
		{
			public function __construct()
			{
				//Included files
				require(LCWP_PATH . 'includes/activation.php');
				require(LCWP_PATH . 'includes/error.php');
				require(LCWP_PATH . 'classes/Lswp_settings_page.php');
				require(LCWP_PATH . 'classes/Lswp_connect.php');
				require(LCWP_PATH . 'classes/Lswp_settings.php');
				require(LCWP_PATH . 'views/index.php');
				include_once(dirname(__DIR__) . '/woocommerce/woocommerce.php');

				//API for getting data
				require(LCWP_PATH . 'api/api.php');

				//Hooks
				register_activation_hook(__FILE__, 'lswp_activation');
				add_action('admin_menu', [new Lswp_settings_page(), 'admin_menu_add_external_link_top_level']);
				add_action('admin_post_lswp_connect', [new Lswp_connect(), 'lswp_connect_with_lazychat']);
				add_action('admin_post_lswp_upload_data', [new Lswp_settings(), 'lswp_handle_settings']);
				add_action('admin_post_lcwp_hard_re_sync', [new Lswp_settings(), 'lcwp_hard_re_sync']);
				add_action(
					'wp_ajax_lswp_map_order_phase',
					[new Lswp_connect(), 'lswp_map_order_phase']
				);
				add_action(
					'wp_ajax_lcwp_sync_options',
					[new Lswp_settings(), 'lcwp_sync_options']
				);
				add_action(
					'wp_ajax_lcwp_get_queue_progress',
					[new Lswp_settings(), 'lcwp_get_queue_progress']
				);
				add_action('rest_api_init', [new Lswp_api, 'register_routes']);

				//Get LazyChat Order Phases
				if (get_option('lswp_auth_token') && get_option('lswp_auth_token') !== null) {
					lswp_get_lazychat_order_phases();
				}
			}
		}
		$LSWP_core = new LSWP_core();
	}
}


function lswp_get_lazychat_order_phases()
{
	$phases = [];

	if (isset($_SESSION['lazychat_order_phases'])) {
		$phases = $_SESSION['lazychat_order_phases'];
	} else {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, LAZYCHAT_URL . '/api/v1/woocommerce/order-phases');
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		$headers = array();
		$headers[] = 'Content-Type: application/json';
		$headers[] = 'Authorization: Bearer ' . get_option('lswp_auth_token');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);

		if (isset($result)) {
			$phases = json_decode($result, true);
			$_SESSION['lazychat_order_phases'] = $phases;
		}

		exit;
	}
}

// function my_plugin_activate()
// {
// 	add_option('Activated_Plugin', 'activate_lazychat/lazychat.php');
// 	/* activation code here */
// }
// register_activation_hook(__FILE__, 'my_plugin_activate');

// function load_plugin()
// {

// 	if (is_admin() && get_option('Activated_Plugin') == 'Plugin-Slug') {

// 		delete_option('Activated_Plugin');

// 		/* do stuff once right after activation */
// 		// example: add_action( 'init', 'my_init_function' );
// 	}
// }
// add_action('admin_init', 'load_plugin');
