<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
function smarty_modifier_truncate_cn($str, $len, $end = '') {
    $i=$j=0;
    $strlen = mb_strlen($str, 'UTF-8');

    for($i=0; $i < $strlen; $i++) {
        if(strlen(mb_substr($str, $i, 1, 'UTF-8')) > 1) {
            $j+=2;
        } else {
            $j++;
        }

        if($j >= $len) break;
    }

    $returnStr  = mb_substr($str, 0, ++$i, 'UTF-8');
    $returnStr .= $j < $len ? '' : $end;

    return $returnStr;
}

/* vim: set expandtab: */

?>
