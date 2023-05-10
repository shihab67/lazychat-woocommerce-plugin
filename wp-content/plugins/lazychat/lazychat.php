<?php

/**
 * Plugin Name: LazyChat
 * Plugin URI: https://lazychat.io
 * Description: LazyChat is an omnichannel chatcommerce tool that enables you to sell products on any messaging channel (e.g. Messenger, Instagram, WhatsApp, etc.) and manage your social media business.
 * Version: 1.0
 * Requires at least: 5.2
 * Requires PHP: 7.3
 * Author: LazyChat
 * Author URI: https://lazychat.io
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI: https://example.com/my-plugin/
 * Text Domain: lcwp
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

defined( 'ABSPATH' ) || exit;

session_start();

if ( ! defined( 'LCWP_PATH' ) ) {
	define( 'LCWP_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'LCWP_URI' ) ) {
	define( 'LCWP_URI', plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'PUSHER_APP_KEY' ) ) {
	define('PUSHER_APP_KEY', '68cdc42e480c1f64420d');
	// define( 'PUSHER_APP_KEY', 'f55c502096321f432f4b' );
}

if ( ! in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) ) {
	/**
	 * This function checks if the WooCommerce plugin is active.
	 */
	function lazychat_fail_wc_not_active() {
		/* translators: %s+: WooCommerce plugin name */
		$message      = sprintf( esc_html__( 'LazyChat WooCommerce requires %s+ to be installed and active.', 'lazychat' ), 'WooCommerce' );
		$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
		echo wp_kses_post( $html_message );
	}
	add_action( 'admin_notices', 'lazychat_fail_wc_not_active' );
	return;
} elseif ( version_compare( get_bloginfo( 'version' ), '5.2', '<' ) ) {
	/**
	 * This function checks if the WordPress version is supported.
	 */
	function lazychat_fail_wp_version() {
		/* translators: %s+: WordPress version */
		$message      = sprintf(
			esc_html__(
				'LazyChat WooCommerce requires WordPress version %s+. 
							Because you are using an earlier version, 
							the plugin is currently NOT RUNNING.',
				'lazychat'
			),
			'5.2'
		);
		$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
		echo wp_kses_post( $html_message );
	}
	add_action( 'admin_notices', 'lazychat_fail_wp_version' );
	return;
} elseif ( version_compare( PHP_VERSION, '7.3', '<' ) ) {
	/**
	 * This function checks if the PHP version is supported.
	 */
	function lazychat_fail_php_version() {
		/* translators: %s+: PHP version */
		$message      = sprintf(
			esc_html__(
				'LazyChat WooCommerce requires PHP version %s+. 
							Because you are using an earlier version, 
							the plugin is currently NOT RUNNING.',
				'lazychat'
			),
			'7.3'
		);
		$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
		echo wp_kses_post( $html_message );
	}
	add_action( 'admin_notices', 'lazychat_fail_php_version' );
	return;
} else {
	if ( ! class_exists( 'LCWP_Core' ) ) {
		/**
		 * This class loads all the files required for this plugin.
		 */
		class LCWP_Core {
			/**
			 * This constructor includes necessary files, load hooks and add actions.
			 */
			public function __construct() {
				require LCWP_PATH . 'includes/activation.php';
				require LCWP_PATH . 'includes/deactivation.php';
				require LCWP_PATH . 'includes/error.php';
				require LCWP_PATH . 'classes/class-lcwp-settings-page.php';
				require LCWP_PATH . 'classes/class-lcwp-connect.php';
				require LCWP_PATH . 'classes/class-lcwp-settings.php';
				require LCWP_PATH . 'views/index.php';
				include_once dirname( __DIR__ ) . '/woocommerce/woocommerce.php';

				require LCWP_PATH . 'api/class-lcwp-api.php';

				register_activation_hook( __FILE__, 'lcwp_activation' );
				add_action( 'admin_menu', array( new Lcwp_Settings_Page(), 'admin_menu_add_external_link_top_level' ) );
				add_action( 'admin_post_lcwp_connect', array( new Lcwp_Connect(), 'lcwp_connect_with_lazychat' ) );
				add_action( 'admin_post_lcwp_upload_data', array( new Lcwp_Settings(), 'lcwp_handle_settings' ) );
				add_action( 'admin_post_lcwp_hard_re_sync', array( new Lcwp_Settings(), 'lcwp_hard_re_sync' ) );
				add_action(
					'wp_ajax_lcwp_map_order_phase',
					array( new Lcwp_Connect(), 'lcwp_map_order_phase' )
				);
				add_action(
					'wp_ajax_lcwp_sync_options',
					array( new Lcwp_Settings(), 'lcwp_sync_options' )
				);
				add_action(
					'wp_ajax_lcwp_get_queue_progress',
					array( new Lcwp_Settings(), 'lcwp_get_queue_progress' )
				);
				add_action(
					'wp_ajax_lcwp_deactivate_lazychat',
					array( new Lcwp_Settings(), 'lcwp_deactivate_lazychat' )
				);
				add_action(
					'wp_ajax_nopriv_lcwp_deactivate_lazychat',
					array( new Lcwp_Settings(), 'lcwp_deactivate_lazychat' )
				);
				add_action( 'rest_api_init', array( new Lcwp_Api(), 'register_routes' ) );

				/**
				 * Get LazyChat Order Phases.
				 */
				if ( get_option( 'lcwp_auth_token' ) && get_option( 'lcwp_auth_token' ) !== null ) {
					lcwp_get_lazychat_order_phases();
				}

				/**
				 * Load the Hooks.
				 */
				add_action(
					'plugins_loaded',
					function () {
						require LCWP_PATH . 'includes/lazychat-hooks.php';
					}
				);
			}
		}
		$l_c_w_p_c_o_r_e = new LCWP_Core();
	}
}

/**
 * Get LazyChat Order Phases
 *
 * @return array $phases
 */
function lcwp_get_lazychat_order_phases() {
	$lazychat_url = 'http://chatbot.test';
	// $lazychat_url = 'https://client.lazychat.io';

	$phases = array();

	if ( isset( $_SESSION['lazychat_order_phases'] ) ) {
		$phases = $_SESSION['lazychat_order_phases'];
	} else {
		$result = wp_remote_get(
			$lazychat_url . '/api/v1/woocommerce/order-phases',
			array(
				'headers' => array(
					'Content-Type'  => 'application/json',
					'Authorization' => 'Bearer ' . get_option( 'lcwp_auth_token' ),
				),
			)
		);

		if ( ! is_wp_error( $result ) ) {
			$phases                            = json_decode( wp_remote_retrieve_body( $result ), true );
			$_SESSION['lazychat_order_phases'] = $phases;
		}

		return true;
	}
}
