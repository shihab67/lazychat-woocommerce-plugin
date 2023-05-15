<?php
/**
 * This file contains the class for connecting with LazyChat.
 *
 * @package LazyChat WooCommerce Plugin
 */

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'Lcwp_Connect' ) ) {
	/**
	 * This class is used to connect with LazyChat.
	 */
	class Lcwp_Connect {
		/**
		 * This variable holds the url of lazychat.
		 *
		 * @var string type of this variable.
		 */
		public $lazychat_url = LAZYCHAT_URL;

		/**
		 * This function is used to connect the plugin with LazyChat.
		 */
		public function lcwp_connect_with_lazychat() {
			check_admin_referer( 'lcwp_connect_verify' );

			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'You do not have sufficient permissions to perform this operation.' ) );
			}

			$data = array(
				'lcwp_auth_token' => sanitize_text_field(
					isset( $_POST ) &&
					isset( $_POST['lcwp_auth_token'] ) ? $_POST['lcwp_auth_token'] : ''
				),
			);

			$result = wp_remote_request(
				$this->lazychat_url . '/api/v1/woocommerce/connect',
				array(
					'method'  => 'POST',
					'headers' => array(
						'Content-Type' => 'application/json',
					),
					'body'    => wp_json_encode( $data ),
				)
			);

			if ( ! is_wp_error( $result ) ) {
				$result = json_decode( wp_remote_retrieve_body( $result ), true );
			}

			if ( isset( $result['error'] ) ) {
				wp_die( esc_html( $result['error'] ) );
				exit;
			} elseif ( $result['success'] ) {
				flash( $result['message'], 'success' );

				/**
				 * Save the auth token to DB.
				 */
				update_option( 'lcwp_auth_token', $result['auth_token'] );

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
		 * This function is used to map order phases with lazychat.
		 *
		 * @return array of message either success or error.
		 */
		public function lcwp_map_order_phase() {
			try {
				check_admin_referer( 'lcwp_map_order_phase_verify' );

				if ( ! current_user_can( 'manage_options' ) ) {
					return array(
						'status' => 'error',
						'msg'    => 'You do not have sufficient permissions to perform this operation!',
					);
				}

				$result = wp_remote_request(
					$this->lazychat_url . '/api/v1/woocommerce/map-order-phase',
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

				if ( 'error' === $result['status'] ) {
					echo wp_json_encode(
						array(
							'status' => 'error',
							'msg'    => $result['message'],
						)
					);
					exit;
				} else {
					/**
					 * Update lcwp_order_phases data.
					 */
					update_option(
						'lcwp_order_phases',
						array(
							'mapped' => true,
							'phases' => $result['phases'],
						)
					);

					/**
					 * Check if order phases are already mapped.
					 */
					if ( isset( $_POST ) && isset( $_POST['is_mapped'] ) && 0 == $_POST['is_mapped'] ) {
						/**
						 * Create woocommerce webhooks.
						 */
						$this->lcwp_create_webhooks();

						if ( isset( $result['shop_id'] ) && get_option( 'lcwp_shop_id' ) === '' ) {
							update_option(
								'lcwp_shop_id',
								$result['shop_id']
							);
						}

						if ( isset( $result['shop_name'] ) && get_option( 'lcwp_shop_name' ) === '' ) {
							update_option(
								'lcwp_shop_name',
								$result['shop_name']
							);
						}

						if ( isset( $result['last_fetched_times'] ) && get_option( 'lcwp_last_fetched_time' ) === '' ) {
							update_option( 'lcwp_last_fetched_time', $result['last_fetched_times'] );
						}
					}

					/**
					 * Store order phases in session.
					 */
					if ( isset( $_SESSION['lazychat_order_phases'] ) ) {
						$_SESSION['lazychat_order_phases'] = $result['phases'];
					}

					echo wp_json_encode(
						array(
							'status' => 'success',
							'msg'    => $result['message'],
						)
					);
					exit;
				}
			} catch ( \Throwable $th ) {
				echo wp_json_encode(
					array(
						'status' => 'error',
						'msg'    => $th->getMessage(),
					)
				);
				exit;
			}
		}

		/**
		 * This function is used to create the webhooks for woocommerce.
		 *
		 * @return bool
		 * @throws \RuntimeException If something went wrong.
		 */
		public function lcwp_create_webhooks() {
			try {
				/**
				 * Delete previous webhooks.
				 */
				$this->lcwp_delete_previous_webhooks();

				/**
				 * Create woocommerce webhooks.
				 */
				$webhooks = array(
					array(
						'status'           => 'active',
						'name'             => 'LazyChat - Order created',
						'user_id'          => get_current_user_id(),
						'delivery_url'     => $this->lazychat_url . '/api/v1/woocommerce/webhooks/orders/' . get_option( 'lcwp_auth_token' ),
						'secret'           => base64_encode( random_bytes( 10 ) ),
						'topic'            => 'order.created',
						'date_created'     => gmdate( 'Y-m-d H:i:s' ),
						'date_created_gmt' => gmdate( 'Y-m-d H:i:s' ),
						'api_version'      => 3,
					),
					array(
						'status'           => 'active',
						'name'             => 'LazyChat - Order updated',
						'user_id'          => get_current_user_id(),
						'delivery_url'     => $this->lazychat_url . '/api/v1/woocommerce/webhooks/orders/' . get_option( 'lcwp_auth_token' ),
						'secret'           => base64_encode( random_bytes( 10 ) ),
						'topic'            => 'order.updated',
						'date_created'     => gmdate( 'Y-m-d H:i:s' ),
						'date_created_gmt' => gmdate( 'Y-m-d H:i:s' ),
						'api_version'      => 3,
					),
					array(
						'status'           => 'active',
						'name'             => 'LazyChat - Order deleted',
						'user_id'          => get_current_user_id(),
						'delivery_url'     => $this->lazychat_url . '/api/v1/woocommerce/webhooks/orders/' . get_option( 'lcwp_auth_token' ),
						'secret'           => base64_encode( random_bytes( 10 ) ),
						'topic'            => 'order.deleted',
						'date_created'     => gmdate( 'Y-m-d H:i:s' ),
						'date_created_gmt' => gmdate( 'Y-m-d H:i:s' ),
						'api_version'      => 3,
					),
					array(
						'status'           => 'active',
						'name'             => 'LazyChat - Product created',
						'user_id'          => get_current_user_id(),
						'delivery_url'     => $this->lazychat_url . '/api/v1/woocommerce/webhooks/products/' . get_option( 'lcwp_auth_token' ),
						'secret'           => base64_encode( random_bytes( 10 ) ),
						'topic'            => 'product.created',
						'date_created'     => gmdate( 'Y-m-d H:i:s' ),
						'date_created_gmt' => gmdate( 'Y-m-d H:i:s' ),
						'api_version'      => 3,
					),
					array(
						'status'           => 'active',
						'name'             => 'LazyChat - Product updated',
						'user_id'          => get_current_user_id(),
						'delivery_url'     => $this->lazychat_url . '/api/v1/woocommerce/webhooks/products/' . get_option( 'lcwp_auth_token' ),
						'secret'           => base64_encode( random_bytes( 10 ) ),
						'topic'            => 'product.updated',
						'date_created'     => gmdate( 'Y-m-d H:i:s' ),
						'date_created_gmt' => gmdate( 'Y-m-d H:i:s' ),
						'api_version'      => 3,
					),
					array(
						'status'           => 'active',
						'name'             => 'LazyChat - Product deleted',
						'user_id'          => get_current_user_id(),
						'delivery_url'     => $this->lazychat_url . '/api/v1/woocommerce/webhooks/products/' . get_option( 'lcwp_auth_token' ),
						'secret'           => base64_encode( random_bytes( 10 ) ),
						'topic'            => 'product.deleted',
						'date_created'     => gmdate( 'Y-m-d H:i:s' ),
						'date_created_gmt' => gmdate( 'Y-m-d H:i:s' ),
						'api_version'      => 3,
					),
					array(
						'status'           => 'active',
						'name'             => 'LazyChat - Contact created',
						'user_id'          => get_current_user_id(),
						'delivery_url'     => $this->lazychat_url . '/api/v1/woocommerce/webhooks/customers/' . get_option( 'lcwp_auth_token' ),
						'secret'           => base64_encode( random_bytes( 10 ) ),
						'topic'            => 'customer.created',
						'date_created'     => gmdate( 'Y-m-d H:i:s' ),
						'date_created_gmt' => gmdate( 'Y-m-d H:i:s' ),
						'api_version'      => 3,
					),
					array(
						'status'           => 'active',
						'name'             => 'LazyChat - Contact updated',
						'user_id'          => get_current_user_id(),
						'delivery_url'     => $this->lazychat_url . '/api/v1/woocommerce/webhooks/customers/' . get_option( 'lcwp_auth_token' ),
						'secret'           => base64_encode( random_bytes( 10 ) ),
						'topic'            => 'customer.updated',
						'date_created'     => gmdate( 'Y-m-d H:i:s' ),
						'date_created_gmt' => gmdate( 'Y-m-d H:i:s' ),
						'api_version'      => 3,
					),
					array(
						'status'           => 'active',
						'name'             => 'LazyChat - Contact deleted',
						'user_id'          => get_current_user_id(),
						'delivery_url'     => $this->lazychat_url . '/api/v1/woocommerce/webhooks/customers/' . get_option( 'lcwp_auth_token' ),
						'secret'           => base64_encode( random_bytes( 10 ) ),
						'topic'            => 'customer.deleted',
						'date_created'     => gmdate( 'Y-m-d H:i:s' ),
						'date_created_gmt' => gmdate( 'Y-m-d H:i:s' ),
						'api_version'      => 3,
					),
				);

				foreach ( $webhooks as $webhook ) {
					$insert = new WC_Webhook();
					$insert->set_name( $webhook['name'] );
					$insert->set_user_id( $webhook['user_id'] ); // User ID used while generating the webhook payload.
					$insert->set_topic( $webhook['topic'] ); // Event used to trigger a webhook.
					$insert->set_secret( $webhook['secret'] ); // Secret to validate webhook when received.
					$insert->set_delivery_url( $webhook['delivery_url'] ); // URL where webhook should be sent.
					$insert->set_status( $webhook['status'] ); // Webhook status.
					$insert->save();
				}

				return true;
			} catch ( \Throwable $th ) {
				throw new \RuntimeException( $th->getMessage() );
			}
		}

		/**
		 * This function is used to delete the previous webhooks.
		 *
		 * @return bool
		 * @throws \RuntimeException If something went wrong.
		 */
		public function lcwp_delete_previous_webhooks() {
			try {
				global $wpdb;

				/**
				 * Get all webhooks.
				 */
				$results = $wpdb->get_results( "SELECT webhook_id, delivery_url FROM {$wpdb->prefix}wc_webhooks" );

				foreach ( $results as $result ) {
					if ( strpos( $result->delivery_url, $this->lazychat_url ) !== false ) {
						$wh = new WC_Webhook();
						$wh->set_id( $result->webhook_id );
						$wh->delete();
					}
				}

				return true;
			} catch ( \Throwable $th ) {
				throw new \RuntimeException( $th->getMessage() );
			}
		}
	}
}
