<?php
/**
 * Helper_Array  
 *
 * @category Helper
 * @package  Helper_Array
 * @author   Lancer <lancer.he@gmail.com>
 * @version  1.0 
 */
class Helper_Array{

 	/**
 	 * sort 二维数组排序
 	 * 
 	 * @access public
     * @static
 	 * @param $arr  二维数组
 	 * @param $key  排序键名
 	 * @param $type 升序降序
 	 * @example $array = array(
 	 * 				array('id' => 2, 'name'=>'lancer', 'age'=>18),
 	 * 				array('id' => 3, 'name'=>'chart', 'age'=>17),
 	 *  		);
 	 * 			$result = Helper_Array::sort($array, 'id', 'desc');
 	 */
	public static function sort($arr, $key, $type='ASC'){ 
		$keys_array = $new_array = array();
		foreach ($arr AS $k=>$v){
			$keys_array[$k] = $v[$key];
		}

		array_multisort($keys_array, $arr, strtoupper( $type ) == 'ASC' ? SORT_ASC : SORT_DESC);
		return $arr;
//		strtoupper( $type ) == 'ASC' ?  asort($keys_array) : arsort($keys_array);
//		reset($keys_array);
//		foreach ($keys_array AS $k=>$v){
//			$new_array[$k] = $arr[$k];
//		}
//		return $new_array;
	}


	/**
 	 * rand 从数组中随机取出一个或多个单元组成新的数组
 	 * 
 	 * @access public
     * @static
 	 * @param $data 二维数组
 	 * @param $num  随机的数组数量
 	 * @example $array = array(
 	 * 				array('id' => 2, 'name'=>'lancer', 'age'=>18),
 	 * 				array('id' => 3, 'name'=>'chart', 'age'=>17),
 	 * 				array('id' => 4, 'name'=>'new', 'age'=>16),
 	 *  		);
 	 * 			$result = Helper_Array::rand($array, 2);
 	 */
	public static function rand($data, $num=1) {
		if ( ! is_array($data) OR empty($data) )
			return FALSE;

		$data = array_values($data);
		$temp = array_rand ( $data, $num );

		! is_array($temp) && $temp = array($temp);

		$new = array();
		foreach( $temp AS $key ) {
			$new[] = $data[$key];
		}

		if ( $num == 1 ) return $new[0];
		return $new;
	}

	/**
 	 * shuffle 把一个数组重新打乱排序返回
 	 * 
 	 * @access public
     * @static
 	 * @param $data 二维数组
 	 * @example $array = array(
 	 * 				array('id' => 2, 'name'=>'lancer', 'age'=>18),
 	 * 				array('id' => 3, 'name'=>'chart', 'age'=>17),
 	 * 				array('id' => 4, 'name'=>'new', 'age'=>16),
 	 *  		);
 	 * 			$result = Helper_Array::shuffle($array);
 	 */
	public static function shuffle($data) {
		if ( ! is_array($data) ) return $data; 

		$keys = array_keys($data); 
  		shuffle($keys); 
  		$random = array(); 
  		foreach ($keys AS $key) 
    		$random[] = $data[$key]; 

  		return $random;
	}


	/**
 	 * page 从数组中分页后，取出元组成新的数组
 	 *
 	 * @access public
     * @static
 	 * @param $data  二维数组
 	 * @param $page  当前页
 	 * @param $per   每页显数据数
 	 */
	public static function page($data, $page=1, $per=10) {
        if ( ! is_array($data) ) return FALSE;

    	$new   = array();
    	$start = ($page - 1) * $per;
    	$end   = $page * $per;

    	$data  = array_values($data);
    	for($i=$start; $i<$end; $i++) {
    		if ( isset($data[$i]) )
    			$new[] = $data[$i];
    	}
    	return $new;
    }


	/**
 	 * search 从数组中查找，存在相等条件的字段 返回对应元组成新的数组
 	 * 
 	 * @access public
     * @static
 	 * @param $data  二维数组 array( 0=>array('id'=>2, 'name'=>'json', 1=>array('id'=>4, 'name'=>'niko') );
 	 * @param $where 条件    array('id'=> array('type'=>'eq', 'value' => 2);
 	 * @return 返回对应数组 array(0=>array('id'=>2, 'name'=>'json'))
 	 */
	public static function search($data, $where) {
        if ( ! is_array($data) ) return FALSE;

		$nodata = array('total'=>0, 'data'=> FALSE);
		if ( ! $data OR empty($data) ) {
			return $nodata;
		}

		if ( ! $where OR empty($where) ) {
			return array('total'=> count($data), 'data' => $data);
		}

		$new   = array();
		$data  = array_values($data);
		foreach ($data AS $key => $row) {
			$find = 1;
			foreach ($where AS $field => $w) {
				//查找不存字段存在
				if ( ! isset( $row[ $field ] ) ) {
					$find = 0;
				} else {
					//查找类型为相等
					if ( $w['type'] == 'eq' AND $row[ $field ] != $w['value'] ) {
						$find = 0;
					}

					//查找类型为模糊匹配
					if ( $w['type'] == 'in_array' AND ! in_array($w['value'],  explode(',', $row[ $field ]) ) ) {
						$find = 0;
					}
				}	
			}

			if ( $find == 1 ) $new[] = $row;
		}

		if ( count($new) == 0 ) {
			return $nodata;
		}
		
		return array( 'total' => count($new), 'data'=> $new);
	}

	

    /**
     * pushStart  在数组第一个键前面添加一个项
     * @access public
     * 
     * @param mixed  $data    数组
     * @param mixed  $value   数据值
     * @param string $key     键名
     *
     * @return array
     */
	public static function pushStart($data, $value, $key='') {
        $new = array($key => $value);
        foreach ($data AS $key => $value) {
            $new[$key] = $value;
        }
        
        return $new;  
	}



	/**
     * setIds 从二维数据中，把需要的id提取出来存在一个数组中
     * @param $data    一个需要的二维数组 如: array(0=>array('c_id'=>2,'c_point'=>3000), 1=>array('c_id'=>3, 'c_point'=>4000))
     * @param $id_key  提取的id key值    如 c_id
	 * @param $implode 是否合组合字符串   
     * @return array/string  array(2,3) / 2,3
     */
	public static function setIds($data, $id_key, $implode=FALSE) {
        if ( ! is_array($data) ) return FALSE;

        $return_ids = array();
        foreach ($data AS $key => $row) {

            if ( ! isset($row[$id_key] ) ) 
                continue;

            $ids = $row[$id_key];

            $ids = ( strpos( $ids, ',') !== FALSE ) ? explode(',', $ids) : array($ids);
            foreach( $ids AS $id ) {
                ( !empty($ids) AND ! in_array($id, $return_ids) ) && $return_ids[] = $id;
            }
        }

        if ( $implode === TRUE ) {
            $return_ids = implode(',', $return_ids);
        }
        return $return_ids;
    }


    /**
     * setIdsKey        从二维数据中，把需要的id提取出来作为二维数据的键值
     * @param  $data    一个需要的二维数组 如: array(0=>array('c_id'=>2,'c_point'=>3000), 1=>array('c_id'=>3, 'c_point'=>4000))
     * @param  $id_key  提取的id key值    如 c_id  
     * @return array    array(2=>array('c_id'=>2,'c_point'=>3000), 3=>array('c_id'=>3, 'c_point'=>4000))
     */
    public static function setIdsKey($data, $id_key) {
        if ( ! is_array($data) ) return FALSE;

        $new = array();
        foreach ($data AS $row) {
            if ( ! isset($row[$id_key] ) ) 
                continue;

            $new[$row[$id_key]] = $row;
        }
        return $new;
    }

    /**
     * setIndex         给二维数据设置index排序号
     * @access public
     * 
     * @param  $data    一个需要的二维数组 如: array(0=>array('c_id'=>2,'c_point'=>3000), 1=>array('c_id'=>3, 'c_point'=>4000))
     * @return array    array(0=>array('index'=>1, 'c_id'=>2,'c_point'=>3000), 1=>array('index'=>2, 'c_id'=>3, 'c_point'=>4000))
     */
    public static function setIndex($data, $page=1, $per=10) {
        if ( ! is_array($data) ) return FALSE;
        
        $data  = array_values($data);

        foreach ($data AS $k => &$row) {
            $row['index'] = ($k + 1) + ($page - 1) * $per;
        }
        return $data;
    }
}