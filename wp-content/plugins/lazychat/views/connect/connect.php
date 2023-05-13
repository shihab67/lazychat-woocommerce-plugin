<?php
/**
 * This file contains HTML codes to show the connect page.
 *
 * @package LazyChat WooCommerce Plugin
 */

defined( 'ABSPATH' ) || exit;
?>

<div id="smartwizard" class="sw-main sw-theme-arrows">
	<ul class="nav nav-tabs step-anchor">
		<li class="nav-item text-center active" style="pointer-events: none;">
			<a href="#" class="nav-link">Step 1<br>
				<small>Provide Auth/Bearer Token</small>
			</a>
		</li>
		<li class="nav-item text-center" style="pointer-events: none;">
			<a href="#" class="nav-link">Step 2<br>
				<small>Map Woocommerce order phases with LazyChat</small>
			</a>
		</li>
	</ul>
	<div class="sw-container tab-content">
		<div id="step-2" class="tab-pane step-content" style="display: block !important;">
			<div class="row mt-4">
				<div class="col-md-12">
					<h4 class="pt-2"><?php _e( 'LazyChat needs your permission to work', 'lcwp' ); ?></h4>
					<p>
					<?php
					_e(
						'Once you connect your WordPress account with LazyChat you will be
					able to sync products, Orders and Customers in your LazyChat account',
						'lcwp'
					)
					?>
					</p>
					<p>
					<?php
					_e(
						'Provide Auth/Bearer Token that you will find in the Settings > Webhook/API page of your LazyChat Account',
						'lcwp'
					)
					?>
						</p>

					<div class="row">
						<div class="col-md-12">
							<div class="card mt-0">
								<div class="card-body">
									<form method="post" action="admin-post.php">
										<input type="hidden" name="action" value="lcwp_connect">
										<?php wp_nonce_field( 'lcwp_connect_verify' ); ?>

										<div class="mb-3">
											<label for="lcwp_auth_token" class="form-label">
												<?php _e( 'Auth/Bearer Token' ); ?>
												<span class="text-danger">*</span>
											</label>
											<input type="text" class="form-control" id="lcwp_auth_token" name="lcwp_auth_token" required>
										</div>

										<button type="submit" class="btn btn-primary"><?php _e( 'Connect with LazyChat', 'lcwp' ); ?></button>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
