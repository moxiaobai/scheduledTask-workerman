<?php

/**
 * 数据库分表辅助函数
 */
class Helper_Dbsuf {


    /**
     * 获取分表标识
     * @param 用户ID
     * @return 表后缀
     */
	public static function getDbSuf($id,$num=36){
		switch($num){
			case 10:$arrsuf = array('0','1','2','3','4','5','6','7','8','9');break;
			case 24:$arrsuf = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');break;
			case 36:$arrsuf = array('0','1','2','3','4','5','6','7','8','9','A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');break;
			default:throw new Exception('error num',100000);
		}
		$str = md5($id);
		$idx = (ord($str[0]) + ord($str[1]) + ord($str[2])) % $num;
		
		return $arrsuf[$idx];
	}
	
	
	/**
	 * 返回GUID值
	 * @return string	新的GUID
	 */
	public static function guid(){
		if (function_exists('com_create_guid')){
	        return substr(com_create_guid(),1,36);
	    }else{
	        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
	        $charid = strtoupper(md5(uniqid(rand(), true)));
	        $hyphen = chr(45);// "-"
	        $uuid = substr($charid, 0, 8).$hyphen
	                .substr($charid, 8, 4).$hyphen
	                .substr($charid,12, 4).$hyphen
	                .substr($charid,16, 4).$hyphen
	                .substr($charid,20,12);
	        return $uuid;
	    }
	}


}