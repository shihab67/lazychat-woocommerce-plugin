<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined('ABSPATH') || exit;

if (!class_exists('Lswp_settings')) {
	class Lswp_settings
	{
		public function lswp_handle_settings()
		{
			check_admin_referer('lswp_upload_data_verify');

			if (!current_user_can('manage_options')) {
				wp_die(__('You do not have sufficient permissions to perform this operation.'));
			}

			if (isset($_POST['upload_type'])) {
				switch ($_POST['upload_type']) {
					case 'upload_product':
						$this->lswp_upload_data('upload_product');
						break;
					case 'upload_contact':
						$this->lswp_upload_data('upload_contact');
						break;
					case 'upload_order':
						$this->lswp_upload_data('upload_order');
						break;
					case 'fetch_product':
						$this->lswp_upload_data('fetch_product');
						break;
					case 'fetch_contact':
						$this->lswp_upload_data('fetch_contact');
						break;
					case 'fetch_order':
						$this->lswp_upload_data('fetch_order');
						break;
					default:
						# code...
						break;
				}
			}
		}

		public function lswp_upload_data($type)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, LAZYCHAT_URL . '/api/v1/woocommerce/fetch-upload-data');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			$data = [
				'type' => $type,
			];
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
			$headers = array();
			$headers[] = 'Content-Type: application/json';
			$headers[] = 'Authorization: Bearer ' . get_option('lswp_auth_token');
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
				curl_setopt($ch, CURLOPT_URL, LAZYCHAT_URL . '/api/v1/woocommerce/sync-options');
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($_POST));
				$headers = array();
				$headers[] = 'Content-Type: application/json';
				$headers[] = 'Authorization: Bearer ' . get_option('lswp_auth_token');
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
			curl_setopt($ch, CURLOPT_URL, LAZYCHAT_URL . '/api/v1/woocommerce/hard-re-sync');
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($type));
			$headers = array();
			$headers[] = 'Content-Type: application/json';
			$headers[] = 'Authorization: Bearer ' . get_option('lswp_auth_token');
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
	}
}
