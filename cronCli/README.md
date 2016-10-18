# Yaf Cli命令行
模型和全局类，一样调用

## 无模块情况
php request.php request_uri="/user/list/"

默认Index模块，User控制器，list方法
application\controllers\User.php

## 有模块情况
php request.php request_uri="/pay/message/list/"

Pay模块，Message控制器，list方法
application\modules\Pay\controllers\Message.php





