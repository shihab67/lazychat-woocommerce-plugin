<?php
/**
 * This file contains HTML codes to show the progressbar.
 *
 * @package LazyChat WooCommerce Plugin
 */

defined( 'ABSPATH' ) || exit;
?>
<div class="col-md-4 col-lg-4 col-sm-12">
	<div class="card">
		<div class="card-body">
			<h5 class="text-center text-primary font-weight-bold">Progress</h5>

			<div class="row pt-4 no-sync">
				<div class="col-md-12 d-flex justify-content-center align-items-center">
					<h5 class="text-muted">No sync in progress</h5>
				</div>
			</div>

			<div class="card message-box d-none mt-0" style="background-color: rgba(0, 108, 103, 0.8)">
				<h6 class="font-weight-bold message p-2 m-0 text-white"></h6>
			</div>

			<div class="row product-sync-box" style="display: none;">
				<div class="col-md-12">
					<h5 class="font-weight-bold">Products</h5>
				</div>
				<div class="col-md-12">
					<!-- product sync progressbar starts -->
					<div class="product-bar-div" style="display: none;">
						<div class="d-flex align-items-center justify-content-between">
							<div class="d-flex flex-row align-items-center sync-text">
								<b>Fetching Products</b>
								<div class="dots-container pl-1 mt-2">
									<div class="pulse-dot pulse-dot-1"></div>
									<div class="pulse-dot pulse-dot-2"></div>
									<div class="pulse-dot pulse-dot-3"></div>
									<div class="pulse-dot pulse-dot-4"></div>
								</div>
							</div>
							<b class="percent">0%</b>
						</div>
						<div class="progress">
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<!-- product sync progressbar ends -->

					<!-- product upload progressbar starts -->
					<div class="product-bar-div-upload" style="display: none;">
						<div class="d-flex align-items-center justify-content-between">
							<div class="d-flex flex-row align-items-center sync-text">
								<b>Uploading Products</b>
								<div class="dots-container pl-1 mt-2">
									<div class="pulse-dot pulse-dot-1"></div>
									<div class="pulse-dot pulse-dot-2"></div>
									<div class="pulse-dot pulse-dot-3"></div>
									<div class="pulse-dot pulse-dot-4"></div>
								</div>
							</div>
							<b class="percent">0%</b>
						</div>
						<div class="progress">
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<!-- product upload progressbar ends -->
				</div>
			</div>

			<div class="row pt-4 order-sync-box" style="display: none;">
				<div class="col-md-12">
					<h5 class="font-weight-bold">Orders</h5>
				</div>
				<div class="col-md-12">
					<!-- order sync progressbar starts -->
					<div class="order-bar-div" style="display: none;">
						<div class="d-flex align-items-center justify-content-between">
							<div class="d-flex flex-row align-items-center sync-text">
								<b>Fetching Orders</b>
								<div class="dots-container pl-1 mt-2">
									<div class="pulse-dot pulse-dot-1"></div>
									<div class="pulse-dot pulse-dot-2"></div>
									<div class="pulse-dot pulse-dot-3"> </div>
									<div class="pulse-dot pulse-dot-4"> </div>
								</div>
							</div>
							<b class="percent">0%</b>
						</div>
						<div class="progress">
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<!-- Order sync progressbar ends  -->

					<!-- order upload progressbar starts  -->
					<div class="order-bar-div-upload" style="display: none;">
						<div class="d-flex align-items-center justify-content-between pt-2">
							<div class="d-flex flex-row align-items-center sync-text">
								<b>Uploading Orders</b>
								<div class="dots-container pl-1 mt-2">
									<div class="pulse-dot pulse-dot-1"></div>
									<div class="pulse-dot pulse-dot-2"></div>
									<div class="pulse-dot pulse-dot-3"> </div>
									<div class="pulse-dot pulse-dot-4"> </div>
								</div>
							</div>
							<b class="percent">0%</b>
						</div>
						<div class="progress">
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<!-- Order upload progressbar ends  -->
				</div>
			</div>

			<div class="row pt-4 customer-sync-box" style="display: none;">
				<div class="col-md-12">
					<h5 class="font-weight-bold">Contacts</h5>
				</div>
				<div class="col-md-12">
					<!-- customer sync progress bar  -->
					<div class="customer-bar-div" style="display: none;">
						<div class="d-flex align-items-center justify-content-between">
							<div class="d-flex flex-row align-items-center sync-text">
								<b>Fetching Contacts</b>
								<div class="dots-container pl-1 mt-2">
									<div class="pulse-dot pulse-dot-1"></div>
									<div class="pulse-dot pulse-dot-2"></div>
									<div class="pulse-dot pulse-dot-3"> </div>
									<div class="pulse-dot pulse-dot-4"> </div>
								</div>
							</div>
							<b class="percent">0%</b>
						</div>
						<div class="progress">
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<!-- Customer sync progressbar ends  -->

					<!-- customer upload progress bar  -->
					<div class="customer-bar-div-upload" style="display: none;">
						<div class="d-flex align-items-center justify-content-between pt-2">
							<div class="d-flex flex-row align-items-center sync-text">
								<b>Uploading Contacts</b>
								<div class="dots-container pl-1 mt-2">
									<div class="pulse-dot pulse-dot-1"></div>
									<div class="pulse-dot pulse-dot-2"></div>
									<div class="pulse-dot pulse-dot-3"> </div>
									<div class="pulse-dot pulse-dot-4"> </div>
								</div>
							</div>
							<b class="percent">0%</b>
						</div>
						<div class="progress">
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
							<div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<!-- Customer upload progressbar ends -->
				</div>
			</div>
		</div>
	</div>
</div>
