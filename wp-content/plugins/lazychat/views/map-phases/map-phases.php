<?php
$statuses = [
	[
		'name' => 'Pending payment',
		'summary' => 'Order received, no payment initiated. Awaiting payment (unpaid).',
		'can_delete' => 1,
		'code' => 'pending'
	],
	[
		'name' => 'Processing',
		'summary' => 'Payment received (paid) and stock has been reduced.',
		'can_delete' => 1,
		'code' => 'processing'
	],
	[
		'name' => 'Completed',
		'summary' => 'Order fulfilled and complete – requires no further action.',
		'can_delete' => 1,
		'code' => 'completed'
	],
	[
		'name' => 'Failed',
		'summary' => 'Payment failed or was declined (unpaid) or requires authentication (SCA). Note that this
                                status may not show immediately and instead show as Pending until verified.',
		'can_delete' => 1,
		'code' => 'failed'
	],
	[
		'name' => 'On hold',
		'summary' => 'Awaiting payment – stock is reduced, but you need to confirm payment.',
		'can_delete' => 1,
		'code' => 'on-hold'
	],
	[
		'name' => 'Cancelled',
		'summary' => 'Awaiting payment – stock is reduced, but you need to confirm payment.Canceled by an admin or
                                the customer – stock is increased, no further action required.',
		'can_delete' => 1,
		'code' => 'cancelled'
	],
	[
		'name' => 'Refunded',
		'summary' => 'Refunded by an admin – no further action required.',
		'can_delete' => 1,
		'code' => 'refunded'
	]
];
?>

<div class="row">
	<div class="col-md-12">
		<div class="card mt-0" style="max-width: 100% !important;">
			<div class="card-body">
				<div class="row">
					<div class="col-md-12 d-flex justify-content-between">
						<label class="font-weight-bold">WooCommerce Order Phases</label>
						<label class="font-weight-bold">LazyChat Order Phases</label>
					</div>
				</div>
				<form method="post" id="map-phase-form" novalidate>
					<?php
					foreach ($statuses as $key => $status) {
						echo '<div class="card mb-2" style="max-width: 100% !important;">
									<div class="card-body">
										<div class="row d-flex align-items-center">
											<div class="col-sm-12 col-xl-6 col-lg-6 d-flex flex-column">
												<label for="' . $status['name'] . '" class="font-weight-bold font-sm" style="font-size: 15px;">' . $status['name'] . '</label>
												<small class="text-muted" style="font-size: 12px;">' . $status['summary'] . '</small>
											</div>
											<div class="col-sm-12 col-xl-6 col-lg-6 d-flex flex-column align-items-end">';

						if ($status['code'] == 'pending') {
							echo '<label for="pending" class="d-flex justify-content-end font-weight-bold" style="font-size: 15px;">Pending</label>';
						} else if ($status['code'] == 'completed') {
							echo '<label for="delivered" class="d-flex justify-content-end font-weight-bold" style="font-size: 15px;">Delivered</label>';
						} else {
							echo '<select class="form-control select2 lazychat-order-phase pb-2" name="order_phase[' . $status['code'] . ']" id="order-phase-' . $key . '" data-code="' . $status['code'] . '" required>
														<option value="">Select Order Phase</option>';
							foreach ($_SESSION['lazychat_order_phases'] as $phase) {
								echo '<option value="' . $phase['id'] . '"' . ($phase['woocommerce_code'] === $status['code'] ? "selected" : "") . '>'
									. $phase['name'] .
									'</option>';
							}
							echo '<option value="create-new">Create New</option>
									</select>
									<input class="form-control mt-2" id="create-new" name="create_new[' . $status['code'] . ']" type="text" placeholder="Create new phase" style="display: none;" required />';
						}
						echo '</div>
										</div>
									</div>
								</div>
							';
					}
					?>

					<input type="hidden" name="action" value="lcwp_map_order_phase">
					<?php wp_nonce_field('lcwp_map_order_phase_verify') ?>

					<!-- Check if order phases are already mapped -->
					<?php
					if (get_option('lcwp_order_phases') && get_option('lcwp_order_phases')['mapped']) {
						echo '<input type="hidden" name="is_mapped" value="1">';
						echo '<input type="hidden" name="site_url" value="'. get_site_url() .'">';
					} else {
						echo '<input type="hidden" name="is_mapped" value="0">';
						echo '<input type="hidden" name="site_url" value="">';
					}
					?>

					<div class="col-md-12 pt-3">
						<button class="btn btn-primary submit">Save</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>