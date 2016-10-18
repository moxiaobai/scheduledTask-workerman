<?php /* Smarty version 3.1.27, created on 2016-09-23 11:36:16
         compiled from "/mnt/outsource/timer/application/views/common/page_header.html" */ ?>
<?php
/*%%SmartyHeaderCode:153132392057e4a3301051b1_56856310%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'db16e5e7d1342a1cef4a89bb51ea8e456086b31a' => 
    array (
      0 => '/mnt/outsource/timer/application/views/common/page_header.html',
      1 => 1474361990,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '153132392057e4a3301051b1_56856310',
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e4a33012d3b3_91764443',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e4a33012d3b3_91764443')) {
function content_57e4a33012d3b3_91764443 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '153132392057e4a3301051b1_56856310';
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
  	<style type="text/css">body{font-family: 微软雅黑;}</style>
    <title>计划任务系统</title>
  </head>
  <body style="padding:10px;">

<div id="navbar-example" class="navbar navbar-static">
    <div class="navbar-inner">
      <div class="container" style="width: auto;">
        <a class="brand" href="/">计划任务系统</a>

        <ul class="nav pull-right">
          <li id="fat-menu" class="dropdown">
            <a href="#" role="button" class="dropdown-toggle" data-toggle="dropdown">
                <?php echo @constant('U_REALNAME');?>

              <b class="caret"></b></a>
            <ul class="dropdown-menu" role="menu" aria-labelledby="drop3">
              <li role="presentation">
                <a role="menuitem" tabindex="-1" href="/">
                  返回主菜单
                </a>
              </li>
              <?php if (@constant('U_ROLE') == 2) {?>
              <li role="presentation">
                <a role="menuitem" tabindex="-1" href="/user/index/">
                  用户管理
                </a>
              </li>
              <?php }?>
              <li role="presentation">
                <a role="menuitem" tabindex="-1" href="/login/logout/">
                  退出登陆
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </div>
</div><?php }
}
?>