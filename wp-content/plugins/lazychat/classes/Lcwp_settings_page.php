<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined('ABSPATH') || exit;

if (!class_exists('Lcwp_settings_page')) {
	class Lcwp_settings_page
	{
		public function admin_menu_add_external_link_top_level()
		{
			//add lazychat menu with lazychat logo
			add_menu_page(
				'LazyChat',
				'LazyChat',
				'manage_options',
				'lazychat_settings',
				'lazychat_settings_page',
				plugins_url('lazychat/assets/images/lazychat.png'),
				2
			);
		}
	}
}
