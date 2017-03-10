<?php

/**
 * 配置辅助类
 *
 * @author: moxiaobai
 * @since : 2016/9/23 15:53
 */

class Config {

    public static function get($file, $key=null) {
        $iniFile = APP_PATH . "/Config/{$file}.ini";
        if(!file_exists($iniFile)) {
            throw new Exception("Missing Config File");
        }

        $ini_array = parse_ini_file($iniFile, true);
        if(is_null($key)) {
            return $ini_array;
        } else {
            if(!isset($ini_array[$key])) {
                throw  new Exception("Missing Config Item");
            }

            return $ini_array[$key];
        }

    }
}