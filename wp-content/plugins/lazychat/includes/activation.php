<?php
/**
 * This file contains the activation function for the plugin.
 *
 * @package LazyChat WooCommerce Plugin
 */

defined( 'ABSPATH' ) || exit;

if ( ! function_exists( 'lcwp_activation' ) ) {
	/**
	 * This function is called when the plugin is activated.
	 * This function creates all the necessary options for the plugin.
	 */
	function lcwp_activation() {
		if ( ! get_option( 'lcwp_shop_name' ) ) {
			add_option( 'lcwp_shop_name', null );
		}

		if ( ! get_option( 'lcwp_auth_token' ) ) {
			add_option( 'lcwp_auth_token', null );
		}

		if ( ! get_option( 'lcwp_order_phases' ) ) {
			add_option(
				'lcwp_order_phases',
				array(
					'mapped' => false,
					'phases' => array(),
				)
			);
		}

		if ( ! get_option( 'lcwp_sync_options' ) ) {
			add_option(
				'lcwp_sync_options',
				array(
					'lcwp_product_created'  => 0,
					'lcwp_product_updated'  => 0,
					'lcwp_product_removed'  => 0,
					'lcwp_customer_created' => 0,
					'lcwp_customer_updated' => 0,
					'lcwp_customer_removed' => 0,
					'lcwp_order_created'    => 0,
					'lcwp_order_updated'    => 0,
					'lcwp_order_removed'    => 0,
				)
			);
		}

		if ( ! get_option( 'lcwp_shop_id' ) ) {
			add_option( 'lcwp_shop_id', null );
		}

		if ( ! get_option( 'lcwp_last_fetched_time' ) ) {
			add_option( 'lcwp_last_fetched_time', null );
		}
	}
}

