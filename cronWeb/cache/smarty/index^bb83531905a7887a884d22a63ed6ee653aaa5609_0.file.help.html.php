<?php /* Smarty version 3.1.27, created on 2016-09-20 16:38:36
         compiled from "/mnt/outsource/timer/application/views/index/help.html" */ ?>
<?php
/*%%SmartyHeaderCode:188283025157e0f58cc55de4_82080353%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bb83531905a7887a884d22a63ed6ee653aaa5609' => 
    array (
      0 => '/mnt/outsource/timer/application/views/index/help.html',
      1 => 1474360715,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '188283025157e0f58cc55de4_82080353',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e0f58ccbbbe8_50358521',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e0f58ccbbbe8_50358521')) {
function content_57e0f58ccbbbe8_50358521 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '188283025157e0f58cc55de4_82080353';
echo $_smarty_tpl->getSubTemplate ("common/page_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<ul class="breadcrumb">
    <li><a href="/">首页</a> <span class="divider">/</span></li>
    <li><a href="/cron/addCron/">添加计划任务</a> <span class="divider">/</span></li>
    <li class="active">计划任务说明</li>
</ul>

<div class="clear"></div>

<div class="container-fluid">
    <div class="row-fluid">

        <div class="faq-content">
            <h3>常见问题</h3>
            <ol>
                <li><a href="#q1">任务添加流程</a></li>
                <li><a href="#q2">任务修改流程</a></li>
                <li><a href="#q3">任务类型</a></li>
                <li><a href="#q4">执行程序类型</a></li>
            </ol>
            <hr>

            <a href="#" class="pull-right"><i class="icon-circle-arrow-up"></i> Top</a>
            <h3 id="q1">任务添加流程</h3>
            <p> 第一步添加计划任务 <i class="icon-arrow-right"></i> 第二步启动计划任务</p>
            <p> 设置任务每天报警次数，默认每天报警5次，通过微信企业号方式发送报警消息</p>
            <p> 选择任务出错需要通知的人员</p>

            <a href="#" class="pull-right"><i class="icon-circle-arrow-up"></i> Top</a>
            <h3 id="q2">任务修改流程</h3>
            <p>第一步：停止任务；     第二步：编辑任务；  第三步：启动计划任务</p>


            <a href="#" class="pull-right"><i class="icon-circle-arrow-up"></i> Top</a>
            <h3 id="q3">任务类型</h3>
            <p><span class="label label-success">循环执行:</span> 比如一分钟执行一次，例如定时发送处理消息队列数据；</p>
            <p><span class="label label-info">每天执行一次:</span>常用就是汇总统计数据，比如每天统计销售数据</p>
            <p><span class="label label-important">只执行一次:</span>执行一次任务不再执行</p>

            <a href="#" class="pull-right"><i class="icon-circle-arrow-up"></i> Top</a>
            <h3 id="q4">执行程序类型</h3>

            <p><span class="label label-success">Curl方式:</span> 例如：http://192.168.1.4:9894/queue/sms</p>
            <p><span class="label label-info">Cli方式:</span> 执行php文件</p>
            <h4>Cli规则：</h4>
            <pre>
# Yaf Cli命令行
模型和全局类，一样调用

## 无模块情况
php request.php request_uri="/user/list/"

默认Index模块，User控制器，list方法
application\controllers\User.php

## 有模块情况
php request.php request_uri="/pay/message/list/"

Pay模块，Message控制器，list方法
application\modules\Pay\controllers\Message.php
            </pre>
            <h4>定时脚本输出格式</h4>
            <pre>
Json格式：code为1，info为信息提示
$data = array('code'=>1, 'info'=>2);
echo json_encode($data);
            </pre>
        </div>
    </div>
</div>

<?php echo '<script'; ?>
 src="/public/js/jquery-1.8.2.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/public/js/bootstrap.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/public/js/common.js"><?php echo '</script'; ?>
>

</body>
</html><?php }
}
?>