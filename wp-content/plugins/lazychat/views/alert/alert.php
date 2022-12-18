<?php
if (isset($_SESSION[FLASH])) {
	echo '<div class="mt-3 alert alert-card alert-' . $_SESSION[FLASH]['type'] . ' alert-dismissible fade 
		show" role="alert"><strong class="text-capitalize">' . $_SESSION[FLASH]['type'] . '!</strong> ' . $_SESSION[FLASH]['message'];
	echo '<button class="close" type="button" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>';
	echo '</div>';
	
	unset($_SESSION[FLASH]);
}
