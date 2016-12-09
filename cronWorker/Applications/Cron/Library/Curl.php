<?php

/**
 * Curl助手类
 *
 * @author: moxiaobai
 * @since : 2015/5/12 9:45
 */

class Curl {

    const TIMEOUT = 60;

    /**
     * Curl Get方式请求
     *
     * @param $url
     * @return array
     */
    public static function get($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, self::TIMEOUT);
        $result = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE); //返回状态码

        $msg = null;
        if($result === FALSE) {
            $msg = curl_error($ch);
        }
        curl_close($ch);

        $data = array('code'=>$httpCode, 'result'=>$result, 'msg'=>$msg);
        return $data;
    }
}