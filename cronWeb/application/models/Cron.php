<?php

/**
 * 计划任务模型
 *
 * @author: moxiaobai
 * @since : 2015/8/4 14:57
 */

class CronModel extends BaseModel {


    private $_db;

    public function __construct() {
        $this->_db    = $this->linkdb('timer');
    }

    /**
     * 获取任务列表
     *
     * @param array $where         搜索条件
     * @param array $pagination    分页
     * @return mixed
     */
    public function getCronList($where=array(), $pagination=array()) {
        $row = $this->_setWhereSQL($where)
            ->_setPaginationSQL($pagination)
            ->_db->select('c_id,d_id,c_title,c_type,c_content,c_interval,c_start_time,c_end_time,c_execute_time,c_persistent,c_run_time,c_stop_time,c_status,c_state,c_update_time,c_addtime')
            ->from('t_cron')
            ->order( 'c_id', 'DESC')
            ->fetchAll();

        if($row === FALSE) {
            return FALSE;
        }

        return $row;

    }

    /**
     * 统计任务数量
     * @param $condition
     * @return mixed
     */
    public function countCron($condition) {
        return $this->_setWhereSQL( $condition )->_db->select('COUNT(*)')->from('t_cron')->fetchValue();
    }

    /**
     * 根据任务ID获取任务信息
     * @param $id
     * @return mixed
     */
    public function getCronById($id) {
        return $this->_db->select("c_id,c_title,c_type,c_content,c_interval,c_start_time,c_end_time,c_execute_time,c_persistent,c_status,c_state,c_alarm,d_id")->from('t_cron')->where('c_id', $id)->fetchOne();
    }

    /**
     * 根据任务ID获取定时器ID
     * @param $id
     * @return mixed
     */
    public function getTimerIdById($id) {
        return $this->_db->select("c_timer_id")->from('t_cron')->where('c_id', $id)->where('c_state', 2)->fetchValue();
    }

    /**
     * 保存任务信息
     *
     * @param $data
     * @param int $id
     * @return mixed
     */
    public function saveCron($data, $id=0){
        if ( $id > 0 ) {
            $data['c_update_time'] = date('Y-m-d H:i:s');
            return $this->_db->update('t_cron')->rows($data)->where('c_id', $id)->execute();
        } else {
            $data['c_addtime'] = date('Y-m-d H:i:s');
            return $this->_db->insert('t_cron')->rows($data)->execute();
        }
    }

    /**
     * 更改状态
     *
     * @param $id     任务ID
     * @return mixed
     */
    public function deleteCron($id, $status) {
        $status = ($status == 2) ? 1 : 2;
        return $this->_db->update('t_cron')->rows(array('c_status'=>$status))->where('c_id', $id)->execute();
    }

    /**
     * 报警日志
     *
     * @param integer   $taskId   任务ID
     * @param array     $page     分页
     * @return array
     */
    public function getAlarmList($taskId, $uid, $pagination=array()) {
        if($taskId != 0) {
            $this->_db->where('c_id', $taskId);
        }

        if($uid != 0) {
            $this->_db->where('d_id', $uid);
        }

        $row = $this->_setPaginationSQL($pagination)
                    ->_db->select('c_id,d_id,d_realname,a_addtime')
                    ->from('t_alarm')
                    ->where('c_id', $taskId)
                    ->order( 'a_id', 'DESC')
                    ->fetchAll();

        if($row === FALSE) {
            return FALSE;
        }

        return $row;
    }

    public function countAlarm($taskId, $uid) {
        if($taskId != 0) {
            $this->_db->where('c_id', $taskId);
        }

        if($uid != 0) {
            $this->_db->where('d_id', $uid);
        }
        return $this->_db->select('COUNT(*)')->from('t_alarm')->fetchValue();
    }

    /**
     * 任务日志
     *
     * @param integer   $taskId   任务ID
     * @param integer   $uid      用户ID
     * @param array     $page     分页
     * @return array
     */
    public function getLogList($taskId, $pagination=array()) {
        $table = $this->getLogTable($taskId);

        $row = $this->_setPaginationSQL($pagination)
            ->_db->select('c_id,cl_status,cl_result,cl_consume_time,cl_consume_memory,cl_datetime')
            ->from($table)
            ->where('c_id', $taskId)
            ->order( 'cl_id', 'DESC')
            ->fetchAll();

        if($row === FALSE) {
            return FALSE;
        }

        return $row;
    }

    public function countLog($taskId) {
        $table = $this->getLogTable($taskId);
        return $this->_db->select('COUNT(*)')->where('c_id', $taskId)->from($table)->fetchValue();
    }

    /**
     * 获取日志表
     * @param $taskId
     * @return string
     */
    private function getLogTable($taskId) {
        $prefix = Helper_Dbsuf::getDbSuf($taskId, 36);

        return "t_cron_log_{$prefix}";
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
     * @param array $condition
     * @return $this
     */
    private function _setWhereSQL ($condition = array()) {
        if (isset($condition['title']) AND $condition['title']) {
            $this->_db->where("c_title LIKE '%{$condition['title']}%'");
        }

        if (isset($condition['content']) AND $condition['content']) {
            $this->_db->where("c_content", $condition['content']);
        }

        if (isset($condition['status']) AND $condition['status']) {
            $this->_db->where("c_status", $condition['status']);
        }

        if (isset($condition['state']) AND $condition['state']) {
            $this->_db->where("c_state", $condition['state']);
        }

        if (isset($condition['id']) AND $condition['id']) {
            $this->_db->where("c_id", $condition['id']);
        }

        if (isset($condition['did']) AND $condition['did']) {
            $this->_db->where("d_id", $condition['did']);
        }

        return $this;
    }



}