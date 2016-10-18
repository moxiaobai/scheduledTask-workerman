<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_modifier_loader($tag, $type) {
	if($type == 'css') {
		return empty($tag) ? Init_Loader::css() : Init_Loader::css($tag);
	} else {
		return empty($tag) ? Init_Loader::js() : Init_Loader::js($tag);
	}   
}

/* vim: set expandtab: */

?>
