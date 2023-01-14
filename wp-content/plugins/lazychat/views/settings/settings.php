<style>
	.fetch-btn {
		padding: 5px;
		width: calc(50% - 10px);
		display: flex;
		justify-content: center;
		align-items: center;
	}

	.loader-container {
		display: flex;
		align-content: center;
		justify-content: center;
	}

	.fetch-btn .dots-container {
		margin-top: 6px;
		margin-left: 3px;
	}

	.fetch-btn .dots-container .pulse-dot {
		background-color: #fff !important;
	}
</style>


<div class="card" style="max-width: 100% !important;">
	<div class="card-body p-0">
		<div class="row">
			<div class="col-md-12 d-flex justify-content-end">
				<div>
					<a class="btn btn-primary btn-sm m-1" href="#" data-toggle="modal" data-target="#mapOrderPhasesModal">
						<i class="fas fa-code-merge"></i> <?php _e('Map WooCommerce Phases') ?></a>
				</div>
				<div>
					<a href="#" class="m-1 btn btn-info btn-sm" data-toggle="modal" data-target="#syncSettingsModal">
						<fa class="fas fa-cog"></fa> <?php _e('Settings') ?>
					</a>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-8 col-lg-8 col-sm-12">
				<div class="row pb-2">
					<div class="col-md-12 d-flex">
						<h4 class="text-primary font-weight-bold pr-2"><ins>P</ins>roduct Sync</h4>
					</div>
				</div>
				<div class="row d-flex justify-content-center align-items-center">
					<div class="col-md-6 col-lg-6 col-xs-12">
						<form action="admin-post.php" method="POST">
							<input type="hidden" name="action" value="lswp_upload_data">
							<input type="hidden" name="upload_type" value="fetch_product">
							<?php wp_nonce_field('lswp_upload_data_verify') ?>
							<button type="submit" class="btn btn-primary fetch-btn product-upload-btn"><?php _e('Fetch Now') ?></button>
						</form>
					</div>
					<div class="col-md-6 col-lg-6 col-xs-12 fetch-msg">
						<?php
						if (
							get_option('lcwp_last_fetched_time') &&
							get_option('lcwp_last_fetched_time') !== null &&
							isset(get_option('lcwp_last_fetched_time')['lcwpSyncProductsInWoocommerce'])
						) {
						?>
							<span class="pt-2" style="color: #979696">
								Last Fetch Completed:
							</span><span style="font-size: 14px; font-weight: bold;">
								<?php print get_option('lcwp_last_fetched_time')['lcwpSyncProductsInWoocommerce']; ?>
							</span>
						<?php } else { ?>
							<span class="pt-2" style="color: #979696">
								Last Fetch Completed:
							</span> <span style="font-size: 14px; font-weight: bold;">Never Fetched</span>
						<?php } ?>
					</div>
				</div>
				<div class="row pt-2 d-flex justify-content-center align-items-center">
					<div class="col-md-6 col-lg-6 col-xs-12">
						<form action="admin-post.php" method="POST">
							<input type="hidden" name="action" value="lswp_upload_data">
							<input type="hidden" name="upload_type" value="upload_product">
							<?php wp_nonce_field('lswp_upload_data_verify') ?>
							<button type="submit" class="btn btn-primary fetch-btn product-upload-btn"><?php _e('Upload Now') ?></button>
						</form>
					</div>
					<div class="col-md-6 col-lg-6 col-xs-12 fetch-msg">
						<?php
						if (
							get_option('lcwp_last_fetched_time') &&
							get_option('lcwp_last_fetched_time') !== null &&
							isset(get_option('lcwp_last_fetched_time')['lcwpSyncProductsFromWoocommerce'])
						) {
						?>
							<span class="pt-2" style="color: #979696">
								Last Upload Completed:
							</span><span style="font-size: 14px; font-weight: bold;">
								<?php print get_option('lcwp_last_fetched_time')['lcwpSyncProductsFromWoocommerce']; ?>
							</span>
						<?php } else { ?>
							<span class="pt-2" style="color: #979696">
								Last Upload Completed:
							</span> <span style="font-size: 14px; font-weight: bold;">Never Uploaded</span>
						<?php } ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 pt-2 d-flex align-items-center">
						<button class="btn btn-danger fetch-btn" onclick="#">
							<i class="fas fa-sync pr-1"></i> <?php _e('Hard Re-Sync') ?> </button>
						<i style="cursor: pointer;" class="fas fa-info-circle pl-2" data-toggle="tooltip" data-placement="top" title="Remove all current products fetched from
                        LazyChat and
                        Re-Sync"></i>
					</div>
				</div>

				<div class="row pt-4">
					<div class="col-md-12 d-flex">
						<h4 class="text-primary font-weight-bold pr-2"><ins>O</ins>rder Sync</h4>
					</div>
				</div>
				<div class="row d-flex justify-content-center align-items-center">
					<div class="col-md-6 col-lg-6 col-xs-12">
						<form action="admin-post.php" method="POST">
							<input type="hidden" name="action" value="lswp_upload_data">
							<input type="hidden" name="upload_type" value="fetch_order">
							<?php wp_nonce_field('lswp_upload_data_verify') ?>
							<button type="submit" class="btn btn-primary fetch-btn product-upload-btn"><?php _e('Fetch Now') ?></button>
						</form>
					</div>
					<div class="col-md-6 col-lg-6 col-xs-12 fetch-msg">
						<?php
						if (
							get_option('lcwp_last_fetched_time') &&
							get_option('lcwp_last_fetched_time') !== null &&
							isset(get_option('lcwp_last_fetched_time')['lcwpSyncOrdersInWoocommerce'])
						) {
						?>
							<span class="pt-2" style="color: #979696">
								Last Fetch Completed:
							</span><span style="font-size: 14px; font-weight: bold;">
								<?php print get_option('lcwp_last_fetched_time')['lcwpSyncOrdersInWoocommerce']; ?>
							</span>
						<?php } else { ?>
							<span class="pt-2" style="color: #979696">
								Last Fetch Completed:
							</span> <span style="font-size: 14px; font-weight: bold;">Never Fetched</span>
						<?php } ?>
					</div>
				</div>
				<div class="row pt-2 d-flex justify-content-center align-items-center">
					<div class="col-md-6 col-lg-6 col-xs-12">
						<form action="admin-post.php" method="POST">
							<input type="hidden" name="action" value="lswp_upload_data">
							<input type="hidden" name="upload_type" value="upload_order">
							<?php wp_nonce_field('lswp_upload_data_verify') ?>
							<button type="submit" class="btn btn-primary fetch-btn product-upload-btn"><?php _e('Upload Now') ?></button>
						</form>
					</div>
					<div class="col-md-6 col-lg-6 col-xs-12 fetch-msg">
						<?php
						if (
							get_option('lcwp_last_fetched_time') &&
							get_option('lcwp_last_fetched_time') !== null &&
							isset(get_option('lcwp_last_fetched_time')['lcwpSyncOrdersFromWoocommerce'])
						) {
						?>
							<span class="pt-2" style="color: #979696">
								Last Upload Completed:
							</span><span style="font-size: 14px; font-weight: bold;">
								<?php print get_option('lcwp_last_fetched_time')['lcwpSyncOrdersFromWoocommerce']; ?>
							</span>
						<?php } else { ?>
							<span class="pt-2" style="color: #979696">
								Last Upload Completed:
							</span> <span style="font-size: 14px; font-weight: bold;">Never Uploaded</span>
						<?php } ?>
					</div>
				</div>
				<div class="row">
					<div class="col-md-6 pt-2 d-flex align-items-center">
						<button class="btn btn-danger fetch-btn" onclick="#">
							<i class="fas fa-sync pr-1"></i> <?php _e('Hard Re-Sync') ?> </button>
						<i style="cursor: pointer;" class="fas fa-info-circle pl-2" data-toggle="tooltip" data-placement="top" title="Remove all current orders fetched from
                        LazyChat and
                        Re-Sync"></i>
					</div>
				</div>

				<div class="row pt-4">
					<div class="col-md-12 d-flex">
						<h4 class="text-primary font-weight-bold pr-2"><ins>C</ins>ontacts Sync</h4>
					</div>
				</div>
				<div class="row d-flex justify-content-center align-items-center">
					<div class="col-md-6 col-lg-6 col-xs-12">
						<form action="admin-post.php" method="POST">
							<input type="hidden" name="action" value="lswp_upload_data">
							<input type="hidden" name="upload_type" value="fetch_contact">
							<?php wp_nonce_field('lswp_upload_data_verify') ?>
							<button type="submit" class="btn btn-primary fetch-btn product-upload-btn"><?php _e('Fetch Now') ?></button>
						</form>
					</div>
					<div class="col-md-6 col-lg-6 col-xs-12 fetch-msg">
						<?php
						if (
							get_option('lcwp_last_fetched_time') &&
							get_option('lcwp_last_fetched_time') !== null &&
							isset(get_option('lcwp_last_fetched_time')['lcwpSyncContactsInWoocommerce'])
						) {
						?>
							<span class="pt-2" style="color: #979696">
								Last Fetch Completed:
							</span><span style="font-size: 14px; font-weight: bold;">
								<?php print get_option('lcwp_last_fetched_time')['lcwpSyncContactsInWoocommerce']; ?>
							</span>
						<?php } else { ?>
							<span class="pt-2" style="color: #979696">
								Last Fetch Completed:
							</span> <span style="font-size: 14px; font-weight: bold;">Never Fetched</span>
						<?php } ?>
					</div>
				</div>
				<div class="row pt-2 d-flex justify-content-center align-items-center">
					<div class="col-md-6 col-lg-6 col-xs-12">
						<form action="admin-post.php" method="POST">
							<input type="hidden" name="action" value="lswp_upload_data">
							<input type="hidden" name="upload_type" value="upload_contact">
							<?php wp_nonce_field('lswp_upload_data_verify') ?>
							<button type="submit" class="btn btn-primary fetch-btn product-upload-btn"><?php _e('Upload Now') ?></button>
						</form>
					</div>
					<div class="col-md-6 col-lg-6 col-xs-12 fetch-msg">
						<?php
						if (
							get_option('lcwp_last_fetched_time') &&
							get_option('lcwp_last_fetched_time') !== null &&
							isset(get_option('lcwp_last_fetched_time')['lcwpSyncContactsFromWoocommerce'])
						) {
						?>
							<span class="pt-2" style="color: #979696">
								Last Upload Completed:
							</span><span style="font-size: 14px; font-weight: bold;">
								<?php print get_option('lcwp_last_fetched_time')['lcwpSyncContactsFromWoocommerce']; ?>
							</span>
						<?php } else { ?>
							<span class="pt-2" style="color: #979696">
								Last Upload Completed:
							</span> <span style="font-size: 14px; font-weight: bold;">Never Uploaded</span>
						<?php } ?>
					</div>
				</div>
				<div class="row pb-3">
					<div class="col-md-6 pt-2 d-flex align-items-center">
						<button class="btn btn-danger fetch-btn" onclick="#">
							<i class="fas fa-sync pr-1"></i> <?php _e('Hard Re-Sync') ?> </button>
						<i style="cursor: pointer;" class="fas fa-info-circle pl-2" data-toggle="tooltip" data-placement="top" title="Remove all current contacts fetched from
                        LazyChat and
                        Re-Sync"></i>
					</div>
				</div>
			</div>

			<!-- Progressbar starts -->
			<?php include(LCWP_PATH . 'views/settings/progress_bar.php'); ?>
		</div>
	</div>
</div>

<!-- Map order phases modal starts -->
<div class="modal fade" id="mapOrderPhasesModal" tabindex="-1" role="dialog" aria-labelledby="syncSettingsModal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-bold"><?php _e('Map Order Phases') ?> </h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<?php
				include(LCWP_PATH . 'views/map-phases/map-phases.php');
				?>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><?php _e('Close') ?> </button>
			</div>
		</div>
	</div>
</div>
<!-- Map order phases modal ends -->

<!-- sync settings modal starts -->
<div class="modal fade" id="syncSettingsModal" tabindex="-1" role="dialog" aria-labelledby="syncSettingsModal" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title font-weight-bold" id="syncSettingsModal"> <?php _e('Sync Settings') ?></h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
			</div>
			<div class="modal-body">
				<form method="post" id="sync-options-form">
					<input type="hidden" name="action" value="lcwp_sync_options">
					<?php wp_nonce_field('lcwp_sync_options_verify') ?>

					<div class="row">
						<div class="col-md-12">
							<h4 class="text-primary font-weight-bold"><ins>P</ins>roducts</h4>
						</div>

						<div class="row" style="padding-left: 15px;">
							<div class="col-md-12">
								<div class="pt-2">
									<label class="checkbox checkbox-primary">
										<input type="checkbox" class="sync" name="options[]" value="lcwp_product_created" <?php is_array(get_option('lcwp_sync_options')) &&
																																get_option('lcwp_sync_options')['lcwp_product_created'] === 1 ? print 'checked' : ''
																															?> /><span>
											When a product is created in LazyChat, Create in WooCommerce too</span>
										<span class="checkmark"></span>
									</label>
									<label class="checkbox checkbox-primary">
										<input type="checkbox" class="sync" name="options[]" value="lcwp_product_updated" <?php is_array(get_option('lcwp_sync_options')) &&
																																get_option('lcwp_sync_options')['lcwp_product_updated'] === 1 ? print 'checked' : ''
																															?> /><span>
											When a product is updated in LazyChat, Update in WooCommerce too</span>
										<span class="checkmark"></span>
									</label>
									<label class="checkbox checkbox-primary">
										<input type="checkbox" class="sync" name="options[]" value="lcwp_product_removed" <?php is_array(get_option('lcwp_sync_options')) &&
																																get_option('lcwp_sync_options')['lcwp_product_removed'] === 1 ? print 'checked' : ''
																															?> /><span>
											When a product is removed in LazyChat, Remove in WooCommerce too</span>
										<span class="checkmark"></span>
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row pt-4">
						<div class="col-md-12">
							<h4 class="text-primary font-weight-bold"><ins>C</ins>ontacts</h4>
						</div>

						<div class="row" style="padding-left: 15px;">
							<div class="col-md-12">
								<div class="pt-2">
									<label class="checkbox checkbox-primary">
										<input type="checkbox" class="sync" name="options[]" value="lcwp_customer_created" <?php is_array(get_option('lcwp_sync_options')) &&
																																get_option('lcwp_sync_options')['lcwp_customer_created'] === 1 ? print 'checked' : ''
																															?> /><span>
											When a contact is created in LazyChat, Create in WooCommerce too</span>
										<span class="checkmark"></span>
									</label>
									<label class="checkbox checkbox-primary">
										<input type="checkbox" class="sync" name="options[]" value="lcwp_customer_updated" <?php is_array(get_option('lcwp_sync_options')) &&
																																get_option('lcwp_sync_options')['lcwp_customer_updated'] === 1 ? print 'checked' : ''
																															?> /><span>
											When a contact is updated in LazyChat, Update in WooCommerce too</span>
										<span class="checkmark"></span>
									</label>
									<label class="checkbox checkbox-primary">
										<input type="checkbox" class="sync" name="options[]" value="lcwp_customer_removed" <?php is_array(get_option('lcwp_sync_options')) &&
																																get_option('lcwp_sync_options')['lcwp_customer_removed'] === 1 ? print 'checked' : ''
																															?> /><span>
											When a contact is removed in LazyChat, Remove in WooCommerce too</span>
										<span class="checkmark"></span>
									</label>
								</div>
							</div>
						</div>
					</div>

					<div class="row pt-4">
						<div class="col-md-12">
							<h4 class="text-primary font-weight-bold"><ins>O</ins>rders</h4>
						</div>

						<div class="row" style="padding-left: 15px;">
							<div class="col-md-12">
								<div class="pt-2">
									<label class="checkbox checkbox-primary">
										<input type="checkbox" class="sync" name="options[]" value="lcwp_order_created" <?php is_array(get_option('lcwp_sync_options')) &&
																															get_option('lcwp_sync_options')['lcwp_order_created'] === 1 ? print 'checked' : ''
																														?> /><span>
											When an order is created in LazyChat, Create in WooCommerce too</span>
										<span class="checkmark"></span>
									</label>
									<label class="checkbox checkbox-primary">
										<input type="checkbox" class="sync" name="options[]" value="lcwp_order_updated" <?php is_array(get_option('lcwp_sync_options')) &&
																															get_option('lcwp_sync_options')['lcwp_order_updated'] === 1 ? print 'checked' : ''
																														?> /><span>
											When an order is updated in LazyChat, Update in WooCommerce too</span>
										<span class="checkmark"></span>
									</label>
									<label class="checkbox checkbox-primary">
										<input type="checkbox" class="sync" name="options[]" value="lcwp_order_removed" <?php is_array(get_option('lcwp_sync_options')) &&
																															get_option('lcwp_sync_options')['lcwp_order_removed'] === 1 ? print 'checked' : ''
																														?> /><span>
											When an order is removed in LazyChat, Remove in WooCommerce too</span>
										<span class="checkmark"></span>
									</label>
								</div>
							</div>
						</div>
					</div>
					<?php
					$all_options = [
						'lcwp_product_created',
						'lcwp_product_updated',
						'lcwp_product_removed',
						'lcwp_customer_created',
						'lcwp_customer_updated',
						'lcwp_customer_removed',
						'lcwp_order_created',
						'lcwp_order_updated',
						'lcwp_order_removed'
					];
					echo "<input type='hidden' name='all_options' value='" . base64_encode(json_encode($all_options)) . "'/>";
					?>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>
<!-- sync settings modal ends -->