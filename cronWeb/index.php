<?php

define('APP_PATH', dirname(__FILE__));
//系统环境
define('APP_ENV', ini_get('yaf.environ'));

$application = new Yaf_Application( APP_PATH . "/config/application.ini", APP_ENV);
$application->bootstrap()->run();

