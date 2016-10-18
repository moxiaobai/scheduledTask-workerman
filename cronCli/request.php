<?php

/**
 * 文件说明
 *
 * @author: moxiaobai
 * @since : 2016/4/13 14:49
 */

define("APP_PATH",  dirname(__FILE__));
define("APP_ENV", ini_get('yaf.environ'));

$app =  new Yaf_Application(APP_PATH . "/config/application.ini");
$app->getDispatcher()->dispatch(new Yaf_Request_Simple());
