<?php

/**
 * 登陆页面
 
 * @author: moxiaobai(mlkom@live.com)
 * @since : 2016-01-31 
 */

class LoginController extends Yaf_Controller_Abstract {

    private $_userModel;

    public function init() {
        $this->_userModel = new UserModel();
    }

    /**
     * 登录页面
     */
    public function indexAction() {}

    /**
     * 退出页面
     */
    public function logoutAction() {
        Yaf_Session::getInstance()->del('userInfo');
        $this->redirect('/login/');
    }

    //登录ajax请求
    public function ajaxAction() {
        $username = Helper_Filter::format($_POST['user'], true);
        $password = Helper_Filter::format($_POST['pwd'], true);;

        if ( empty($username) || empty($password) ) {
            Helper_Json::echoJson(-1, '请输入用户名和密码');
        }

        $userInfo     = $this->_userModel->login($username, $password);
        if( ! $userInfo ) {
            Helper_Json::echoJson(-1, '密码错误,请重试');
        }

        Yaf_Session::getInstance()->set('userInfo', $userInfo);
        Helper_Json::echoJson(1, '');
    }

}