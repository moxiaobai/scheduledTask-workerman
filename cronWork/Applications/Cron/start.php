
<?php

/**
 * 计划任务系统
 *
 * @author: moxiaobai
 * @since : 2016/4/11 11:26
 */

use Workerman\Worker;
use \Workerman\Lib\Timer;
require_once __DIR__ . '/../../Workerman/Autoloader.php';

//系统环境
define('APP_ENV',   ini_get('yaf.environ'));
define("APP_PATH",  dirname(__FILE__));

//加载类库
require_once APP_PATH . '/Library/Mysql.php';
require_once APP_PATH . '/Service/Alarm.php';
require_once APP_PATH . '/Service/Task.php';
require_once APP_PATH . '/Service/Cron.php';
require_once APP_PATH . '/Library/Mail/Send.php';

//执行任务
class Execute {

    public static  function task($data) {
        //添加定时器，返回定时器ID
        $timer_id = Timer::add($data['c_interval'], array('Cron', 'execute'), array($data));

        //更新任务定时器ID
        $task     = new Task();
        $task->updateTimer($data['c_id'], $timer_id);

        return $timer_id;
    }
}


//Worker 配置
Worker::$logFile    = APP_PATH . '/workerman.log';       //workman日志文件
Worker::$pidFile    = APP_PATH . '/workerman_cron.pid';
Worker::$stdoutFile = APP_PATH . '/stdout.log';          //输出日志

$task = new Worker('text://0.0.0.0:2015');
$task->count = 1;

//启动定时任务
$task->onWorkerStart = function($task)
{
    //读出符合条件的任务
    $task     = new Task();
    $taskList = $task->getTaskList();

    if($taskList) {
        foreach($taskList as $val) {
            Execute::task($val);
        }
    }

    //输出日志
    echo '定时任务启动: ' . date('Y-m-d H:i:s') . PHP_EOL;
};

//监听接收数据
$task->onMessage = function($connection, $data)
{

    //@todo 验证数据的完整性


    $data = trim($data);
    $data = json_decode($data, true);

    //任务ID
    $taskId = $data['id'];
    //请求类型
    $type = $data['type'];
    switch($type) {
        //添加定时器
        case 'add':
            //添加定时器
            $task     = new Task();
            $list     = $task->getTaskById($taskId);
            $timer_id = Execute::task($list);

            //发送数据
            $data = array('code'=>1, 'msg'=>'添加定时器成功');

            //输出日志
            echo "[添加定时器ID: {$timer_id}] ---- [任务ID: {$taskId}] ----[启动时间:]" .  date('Y-m-d H:i:s') . PHP_EOL;
            break;
        //删除定时器
        case 'stop':
            //定时器ID
            $timer_id = $data['c_timer_id'];

            //删除定时器
            $ret = Timer::del($timer_id);
            if($ret) {
                //删除任务
                $task   = new Task();
                $task->delTask($taskId);

                $data = array('code'=>1, 'msg'=>'删除定时器成功');
            } else {
                $data = array('code'=>201, 'msg'=>'删除定时器失败');
            }

            //输出日志
            echo "[删除定时器ID: {$timer_id}] ---- [任务ID: {$taskId}] ----[删除时间:]" .  date('Y-m-d H:i:s') . PHP_EOL;

            break;
        default:
            $data = array('code'=>500, 'msg'=>'非法请求');
            break;

    }
    return $connection->send(json_encode($data));
};

// 进程关闭时
$task->onWorkerStop = function($worker)
{
    //清空定时任务
    $task  = new Task();
    $task->clearTimer();

    //通知运维人员
    $alarm = new Alarm();
    $alarm->noticeOperational();
};

// 如果不是在根目录启动，则运行runAll方法
if(!defined('GLOBAL_START'))
{
    Worker::runAll();
}