<?php

/**
 * 计划任务系统
 *
 * @author: moxiaobai
 * @since : 2016/8/4 14:54
 */

class IndexController extends Yaf_Controller_Abstract
{

    private $_cronModel;
    private $_pageSize = 8;

    private $_state   = array(1=>'未运行', 2=>'运行');
    private $_status  = array(1=>'正常', 2=>'禁用');
    private $_type    = array(1=>'Curl', 2=>'Cli');

    public function init()
    {
        $this->_cronModel = new CronModel();
    }

    /**
     * 首页
     */
    public function indexAction()
    {
        $page     = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $id       = isset($_GET['id']) ? $_GET['id'] : '';
        $title    = isset($_GET['title']) ? $_GET['title'] : '';
        $content  = isset($_GET['content']) ? $_GET['content'] : '';
        $did      = isset($_GET['did']) ? intval($_GET['did']) : '';
        $state    = isset($_GET['state']) ? intval($_GET['state']) : '';
        $status   = isset($_GET['status']) ? intval($_GET['status']) : '';


        $where = array('id'=>$id, 'title' => $title, 'did'=>$did, 'state'=>$state, 'status'=>$status, 'content'=>$content);
        $pagination = array('page'=> $page, 'pagesize'=> $this->_pageSize);
        $data       = $this->_cronModel->getCronList($where, $pagination);
        $total      = $this->_cronModel->countCron($where);

        $baseUrl  = "/index/?id={$id}&title={$title}&content={$content}&did={$did}&state={$state}&status={$status}&page={$page}";
        $page     = new Page(array('total'=>$total, 'perpage'=>$this->_pageSize, 'url'=>$baseUrl, 'nowindex'=>$page));
        $pagecode = $page->show(4);

        //任务负责人
        $director = UserModel::getInstance()->getDirectorOption();

        $this->getView()->assign(array(
            'page'           => $pagecode,
            'id'             => $id,
            'title'          => $title,
            'content'        => $content,
            'director'       => $director,
            'directorOption' => Helper_Form::select('did', $director, $did, '请选择任务负责人'),
            'state'          => Helper_Form::select('state', $this->_state, $state, '请选择运行状态'),
            'status'         => Helper_Form::select('status', $this->_status, $state, '请选择任务状态'),
            'data'           => $data,
            'total'          => $total,
        ));
    }

    //帮助说明
    public function helpAction() {}

    //添加任务
    public function addCronAction() {
        $id   = isset($_GET['id']) ? intval($_GET['id']) : 0;

        //通知人员列表
        $userList = UserModel::getInstance()->getDirectorOption();

        if ( $id > 0 ) {
            $row = $this->_cronModel->getCronById($id);

            $row['c_start_time'] = date('Y-m-d H:i', $row['c_start_time']);
            $row['c_end_time']    = date('Y-m-d H:i', $row['c_end_time']);

            if($row['c_persistent'] == 3) {
                $row['c_execute_time'] = date('Y-m-d H:i', $row['c_execute_time']);
            } else {
                $row['c_execute_time'] = date('H:i', $row['c_execute_time']);
            }


            $noticeUser = Helper_Form::option($userList, intval($row['d_id']) );
            $type       = Helper_Form::option($this->_type, intval($row['c_type']) );
            $status     = Helper_Form::option($this->_status, intval($row['c_status']));
        } else {
            $row = array(
                'c_id'      => '',
                'c_title'   => '',
                'c_content' => '',
                'c_persistent' => '',
                'c_start_time' => date('Y-m-d H:i'),
                'c_end_time'   => '',
                'c_interval'   => 2,
                'c_alarm'      => 10,
            );
            $noticeUser = Helper_Form::option($userList, '', '请选择报警通知人员');
            $type       = Helper_Form::option($this->_type, '', '请选择任务类型');
            $status     = Helper_Form::option($this->_status, '', '请选择任务状态');
        }

        $this->getView()->assign('row', $row);
        $this->getView()->assign('noticeUser', $noticeUser);
        $this->getView()->assign('type', $type);
        $this->getView()->assign('status', $status);
    }

    //保存任务
    public function saveCronAction() {
        $id         = intval($_POST['id']);
        $title      = $_POST['title'];
        $type       = $_POST['type'];
        $status     = $_POST['status'];
        $uid        = intval($_POST['uid']);
        $content    = $_POST['url'];
        $persistent = intval($_POST['persistent']);
        $alarm      = intval($_POST['alarm']);
        $interval   = isset($_POST['interval']) ? intval($_POST['interval']) : '';
        $executeTime     = isset($_POST['executeTime']) ? $_POST['executeTime'] : '';
        $executeDateTime = isset($_POST['executeDateTime']) ? $_POST['executeDateTime'] : '';

        if(!$alarm) {
            Helper_Json::formJson('请填写任务每天报警次数');
        }

        if($alarm < 10) {
            Helper_Json::formJson('每天报警次数必须大于10次');
        }

        $data = array();
        $data['c_id']          = $id;
        $data['c_title']       = $title;
        $data['c_type']        = $type;
        $data['c_content']     = $content;
        $data['c_persistent']  = $persistent;
        $data['d_id']          = $uid;
        $data['c_alarm']       = $alarm;
        $data['c_status']      = $status;

        switch($persistent) {
            case 1:
                if(!$interval || $interval == 0) {
                    Helper_Json::formJson('请填写任务执行间隔时间');
                }

                $startTimeOne  = $_POST['startTimeOne'];
                $endTimeOne    = $_POST['endTimeOne'];

                if(!$startTimeOne) {
                    Helper_Json::formJson('请填写任务开始时间');
                }

                if(!$endTimeOne) {
                    Helper_Json::formJson('请填写任务结束时间');
                }

                if($startTimeOne > $endTimeOne) {
                    Helper_Json::formJson('任务执行开始时间不能大于任务结束时间!');
                }

                $data['c_interval']    = $interval;
                $data['c_start_time']  = strtotime($startTimeOne);
                $data['c_end_time']    = strtotime($endTimeOne);
                break;
            case 2:
                if(!$executeTime) {
                    Helper_Json::formJson('请填写任务执行时间');
                }

                $startTimeTwo  = $_POST['startTimeTwo'];
                $endTimeTwo    = $_POST['endTimeTwo'];

                if(!$startTimeTwo) {
                    Helper_Json::formJson('请填写任务开始时间');
                }

                if(!$endTimeTwo) {
                    Helper_Json::formJson('请填写任务结束时间');
                }

                if($startTimeTwo > $endTimeTwo) {
                    Helper_Json::formJson('任务执行开始时间不能大于任务结束时间!');
                }

                $data['c_interval']    = 60;
                $data['c_start_time']  = strtotime($startTimeTwo);
                $data['c_end_time']    = strtotime($endTimeTwo);
                $data['c_execute_time'] = strtotime(date("Y-m-d {$executeTime}"));
                break;
            case 3:
                if(!$executeDateTime) {
                    Helper_Json::formJson('请填写任务执行时间');
                }

                if($executeDateTime < date("Y-m-d H:i")) {
                    Helper_Json::formJson('任务执行时间不能小于当前时间');
                }

                $data['c_interval']   = 60;
                $data['c_start_time'] = strtotime("-5 minutes", strtotime($executeDateTime));
                $data['c_end_time']   = strtotime("+5 minutes", strtotime($executeDateTime));
                $data['c_execute_time'] = strtotime($executeDateTime);
                break;
        }

        if ( $id > 0) {
            $this->_cronModel->saveCron($data, $id);
            Helper_Json::formJson('编辑任务成功。', 'y');
        } else {
            $result = $this->_cronModel->saveCron($data);
            if($result) {
                Helper_Json::formJson('新增任务成功', 'y');
            } else {
                Helper_Json::formJson('新增任务失败!');
            }

        }
    }

    //启动任务
    public function startCronAction() {
        $id   = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if($id == 0) {
            Helper_Json::formJson('任务ID为空');
        }

        //任务当前情况
        $info = $this->_cronModel->getCronById($id);
        if(!$info) {
            Helper_Json::formJson('任务不存在');
        }

        if($info['c_status'] == 2) {
            Helper_Json::formJson('任务被禁用');
        }

        if($info['c_state'] == 2) {
            Helper_Json::formJson('任务已经在运行');
        }

        if(time() > $info['c_end_time']) {
            Helper_Json::formJson('任务结束时间小于当前时间');
        }

        $data = array('type'=>'add', 'id'=>$id);
        $ret = $this->cronSocketServer($data);

        if($ret['code'] == 1) {
            Helper_Json::formJson($ret['msg'], 'y');
        } else {
            Helper_Json::formJson($ret['msg']);
        }
    }

    //停止任务
    public function stopCronAction() {
        $id   = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if($id == 0) {
            Helper_Json::formJson('任务ID为空');
        }

        $timerId = $this->_cronModel->getTimerIdById($id);
        if(!$timerId) {
            Helper_Json::formJson('任务已经停止或者不存在');
        }

        $data = array('type'=>'stop', 'id'=>$id, 'c_timer_id'=>$timerId);
        $ret = $this->cronSocketServer($data);

        if($ret['code'] == 1) {
            Helper_Json::formJson($ret['msg'], 'y');
        } else {
            Helper_Json::formJson($ret['msg']);
        }
    }

    //服务器建立连接
    private function cronSocketServer($data) {
        $buffer = json_encode($data) . "\n";

        // 与服务端建立socket连接
        try {
            $client = stream_socket_client(SERVER_HOST, $errno, $errstr, 30);
        } catch(Exception $e) {
            return array('code'=>101, 'msg'=>'与服务器通讯失败');
        }

        // 以text协议发送buffer1数据
        fwrite($client, $buffer);

        $ret = fgets($client);
        fclose($client);
        return json_decode($ret, true);
    }

    //任务日志
    public function logAction() {
        $id   = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;

        if($id == 0) {
            Helper_Json::formJson('任务ID为空');
        }

        $pageSize   = 20;
        $pagination = array('page'=> $page, 'pagesize'=> $pageSize);
        $logData = $this->_cronModel->getLogList($id, $pagination);

        $total      = $this->_cronModel->countLog($id);
        $baseUrl  = "/index/log/?id={$id}&page={$page}";
        $page     = new Page(array('total'=>$total, 'perpage'=>$pageSize, 'url'=>$baseUrl, 'nowindex'=>$page));
        $pagecode = $page->show(4);

        $this->getView()->assign(array(
            'page'          => $pagecode,
            'data'          => $logData,
            'total'         => $total
        ));
    }

    //报警日志
    public function alarmAction() {
        $id   = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $did  = isset($_GET['did']) ? intval($_GET['did']) : 0;
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;


        $pageSize   = 20;
        $pagination = array('page'=> $page, 'pagesize'=> $pageSize);
        $total      = $this->_cronModel->countAlarm($id,$did);

        $baseUrl  = "/index/alarm/?id={$id}&page={$page}";
        $page     = new Page(array('total'=>$total, 'perpage'=> $pageSize, 'url'=>$baseUrl, 'nowindex'=>$page));
        $pagecode = $page->show(4);

        $logData = $this->_cronModel->getAlarmList($id,$did, $pagination);

        $this->getView()->assign(array(
            'page'          => $pagecode,
            'data'          => $logData,
            'total'         => $total
        ));
    }

}