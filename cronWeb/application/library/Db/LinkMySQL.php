<?php
/**
 * Db_MySQL  辅助MySql生成sql语句
 *
 * @category Db
 * @package  MySQL
 * @version  1.0
 */
class Db_LinkMySQL{

	private static $_configs   = array();
	private static $_instances = array();

	protected $_connection = NULL;
	protected $_type       = 'SELECT';
	protected $_table      = NULL;
	protected $_limit      = NULL;
	protected $_where      = NULL;
	protected $_join       = NULL;
	protected $_group      = NULL;
	protected $_selects    = array();
	protected $_inserts    = array();
	protected $_updates    = array();
	protected $_orders     = array();
	protected $_sqls       = array();
	protected $delimiter   = '`';
	protected $comma       = ', ';



	public static function get($database) {
		if ( empty(self::$_configs) ) {
			$config = new Yaf_Config_Ini(APP_PATH . "/config/database.ini",APP_ENV);
			$config = $config->toArray();

			foreach ($config['mysql'] AS $key => $row) {
				self::$_configs[$key] = $row;
			}
		}
		if ( ! isset(self::$_instances[$database]) ) {
			$row      = self::$_configs[$database];
			$instance = new Db_LinkMySQL( $row['host'], $row['user'], $row['password'], $row['database'] );
			self::$_instances[$database] = $instance;
			return $instance;
		}
		return self::$_instances[$database];
	}


	/**
	 * 构造函数 选择数据库
	 */
	public function __construct($hostname, $username, $password, $database) {
		if ( ! $this->_connection = mysqli_connect($hostname, $username, $password, $database)) {
			die('Error: Could not make a database _connection using ' . $username . '@' . $hostname);
		}

		mysqli_query($this->_connection, "SET NAMES 'utf8'");
		mysqli_query($this->_connection, "SET CHARACTER SET utf8");
		mysqli_query($this->_connection, "SET CHARACTER_SET_CONNECTION=utf8");
		mysqli_query($this->_connection, "SET SQL_MODE = ''");
	}


	/**
	 * countAffected 返回影响行
	 * @access public
	 *
	 * @return int 影响行
	 */
	public function countAffected() {
		return mysqli_affected_rows($this->_connection);
	}


	/**
	 * getInsertId  返回最新插入的Id
	 * @access public
	 *
	 * @return int 最新id值
	 */
	public function getInsertId() {
		return mysqli_insert_id($this->_connection);
	}


	/**
	 * query 执行SQL操作
	 * @access public
	 *
	 * @param mixed $sql   SQL字符串或者SQL对象
	 * @return mixed 如果是Resource返回对象，否则返回影响行/最新插入id
	 */
	public function query($sql) {
		if ( is_object($sql) ) {
			$sql = $sql->_toSQL();
		}

		$resource = mysqli_query($this->_connection, $sql);
		if(! $resource) {
			die('Error: ' . mysqli_error($this->_connection) . '<br />Error No: ' . mysqli_errno($this->_connection) . '<br />' . $sql);
		}

		if($this->_type == 'SELECT') {
			$i = 0; $data = array();
			while ($result = mysqli_fetch_assoc($resource)) {
				$data[$i] = $result;
				$i++;
			}
			mysqli_free_result($resource);

			$query = new stdClass();
			$query->one  = isset($data[0]) ? $data[0] : FALSE;
			$query->rows = empty($data) ? FALSE : $data;
			$query->num  = $i;

			unset($data);
			return $query;
		} else {
			return ( $this->_type == 'INSERT' ) ? $this->getInsertId() : $this->countAffected();
		}
	}



	/**
	 * delimiter 给字段增加定界符
	 * @access private
	 *
	 * @param string $field 字段名
	 * @return string
	 */
	private function _delimiter($field) {
		return $this->delimiter . $field . $this->delimiter;
	}


	/**
	 * _toSQL 构造SQL语句
	 * @access private
	 *
	 * @return string sql语句
	 */
	private function _toSQL(){
		if ( empty($this->_type) )
			$this->_type = 'SELECT';

		$this->_type = strtoupper($this->_type);
		switch ($this->_type) {

			case "SELECT":
				$sql = "SELECT ";
				if ( empty( $this->_selects ) )
					$sql .= "*";
				else {
					foreach ( $this->_selects AS $select_field ) {
						//没有括号，说明不是Mysql函数，
						if ( strpos($select_field, '(') === FALSE )
							$select_field = $this->_delimiter( $select_field );
					}
				}
				$sql .= implode( ', ', $this->_selects );
				$sql .= " FROM ";
				$sql .= strpos($this->_table, ',') ? $this->_table : $this->_delimiter( $this->_table );

				if ( $this->_join )
					$sql .= $this->_join;

				if ( $this->_where )
					$sql .= " WHERE " . $this->_where;

				//GROUP BY
				if ( ! empty( $this->_group) ) {
					$sql .= " GROUP BY " . $this->_delimiter($this->_group);
				}

				//ORDER BY
				if ( ! empty( $this->_orders ) ) {
					$_orders = array();
					foreach ( $this->_orders AS $field => $sort) {
						//没有括号，说明不是Mysql函数，
						if ( strpos($field, '(') === FALSE )
							$_orders[] = $this->_delimiter( $field ) . ' ' . $sort;
						else
							$_orders[] = $field;
					}
					$sql .= " ORDER BY " . implode(', ', $_orders);
				}

				//LIMIT
				if ( $this->_limit )
					$sql .= " LIMIT " . $this->_limit;

				break;

			case "INSERT":
				$sql_insert = $sql_value = '';
				foreach ($this->_inserts AS $field => $value) {
					$sql_insert .= $this->_delimiter($field) . $this->comma;
					$sql_value  .= "'{$value}'" . $this->comma;
				}
				$sql_insert = trim($sql_insert, $this->comma);
				$sql_value  = trim($sql_value, $this->comma);

				$sql  = "INSERT INTO ";
				$sql .= $this->_delimiter( $this->_table );
				$sql .= " ({$sql_insert}) VALUES ({$sql_value}) ";
				break;

			case "UPDATE":
				$sql_update = '';
				foreach ($this->_updates AS $field => $row) {
					$value = $row['value'];
					if ( $row['type'] == 'equal' ) {
						$sql_update .= $this->_delimiter($field) . " = '{$value}'" .  $this->comma;
					} elseif ( $row['type'] == 'identity' ) {
						$sql_update .= $this->_delimiter($field) . " = " . $this->_delimiter($field) . "+" . $value .  $this->comma;
					}
				}
				$sql_update = trim($sql_update, $this->comma);

				$sql  = "UPDATE ";
				$sql .= $this->_delimiter( $this->_table );
				$sql .= " SET {$sql_update}";

				if ( $this->_where )
					$sql .= " WHERE " . $this->_where;
				//LIMIT
				if ( $this->_limit )
					$sql .= " LIMIT " . $this->_limit;
				break;

			case "DELETE":
				$sql  = "DELETE FROM ";
				$sql .= $this->_delimiter( $this->_table );
				if ( $this->_where )
					$sql .= " WHERE " . $this->_where;

				//LIMIT
				if ( $this->_limit )
					$sql .= " LIMIT " . $this->_limit;
				break;

		}
		$sql .= ';';
		$this->_clear();
		return $sql;
	}


	/**
	 * __toString 魔法方法，当输出这个对象的时候转化成SQL字符串
	 * @access public
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->_toSQL();
	}


	/**
	 * _clear 清除sql组合
	 * @access private
	 *
	 * @return mixed Value.
	 */
	private function _clear(){
		$this->_table   = $this->_limit   = $this->_where   = $this->_join    = $this->_group = NULL ;
		$this->_selects = $this->_inserts = $this->_updates = $this->_orders  = array();
	}


	/**
	 * fetchNum 返回记录数量
	 * @access public
	 *
	 * @return int
	 */
	public function fetchNum() {
		$this->_selects = array('COUNT(*) AS count');
		$row = $this->fetchOne();
		return intval($row['count']);
	}


	/**
	 * fetchValue 返回结果集中第一个字段的值
	 * @access public
	 *
	 * @return array
	 */
	public function fetchValue() {
		$sql = $this->limit(1)->_toSQL();
		$row = $this->query( $sql )->one;
		return ($row === FALSE) ? FALSE : array_shift($row);
	}


	/**
	 * fetchOne 返回单行数组
	 * @access public
	 *
	 * @return array
	 */
	public function fetchOne() {
		$sql = $this->limit(1)->_toSQL();
		return $this->query( $sql )->one;
	}


	/**
	 * fetchAll 返回多行数组
	 * @access public
	 *
	 * @return array
	 */
	public function fetchAll() {
		$sql = $this->_toSQL();
		return $this->query( $sql )->rows;
	}


	/**
	 * queue   把SQL语句按顺序存起来
	 * @access public
	 *
	 * @return object
	 */
	public function queue() {
		$sql = $this->_toSQL();
		$this->_sqls[] = $sql;
		return $this;
	}


	/**
	 * toQueueString 查看多条SQL
	 * @access public
	 *
	 * @return array
	 */
	public function toQueueString() {
		$sql = '';
		foreach( $this->_sqls AS $_sql) {
			$sql .= $_sql . PHP_EOL;
		}

		return $sql;
	}


	/**
	 * executeQueue 执行已经保存的多条SQL语句
	 * @access public
	 *
	 * @return array
	 */
	public function executeQueue() {
		$sql = $this->toQueueString();
		return $this->query( $sql );
	}


	/**
	 * execute 执行mysql
	 * @access public
	 *
	 * @return array
	 */
	public function execute() {
		$sql = $this->_toSQL();
		return $this->query( $sql );
	}


	/**
	 * toString 返回SQL局域
	 * @access public
	 *
	 * @return string.
	 */
	public function toString() {
		return $this->_toSQL();
	}


	/**
	 * group
	 * @access public
	 *
	 * @param   string $field 字段
	 * @return  object
	 * @example $this->order('field_1 DESC', 'field_2 ASC')
	 */
	public function group($field) {
		$this->_group = $field;
		return $this;
	}


	/**
	 * order 排序字段
	 * @access public
	 *
	 * @return  object
	 * @example $this->order('field_1', 'DESC')
	 */
	function order($field, $sort='ASC') {
		$sort = strtoupper($sort);
		$sort = in_array( $sort, array('ASC', 'DESC') ) ? $sort : 'ASC';

		if ( ! array_key_exists( $field, $this->_orders ) ) {
			$this->_orders[$field] = $sort;
		}
		return $this;
	}

	/**
	 * _where 查询条件设置
	 * @access private
	 *
	 * @param $field	字段(字符串/数组)
	 * @param $value	值
	 * @param $operator 运算符,默认"AND"
	 * @example _where(字段,值) | _where(array('字段'=>'值')) | _where("字符串")
	 */
	function _where($field, $value=FALSE, $operator="AND"){
		if( empty($field) ) {
			return $this;
		}

		$operator = strtoupper($operator);
		$operator = $operator == 'AND' ? 'AND' : 'OR';
		if ( is_array($field) ) {
			//格式:(array('字段'=>'值'))
			$field = $this->escape($field);
			foreach ($field AS $f => $value){
				if ( ! empty($this->_where) ) $this->_where .= $operator;

				$this->_where .= " ($f = '{$value}') ";
			}
		} else {
			if ( ! empty($this->_where) ) {
				$this->_where .= $operator;
			}

			if ( $value !== FALSE ) {
				$value = $this->escape($value);
				$this->_where .= " ($field = '{$value}') ";
			} else {
				$this->_where .= " ($field) ";
			}
		}
		return $this;
	}

	/**
	 * where 查询条件AND
	 * @access public
	 *
	 * @param  $field	字段(字符串/数组)
	 * @param  $value	值
	 * @return object
	 */
	function where($field, $value=FALSE){
		$this->_where($field, $value, "AND");
		return $this;
	}


	/**
	 * orWhere 查询条件OR
	 * @access public
	 *
	 * @param  $field	字段(字符串/数组)
	 * @param  $value	值
	 * @return object
	 */
	function orWhere($field, $value=FALSE){
		$this->_where($field, $value, "OR");
		return $this;
	}


	/**
	 * limit  Limit设置
	 * @access public
	 *
	 * @param  int $start	开始位置
	 * @param  int $num	    LIMIT数量
	 * @return object
	 */
	function limit($start, $num = "") {
		$start = intval($start);
		$num   = intval($num);
		$this->_limit = $num ? ( $start . "," . $num ) : $start;
		return $this;
	}


	/**
	 * page 分页
	 * @access public
	 *
	 * @param  int    $page     当前页
	 * @param  int    $pagesize 每页数量
	 * @return object
	 */
	function page($page, $pagesize) {
		$page     = intval($page);
		$pagesize = intval($pagesize);
		$start    = ( $page - 1 ) * $pagesize;
		return $this->limit($start, $pagesize);
	}


	/**
	 * rows 更新或者插入数组 只有 INSERT和UPDATE情况下可用
	 * @access public
	 * @param  array $data   更新或者插入数组
	 * @return object
	 */
	function rows($data) {
		if ( ! in_array( $this->_type, array('INSERT', 'UPDATE') ) )
			return $this;

		$data = $this->escape($data);
		foreach ( $data AS $field => $value ) {
			if ( $this->_type == 'INSERT' ) {
				if ( ! in_array($field, $this->_inserts) )
					$this->_inserts[ $field ] = $value;
			} else {
				if ( ! in_array($field, $this->_updates) )
					$this->_updates[ $field ] = array('type' => 'equal', 'value' => $value);
			}
		}

		return $this;
	}


	/**
	 * set UPDATE set方法
	 * @access public
	 * @param  array $data   更新或者插入数组
	 * @return object
	 */
	function set($field, $value, $identity=FALSE) {
		if ( $this->_type != 'UPDATE' )
			return $this;

		if ( $identity === TRUE ) {
			//对字段进行自增等特殊化操作
			$this->_updates[$field] = array('type' => 'identity', 'value' => $value);
		} else {
			$this->_updates[$field] = array('type' => 'equal', 'value' => $value);
		}
		return $this;
	}


	/**
	 * select 选择字段
	 * @access public
	 *
	 * @return  object
	 * @example $this->select('field_1', 'field_2', 'field_3')
	 */
	public function select() {
		$this->_type	= "SELECT";

		$args = func_get_args();
		if ( empty( $args ) )
			return $this;

		foreach ( $args AS $arg ) {
			if ( is_array($arg) ) {
				foreach ($arg AS $_arg) {
					if ( ! in_array($_arg, $this->_selects) ) {
						$this->_selects[] = $_arg;
					}
				}
			} else {
				if ( ! in_array($arg, $this->_selects) ) {
					$this->_selects[] = $arg;
				}
			}
		}
		return $this;
	}


	/**
	 * from 表名设置
	 * @access public
	 *
	 * @param  string $tablename 表名
	 * @return object
	 * @example $this->from('newtable')
	 */
	public function from($tablename) {
		$this->_table = $tablename;
		return $this;
	}


	/**
	 * insert 插入数据
	 * @access public
	 *
	 * @param  string $tablename 表名
	 * @return object
	 * @example $this->insert('newtable')
	 */
	public function insert($tablename) {
		$this->_type	 = "INSERT";
		$this->_table = $tablename;
		return $this;
	}


	/**
	 * update 更新数据
	 * @access public
	 *
	 * @param  string $tablename 表名
	 * @return object
	 * @example $this->update('newtable')
	 */
	public function update($tablename) {
		$this->_type  = "UPDATE";
		$this->_table = $tablename;
		return $this;
	}


	/**
	 * delete 删除数据 (需要配合->where()指定条件,否则将删除整张表的数据.)
	 * @access public
	 *
	 * @param  string $tablename 表名
	 * @return object
	 * @example $this->delete('newtable')
	 */
	public function delete($tablename, $query=TRUE) {
		$this->_type  = "DELETE";
		$this->_table = $tablename;
		return $this;
	}



	/**
	 * 关联查询
	 * @param string 关联表名名称
	 * @param string 关联条件
	 * @param $type string 关联类型 LEFT, RIGHT, INNER
	 */
	function join($tablename, $where, $type = ""){
		if ( $type ) {
			$type = strtoupper($type);
			if (! in_array($type, array('LEFT', 'RIGHT', 'INNER') ) )
				return $this;
		}
		$tablename = $this->_delimiter( $tablename );
		$where     = $this->escape($where);
		$this->_join .= " {$type} JOIN {$tablename} ON({$where}) ";
		return $this;
	}


	/**
	 * SQL语句字段转义
	 * @param $data
	 * @param $like
	 */
	function escape($data, $like = FALSE){
		if ( is_array($data) ){
			foreach ($data AS $key => $row){
				$data[$key] = $this->escape($row, $like);
			}
			return $data;
		}

		if ( function_exists('mysqli_real_escape_string') ) {
			$data = mysqli_real_escape_string($this->_connection, $data);
		} else {
			$data = addslashes($data);
		}

		if ( $like === TRUE ) {
			$data = str_replace(array('%', '_'), array('\\%', '\\_'), $data);
		}
		return $data;
	}

}

if ( ! function_exists('stripslashes_deep') ) {
	function stripslashes_deep($value){
		return is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
	}
}