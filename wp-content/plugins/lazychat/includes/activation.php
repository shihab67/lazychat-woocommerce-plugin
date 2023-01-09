<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined('ABSPATH') || exit;

if (!function_exists('lswp_activation')) {
	function lswp_activation()
	{
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

		if (!get_option('lcwp_sync_options')) {
			add_option('lcwp_sync_options', [
				'lcwp_product_created' => 0,
				'lcwp_product_updated' => 0,
				'lcwp_product_removed' => 0,
				'lcwp_customer_created' => 0,
				'lcwp_customer_updated' => 0,
				'lcwp_customer_removed' => 0,
				'lcwp_order_created' => 0,
				'lcwp_order_updated' => 0,
				'lcwp_order_removed' => 0,
			]);
		}
	}
}
