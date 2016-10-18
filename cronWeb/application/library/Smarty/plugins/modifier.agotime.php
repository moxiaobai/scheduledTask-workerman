<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_modifier_agotime($timestamp) {
    return Helper_DateFormat::agotime($timestamp);
}

/* vim: set expandtab: */

?>
