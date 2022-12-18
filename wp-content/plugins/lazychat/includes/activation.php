<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined('ABSPATH') || exit;

if (!function_exists('lswp_activation')) {
	function lswp_activation()
	{
		//Check if lswp_settings exists
		if (!get_option('lswp_settings')) {
			add_option('lswp_settings', [
				'lswp_label' => 'LazyChat'
			]);
		}

		if (!get_option('lswp_auth_token')) {
			add_option('lswp_auth_token', null);
		}

		if (!get_option('lswp_order_phases')) {
			add_option('lswp_auth_token', [
				'mapped' => false,
				'phases' => []
			]);
		}
	}
}
