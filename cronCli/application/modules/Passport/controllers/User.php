<?php
/**
 * 用户统计
 *
 * @author: moxiaobai
 * @since : 2016/9/1 15:51
 */

class UserController extends BaseController {

    public function init()
    {
        parent::init();
    }

    public function statAction() {

        $userInfo = $this->loadModel('Member')->getUserInfo(1024);
        $this->echoJson(1, $userInfo);

    }
}