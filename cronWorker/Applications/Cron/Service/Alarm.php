<?php

/**
 * 报警系统
 * 通知方式：企业号通知，短信通知、RTX通知、邮件通知
 *
 * @author: moxiaobai
 * @since : 2015/5/11 15:15
 */

require_once APP_PATH . '/Library/QyWeixin.php';
require_once APP_PATH . '/Library/Config.php';

class Alarm {

    private $_db;

    //通知开关
    private $_config;

    public function __construct()
    {
        $this->_db = Mysql::instance('cron');

        $this->_config = Config::get('application');
    }

    /**
     * 报警：通知程序负责人处理
     *
     * @param $uid     程序员用户ID
     * @todo 通知方式自己实现
     * @return mixed
     */
    public function noticeProgrammer($uid, $data, $alarmNumber) {
        $userInfo = $this->getUserInfo($uid);

        //报警记录日志
        $this->addAlarmLog($data, $userInfo);

        //达到报警次数，不再报警
        if($alarmNumber >= $this->countTodayAlarm($data['c_id'])) {
            $content = "定时任务出错，请尽快处理！！！\n\n";
            $content .= "任务ID:" .  $data['c_id'] . "\n";
            $content .= "名称: " . $data['c_title'] . "\n";
            $content .= "内容: " . $data['c_content'] . "\n\n";
            $content .= "报警时间：" . date('Y-m-d H:i:s');

            //企业号通知
            if($this->_config['noticeSwitch']['qyWeixin'] == 1) {
                QyWeixin::sendMessage($userInfo['u_username'], $content);
            }

            //邮箱通知
            if($this->_config['noticeSwitch']['email'] == 1) {
                $this->sendEmail($userInfo['u_email'], '定时任务系统出错，请火速处理', str_replace("\n", "<br />", $content));
            }

            //@todo 短信通知
            //@公众号消息模版
        }
    }


    /**
     * 报警：通知运维人员处理
     *
     * @todo   通知方式自己实现
     * @return mixed
     */
    public function noticeOperational() {
        $content = "定时任务系统关闭，请赶紧启动系统";

        $ini = Config::get('application', 'notice.email');
        foreach($ini as $key => $val) {
            if($this->_config['noticeEmail']['email'] == 1) {
                QyWeixin::sendMessage($key, $content);
            }

            if($this->_config['noticeEmail']['email'] == 1) {
                $this->sendEmail($val, '定时任务系统关闭', $content);
            }
        }
    }

    /**
     * 发送邮件
     *
     * @param $email
     * @param $title
     * @param $body
     */
    private function sendEmail($email, $title, $body) {
        $emailInstance = new Mail_Send('tech');
        $emailInstance->send($email, $title, $body);
    }

    /**
     * 获取程序员用户信息
     *
     * @param $id
     * @return mixed
     * @throws Exception
     */
    private function getUserInfo($id) {
        return $this->_db->select('u_id,u_username,u_realname,u_email')->from('t_user')->where('u_id', $id)->fetchOne();
    }

    /**
     * 统计当天报警次数
     *
     * @param $id
     * @return mixed
     */
    private function countTodayAlarm($id) {
        return $this->_db->select('count(*)')->from('t_alarm')->where("c_id", $id)->where("date(a_addtime) = curdate()")->fetchValue();
    }

    /**
     * 添加报警日志
     *
     * @param $data
     * @param $userInfo
     * @return mixed
     */
    private function addAlarmLog($data, $userInfo) {
        $rows = array(
            'c_id'        => $data['c_id'],
            'd_id'        => $userInfo['u_id'],
            'd_realname'  => $userInfo['u_realname'],
            'a_addtime'   => date('Y-m-d H:i:s')
        );

        return $this->_db->insert('t_alarm')->rows($rows)->execute();
    }
}