<?php
/**
 * This file contains the settings class for the plugin.
 *
 * @package LazyChat WooCommerce Plugin
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Lcwp_Settings' ) ) {
	/**
	 * This class handles all the settings related to the plugin.
	 */
	class Lcwp_Settings {

		/**
		 * This variable stores the url of lazychat.
		 *
		 * @var string
		 */
		public $lazychat_url = 'http://chatbot.test';
		// public $lazychat_url = 'https://client.lazychat.io';

		/**
		 * This function receives the post request to fetch or upload data from lazychat.
		 */
		public function lcwp_handle_settings() {
			check_admin_referer( 'lcwp_upload_data_verify' );

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to perform this operation.' ) );
			}

			if ( isset( $_POST['upload_type'] ) ) {
				switch ( $_POST['upload_type'] ) {
					case 'upload_product':
						$this->lcwp_upload_data( 'upload_product' );
						break;
					case 'upload_contact':
						$this->lcwp_upload_data( 'upload_contact' );
						break;
					case 'upload_order':
						$this->lcwp_upload_data( 'upload_order' );
						break;
					case 'fetch_product':
						$this->lcwp_upload_data( 'fetch_product' );
						break;
					case 'fetch_contact':
						$this->lcwp_upload_data( 'fetch_contact' );
						break;
					case 'fetch_order':
						$this->lcwp_upload_data( 'fetch_order' );
						break;
					default:
						// code...
						break;
				}
			}
		}

		/**
		 * This function sends an api request to fetch or upload data from lazychat.
		 *
		 * @param string $type The type of data to be fetched or uploaded.
		 */
		public function lcwp_upload_data( $type ) {
			$result = wp_remote_request(
				$this->lazychat_url . '/api/v1/woocommerce/fetch-upload-data',
				array(
					'method'  => 'POST',
					'headers' => array(
						'Content-Type'  => 'application/json',
						'Authorization' => 'Bearer ' . get_option( 'lcwp_auth_token' ),
					),
					'body'    => wp_json_encode(
						array(
							'type' => $type,
						)
					),
				)
			);

			if ( ! is_wp_error( $result ) ) {
				$result = json_decode( wp_remote_retrieve_body( $result ), true );
			}

			if ( ( isset( $result['status'] ) && 'error' === $result['status'] ) ) {
				flash( $result['message'], 'danger' );

				/**
				 * Redirect back to settings page.
				 */
				wp_safe_redirect( get_admin_url() . 'admin.php?page=lazychat_settings' );
				exit;
			} elseif ( ( isset( $result['status'] ) && 'success' === $result['status'] ) ) {
				flash( $result['message'], 'success' );

				/**
				 * Redirect back to settings page.
				 */
				wp_safe_redirect( get_admin_url() . 'admin.php?page=lazychat_settings' );
				exit;
			} else {
				wp_die( 'Something went wrong. Please try again later' );
				exit;
			}
		}

		/**
		 * This function handles the request to sync the options.
		 *
		 * @return void
		 */
		public function lcwp_sync_options() {
			check_admin_referer( 'lcwp_sync_options_verify' );

			if ( ! current_user_can( 'manage_options' ) ) {
				echo wp_json_encode(
					array(
						'status' => 'error',
						'msg'    => 'You do not have sufficient permissions to perform this operation!',
					)
				);
				exit;
			} else {
				$result = wp_remote_request(
					$this->lazychat_url . '/api/v1/woocommerce/sync-options',
					array(
						'method'  => 'POST',
						'headers' => array(
							'Content-Type'  => 'application/json',
							'Authorization' => 'Bearer ' . get_option( 'lcwp_auth_token' ),
						),
						'body'    => wp_json_encode( $_POST ),
					)
				);

				if ( ! is_wp_error( $result ) ) {
					$result = json_decode( wp_remote_retrieve_body( $result ), true );
				}

				if ( isset( $result['status'] ) && 'success' === $result['status'] && get_option( 'lcwp_sync_options' ) ) {
					update_option(
						'lcwp_sync_options',
						$result['options']
					);
				}

				echo wp_json_encode(
					array(
						'status' => $result['status'],
						'msg'    => $result['message'],
					)
				);
				exit;
			}
		}

		/**
		 * This function handles the request to hard re-sync data to lazychat.
		 *
		 * @return void
		 */
		public function lcwp_hard_re_sync() {
			try {
				check_admin_referer( 'lcwp_hard_re_sync_verify' );

				if ( ! current_user_can( 'manage_options' ) ) {
					flash( 'You do not have sufficient permissions to perform this operation!', 'danger' );
					wp_safe_redirect( get_admin_url() . 'admin.php?page=lazychat_settings' );
				} else {
					if ( isset( $_POST['type'] ) ) {
						switch ( $_POST['type'] ) {
							case 'product':
								$this->lcwp_send_re_sync_request( 'product' );
								break;
							case 'contact':
								$this->lcwp_send_re_sync_request( 'contact' );
								break;
							case 'order':
								$this->lcwp_send_re_sync_request( 'order' );
								break;
							default:
								flash( 'Something went wrong. Please try again later', 'danger' );
								wp_safe_redirect( get_admin_url() . 'admin.php?page=lazychat_settings' );
								break;
						}
					} else {
						flash( 'Something went wrong. Please try again later', 'danger' );
						wp_safe_redirect( get_admin_url() . 'admin.php?page=lazychat_settings' );
					}
				}
			} catch ( \Throwable $th ) {
				flash( $th->getMessage(), 'danger' );
				wp_safe_redirect( get_admin_url() . 'admin.php?page=lazychat_settings' );
			}
		}

		/**
		 * This function is used to send an Api request to hard re-sync data to lazychat.
		 *
		 * @param string $type The type of data to be re-synced.
		 * @return void
		 */
		public function lcwp_send_re_sync_request( $type ) {
			$result = wp_remote_request(
				$this->lazychat_url . '/api/v1/woocommerce/hard-re-sync',
				array(
					'method'  => 'POST',
					'headers' => array(
						'Content-Type'  => 'application/json',
						'Authorization' => 'Bearer ' . get_option( 'lcwp_auth_token' ),
					),
					'body'    => wp_json_encode( array( 'type' => $type ) ),
				)
			);

			if ( ! is_wp_error( $result ) ) {
				$result = json_decode( wp_remote_retrieve_body( $result ), true );
			}

			if ( isset( $result['status'] ) && 'success' === $result['status'] ) {
				flash( $result['message'], 'success' );
			} else {
				flash( $result['message'], 'danger' );
			}
			wp_safe_redirect( get_admin_url() . 'admin.php?page=lazychat_settings' );
		}

		/**
		 * This method is used to get the queue progress from lazychat.
		 *
		 * @return void
		 */
		public function lcwp_get_queue_progress() {
			$result = wp_remote_request(
				$this->lazychat_url . '/api/v1/woocommerce/queue-progress',
				array(
					'method'  => 'POST',
					'headers' => array(
						'Content-Type'  => 'application/json',
						'Authorization' => 'Bearer ' . get_option( 'lcwp_auth_token' ),
					),
				)
			);

			if ( ! is_wp_error( $result ) ) {
				wp_send_json_success( wp_remote_retrieve_body( $result ) );
			}
		}

		/**
		 * This method is used to deactivate the plugin.
		 *
		 * @return void
		 */
		public function lcwp_deactivate_lazychat() {
			if ( ! wp_verify_nonce( isset( $_POST['nonce'] ), 'ajax-nonce' ) ) {
				wp_kses_post( __( 'Sorry, your nonce did not verify.', 'lazychat' ), array( 'p' => array() ) );
			}
			try {
				if ( get_option( 'lcwp_auth_token' ) === '' ) {
					deactivate_plugins( 'lazychat/lazychat.php' );
					wp_send_json_success(
						array(
							'status'  => 'success',
							'message' => 'LazyChat has been deactivated successfully',
						)
					);
				} else {
					$result = wp_remote_request(
						$this->lazychat_url . '/api/v1/woocommerce/deactivate',
						array(
							'method'  => 'POST',
							'headers' => array(
								'Content-Type'  => 'application/json',
								'Authorization' => 'Bearer ' . get_option( 'lcwp_auth_token' ),
							),
							'body'    => wp_json_encode( $_POST ),
						)
					);

					if ( ! is_wp_error( $result ) ) {
						$result = json_decode( wp_remote_retrieve_body( $result ), true );
					}

					if ( isset( $result ) && isset( $result['status'] ) && 'success' === $result['status'] ) {
						/**
						 * Delete all the plugin options from DB
						 */
						delete_option( 'lcwp_shop_name' );
						delete_option( 'lcwp_auth_token' );
						delete_option( 'lcwp_order_phases' );
						delete_option( 'lcwp_sync_options' );
						delete_option( 'lcwp_shop_id' );
						delete_option( 'lcwp_last_fetched_time' );

						/**
						 * Delete all the webhooks
						 */
						( new Lcwp_connect() )->lcwp_delete_previous_webhooks();

						/**
						 * Deactivate lazychat plugin
						 */
						deactivate_plugins( 'lazychat/lazychat.php' );
					}

					wp_send_json_success( $result );
				}
			} catch ( \Throwable $th ) {
				wp_send_json_success(
					array(
						'status'  => 'error',
						'message' => $th->getMessage(),
					)
				);
			}
		}
	}
}
