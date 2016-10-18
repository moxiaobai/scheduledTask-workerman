<?php

/**
 * 企业号
 * 返回数据 errcode为0表示成功，其他都是错误
 *
 * @author: moxiaobai(mlkom@live.com)
 * @since : 2016-01-25 
 */

class QyWeixin {

    /**
     * 发送消息
     *
     * @param $userid
     * @param $content
     * @return mixed|string
     */
    public static function sendMessage($userid, $content, $agentid=5) {
        $token = self::getToken();
        $url  = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token={$token}";

        $data = array(
            "touser"     => $userid,
            "msgtype"    => 'text',
            "agentid"    => $agentid,
            "text"       => array('content'=>$content),
            "safe"       => 0,

        );
        return self::curlPost($url, $data);
    }

    //获取token
    public static function getToken() {
        $corpid     = "wxf9f138ce3059d156";
        $corpsecret = "7g9dpZ5_sCNkAnA3OQQpflOmc7f26EzQ03BjBu47ROk5MPRucxv03VZjbx5sHFkV";
        $url = "https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$corpid}&corpsecret={$corpsecret}";

        $ret = self::curlGet($url);
        $token = json_decode($ret, true);
        return $token['access_token'];
    }

    public static function curlGet($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);

        return $ret;
    }

    public static function curlPost($url, $data) {
        $data = json_encode($data, JSON_UNESCAPED_UNICODE);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        $ret = curl_exec($ch);
        curl_close($ch);

        $data = json_decode($ret, true);
        return $data;
    }
}