<?php

function smarty_modifier_erp_avatar($id, $size=150) {
	if ( ! in_array($size, array('src', '150', '50', '30') ) ) {
		$size = 120;
	}

	if ( file_exists( APP_UPLOAD_DIR . "avatar/{$id}/{$size}.jpg" ) ) {
		return APP_UPLOAD_URL . "avatar/{$id}/{$size}.jpg";
	}
	return APP_DOMAIN . "/public/img/avatar/{$size}.jpg";
}

?>
