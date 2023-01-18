<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined('ABSPATH') || exit;

if (!class_exists('Lcwp_connect')) {
	class Lcwp_connect
	{
		public function lcwp_connect_with_lazychat()
		{
			check_admin_referer('lcwp_connect_verify');

			if (!current_user_can('manage_options')) {
				wp_die(__('You do not have sufficient permissions to perform this operation.'));
			}

			$data = [
				'lcwp_auth_token' => sanitize_text_field($_POST['lcwp_auth_token']),
			];

			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, LAZYCHAT_URL . '/api/v1/woocommerce/connect');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$headers = array();
			$headers[] = 'Content-Type: application/json';
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			curl_close($ch);

			if (isset($result)) $result = json_decode($result, true);

			if (isset($result['error'])) {
				wp_die($result['error']);
				exit;
			} else if ($result['success']) {
				flash($result['message'], 'success');

				//save the auth token to DB
				update_option('lcwp_auth_token', $result['auth_token']);

				//redirect back to settings page
				wp_redirect(get_admin_url() . 'admin.php?page=lazychat_settings');
				exit;
			} else {
				wp_die('Something went wrong. Please try again later');
				exit;
			}
		}

		public function lcwp_map_order_phase()
		{
			try {
				check_admin_referer('lcwp_map_order_phase_verify');

				if (!current_user_can('manage_options')) {
					return [
						'status' => 'error',
						'msg' => 'You do not have sufficient permissions to perform this operation!'
					];
				}

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, LAZYCHAT_URL . '/api/v1/woocommerce/map-order-phase');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($_POST));
				$headers = array();
				$headers[] = 'Content-Type: application/json';
				$headers[] = 'Authorization: Bearer ' . get_option('lcwp_auth_token');
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
				$result = curl_exec($ch);
				if (curl_errno($ch)) {
					echo 'Error:' . curl_error($ch);
				}
				curl_close($ch);

				if (isset($result)) $result = json_decode($result, true);

				if ($result['status'] === 'error') {
					echo json_encode([
						'status' => 'error',
						'msg' => $result['message']
					]);
					exit;
				} else {
					//Update lcwp_order_phases data
					update_option('lcwp_order_phases', [
						'mapped' => true,
						'phases' => $result['phases']
					]);

					//Check if order phases are already mapped
					if ($_POST['is_mapped'] == 0) {
						//create woocommerce webhooks
						$this->lcwp_create_webhooks();

						if (isset($result['shop_id']) && get_option('lcwp_shop_id') == "") {
							update_option(
								'lcwp_shop_id',
								$result['shop_id']
							);
						}

						if (isset($result['last_fetched_times']) && get_option('lcwp_last_fetched_time') == "") {
							update_option('lcwp_last_fetched_time', $result['last_fetched_times']);
						}
					}

					//Store order phases in session
					if (isset($_SESSION['lazychat_order_phases'])) {
						$_SESSION['lazychat_order_phases'] = $result['phases'];
					}

					echo json_encode([
						'status' => 'success',
						'msg' => $result['message']
					]);
					exit;
				}
			} catch (\Throwable $th) {
				echo json_encode([
					'status' => 'error',
					'msg' => $th->getMessage()
				]);
				exit;
			}
		}

		public function lcwp_create_webhooks()
		{
			try {
				//Delete previous webhooks
				$this->lcwp_delete_previous_webhooks();

				//Create woocommerce webhooks
				$webhooks = [
					[
						'status' => 'active',
						'name' => 'LazyChat - Order created',
						'user_id' => get_current_user_id(),
						'delivery_url' => LAZYCHAT_URL . '/webhooks/woocommerce-orders/' . get_option('lcwp_auth_token'),
						'secret' => base64_encode(random_bytes(10)),
						'topic' => 'order.created',
						'date_created' => date('Y-m-d H:i:s'),
						'date_created_gmt' => date('Y-m-d H:i:s'),
						'api_version' => 3
					],
					[
						'status' => 'active',
						'name' => 'LazyChat - Order updated',
						'user_id' => get_current_user_id(),
						'delivery_url' => LAZYCHAT_URL . '/webhooks/woocommerce-orders/' . get_option('lcwp_auth_token'),
						'secret' => base64_encode(random_bytes(10)),
						'topic' => 'order.updated',
						'date_created' => date('Y-m-d H:i:s'),
						'date_created_gmt' => date('Y-m-d H:i:s'),
						'api_version' => 3
					],
					[
						'status' => 'active',
						'name' => 'LazyChat - Order deleted',
						'user_id' => get_current_user_id(),
						'delivery_url' => LAZYCHAT_URL . '/webhooks/woocommerce-orders/' . get_option('lcwp_auth_token'),
						'secret' => base64_encode(random_bytes(10)),
						'topic' => 'order.deleted',
						'date_created' => date('Y-m-d H:i:s'),
						'date_created_gmt' => date('Y-m-d H:i:s'),
						'api_version' => 3
					],
					[
						'status' => 'active',
						'name' => 'LazyChat - Product created',
						'user_id' => get_current_user_id(),
						'delivery_url' => LAZYCHAT_URL . '/webhooks/woocommerce-products/' . get_option('lcwp_auth_token'),
						'secret' => base64_encode(random_bytes(10)),
						'topic' => 'product.created',
						'date_created' => date('Y-m-d H:i:s'),
						'date_created_gmt' => date('Y-m-d H:i:s'),
						'api_version' => 3
					],
					[
						'status' => 'active',
						'name' => 'LazyChat - Product updated',
						'user_id' => get_current_user_id(),
						'delivery_url' => LAZYCHAT_URL . '/webhooks/woocommerce-products/' . get_option('lcwp_auth_token'),
						'secret' => base64_encode(random_bytes(10)),
						'topic' => 'product.updated',
						'date_created' => date('Y-m-d H:i:s'),
						'date_created_gmt' => date('Y-m-d H:i:s'),
						'api_version' => 3
					],
					[
						'status' => 'active',
						'name' => 'LazyChat - Product deleted',
						'user_id' => get_current_user_id(),
						'delivery_url' => LAZYCHAT_URL . '/webhooks/woocommerce-products/' . get_option('lcwp_auth_token'),
						'secret' => base64_encode(random_bytes(10)),
						'topic' => 'product.deleted',
						'date_created' => date('Y-m-d H:i:s'),
						'date_created_gmt' => date('Y-m-d H:i:s'),
						'api_version' => 3
					],
					[
						'status' => 'active',
						'name' => 'LazyChat - Contact created',
						'user_id' => get_current_user_id(),
						'delivery_url' => LAZYCHAT_URL . '/webhooks/woocommerce-customers/' . get_option('lcwp_auth_token'),
						'secret' => base64_encode(random_bytes(10)),
						'topic' => 'customer.created',
						'date_created' => date('Y-m-d H:i:s'),
						'date_created_gmt' => date('Y-m-d H:i:s'),
						'api_version' => 3
					],
					[
						'status' => 'active',
						'name' => 'LazyChat - Contact updated',
						'user_id' => get_current_user_id(),
						'delivery_url' => LAZYCHAT_URL . '/webhooks/woocommerce-customers/' . get_option('lcwp_auth_token'),
						'secret' => base64_encode(random_bytes(10)),
						'topic' => 'customer.updated',
						'date_created' => date('Y-m-d H:i:s'),
						'date_created_gmt' => date('Y-m-d H:i:s'),
						'api_version' => 3
					],
					[
						'status' => 'active',
						'name' => 'LazyChat - Contact deleted',
						'user_id' => get_current_user_id(),
						'delivery_url' => LAZYCHAT_URL . '/webhooks/woocommerce-customers/' . get_option('lcwp_auth_token'),
						'secret' => base64_encode(random_bytes(10)),
						'topic' => 'customer.deleted',
						'date_created' => date('Y-m-d H:i:s'),
						'date_created_gmt' => date('Y-m-d H:i:s'),
						'api_version' => 3
					],
				];

				foreach ($webhooks as $webhook) {
					$insert = new WC_Webhook();
					$insert->set_name($webhook['name']);
					$insert->set_user_id($webhook['user_id']); // User ID used while generating the webhook payload.
					$insert->set_topic($webhook['topic']); // Event used to trigger a webhook.
					$insert->set_secret($webhook['secret']); // Secret to validate webhook when received.
					$insert->set_delivery_url($webhook['delivery_url']); // URL where webhook should be sent.
					$insert->set_status($webhook['status']); // Webhook status.
					$insert->save();
				}

				return true;
			} catch (\Throwable $th) {
				throw new \RuntimeException($th->getMessage());
			}
		}

		public function lcwp_delete_previous_webhooks()
		{
			try {
				global $wpdb;

				//Get all webhooks
				$results = $wpdb->get_results("SELECT webhook_id, delivery_url FROM {$wpdb->prefix}wc_webhooks");

				foreach ($results as $result) {
					if (strpos($result->delivery_url, LAZYCHAT_URL) !== false) {
						$wh = new WC_Webhook();
						$wh->set_id($result->webhook_id);
						$wh->delete();
					}
				}

				return true;
			} catch (\Throwable $th) {
				throw new \RuntimeException($th->getMessage());
			}
		}
	}
}
