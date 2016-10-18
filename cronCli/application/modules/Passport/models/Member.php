<?php

/**
 * 用户模型
 *
 * @author: moxiaobai
 * @since : 2016/6/18 13:13
 */

class MemberModel extends BaseModel
{

    public function getUserInfo($uid) {
        $data = array(
            'uid'       => $uid,
            'username'  => 'moxiaobai',
            'realname'  => '莫小白'
        );
        return $data;
    }
}