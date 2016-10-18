<?php

/**
 * 一些公用的控制器方法,需要继承此类.
 * 
 * @author moxiaobai
 * @since  2015-03-18
 */

Abstract Class BaseController extends Yaf_Controller_Abstract {

	protected function init() {
		Yaf_Dispatcher::getInstance()->disableView();
	}

	/**
	 * 输出Json数据
	 *
	 * @param $code  1正常，其他都是错误
	 * @param $info
	 */
	protected function echoJson($code, $info) {
		$data = array('code'=>$code, 'info'=>$info);
		echo json_encode($data);
		exit;
	}

	/**
	 * 载入modules下的model类(注意大小写)
	 *
	 * @param $module_name  模块名称
	 * @param $class_name   类名称
	 */
	protected function loadModel($class_name,$param=array(),$module_name=false){
		//return module name;
		if(!$module_name){
			$module_name = $this->getModuleName();
		}
		$class_name  = ucwords($class_name);

		$key   = "{$module_name}[{$class_name}]";
		$model = Yaf_Registry::get($key);

		//Is model has instance.
		if ( ! $model ) {
			//Is model file exists.
			$model_file = APP_PATH . '/application/modules/' . $module_name . '/models/' . $class_name.'.php';
			if ( ! file_exists( $model_file ) ) {
                throw new Exception('Model file not exists: ' . $model_file);
            }

			require $model_file;

			$code_str = "";
			foreach ($param as $key => $value) {
				$code_str.='$param['.$key.'],';
			}
			if($code_str!=""){
				$code_str=substr($code_str,0,-1);
			}
			$class_name = $class_name . 'Model';
			$code_str    = '$model = new '.$class_name.'('.$code_str.');';
			eval($code_str);
			Yaf_Registry::set($key, $model);
			
			if( ! defined('MODULES_NAME') ) {
				define('MODULES_NAME', $module_name);
			}
		}
		return $model;
	}
}