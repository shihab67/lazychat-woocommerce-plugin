<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined('ABSPATH') || exit;

if (!class_exists('Lcwp_settings')) {
	class Lcwp_settings
	{
		// public $lazychat_url = 'http://chatbot.test';
		public $lazychat_url = 'https://client.lazychat.io';

		public function lcwp_handle_settings()
		{
			check_admin_referer('lcwp_upload_data_verify');

			if (!current_user_can('manage_options')) {
				wp_die(__('You do not have sufficient permissions to perform this operation.'));
			}

			if (isset($_POST['upload_type'])) {
				switch ($_POST['upload_type']) {
					case 'upload_product':
						$this->lcwp_upload_data('upload_product');
						break;
					case 'upload_contact':
						$this->lcwp_upload_data('upload_contact');
						break;
					case 'upload_order':
						$this->lcwp_upload_data('upload_order');
						break;
					case 'fetch_product':
						$this->lcwp_upload_data('fetch_product');
						break;
					case 'fetch_contact':
						$this->lcwp_upload_data('fetch_contact');
						break;
					case 'fetch_order':
						$this->lcwp_upload_data('fetch_order');
						break;
					default:
						# code...
						break;
				}
			}
		}

		public function lcwp_upload_data($type)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->lazychat_url . '/api/v1/woocommerce/fetch-upload-data');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			$data = [
				'type' => $type,
			];
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
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

			if ((isset($result['status']) && $result['status'] === 'error')) {
				flash($result['message'], 'danger');

				//redirect back to settings page
				wp_redirect(get_admin_url() . 'admin.php?page=lazychat_settings');
				exit;
			} else if ((isset($result['status']) && $result['status'] === 'success')) {
				flash($result['message'], 'success');

				//redirect back to settings page
				wp_redirect(get_admin_url() . 'admin.php?page=lazychat_settings');
				exit;
			} else {
				wp_die('Something went wrong. Please try again later');
				exit;
			}
		}

		public function lcwp_sync_options()
		{
			check_admin_referer('lcwp_sync_options_verify');

			if (!current_user_can('manage_options')) {
				echo json_encode([
					'status' => 'error',
					'msg' => 'You do not have sufficient permissions to perform this operation!'
				]);
				exit;
			} else {
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $this->lazychat_url . '/api/v1/woocommerce/sync-options');
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

				if (isset($result['status']) && $result['status'] === 'success' && get_option('lcwp_sync_options')) {
					update_option(
						'lcwp_sync_options',
						$result['options']
					);
				}

				echo json_encode([
					'status' => $result['status'],
					'msg' => $result['message'],
				]);
				exit;
			}
		}

		public function lcwp_hard_re_sync()
		{
			try {
				check_admin_referer('lcwp_hard_re_sync_verify');

				if (!current_user_can('manage_options')) {
					flash('You do not have sufficient permissions to perform this operation!', 'danger');
					wp_redirect(get_admin_url() . 'admin.php?page=lazychat_settings');
				} else {
					if (isset($_POST['type'])) {
						switch ($_POST['type']) {
							case 'product':
								$this->lcwp_send_re_sync_request('product');
								break;
							case 'contact':
								$this->lcwp_send_re_sync_request('contact');
								break;
							case 'order':
								$this->lcwp_send_re_sync_request('order');
								break;
							default:
								flash('Something went wrong. Please try again later', 'danger');
								wp_redirect(get_admin_url() . 'admin.php?page=lazychat_settings');
								break;
						}
					} else {
						flash('Something went wrong. Please try again later', 'danger');
						wp_redirect(get_admin_url() . 'admin.php?page=lazychat_settings');
					}
				}
			} catch (\Throwable $th) {
				flash($th->getMessage(), 'danger');
				wp_redirect(get_admin_url() . 'admin.php?page=lazychat_settings');
			}
		}

		public function lcwp_send_re_sync_request($type)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->lazychat_url . '/api/v1/woocommerce/hard-re-sync');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(['type' => $type]));
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

			if (isset($result['status']) && $result['status'] === 'success') {
				flash($result['message'], 'success');
			} else {
				flash($result['message'], 'danger');
			}
			wp_redirect(get_admin_url() . 'admin.php?page=lazychat_settings');
		}

		public function lcwp_get_queue_progress()
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->lazychat_url . '/api/v1/woocommerce/queue-progress');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			$headers = array();
			$headers[] = 'Content-Type: application/json';
			$headers[] = 'Authorization: Bearer ' . get_option('lcwp_auth_token');
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			$result = curl_exec($ch);
			if (curl_errno($ch)) {
				echo 'Error:' . curl_error($ch);
			}
			curl_close($ch);

			wp_send_json_success($result);
		}

		public function lcwp_deactivate_lazychat()
		{
			try {
				if (get_option('lcwp_auth_token') === "") {
					deactivate_plugins('lazychat/lazychat.php');
					wp_send_json_success([
						'status' => 'success',
						'message' => 'LazyChat has been deactivated successfully',
					]);
				} else {
					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL, $this->lazychat_url . '/api/v1/woocommerce/deactivate');
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

					if (isset($result) && isset($result['status']) && $result['status'] === 'success') {
						//Delete all the lcwp options from DB
						delete_option('lcwp_shop_name');
						delete_option('lcwp_auth_token');
						delete_option('lcwp_order_phases');
						delete_option('lcwp_sync_options');
						delete_option('lcwp_shop_id');
						delete_option('lcwp_last_fetched_time');

						//Delete all the webhooks
						(new Lcwp_connect())->lcwp_delete_previous_webhooks();

						//Deactivate lazychat plugin
						deactivate_plugins('lazychat/lazychat.php');
					}

					wp_send_json_success($result);
				}
			} catch (\Throwable $th) {
				wp_send_json_success([
					'status' => 'error',
					'message' => $th->getMessage(),
				]);
			}
		}
	}
}
