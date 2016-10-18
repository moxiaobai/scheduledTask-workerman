<?php 

/**
 * 所有在Bootstrap类中, 以_init开头的方法, 都会被Yaf调用,
 * 这些方法, 都接受一个参数:Yaf_Dispatcher $dispatcher
 * 调用的次序, 和申明的次序相同
 */

class Bootstrap extends Yaf_Bootstrap_Abstract {

	private $_config;
    
    /**
     * 初始化系统配置
     */
    public function _initConfig(Yaf_Dispatcher $dispatcher) {
        $this->_config = Yaf_Application::app()->getConfig();
    }
    
    /**
     * 初始化系统环境
     */
    public function _initEnvironment(Yaf_Dispatcher $dispatcher) {
        header('Content-Type: text/html; charset=UTF-8');
        date_default_timezone_set('Asia/Chongqing');

        /* 定义常量 */
        define('APP_DOMAIN', $this->_config->app->host);
        define('APP_KEY',    $this->_config->app->authKey);

        define('SERVER_HOST', $this->_config->app->server);

        /* Session */
        Yaf_Session::getInstance()->start();
    }

    /**
     * 初始化用户信息
     */
    public function _initAuth(Yaf_Dispatcher $dispatcher) {
        $request_uri = $dispatcher->getRequest()->getRequestUri();

        if( strpos($request_uri, '/ajax') !== FALSE ){
            return FALSE;
        }

        if( ! Yaf_Session::getInstance()->has('userInfo') AND strpos($request_uri, 'login') === FALSE ) {
            header('Location:' . APP_DOMAIN . '/login');
        } elseif (Yaf_Session::getInstance()->has('userInfo')) {
            $user_info = Yaf_Session::getInstance()->get('userInfo');
            define('UID',         $user_info['u_id'] );
            define('U_NAME',      $user_info['u_username'] );
            define('U_REALNAME',  $user_info['u_realname'] );
            define('U_ROLE',      $user_info['u_role'] );
        }
    }


    /**
     * 初始化Smarty模版
     */
    public function _initSmarty(Yaf_Dispatcher $dispatcher) {
        $config     = $this->_config->smarty->toArray();
        $requestUri = ltrim( $dispatcher->getRequest()->getRequestUri(), '/');
        $urls       = explode('/', $requestUri);

        if ( FALSE !== strpos($requestUri, '.html') ) {
            $config['compile_id'] = $requestUri;
        } elseif ( count($urls) >= 3 ) {
            //路由URL 结构大于3个，表示有模块，防止模板重名加载，在编译上文件名加上模块作为参数
            $config['compile_id'] = array_shift($urls);
        }

        $smarty = new Smarty_Adapter(null, $config);
        $dispatcher->setView($smarty);
    }
}
