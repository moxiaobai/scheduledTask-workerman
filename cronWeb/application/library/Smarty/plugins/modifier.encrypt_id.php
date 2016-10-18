<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_modifier_encrypt_id($id) {
    return Arithmetic_Id::encrypt($id);
}

/* vim: set expandtab: */

?>
