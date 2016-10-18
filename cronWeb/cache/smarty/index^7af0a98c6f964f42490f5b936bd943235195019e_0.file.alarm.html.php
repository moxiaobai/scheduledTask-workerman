<?php /* Smarty version 3.1.27, created on 2016-09-20 17:52:51
         compiled from "/mnt/outsource/timer/application/views/index/alarm.html" */ ?>
<?php
/*%%SmartyHeaderCode:69460078057e106f3f2f807_15760035%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7af0a98c6f964f42490f5b936bd943235195019e' => 
    array (
      0 => '/mnt/outsource/timer/application/views/index/alarm.html',
      1 => 1474365170,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '69460078057e106f3f2f807_15760035',
  'variables' => 
  array (
    'data' => 0,
    'row' => 0,
    'page' => 0,
    'total' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e106f4127ff9_26430311',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e106f4127ff9_26430311')) {
function content_57e106f4127ff9_26430311 ($_smarty_tpl) {
if (!is_callable('smarty_modifier_date_format')) require_once '/mnt/outsource/timer/application/library/Smarty/plugins/modifier.date_format.php';

$_smarty_tpl->properties['nocache_hash'] = '69460078057e106f3f2f807_15760035';
echo $_smarty_tpl->getSubTemplate ("common/page_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<ul class="breadcrumb">
    <li><a href="/">首页</a> <span class="divider">/</span></li>
    <li><a href="/index/addCron/">添加计划任务</a> <span class="divider">/</span></li>
    <li><a href="/index/help/">计划任务说明</a> <span class="divider">/</span></li>
</ul>
<div class="clear"></div>

<!-- 内容区域 -->
<table class="table table-striped table-condensed table-bordered table-hover">
    <thead>
    <tr>
        <th>任务ID</th>
        <th>负责人</th>
        <th>报警时间</th>
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
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['d_realname'];?>
</td>
        <td><?php echo smarty_modifier_date_format($_smarty_tpl->tpl_vars['row']->value['a_addtime'],"%Y-%m-%d %H:%M:%S");?>
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