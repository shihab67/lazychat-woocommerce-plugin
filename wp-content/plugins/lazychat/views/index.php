<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined('ABSPATH') || exit;

function lazychat_settings_page()
{
?>
	<!-- css files -->
	<link rel="stylesheet" href="<?php echo plugins_url('lazychat/assets/css/lite-purple.min.css'); ?>">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="<?php echo plugins_url('lazychat/assets/css/toastr.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo plugins_url('lazychat/assets/css/smart_wizard_theme_arrows.min.css'); ?>">
	<link rel="stylesheet" href="<?php echo plugins_url('lazychat/assets/css/custom.css'); ?>">
	<link rel="stylesheet" href="<?php echo plugins_url('lazychat/assets/css/loader.css'); ?>">

	<div class="container-fluid lazychat-body">
		<img class="mb-2" src="<?php echo plugins_url('lazychat/assets/images/Lazychat Logo-03.png'); ?>" alt="lazychat logo" height="30">

		<?php include(LCWP_PATH . 'views/alert/alert.php'); ?>

		<?php
		if (
			get_option('lcwp_auth_token') &&
			get_option('lcwp_auth_token') === null ||
			!get_option('lcwp_auth_token')
		) {
			include(LCWP_PATH . 'views/connect/connect.php');
		} else if (
			get_option('lcwp_auth_token') &&
			get_option('lcwp_auth_token') !== null &&
			get_option('lcwp_order_phases') &&
			get_option('lcwp_order_phases')['mapped'] === false
		) {
		?>
		<?php
			include(LCWP_PATH . 'views/connect/map-phases.php');
		} else {
			include(LCWP_PATH . 'views/settings/settings.php');
		}
		?>
	</div>

	<!-- js files -->
	<script src="<?php echo plugins_url('lazychat/assets/js/jquery-3.3.1.min.js'); ?>"></script>
	<script src="<?php echo plugins_url('lazychat/assets/js/bootstrap.bundle.min.js'); ?>"></script>
	<script src="<?php echo plugins_url('lazychat/assets/js/toastr.min.js'); ?>"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
	<script src="https://js.pusher.com/7.2.0/pusher.min.js"></script>
	<script src="<?php echo plugins_url('lazychat/assets/js/echo.js'); ?>"></script>
	<script src="<?php echo plugins_url('lazychat/assets/js/scripts.js'); ?>"></script>

	<script type="text/javascript">
		jQuery(document).ready(function() {
			$('.select2').select2({
				placeholder: 'Select...',
				allowClear: true,
				width: '100%'
			});

			$(document).on('change', '.lazychat-order-phase', function() {
				var value = $(this).val();
				var code = $(this).data('code');

				if (value == 'create-new') {
					$(this).parent().find('#create-new').show();
					$(this).parent().find('#create-new').prop('required', true);
				} else {
					$(this).parent().find('#create-new').hide();
					$(this).parent().find('#create-new').prop('required', false);
				}
			});

			$(document).on('submit', '#map-phase-form', function(e) {
				e.preventDefault();

				var selects = $('.lazychat-order-phase');

				var values = [];
				for (i = 0; i < selects.length; i++) {
					var select = selects[i];
					var value = $(select).val();
					var code = $(select).data('code');

					if (value == 'create-new') {
						values.push($(select).parent().find('#create-new').val().toLowerCase());
					} else values.push(value);

					if (values[i] == '') {
						toastr.error('Some fields are empty. Please fill them!', {
							progressBar: !0,
							closeButton: !0
						});
						return false;
					}
				}

				var seen = values.filter((s => v => s.has(v) || !s.add(v))(new Set));
				if (seen.length > 0) {
					toastr.error('Some phases are selected multiple times. Please select different ones!', {
						progressBar: !0,
						closeButton: !0
					});
				} else {
					$('#map-phase-form').find('.submit').prop('disabled', true);
					$('#map-phase-form').find('.submit').html("Please Wait...");

					$.ajax({
						url: '<?php echo admin_url('admin-ajax.php'); ?>',
						method: "POST",
						data: new FormData(this),
						contentType: false,
						cache: false,
						processData: false,
						dataType: "json",
						success: function(res) {
							if (res.status == 'success') {
								toastr.success(
									res.msg, {
										progressBar: !0,
										closeButton: !0
									});

								$('#map-phase-form').find('.submit').html("Order Phase Mapped Successfully");

								setTimeout(function() {
									window.location.reload();
								}, 2000);
							} else {
								$('#map-phase-form').find('.submit').prop('disabled', false);
								$('#map-phase-form').find('.submit').html("Save");

								toastr.error(res.msg, {
									progressBar: !0,
									closeButton: !0
								});
							}
						}
					});
				}
			});

			$(document).on('change', '.sync', function() {
				var value = $(this).val();

				$.ajax({
					url: '<?php echo admin_url('admin-ajax.php'); ?>',
					method: "POST",
					data: new FormData($('#sync-options-form')[0]),
					contentType: false,
					cache: false,
					processData: false,
					dataType: "json",
					success: function(res) {
						if (res.status === 'success') {
							toastr.success(res.msg, {
								progressBar: !0,
								closeButton: !0
							});
						} else {
							toastr.error(res.msg, {
								progressBar: !0,
								closeButton: !0
							});
						}
					}
				});
			});

			$(document).on('click', '.resync-btn', function() {
				let type = $(this).attr('data-type');
				$('#hard-re-sync-form').find('input[name="type"]').val(type);
			});

			//Deactivate plugin
			$(".deactivate_lazychat_btn").click(function() {
				$(this).attr("disabled", "disabled");
				$(this).html("Deactivating...");

				deactivate();
			});

			//get the queue progress on page load starts
			wp.ajax.post("lcwp_get_queue_progress", {})
				.done(function(res) {
					console.log(res);
					res = JSON.parse(res);
					if (res.status === 'success') {
						progressBar(res.data);
					} else {
						console.log(res.message);
					}
				});
			//get the queue progress on page load ends

			// const pusher_app_host = '127.0.0.1';
			const pusher_app_host = 'client.lazychat.io';
			const isLocalhost = () => {
				return pusher_app_host === 'localhost' || pusher_app_host === '127.0.0.1';
			}

			window.Echo = new Echo({
				broadcaster: 'pusher',
				key: "<?php print PUSHER_APP_KEY; ?>",
				encrypted: true,
				wsHost: pusher_app_host,
				wsPort: 6001,
				wssPort: 6001,
				disableStats: false,
				forceTLS: !isLocalhost(),
				authEndpoint: (isLocalhost() ? 'http://' : 'https://') + pusher_app_host + '/broadcasting/auth',
			});

			Echo.private("<?php echo "user-channel-" . md5(get_option('lcwp_auth_token')); ?>").listen(
				'QueueProgress',
				(data) => {
					console.log(data);
					if (data.progress && data.progress.length > 0) {
						progressBar(data.progress)
					}
				});

			function progressBar(data) {
				$.each(data, function(index, value) {
					if (value['type'] == 'lcwp_fetch_product') {
						$('.no-sync').css('display', 'none');
						$('.product-sync-box').show();
						$('.product-fetch-btn').addClass('disabled');
						$('.product-fetch-btn').find('.title').html('Fetching');
						$('.product-fetch-btn').find('.bubble-loader').attr("style", "display:flex !important;");;
						$('.product-fetch-btn').closest('.row').find('.fetch-msg').html(
							'Fetch in progress...');

						if (!$('.product-bar-div').show()) {
							$('.product-bar-div').show();
						}

						if (value['total'] > 0) {
							var part_to_increase = 100 / value['total'];

							$('.product-bar-div').find('.progress-bar.bg-primary').css('width',
								part_to_increase * value['done'] + '%');
							$('.product-bar-div').find('.progress-bar.bg-danger').css('width',
								part_to_increase * value['failed'] + '%');
							$('.product-bar-div').find('.percent')
								.text(
									(((part_to_increase * value['done'])) + ((
										part_to_increase * value['failed']))).toFixed(2) + '%');

							if (value['total'] == value['done'] + value['failed']) {
								$('.product-bar-div').find('.sync-text').html(
									`<i class="{{ getIcon('check') }} text-success"></i> <b>Product fetch completed.</b>`
								);

								$('.product-fetch-btn').removeClass('disabled');
								$('.product-fetch-btn').html('Fetch Now');
								$('.product-fetch-btn').closest('.row').find('.fetch-msg').html(
									'<span class="font-weight-bold" style="color: #006c67">Fetch completed successfully...</span>'
								);
							}
						}
					} else if (value['type'] == "lcwp_upload_product") {
						$('.no-sync').css('display', 'none');
						$('.product-sync-box').show();
						$('.product-upload-btn').addClass('disabled');
						$('.product-upload-btn').find('.title').html('Uploading');
						$('.product-upload-btn').find('.bubble-loader').attr("style", "display:flex !important;");
						$('.product-upload-btn').closest('.row').find('.fetch-msg').html(
							'Upload in progress...');

						if (!$('.product-bar-div-upload').show()) {
							$('.product-bar-div-upload').show();
						}

						if (value['total'] > 0) {
							var part_to_increase = 100 / value['total'];

							$('.product-bar-div-upload').find('.progress-bar.bg-primary').css(
								'width',
								part_to_increase * value['done'] + '%');
							$('.product-bar-div-upload').find('.progress-bar.bg-danger').css(
								'width',
								part_to_increase * value['failed'] + '%');
							$(
									'.product-bar-div-upload').find('.percent')
								.text(
									(((part_to_increase * value['done'])) + ((
										part_to_increase * value['failed']))).toFixed(2) + '%');

							if (value['total'] == value['done'] + value['failed']) {
								$('.product-bar-div-upload').find('.sync-text').html(
									`<i class="{{ getIcon('check') }} text-success"></i> <b>Product upload completed!</b>`
								);

								$('.product-upload-btn').removeClass('disabled');
								$('.product-upload-btn').html('Upload Now');
								$('.product-upload-btn').closest('.row').find('.fetch-msg')
									.html(
										'<span class="font-weight-bold" style="color: #006c67">Upload completed successfully...</span>'
									);
							}
						}
					} else if (value['type'] == 'lcwp_fetch_contact') {
						$('.no-sync').css('display', 'none');
						$('.customer-sync-box').show();
						$('.contact-fetch-btn').addClass('disabled');
						$('.contact-fetch-btn').find('.title').html('Fetching');
						$('.contact-fetch-btn').find('.bubble-loader').attr("style", "display:flex !important;");
						$('.contact-fetch-btn').closest('.row').find('.fetch-msg').html(
							'Fetch in progress...');

						if (!$('.customer-bar-div').show()) {
							$('.customer-bar-div').show();
						}

						if (value['total'] > 0) {
							var part_to_increase = 100 / value['total'];

							$('.customer-bar-div').find('.progress-bar.bg-primary').css(
								'width',
								part_to_increase * value['done'] + '%');
							$('.customer-bar-div').find('.progress-bar.bg-danger').css(
								'width',
								part_to_increase * value['failed'] + '%');
							$('.customer-bar-div').find('.percent').text(
								(((part_to_increase * value['done'])) + ((
									part_to_increase * value['failed']))).toFixed(2) + '%');

							if (value['total'] == value['done'] + value['failed']) {
								$('.customer-bar-div').find('.sync-text').html(
									`<i class="{{ getIcon('check') }} text-success"></i> <b>Customer sync completed.</b>`
								);

								$('.contact-fetch-btn').removeClass('disabled');
								$('.contact-fetch-btn').html('Fetch Now');
								$('.contact-fetch-btn').closest('.row').find('.fetch-msg').html(
									'<span class="font-weight-bold" style="color: #006c67">Fetch completed successfully...</span>'
								);
							}
						}
					} else if (value['type'] == 'lcwp_upload_contact') {
						$('.no-sync').css('display', 'none');
						$('.customer-sync-box').show();
						$('.contact-upload-btn').addClass('disabled');
						$('.contact-upload-btn').find('.title').html('Uploading');
						$('.contact-upload-btn').find('.bubble-loader').attr("style", "display:flex !important;");
						$('.contact-upload-btn').closest('.row').find('.fetch-msg').html(
							'Upload in progress...');

						if (!$('.customer-bar-div-upload').show()) {
							$('.customer-bar-div-upload').show();
						}

						if (value['total'] > 0) {
							var part_to_increase = 100 / value['total'];

							$('.customer-bar-div-upload').find('.progress-bar.bg-primary').css(
								'width',
								part_to_increase * value['done'] + '%');
							$('.customer-bar-div-upload').find('.progress-bar.bg-danger').css(
								'width',
								part_to_increase * value['failed'] + '%');
							$('.customer-bar-div-upload').find('.percent').text(
								(((part_to_increase * value['done'])) + ((
									part_to_increase * value['failed']))).toFixed(2) + '%');

							if (value['total'] == value['done'] + value['failed']) {
								$('.customer-bar-div-upload').find('.sync-text').html(
									`<i class="{{ getIcon('check') }} text-success"></i> <b>Customer upload completed!</b>`
								);

								$('.contact-upload-btn').removeClass('disabled');
								$('.contact-upload-btn').html('Upload Now');
								$('.contact-upload-btn').closest('.row').find('.fetch-msg')
									.html(
										'<span class="font-weight-bold" style="color: #006c67">Upload completed successfully...</span>'
									);
							}
						}
					} else if (value['type'] == 'lcwp_fetch_order') {
						$('.no-sync').css('display', 'none');
						$('.order-sync-box').show();
						$('.order-fetch-btn').addClass('disabled');
						$('.order-fetch-btn').find('.title').html('Fetching');
						$('.order-fetch-btn').find('.bubble-loader').attr("style", "display:flex !important;");
						$('.order-fetch-btn').closest('.row').find('.fetch-msg').html(
							'Fetch in progress...');

						if (!$('.order-bar-div').show()) {
							$('.order-bar-div').show();
						}

						if (value['total'] > 0) {
							var part_to_increase = 100 / value['total'];

							$('.order-bar-div').find('.progress-bar.bg-primary').css('width',
								part_to_increase * value['done'] + '%');
							$('.order-bar-div').find('.progress-bar.bg-danger').css('width',
								part_to_increase * value['failed'] + '%');
							$('.order-bar-div').find('.percent').text(
								(((part_to_increase * value['done'])) + ((
									part_to_increase * value['failed']))).toFixed(2) + '%');

							if (value['total'] == value['done'] + value['failed']) {
								$('.order-bar-div').find('.sync-text').html(
									`<i class="{{ getIcon('check') }} text-success"></i> <b>Order sync completed.</b>`
								);

								$('.order-fetch-btn').removeClass('disabled');
								$('.order-fetch-btn').html('Fetch Now');
								$('.order-fetch-btn').closest('.row').find('.fetch-msg').html(
									'<span class="font-weight-bold" style="color: #006c67">Fetch completed successfully...</span>'
								);
							}
						}
					} else if (value['type'] == 'lcwp_upload_order') {
						$('.no-sync').css('display', 'none');
						$('.order-sync-box').show();
						$('.order-upload-btn').addClass('disabled');
						$('.order-upload-btn').find('.title').html('Uploading');
						$('.order-upload-btn').find('.bubble-loader').attr("style", "display:flex !important;");
						$('.order-upload-btn').closest('.row').find('.fetch-msg').html(
							'Upload in progress...');

						if (!$('.order-bar-div-upload').show()) {
							$('.order-bar-div-upload').show();
						}

						if (value['total'] > 0) {
							var part_to_increase = 100 / value['total'];

							$('.order-bar-div-upload').find('.progress-bar.bg-primary').css(
								'width',
								part_to_increase * value['done'] + '%');
							$('.order-bar-div-upload').find('.progress-bar.bg-danger').css(
								'width',
								part_to_increase * value['failed'] + '%');
							$('.order-bar-div-upload').find('.percent').text(
								(((part_to_increase * value['done'])) + ((
									part_to_increase * value['failed']))).toFixed(2) + '%');

							if (value['total'] == value['done'] + value['failed']) {
								$('.order-bar-div-upload').find('.sync-text').html(
									`<i class="{{ getIcon('check') }} text-success"></i> <b>Order upload completed!</b>`
								);

								$('.order-upload-btn').removeClass('disabled');
								$('.order-upload-btn').html('Upload Now');
								$('.order-upload-btn').closest('.row').find('.fetch-msg').html(
									'<span class="font-weight-bold" style="color: #006c67">Upload completed successfully...</span>'
								);
							}
						}
					}
				});
			}
		});
	</script>
<?php
}
