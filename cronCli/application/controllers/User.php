<?php
/**
 * 文件说明
 *
 * @author: moxiaobai
 * @since : 2016/4/13 14:47
 */

class UserController extends BaseController {

    public function init()
    {
        parent::init();
    }

    public function listAction() {
        $data = array('code'=>1, 'info'=>2);
        echo json_encode($data);
    }

    public function statAction() {
        $money = mt_rand(10000,20000);
        $data = array('code'=>1, 'info'=>$money);
        echo json_encode($data);
    }
}