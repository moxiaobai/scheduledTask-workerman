<?php
/**
 * 文件说明
 *
 * @author: moxiaobai
 * @since : 2016/4/12 16:12
 */

//系统环境
define("APP_PATH",  dirname(__FILE__));

$iniFile = APP_PATH . "/Config/application.ini";
$ini_array = parse_ini_file($iniFile, true);


print_r($ini_array);

//发送通知
//$alarm = new Alarm();
//
//$data = array('c_id'=>1, 'c_title'=>'定时发送邮件', 'c_content'=>'http://www.baidu.com');
//$alarm->noticeProgrammer(1, $data);

//$task = new Task();
//var_dump($task->getTaskList());

//添加定时器
//$data   = array('type'=>'add', 'list'=>array('c_id'=>5, 'c_title'=>'小钢炮', 'c_type'=>1, 'c_content'=>'http://www.qq.com', 'c_interval'=>10, 'c_persistent'=>1));
//
////$data = array('type'=>'stop', 'list'=>array('c_id'=>3, 'c_timer_id'=>3));
//$buffer = json_encode($data) . "\n";
//
//// 与服务端建立socket连接
//$client = stream_socket_client('tcp://127.0.0.1:2015');
//// 以text协议发送buffer1数据
//fwrite($client, $buffer);
//
//$ret = fgets($client);
//var_dump(json_decode($ret, true));


//$file = '/mnt/study/Applications/Cron/unit.php';
//$ret = exec("php {$file}");
//print_r(json_decode($ret, true));

//$env = APP_ENV;
//echo Yaconf::get("app.{$env}.cli.directory");

//echo strtotime("+7 minutes");

//$executeTime = 1460607966;
//$persistent = 2;
//
//if(($persistent == 2 || $persistent == 3)) {
//    if(date('Y-m-d H:i') != date('Y-m-d H:i', $executeTime)) {
//        echo 1;
//    } else {
//        echo 2;
//    }
//}

