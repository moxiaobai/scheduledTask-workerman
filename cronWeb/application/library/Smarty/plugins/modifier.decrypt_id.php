<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_modifier_decrypt_id($id) {
    return Arithmetic_Id::decrypt($id);
}

/* vim: set expandtab: */

?>
