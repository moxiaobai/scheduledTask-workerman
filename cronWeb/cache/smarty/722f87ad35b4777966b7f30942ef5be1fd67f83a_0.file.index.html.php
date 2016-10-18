<?php /* Smarty version 3.1.27, created on 2016-09-26 16:11:08
         compiled from "/mnt/outsource/timer/cronWeb/application/views/login/index.html" */ ?>
<?php
/*%%SmartyHeaderCode:144664023257e8d81c296af4_50162873%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '722f87ad35b4777966b7f30942ef5be1fd67f83a' => 
    array (
      0 => '/mnt/outsource/timer/cronWeb/application/views/login/index.html',
      1 => 1474877466,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '144664023257e8d81c296af4_50162873',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e8d81c2ee6f6_86441755',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e8d81c2ee6f6_86441755')) {
function content_57e8d81c2ee6f6_86441755 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '144664023257e8d81c296af4_50162873';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <link href="/public/tree/bootstrap.css" rel="stylesheet">
    <link href="/public/tree/bootstrap-responsive.css" rel="stylesheet">
    <link href="/public/tree/base.css" rel="stylesheet">
    <link href="/public/tree/sweet-alert.css" rel="stylesheet">
    <?php echo '<script'; ?>
 src="/public/tree/jquery.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/public/tree/bootstrap.min.js"><?php echo '</script'; ?>
>
    <?php echo '<script'; ?>
 src="/public/tree/sweet-alert.min.js"><?php echo '</script'; ?>
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
            swal({   title: "请输入用户名",timer: 2000 });
            return false;
        }

        if(! password) {
            swal({   title: "请输入密码",timer: 2000 });
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/login/ajax",
            data: {user:username, pwd: password},
            async: true,
            success: function(json) {
                if(json.code == -1) {
                    swal({   title: json.data,timer: 2000 });
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