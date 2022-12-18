<div class="row mt-4">
	<div class="col-md-12">
		<h4 class="pt-2"><?php _e('LazyChat needs your permission to work', 'lswp') ?></h4>
		<p><?php _e('Once you connect your Wordpress account with LazyChat you will be
					able to sync products, Orders and Customers in your LazyChat account', 'lswp') ?></p>
		<p><?php _e(
				'Provide Auth/Bearer Token that you will find in the Settings > Webhook/API page of your LazyChat Account',
				'lswp'
			) ?></p>

		<div class="row">
			<div class="col-md-12">
				<div class="card mt-0">
					<div class="card-body">
						<form method="post" action="admin-post.php">
							<input type="hidden" name="action" value="lswp_connect">
							<?php wp_nonce_field('lswp_connect_verify') ?>

							<div class="mb-3">
								<label for="lswp_auth_token" class="form-label">
									<?php _e('Auth/Bearer Token') ?>
									<span class="text-danger">*</span>
								</label>
								<input type="text" class="form-control" id="lswp_auth_token" name="lswp_auth_token" required>
							</div>

							<button type="submit" class="btn btn-primary"><?php _e('Connect with LazyChat', 'lswp') ?></button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>