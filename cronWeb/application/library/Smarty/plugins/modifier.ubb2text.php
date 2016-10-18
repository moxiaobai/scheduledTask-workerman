<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_modifier_ubb2text($message, $wrap=FALSE) {
    return Helper_UBB::ubb2text($message, $wrap);
}

/* vim: set expandtab: */

?>
