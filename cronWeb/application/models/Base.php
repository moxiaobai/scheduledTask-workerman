<?php

/**
 * 数据库模式基类
 * 
 * @author xiaogang
 * @since  2012-11-12
 */

class BaseModel {

    static  $_instance = array();
    private $Mysql_db;

    /**
     * 数据库链式sql操作
     */
	public function linkdb($dbName){
        if(!$this->Mysql_db) {
            $this->Mysql_db = Db_LinkMySQL::get($dbName);
        }

        return $this->Mysql_db;
    }

	/**
     * 返回结果
     *
     * @param $code 状态值
     * @param $data 提示信息
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
}