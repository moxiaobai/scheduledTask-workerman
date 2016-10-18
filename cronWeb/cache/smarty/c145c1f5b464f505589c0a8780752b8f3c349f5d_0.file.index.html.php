<?php /* Smarty version 3.1.27, created on 2016-09-20 17:52:53
         compiled from "/mnt/outsource/timer/application/views/index/index.html" */ ?>
<?php
/*%%SmartyHeaderCode:81330911557e106f592ffa7_99245216%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c145c1f5b464f505589c0a8780752b8f3c349f5d' => 
    array (
      0 => '/mnt/outsource/timer/application/views/index/index.html',
      1 => 1474365134,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '81330911557e106f592ffa7_99245216',
  'variables' => 
  array (
    'id' => 0,
    'title' => 0,
    'content' => 0,
    'director' => 0,
    'status' => 0,
    'state' => 0,
    'data' => 0,
    'row' => 0,
    'page' => 0,
    'total' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e106f5c4ad69_75022854',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e106f5c4ad69_75022854')) {
function content_57e106f5c4ad69_75022854 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/mnt/outsource/timer/application/library/Smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '81330911557e106f592ffa7_99245216';
echo $_smarty_tpl->getSubTemplate ("common/page_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<p class="lead" style="padding-left:15px;">
    当前操作用户:<?php echo @constant('U_REALNAME');?>

</p>

<ul class="breadcrumb">
    <li><a href="/">首页</a> <span class="divider">/</span></li>
    <li><a href="/index/addCron/">添加计划任务</a> <span class="divider">/</span></li>
    <li><a href="/index/help/">计划任务说明</a> <span class="divider">/</span></li>
</ul>

<!-- 搜索区域 -->
<form class="form-inline pull-left" action="/index/">
    <div class="form-group">
        <input type="text"  name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" class="input-small form-control" placeholder="任务ID">
        <input type="text" name="title" value="<?php echo $_smarty_tpl->tpl_vars['title']->value;?>
" class="input-big form-control" placeholder="任务标题">
        <input type="text" name="content" value="<?php echo $_smarty_tpl->tpl_vars['content']->value;?>
" class="input-big form-control" placeholder="任务内容">
        <?php echo $_smarty_tpl->tpl_vars['director']->value;?>

        <?php echo $_smarty_tpl->tpl_vars['status']->value;?>

        <?php echo $_smarty_tpl->tpl_vars['state']->value;?>

        <button type="submit" class="btn">搜索</button>
    </div>
</form>

<div class="clear10"></div>

<!-- 内容区域 -->
<table class="table table-striped table-condensed table-bordered table-hover">
    <thead>
    <tr>
        <th>ID</th>
        <th>任务标题</th>
        <th>任务类型</th>
        <th>执行程序</th>
        <th>任务时间</th>
        <th>运行状态</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    </thead>
    <tbody>
    <?php if ($_smarty_tpl->tpl_vars['data']->value) {?>
    <?php
$_from = $_smarty_tpl->tpl_vars['data']->value;
if (!is_array($_from) && !is_object($_from)) {
settype($_from, 'array');
}
$_smarty_tpl->tpl_vars['row'] = new Smarty_Variable;
$_smarty_tpl->tpl_vars['row']->_loop = false;
foreach ($_from as $_smarty_tpl->tpl_vars['row']->value) {
$_smarty_tpl->tpl_vars['row']->_loop = true;
$foreach_row_Sav = $_smarty_tpl->tpl_vars['row'];
?>
    <tr>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['c_id'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['c_title'];?>
</td>
        <td>
            <?php if ($_smarty_tpl->tpl_vars['row']->value['c_persistent'] == 1) {?><span class="label label-success">循环执行</span><br />
            开始时间: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['c_start_time'],"%Y-%m-%d %H:%M:%S");?>
 - 结束时间: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['c_end_time'],"%Y-%m-%d %H:%M:%S");?>
<br />
            间隔执行时间: <?php echo $_smarty_tpl->tpl_vars['row']->value['c_interval']/60;?>
（分钟）
            <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['c_persistent'] == 2) {?>
            <span class="label label-info">每天执行一次</span><br />
            每天执行时间：<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['c_execute_time'],"%H:%M");?>
<br />
            开始时间: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['c_start_time'],"%Y-%m-%d %H:%M:%S");?>
 - 结束时间: <?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['c_end_time'],"%Y-%m-%d %H:%M:%S");?>
<br />
            <?php } else { ?>
            <span class="label label-important">只执行一次</span><br />
            任务执行时间：<?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['c_execute_time'],"%Y-%m-%d %H:%M");?>

            <?php }?>
        </td>
        <td>
            <?php if ($_smarty_tpl->tpl_vars['row']->value['c_type'] == 1) {?><span class="badge badge-success">Curl</span><?php } else { ?><span class="badge badge-info">Cli</span><?php }?><br />
            <?php echo $_smarty_tpl->tpl_vars['row']->value['c_content'];?>

        </td>
        <td>
            <span class="label label-success">启动:</span><?php echo $_smarty_tpl->tpl_vars['row']->value['c_run_time'];?>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-important">停止:</span><?php echo $_smarty_tpl->tpl_vars['row']->value['c_stop_time'];?>
<br />
            <span class="label label-info">添加:</span><?php echo $_smarty_tpl->tpl_vars['row']->value['c_addtime'];?>
&nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-warning">编辑:</span><?php echo $_smarty_tpl->tpl_vars['row']->value['c_update_time'];?>
<br />
        </td>
        <td>
            <?php if ($_smarty_tpl->tpl_vars['row']->value['c_state'] == 2) {?>
            <span class="label label-success">正常运行</span>
            <?php } else { ?>
            <span class="label label-warning">未运行</span>
            <?php }?>
        </td>
        <td>
            <?php if ($_smarty_tpl->tpl_vars['row']->value['c_status'] == 1) {?>
            <span class="label label-success">正常</span>
            <?php } else { ?>
            <span class="label label-warning">停用</span>
            <?php }?>
        </td>
        <td>
            <?php if ($_smarty_tpl->tpl_vars['row']->value['c_state'] == 1) {?>
            <a data-href="/index/startCron/?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['c_id'];?>
" data-json="确认要启动该任务吗？" title="启动任务"><i class="icon-play-circle"></i>启动 </a>&nbsp;
            <a href="/index/addCron/?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['c_id'];?>
" title="编辑任务"><i class="icon-edit"></i>编辑</a>&nbsp;
            <?php } else { ?>
            <a data-href="/index/stopCron/?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['c_id'];?>
" data-json="确认要停止该任务吗？" title="停止任务"><i class="icon-off"></i>暂停</a>&nbsp;
            <?php }?>
            <a href="/index/log/?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['c_id'];?>
"  title="任务日志"><i class="icon-th-list"></i>任务日志</a>&nbsp;
            <a href="/index/alarm/?id=<?php echo $_smarty_tpl->tpl_vars['row']->value['c_id'];?>
"  title="任务日志"><i class="icon-bullhorn"></i>报警日志</a>
            <!--<a href="/system/cron/trash/id/<?php echo $_smarty_tpl->tpl_vars['row']->value['s_id'];?>
"  title="移除任务"><i class="icon-trash"></i>移除</a>-->
        </td>
    </tr>
    <?php
$_smarty_tpl->tpl_vars['row'] = $foreach_row_Sav;
}
?>
    <?php }?>
    </tbody>
</table>

<div class="pagination pagination-small">
    <ul class="pull-right"><?php echo $_smarty_tpl->tpl_vars['page']->value;?>
<a class="current">总记录：<?php echo $_smarty_tpl->tpl_vars['total']->value;?>
</a></ul>
    <div class="clear"></div>
</div>
<?php echo '<script'; ?>
>
    $('.pagination ul a').each( function() {
        $(this).hasClass('current') ? $(this).wrap('<li class="disabled" />') : $(this).wrap('<li />');
    });
<?php echo '</script'; ?>
>

</body>
</html><?php }
}
?>