<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined('ABSPATH') || exit;

//add custom deactivate action link
add_filter(
	'plugin_action_links_lazychat/lazychat.php',
	function ($actions) {
		$actions['deactivate'] = '<a href="#" id="deactivate-lazychat" aria-label="' .
			esc_html__('Deactivate LazyChat', 'lcwp') . '">' . esc_html__('Deactivate', 'lcwp') . '</a>';
		return $actions;
	}
);
