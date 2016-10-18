<?php

/**
 * 计划任务类
 *
 * @author: moxiaobai
 * @since : 2015/5/6 18:17
 */


class Task {

    private $_db;

    public function __construct()
    {
        $this->_db = Mysql::instance('cron');
    }

    /**
     * 获取符合条件的任务列表
     */
    public  function getTaskList() {
        $now = time();

        $rows =  $this->_db->select('c_id,c_title,c_type,c_content,c_interval,c_start_time,c_end_time,c_execute_time,d_id,c_persistent,c_alarm,c_timer_id')
                        ->from('t_cron')
                        ->where("c_status = 1")
                        ->where("'{$now}' <= c_end_time")
                        ->order('c_id', 'ASC')
                        ->fetchAll();

        if($rows == FALSE) {return FALSE;}
        return $rows;
    }

    /**
     * 根据任务ID获取任务信息
     *
     * @param $id
     * @return mixed
     */
    public function getTaskById($id) {
        return $this->_db->select('c_id,c_title,c_type,c_content,c_interval,c_start_time,c_end_time,c_execute_time,d_id,c_persistent,c_alarm,c_timer_id')
                        ->from('t_cron')
                        ->where("c_status = 1")
                        ->where("c_id", $id)
                        ->fetchOne();
    }

    /**
     * 更新任务定时器
     *
     * @param $taskId   任务ID
     * @param $timerId  定时器ID
     */
    public  function updateTimer($taskId, $timerId) {
        $data = array(
            'c_run_time'  => date('Y-m-d H:i:s'),
            'c_timer_id'  => $timerId,
            'c_state'     => 2
        );
        return $this->_db->update('t_cron')->where('c_id', $taskId)->rows($data)->execute();
    }

    /**
     * worker停止，清除所有定时器
     */
    public  function clearTimer() {
        $data = array(
            'c_stop_time' => date('Y-m-d H:i:s'),
            'c_timer_id'  => 0,
            'c_state'     => 1
        );
        return $this->_db->update('t_cron')->rows($data)->where('c_state', 2)->execute();
    }

    /**
     * 删除任务
     *
     * @param $taskId 任务ID
     * @return mixed
     * @throws Exception
     */
    public function delTask($taskId) {
        $data = array(
            'c_stop_time' => date('Y-m-d H:i:s'),
            'c_timer_id'  => 0,
            'c_state'     => 1
        );

        return $this->_db->update('t_cron')->where('c_id', $taskId)->rows($data)->execute();
    }
}