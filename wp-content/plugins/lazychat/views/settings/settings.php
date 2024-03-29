<style>
	.fetch-btn {
		padding: 5px;
		width: calc(50% - 10px);
		display: flex;
		justify-content: center;
		align-items: center;
		font-size: 0.85rem;
	}

	.loader-container {
		display: flex;
		align-content: center;
		justify-content: center;
	}

	@keyframes ScaleInOut {
		0% {
			transform: scale(0.8);
		}

		100% {
			transform: scale(1.5);
		}
	}

	.dot1 {
		width: 0.65rem;
		height: 0.65rem;
		animation: ScaleInOut 0.6s ease-in-out 0.2s infinite alternate;
	}

	.dot2 {
		width: 0.65rem;
		height: 0.65rem;
		animation: ScaleInOut 0.6s ease-in-out 0.4s infinite alternate;
	}

	.dot3 {
		width: 0.65rem;
		height: 0.65rem;
		animation: ScaleInOut 0.6s ease-in-out 0.6s infinite alternate;
	}

	.dot4 {
		width: 0.65rem;
		height: 0.65rem;
		animation: ScaleInOut 0.6s ease-in-out 0.8s infinite alternate;
	}

	.bubble-loader {
		display: none !important;
	}

	.dropdown-menu {
		position: absolute;
		will-change: transform;
		top: 0px;
		left: 0px;
		transform: translate3d(-134px, 27px, 0px) !important;
	}

	.shop-name {
		font-size: 1.3rem;
		font-weight: 500;
		color: #006c67;
	}

	.shop-connected-to {
		font-weight: 500;
		font-size: 1.1rem;
	}
</style>


<div class="card" style="max-width: 100% !important;">
	<div class="card-body p-0">
		<div class="row mb-4">
			<div class="col-md-12 d-flex justify-content-between align-items-center">
				<div class="shop-name-div d-flex align-items-center justify-content-center">
					<div class="shop-connected-to">
						<i class="fas fa-store-alt mr-2 text-primary"></i>
					</div>
					<div class="shop-name">
						<?php get_option('lcwp_shop_name') &&
							get_option('lcwp_shop_name') !== "" ? print get_option('lcwp_shop_name') : ""; ?>
					</div>
				</div>
				<div class="dropdown contact-bulk-action">
					<button class="btn btn-success text-white dropdown-toggle btn-sm" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-expanded="false">
						<i class="fas fa-bars"></i>
						</i> <?php _e('Menu') ?>
					</button>

					<div class="dropdown-menu" aria-labelledby="dropdownMenuButton" id="add-customer-dropdown" x-placement="bottom-start">
						<a class="dropdown-item" href="#" data-toggle="modal" data-target="#mapOrderPhasesModal">
							<i class="fas fa-code-merge"></i> <?php _e('Map WooCommerce Phases') ?>
						</a>
						<a class="dropdown-item text-info" href="#" data-toggle="modal" data-target="#syncSettingsModal">
							<i class="fas fa-cog"></i> <?php _e('Settings') ?>
						</a>
						<a class="dropdown-item text-danger" href="#" data-toggle="modal" data-target="#DeactivateModal">
							<i class=" fas fa-exclamation-circle"></i> <?php _e('Deactivate') ?>
						</a>
					</div>
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
							<input type="hidden" name="action" value="lcwp_upload_data">
							<input type="hidden" name="upload_type" value="fetch_product">
							<?php wp_nonce_field('lcwp_upload_data_verify') ?>
							<button type="submit" class="btn btn-primary fetch-btn product-fetch-btn">
								<span class="title">
									<?php _e('Fetch Now') ?>
								</span>
								<?php include(LCWP_PATH . 'views/loader/loader.php'); ?>
							</button>
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
							<input type="hidden" name="action" value="lcwp_upload_data">
							<input type="hidden" name="upload_type" value="upload_product">
							<?php wp_nonce_field('lcwp_upload_data_verify') ?>
							<button type="submit" class="btn btn-primary fetch-btn product-upload-btn">
								<span class="title">
									<?php _e('Upload Now') ?>
								</span>
								<?php include(LCWP_PATH . 'views/loader/loader.php'); ?>
							</button>
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
						<button class="btn btn-danger fetch-btn resync-btn" data-toggle="modal" data-target="#hardReSyncModal" data-type="product">
							<i class="fas fa-sync pr-1"></i> <?php _e('Hard Re-Sync') ?>
						</button>
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
							<input type="hidden" name="action" value="lcwp_upload_data">
							<input type="hidden" name="upload_type" value="fetch_order">
							<?php wp_nonce_field('lcwp_upload_data_verify') ?>
							<button type="submit" class="btn btn-primary fetch-btn order-fetch-btn">
								<span class="title">
									<?php _e('Fetch Now') ?>
								</span>
								<?php include(LCWP_PATH . 'views/loader/loader.php'); ?>
							</button>
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
							<input type="hidden" name="action" value="lcwp_upload_data">
							<input type="hidden" name="upload_type" value="upload_order">
							<?php wp_nonce_field('lcwp_upload_data_verify') ?>
							<button type="submit" class="btn btn-primary fetch-btn order-upload-btn">
								<span class="title">
									<?php _e('Upload Now') ?>
								</span>
								<?php include(LCWP_PATH . 'views/loader/loader.php'); ?>
							</button>
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
						<button class="btn btn-danger fetch-btn resync-btn" data-toggle="modal" data-target="#hardReSyncModal" data-type="order">
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
							<input type="hidden" name="action" value="lcwp_upload_data">
							<input type="hidden" name="upload_type" value="fetch_contact">
							<?php wp_nonce_field('lcwp_upload_data_verify') ?>
							<button type="submit" class="btn btn-primary fetch-btn contact-fetch-btn">
								<span class="title">
									<?php _e('Fetch Now') ?>
								</span>
								<?php include(LCWP_PATH . 'views/loader/loader.php'); ?>
							</button>
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
							<input type="hidden" name="action" value="lcwp_upload_data">
							<input type="hidden" name="upload_type" value="upload_contact">
							<?php wp_nonce_field('lcwp_upload_data_verify') ?>
							<button type="submit" class="btn btn-primary fetch-btn contact-upload-btn">
								<span class="title">
									<?php _e('Upload Now') ?>
								</span>
								<?php include(LCWP_PATH . 'views/loader/loader.php'); ?>
							</button>
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
						<button class="btn btn-danger fetch-btn resync-btn" data-toggle="modal" data-target="#hardReSyncModal" data-type="contact">
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

<!-- Hard Re-sync modal starts -->
<div class="modal fade" id="hardReSyncModal" tabindex="-1" role="dialog" aria-labelledby="hardReSyncModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="hardReSyncModalLabel">Hard Re-sync</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body text-center">
				<i class="fas fa-exclamation-triangle" style="color: #ffc107 !important; font-size: 3rem;"></i>
				<p class="font-weight-500" style="font-size: 1rem;">Are you sure you want to hard re-sync all the data?</p>
				<p>This will delete all the data in LazyChat and re-sync all the data from WooCommerce.</p>
			</div>
			<div class="modal-footer">
				<form action="admin-post.php" method="POST" id="hard-re-sync-form">
					<?php wp_nonce_field('lcwp_hard_re_sync_verify') ?>
					<input type="hidden" name="action" value="lcwp_hard_re_sync">
					<input type="hidden" name="type">
					<button class="btn btn-secondary" type="button" data-dismiss="modal"><?php _e('Close') ?></button>
					<button class="btn btn-danger" type="submit" id="hardReSyncBtn"><?php _e('Re-sync') ?></button>
				</form>
			</div>
		</div>
	</div>
</div>
<!-- Hard Re-sync modal ends -->

<!-- Deactivate modal starts -->
<div class="modal fade" id="DeactivateModal" tabindex="-1" role="dialog" aria-labelledby="DeactivateModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="DeactivateModalLabel">Deactivate LazyChat</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body text-center deactivate-body">
				<i class="fas fa-exclamation-triangle" style="color: #ffc107 !important; font-size: 3rem;"></i>
				<p class="font-weight-500" style="font-size: 1rem;">Are you sure you want to Deactivate LazyChat?</p>
				<label class="checkbox checkbox-primary">
					<input type="checkbox" name="remove_all" id="remove_all" checked><span>
						Delete all data(products, categories, images, contacts, orders) fetched in LazyChat</span>
					<span class="checkmark"></span>
				</label>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal"><?php _e('Close') ?></button>
				<button class="btn btn-danger deactivate_lazychat_btn"><?php _e('Deactivate') ?></button>
			</div>
		</div>
	</div>
</div>
<!-- Deactivate modal ends -->