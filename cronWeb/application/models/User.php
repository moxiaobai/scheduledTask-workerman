<?php

 /**
  * 用户登陆相关
  */
 class UserModel extends BaseModel {

	 private $_db;

	 public function __construct()
	 {
		 $this->_db = $this->linkdb('timer');
	 }

	 function login($username, $password){
        $userInfo = $this->_db->select('u_id, u_username, u_realname,u_role')->from('t_user')
                    ->where('u_username',$username)
                    ->where('u_password', md5(APP_KEY . $password))
					->where('u_status', 1)
                    ->fetchOne();
        return $userInfo;
 	}

	 /**
	  * 获取列表
	  *
	  * @param array $where
	  * @param array $pagination
	  * @return bool
	  */
	 public function getList($where=array(), $pagination=array()) {
		 $data = $this->_setWhereSQL($where)
			 ->_setPaginationSQL($pagination)
			 ->_db->select('u_id,u_username,u_realname,u_status,u_role,u_addtime')
			 ->from('t_user')
			 ->order('u_id', 'DESC')
			 ->fetchAll();

		 if ( $data === FALSE ) return FALSE;
		 return $data;
	 }

	 public function getInfo($id) {
		 return $this->_db->select('u_id,u_username,u_realname,u_status')->from('t_user')->where('u_id', $id)->fetchOne();
	 }

	 /**
	  * 统计数量
	  *
	  * @param array $where
	  */
	 public function countData($where=array()) {
		 return $this->_setWhereSQL($where)->_db->select('COUNT(*)')->from('t_user')->fetchValue();
	 }

	 /**
	  * 改变状态
	  *
	  * @param $id
	  * @param array $data 修改数据
	  * @return mixed
	  */
	 public function changeData($id, $data) {
		 return $this->_db->update('t_user')->rows($data)->where('u_id', $id)->execute();
	 }

	 /**
	  * 保存数据
	  *
	  * @param array $data
	  * @param int   $id
	  * @return mixed
	  */
	 public function saveData($data, $id=0) {
		 $data['u_realname'] = Helper_Filter::format($data['u_realname'], true);

		 if ( $id > 0 ) {
			 if($this->isExistData(array('username'=>$data['u_username'], 'u_id'=>$id)) ) {
				 return $this->result(101, '登录用户名已经存在');
			 }
			 $result = $this->_db->update('t_user')->rows( $data )->where('u_id', $id)->execute();
		 } else {
			 if($this->isExistData(array('username'=>$data['u_username'])) ) {
				 return $this->result(101, '登录用户名已经存在');
			 }


			 $data['u_password'] = $this->setMd5Password($data['u_password']);
			 $data['u_addtime']  = date('Y-m-d H:i:s');
			 $result = $this->_db->insert('t_user')->rows( $data )->execute();
		 }

		 if($result) {
			 return $this->result(1, '操作成功');
		 } else {
			 return $this->result(102, '没有修改');
		 }
	 }

	 /**
	  * 修改密码
	  *
	  * @param $id
	  * @param $password
	  * @return mixed
	  */
	 public function editPassword($id, $password) {
		 $password = $this->setMd5Password($password);
		 return $this->_db->update('t_user')->set('u_password', $password)->where('u_id', $id)->execute();
	 }

	 /**
	  * 获取报警人列表
	  *
	  * @return array
	  */
	 public function getDirectorOption() {
		 $rows = $this->_db->select('u_id, u_realname')->from('t_user')->where('u_status', 1)->order('u_id', 'ASC')->fetchAll();

		 $option = array();
		 if($rows) {
			 foreach($rows as $val) {
				 $option[$val['u_id']] = $val['u_realname'];
			 }
		 }
		 return $option;
	 }

	 /**
	  * 设置密码
	  *
	  * @param $password
	  * @return string
	  */
	 private function setMd5Password($password) {
		 return md5(APP_KEY . $password);
	 }

	 /**
	  * 是否存在用户
	  *
	  * @param $username
	  * @return mixed
	  */
	 private function isExistData($where) {
		 return $this->_setWhereSQL($where)->_db->select('u_id')->from('t_user')->fetchValue();
	 }

	 /**
	  * SQL分页查询
	  */
	 private function _setPaginationSQL( $pagination = array() ) {
		 if ( isset($pagination['page']) AND isset($pagination['pagesize']) ) {
			 $page      = isset( $pagination['page'] ) ? intval($pagination['page']) : 1;
			 $pagesize  = isset( $pagination['pagesize']  ) ? intval($pagination['pagesize'])  : 10;
			 $this->_db->page($page, $pagesize);
		 } elseif ( isset($pagination['limit']) ) {
			 $this->_db->limit( intval($pagination['limit']) );
		 }
		 return $this;
	 }

	 /**
	  * SQL Where条件
	  * @param array $where
	  * @return $this
	  */
	 private function _setWhereSQL ($where = array()) {
		 if (isset($where['id']) AND $where['id']) {
			 $this->_db->where("u_id", $where['id']);
		 }

		 if (isset($where['u_id']) AND $where['u_id']) {
			 $this->_db->where("u_id != " . $where['u_id']);
		 }

		 if (isset($where['username']) AND $where['username']) {
			 $this->_db->where("u_username", $where['username']);
		 }

		 return $this;
	 }
 }