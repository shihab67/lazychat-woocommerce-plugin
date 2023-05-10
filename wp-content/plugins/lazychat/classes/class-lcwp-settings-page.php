<?php
/**
 * This class is used to add the settings page for the plugin.
 *
 * @package LazyChat WooCommerce Plugin
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Lcwp_Settings_Page' ) ) {
	/**
	 * This class adds the settings page for the plugin.
	 */
	class Lcwp_Settings_Page {

		/**
		 * This function adds the settings page for the plugin.
		 */
		public function admin_menu_add_external_link_top_level() {
			/**
			 * Add lazychat menu with lazychat logo.
			 */
			add_menu_page(
				'LazyChat',
				'LazyChat',
				'manage_options',
				'lazychat_settings',
				'lazychat_settings_page',
				plugins_url( 'lazychat/assets/images/lazychat.png' ),
				2
			);
		}
	}
}
