<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined('ABSPATH') || exit;

if (!function_exists('lcwp_activation')) {
	function lcwp_activation()
	{
		if (!get_option('lcwp_settings')) {
			add_option('lcwp_settings', [
				'lcwp_label' => 'LazyChat'
			]);
		}

		if (!get_option('lcwp_auth_token')) {
			add_option('lcwp_auth_token', null);
		}

		if (!get_option('lcwp_order_phases')) {
			add_option('lcwp_order_phases', [
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

		if (!get_option('lcwp_shop_id')) {
			add_option('lcwp_shop_id', null);
		}

		if (!get_option('lcwp_last_fetched_time')) {
			add_option('lcwp_last_fetched_time', null);
		}
	}
}
