<?php

/**
 * 错误异常
 *
 * @author moxiaobai
 * @since  2015-3-18
 */

class ErrorController extends Yaf_Controller_Abstract {
    
    public function errorAction($exception) {
        echo "[Message]" . $exception->getMessage() . ";[File]" . $exception->getFile() . ";[Line]" . $exception->getLine();
        exit;
    }
}