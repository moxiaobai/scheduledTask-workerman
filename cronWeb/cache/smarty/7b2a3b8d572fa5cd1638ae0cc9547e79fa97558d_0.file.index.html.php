<?php /* Smarty version 3.1.27, created on 2016-09-20 16:13:51
         compiled from "/mnt/outsource/timer/application/views/login/index.html" */ ?>
<?php
/*%%SmartyHeaderCode:46911860957e0efbfad77c1_56069390%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b2a3b8d572fa5cd1638ae0cc9547e79fa97558d' => 
    array (
      0 => '/mnt/outsource/timer/application/views/login/index.html',
      1 => 1474359230,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '46911860957e0efbfad77c1_56069390',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e0efbfb1de99_47577775',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e0efbfb1de99_47577775')) {
function content_57e0efbfb1de99_47577775 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '46911860957e0efbfad77c1_56069390';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="/public/tree/bootstrap.css" rel="stylesheet">
    <link href="/public/tree/bootstrap-responsive.css" rel="stylesheet">
    <link href="/public/tree/base.css" rel="stylesheet">
    <?php echo '<script'; ?>
 src="/public/tree/jquery.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/public/tree/bootstrap.min.js"><?php echo '</script'; ?>
>
    <title>站点同步工具</title>
</head>
<body style="padding:10px;">

<div style="width:460px;margin:auto;padding-top:200px;">
    <div class="well">
        <form class="form-horizontal" onsubmit="return login();">
            <legend>计划任务系统</legend>
            <div class="control-group">
                <label class="control-label">帐号</label>
                <div class="controls">
                    <input type="text" id="username" name="username" placeholder="后台管理账号">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="Password">密码</label>
                <div class="controls">
                    <input type="password" id="password" name="password" placeholder="后台管理密码">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn">登录</button>
                </div>
            </div>
            <div>
            </div>
        </form>
    </div>
</div>
<?php echo '<script'; ?>
 type="text/javascript">

    function login() {
        var username = $('#username').val();
        var password = $('#password').val();

        if(! username) {
            alert('请输入用户名');
            return false;
        }

        if(! password) {
            alert('请输入密码');
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/login/ajax",
            data: {user:username, pwd: password},
            async: true,
            success: function(json) {
                if(json.code == -1) {
                    alert(json.data);
                } else if (json.code == 1) {
                    window.location = '/';
                }
            },
            dataType: "json"
        });

        return false;
    }
<?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
?>