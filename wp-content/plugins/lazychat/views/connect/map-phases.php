<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined('ABSPATH') || exit;

?>

<div id="smartwizard" class="sw-main sw-theme-arrows">
	<ul class="nav nav-tabs step-anchor">
		<li class="nav-item text-center done" style="pointer-events: none;">
			<a href="#" class="nav-link">Step 1<br>
				<small>Provide Auth/Bearer Token</small>
			</a>
		</li>
		<li class="nav-item text-center active" style="pointer-events: none;">
			<a href="#" class="nav-link">Step 2<br>
				<small>Map Woocommerce order phases with LazyChat</small>
			</a>
		</li>
	</ul>
	<div class="sw-container tab-content">
		<div id="step-2" class="tab-pane step-content" style="display: block !important;">
			<div class="row">
				<div class="col-md-12">
					<h4 class="pt-2"><?php _e('Map LazyChat Order Phases', 'lcwp') ?></h4>
					<p><?php _e('You have connected your LazyChat account. Now Map 
						LazyChat Order Phases with WooCommerce Order Phases', 'lcwp') ?></p>
				</div>
			</div>

			<?php include(LCWP_PATH . 'views/map-phases/map-phases.php'); ?>
		</div>
	</div>
</div>