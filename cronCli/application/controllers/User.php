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
        $info = array(
            'uid'       => 1024,
            'age'       => 100,
            'username'  => 'moxiaobai',
            'realname'  => '莫小白'
        );
        $data = array('code'=>1, 'info'=>$info);
        echo json_encode($data);
    }
}