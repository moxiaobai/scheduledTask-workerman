<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_modifier_ubb2html($message, $hide=TRUE) {
    return Helper_UBB::ubb2html($message, $hide);
}

/* vim: set expandtab: */

?>
