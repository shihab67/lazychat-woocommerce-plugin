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
					case 'product':
						$this->lswp_upload_data('product');
						exit;
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
			curl_setopt($ch, CURLOPT_URL, LAZYCHAT_URL . '/api/v1/woocommerce/upload-data');
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

			var_dump($result);
			exit;

			if (isset($result['error'])) {
				wp_die($result['error']);
				exit;
			} else if ($result['success']) {
				flash($result['message'], 'success');

				//redirect back to settings page
				wp_redirect(get_admin_url() . 'admin.php?page=lazychat_settings');
				exit;
			} else {
				wp_die('Something went wrong. Please try again later');
				exit;
			}
		}
	}
}