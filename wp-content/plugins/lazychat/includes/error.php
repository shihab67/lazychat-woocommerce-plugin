<?php
/**
 * This file contains the error functions for the plugin.
 *
 * @package LazyChat WooCommerce Plugin
 */

const FLASH = 'FLASH_MESSAGES';

const FLASH_ERROR   = 'error';
const FLASH_WARNING = 'warning';
const FLASH_INFO    = 'info';
const FLASH_SUCCESS = 'success';

/**
 * Create a flash message
 *
 * @param string $message message to be displayed.
 * @param string $type (error, warning, info, success).
 * @return void
 */
function create_flash_message( string $message, string $type ): void {
	/**
	 * Remove existing message with the name.
	 */
	if ( isset( $_SESSION[ FLASH ] ) ) {
		unset( $_SESSION[ FLASH ] );
	}
	/**
	 * Add the message to the session.
	 */
	$_SESSION[ FLASH ] = array(
		'message' => $message,
		'type'    => $type,
	);
}


/**
 * Format a flash message
 *
 * @param array $flash_message flash message to be formatted.
 * @return string
 */
function format_flash_message( array $flash_message ): string {
	return sprintf(
		'<div class="alert alert-%s">%s</div>',
		$flash_message['type'],
		$flash_message['message']
	);
}

/**
 * Display a flash message
 *
 * @return void
 */
function display_flash_message(): void {
	if ( ! isset( $_SESSION[ FLASH ] ) ) {
		return;
	}

	/**
	 * Get message from the session.
	 */
	$flash_message = $_SESSION[ FLASH ];

	/**
	 * Delete the flash message.
	 */
	unset( $_SESSION[ FLASH ] );

	/**
	 * Display the flash message.
	 */
	echo format_flash_message( $flash_message );
}

/**
 * Display all flash messages
 *
 * @return void
 */
function display_all_flash_messages(): void {
	if ( ! isset( $_SESSION[ FLASH ] ) ) {
		return;
	}

	/**
	 * Get flash messages.
	 */
	$flash_messages = $_SESSION[ FLASH ];

	/**
	 * Remove all the flash messages.
	 */
	unset( $_SESSION[ FLASH ] );

	/**
	 * Show all flash messages.
	 */
	foreach ( $flash_messages as $flash_message ) {
		echo format_flash_message( $flash_message );
	}
}

/**
 * Flash a message
 *
 * @param string $message message to be displayed.
 * @param string $type (error, warning, info, success).
 * @return void
 */
function flash( string $message = '', string $type = '' ): void {
	if ( '' !== $message && '' !== $type ) {
		/**
		 * Create a flash message.
		 */
		create_flash_message( $message, $type );
	} elseif ( '' === $message && '' === $type ) {
		/**
		 * Display a flash message.
		 */
		display_flash_message();
	} elseif ( '' === $message && '' === $type ) {
		/**
		 * Display all flash message.
		 */
		display_all_flash_messages();
	}
}
