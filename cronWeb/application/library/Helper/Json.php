<?php

/**
 * Ajax 操作，相应数据
 * 
 * @author moxiaobai
 * @since  2014-12-13
 *
 */

class Helper_Json {
    
	/**
	 * 输出json数据
	 * 
	 * @param integer $code -1表示错误，1表示正确
	 * @param mixed $data 错误信息或者返回数据
	 * @param $callback 跨域操作时的回调函数名称
	 * @param $isheader 是否设置Content-type
	 */
	public static function echoJson($code, $data='',$callback=false,$isheader=true) {
		if($isheader){
			header('Content-type:application/json;charset=utf-8');
		}
        $arr = array('code'=>$code, 'data'=>$data);
        if($callback===false){
        	echo json_encode($arr);
        }else{
        	echo $callback.'('.json_encode($arr).')';
        }
	    exit;
	}


	public static function formatJson($code, $msg, $url=NULL, $result=NULL, $callback=false,$isheader=true) {
		if ( $isheader ) {
			header('Content-type:application/json;charset=utf-8');
		}
        $arr = array('code'=>$code, 'msg'=> $msg, 'result'=>$result, 'url' => $url );
        if($callback===false){
        	echo json_encode($arr);
        }else{
        	echo $callback.'('.json_encode($arr).')';
        }
	    exit;
	}
	
	/**
	 * validform 表单元素验证
	 * 
	 * @param string $msg y表示表单验证通过,其它为错误信息
	 */
	public static function haltMsg($msg='y') {
	   echo $msg;exit;
	}
	
	/**
	 * validform 表单提交验证
	 * 
	 * @param string $msg
	 * @param string $status y表示通过，n表示未通过
	 */
	public static function formJson($msg, $status='n') {
	    echo json_encode(array('info'=>$msg, 'status'=>$status));
        exit;
	}
}