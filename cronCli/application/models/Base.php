<?php

/**
 * 数据库模式基类
 * 
 * @author xiaogang
 * @since  2012-11-12
 */

class BaseModel {


    static  $_instance = array();


	/**
     * 返回结果
     * @param integer $status 状态值
     * @param mixed    $data   提示信息
     */
	public function result( $code=1, $data='' ){
        return array( 'code'=>$code, 'data'=>$data );
    }

	/**
     * 返回单例对象
     * @return object
     */
    static public function getInstance() {
        $called_class_name = get_called_class();

        if ( ! isset( self::$_instance[$called_class_name] ) ) {
            self::$_instance[$called_class_name] = new $called_class_name();
        }

        return self::$_instance[$called_class_name];
    }

	/**
	 * 载入modules下的model类(注意大小写)
	 * @param $module_name 模块名称
	 * @param $class_name   类名称
	 */
	protected function loadmodel($class_name,$param=array(),$module_name=false){
		if(!$module_name){
			$module_name = MODULES_NAME;
		}
		$class_name  = ucwords($class_name);

		$key   = "{$module_name}[{$class_name}]";
		$model = Yaf_Registry::get($key);

		//Is model has instance.
		if ( ! $model ) {
			//Is model file exists.
			$model_file = APP_PATH . '/application/modules/' . $module_name . '/models/' . $class_name.'.php';
			if ( ! file_exists( $model_file ) ){
				exit('Model file not exists: ' . $model_file);
			}
			require $model_file;

			$code_str = "";
            if($param){
                foreach ($param as $key => $value) {
                    $code_str.='$param['.$key.'],';
                }
                if($code_str!=""){
                    $code_str=substr($code_str,0,-1);
                }
            }

			$class_name = $class_name . 'Model';
			$code_str    = '$model = new '.$class_name.'('.$code_str.');';
			eval($code_str);
			Yaf_Registry::set($key, $model);
		}
		return $model;
	}
}