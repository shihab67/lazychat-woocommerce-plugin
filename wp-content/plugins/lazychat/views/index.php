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
	<link rel="stylesheet" href="<?php echo plugins_url('lazychat/assets/css/custom.css'); ?>">
	<link rel="stylesheet" href="<?php echo plugins_url('lazychat/assets/css/loader.css'); ?>">

	<div class="container-fluid lazychat-body">
		<img class="mb-2" src="<?php echo plugins_url('lazychat/assets/images/Lazychat Logo-03.png'); ?>" alt="lazychat logo" height="30">

		<?php include(LCWP_PATH . 'views/alert/alert.php'); ?>

		<?php
		if (
			get_option('lswp_auth_token') &&
			get_option('lswp_auth_token') === null
		) {
			include(LCWP_PATH . 'views/connect/connect.php');
		} else if (
			get_option('lswp_auth_token') &&
			get_option('lswp_auth_token') !== null &&
			get_option('lswp_order_phases') &&
			get_option('lswp_order_phases')['mapped'] === false
		) {
		?>
			<div class="row">
				<div class="col-md-12">
					<h4 class="pt-2"><?php _e('Map LazyChat Order Phases', 'lswp') ?></h4>
					<p><?php _e('You have connected your LazyChat account. Now Map 
						LazyChat Order Phases with WooCommerce Order Phases', 'lswp') ?></p>
				</div>
			</div>
		<?php
			include(LCWP_PATH . 'views/map-phases/map-phases.php');
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
		});
	</script>
<?php
}
