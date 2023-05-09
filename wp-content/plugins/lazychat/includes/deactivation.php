<?php

/**
 * @package LazyChat WooCommerce Plugin
 */

defined( 'ABSPATH' ) || exit;

add_action(
	'admin_head',
	function () { ?>
	<style>
		.lazychat-deactivation-modal button {
			font-size: 18px;
			font-weight: 400;
			color: #fff;
			background-color: #f44336;
			border-radius: 6px;
			border: none;
			padding: 14px 22px;
			cursor: pointer;
		}

		.lazychat-deactivation-modal button:hover {
			background: #f44336;
			box-shadow: 0 8px 25px -8px #f44336;
			border-color: #f44336;
		}

		.lazychat-deactivation-modal button.show-modal,
		.modal-box {
			position: absolute;
			top: 15%;
			left: 50%;
			transform: translate(-50%, -50%);
			box-shadow: 0 5px 10px rgba(0, 0, 0, 0.1);
		}

		.lazychat-deactivation-modal.active .show-modal {
			display: none;
		}

		.overlay {
			position: absolute;
			width: 100%;
			height: 100%;
			background-color: rgba(0, 0, 0, 0.5);
			opacity: 0;
			top: 0;
			left: 0;
			z-index: -1;
		}

		.lazychat-deactivation-modal.active .overlay,
		.lazychat-deactivation-modal.active .modal-box {
			opacity: 1;
			pointer-events: auto;
		}

		.lazychat-deactivation-modal.active .modal-box {
			transform: translate(-50%, -50%) scale(1);
		}

		.modal-box {
			display: flex;
			flex-direction: column;
			justify-content: center;
			align-items: center;
			width: 100%;
			max-width: 380px;
			background-color: #fff;
			border-radius: 7px;
			padding: 30px 20px;
			opacity: 0;
			pointer-events: none;
			transition: all 0.3s ease;
			transform: translate(-50%, -50%) scale(1.2);
		}

		.modal-box i {
			font-size: 70px;
			color: #4070f4;
		}

		.modal-box h3 {
			font-size: 25px;
			font-weight: 600;
			margin-top: 20px;
			color: #333;
		}

		.modal-box p {
			font-size: 16px;
			font-weight: 400;
			color: #333;
			text-align: center;
		}

		.modal-box .buttons {
			margin-top: 25px;
		}

		.modal-box button {
			font-size: 14px;
			font-weight: 400;
			padding: 6px 12px;
			margin: 0 10px;
		}

		.close-button {
			position: absolute;
			top: -13px;
			left: 399px;
			cursor: pointer;
		}

		.checkbox label {
			transition: 0.3s;
		}

		.checkbox:hover .custom-checkbox+label::before {
			border-color: #006c67;
		}

		.checkbox:hover label {
			color: #000;
		}

		.checkbox .custom-checkbox {
			position: absolute;
			z-index: -1;
			opacity: 0;
		}

		.checkbox .custom-checkbox+label {
			display: inline-flex;
			align-items: center;
			-webkit-user-select: none;
			-moz-user-select: none;
			-ms-user-select: none;
			user-select: none;
		}

		.checkbox .custom-checkbox+label::before {
			transition: 0.3s;
			content: "";
			display: inline-block;
			width: 20px;
			height: 20px;
			flex-shrink: 0;
			flex-grow: 0;
			border: 1px solid #cccccc;
			border-radius: 4px;
			margin-right: 0.5em;
			background-repeat: no-repeat;
			background-position: center center;
			background-size: 50% 50%;
		}

		.checkbox .custom-checkbox:checked+label::before {
			border-color: #006c67;
			background-color: #006c67;
			background-image: url("data:image/svg+xml,%3Csvg%20width%3D%2212%22%20height%3D%2210%22%20viewBox%3D%220%200%2012%2010%22%20fill%3D%22none%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%3E%0A%3Cpath%20d%3D%22M10%202L4.5%208L2%205.27273%22%20stroke%3D%22white%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22square%22%2F%3E%0A%3C%2Fsvg%3E%0A");
		}
	</style>
		<?php
	}
);

add_action(
	'admin_footer',
	function () {
		?>
	<section class="lazychat-deactivation-modal">
		<span class="overlay"></span>
		<div class="modal-box">
			<div class="close-button">
				<svg height="30px" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 512 512" xml:space="preserve">
					<circle style="fill:#006c67;" cx="256" cy="256" r="256" />
					<path style="fill:#188561;" d="M150.2,368.6l141,141c115.2-15.8,205.9-108.3,219.1-224.2L367.9,142.9L150.2,368.6z" />
					<path style="fill:#FFFFFF;" d="M368.5,337.4l-82.8-82.8l82.8-82.8c7.8-7.8,7.8-20.5,0-28.3s-20.5-7.8-28.3,0l-82.8,82.8l-82.8-82.8
						c-7.8-7.8-20.5-7.8-28.3,0s-7.8,20.5,0,28.3l82.8,82.8l-82.8,82.8c-7.8,7.8-7.8,20.5,0,28.3c3.9,3.9,9,5.9,14.1,5.9s10.2-2,14.1-5.9
						l82.8-82.8l82.8,82.8c3.9,3.9,9,5.9,14.1,5.9s10.2-2,14.1-5.9C376.3,357.9,376.3,345.2,368.5,337.4z" />
				</svg>
			</div>
			<p>Are you sure you want to Deactivate LazyChat?</p>
			<div class="checkbox">
				<input class="custom-checkbox remove_all_1" type="checkbox" id="checkbox" name="checkbox" checked>
				<label for="checkbox" style="font-size: 0.9rem;">
					Delete all data(products, categories, images, contacts, orders) fetched in LazyChat</label>
			</div>
			<div class="buttons">
				<button class="lcwp_deactivate_lazychat">Yes, Deactivate LazyChat</button>
			</div>
		</div>
	</section>

	<script type="text/javascript">
		jQuery(document).ready(function($) {
			if ($('#deactivate-lazychat').length > 0) {
				const section = document.querySelector('.lazychat-deactivation-modal'),
					overlay = document.querySelector('.overlay'),
					showBtn = document.querySelector('#deactivate-lazychat'),
					closeBtn = document.querySelector('.close-button');

				showBtn.addEventListener('click', () => {
					overlay.style.zIndex = 'unset';
					section.classList.add('active');

				});

				closeBtn.addEventListener('click', () => {
					section.classList.remove('active');
					overlay.style.zIndex = -1;
				});

				overlay.addEventListener('click', () => {
					section.classList.remove('active');
					overlay.style.zIndex = -1;

				});

				$(".lcwp_deactivate_lazychat").click(function() {
					$(this).attr("disabled", "disabled");
					$(this).html("Deactivating...");

					deactivate();
				});
			}
		});

		function deactivate() {
			let element = document.getElementsByClassName('deactivate_lazychat_btn');
			let remove_all = 0;
			if (element.length > 0) {
				var parent = document.querySelector('.deactivate-body #remove_all');
				if (parent.checked) remove_all = 1;
				else remove_all = 0;
			} else {
				var parent = document.querySelector('.lazychat-deactivation-modal #checkbox');
				if (parent.checked) remove_all = 1;
				else remove_all = 0;
			}

			wp.ajax.post("lcwp_deactivate_lazychat", {
				remove_all: remove_all,
				nonce: "<?php echo esc_html__( 'lcwp_deactivate_lazychat' ); ?>",
			})
				.done(function(res) {
					if (res.status === 'success') {
						element.innerText = "LazyChat Plugin Deactivated Successfully";
						setTimeout(function() {
							if (element.length > 0) {
								window.location.href = "<?php echo get_dashboard_url(); ?>";
							} else {
								window.location.reload();
							}
						}, 1000);
					} else {
						element.innerText = res.message;
					}
				});
		}
	</script>
		<?php
	}
);
