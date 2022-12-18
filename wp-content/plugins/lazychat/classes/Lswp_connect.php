<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined('ABSPATH') || exit;

if (!class_exists('Lswp_connect')) {
	class Lswp_connect
	{
		public function lswp_connect_with_lazychat()
		{
			check_admin_referer('lswp_connect_verify');

			if (!current_user_can('manage_options')) {
				wp_die(__('You do not have sufficient permissions to perform this operation.'));
			}

			$data = [
				'lswp_auth_token' => sanitize_text_field($_POST['lswp_auth_token']),
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
				update_option('lswp_auth_token', $data['lswp_auth_token']);

				//redirect back to settings page
				wp_redirect(get_admin_url() . 'admin.php?page=lazychat_settings');
				exit;
			} else {
				wp_die('Something went wrong. Please try again later');
				exit;
			}
		}

		public function lswp_map_order_phase()
		{
			check_admin_referer('lswp_map_order_phase_verify');

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
			$headers[] = 'Authorization: Bearer ' . get_option('lswp_auth_token');
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
				update_option('lswp_order_phases', [
					'mapped' => true,
					'phases' => $result['phases']
				]);

				if (isset($_SESSION['lazychat_order_phases'])) {
					$_SESSION['lazychat_order_phases'] = $result['phases'];
				}

				echo json_encode([
					'status' => 'success',
					'msg' => $result['message']
				]);
				exit;
			}
		}
	}
}
