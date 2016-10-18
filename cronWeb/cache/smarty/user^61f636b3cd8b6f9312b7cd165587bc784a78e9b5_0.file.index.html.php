<?php /* Smarty version 3.1.27, created on 2016-09-23 11:36:15
         compiled from "/mnt/outsource/timer/application/views/user/index.html" */ ?>
<?php
/*%%SmartyHeaderCode:193788497457e4a32fe66170_85681600%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '61f636b3cd8b6f9312b7cd165587bc784a78e9b5' => 
    array (
      0 => '/mnt/outsource/timer/application/views/user/index.html',
      1 => 1474274301,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '193788497457e4a32fe66170_85681600',
  'variables' => 
  array (
    'username' => 0,
    'data' => 0,
    'row' => 0,
    'pageHtml' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e4a3300ee604_57216773',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e4a3300ee604_57216773')) {
function content_57e4a3300ee604_57216773 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '193788497457e4a32fe66170_85681600';
echo $_smarty_tpl->getSubTemplate ("common/page_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>


<p class="lead" style="padding-left:15px;">
    当前操作用户:<?php echo @constant('U_REALNAME');?>

</p>

<!--搜索区域-->
<form class="form-inline pull-left">
    <div class="form-group">
        <input type="text" name="username" value="<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
" class="form-control" placeholder="用户名">
        <button type="submit" class="btn btn-default">搜索</button>
    </div>
</form>
<button type="button" class="btn btn-default pull-right" onclick="window.location.reload();">刷新界面</button>
<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#adminModal" href="/user/form/">添加管理员</button>

<div class="clear10"></div>

<!-- 表格 -->
<table class="table table-bordered table-striped">
    <tr>
        <td>用户名</td>
        <td>真实姓名</td>
        <td>角色</td>
        <td>状态</td>
        <?php if (@constant('U_ROLE') == 2) {?><td>修改密码</td><?php }?>
        <td>添加时间</td>
        <td>操作</td>
    </tr>
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
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['u_username'];?>
</td>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['u_realname'];?>
</td>
        <td><?php if ($_smarty_tpl->tpl_vars['row']->value['u_role'] == 2) {?><span class="label label-important"><?php if ($_smarty_tpl->tpl_vars['row']->value['u_id'] == @constant('UID')) {?>当前<?php }?>系统管理员</span><?php } else { ?><span class="label label-info">普通管理员</span><?php }?></td>
        <td>
            <a href="#" data-json="确认要更改状态吗？" data-href="/user/status/id/<?php echo $_smarty_tpl->tpl_vars['row']->value['u_id'];?>
/status/<?php echo $_smarty_tpl->tpl_vars['row']->value['u_status'];?>
">
                <i class="<?php if ($_smarty_tpl->tpl_vars['row']->value['u_status'] == 1) {?>icon-eye-open<?php } else { ?>icon-eye-close<?php }?>" title="<?php if ($_smarty_tpl->tpl_vars['row']->value['u_status'] == 2) {?>禁用<?php } else { ?>正常<?php }?>"></i>
                <?php if ($_smarty_tpl->tpl_vars['row']->value['u_status'] == 1) {?><span class="label label-success">正常</span><?php } else { ?><span class="label label-warning">禁用</span><?php }?>
            </a>
        </td>
        <?php if (@constant('U_ROLE') == 2) {?>
        <td>
            <a data-toggle="modal" href="/user/formPassword/id/<?php echo $_smarty_tpl->tpl_vars['row']->value['u_id'];?>
" data-target="#formPasswordModal" title="修改密码"><i class="icon-lock"></i></a>
        </td>
        <?php }?>
        <td><?php echo $_smarty_tpl->tpl_vars['row']->value['u_addtime'];?>
</td>
        <td>
            <a class="icon-cog" data-toggle="modal" data-target="#adminModal" href="/user/form/id/<?php echo $_smarty_tpl->tpl_vars['row']->value['u_id'];?>
" title="编辑用户"></a>&nbsp;&nbsp;
        </td>
    </tr>
    <?php
$_smarty_tpl->tpl_vars['row'] = $foreach_row_Sav;
}
?>
    <?php }?>
</table>

<!-- 分页 -->
<?php if ($_smarty_tpl->tpl_vars['data']->value) {?>
<div class="pagination pagination-right">
    <ul><?php echo $_smarty_tpl->tpl_vars['pageHtml']->value;?>
</ul>
</div>
<?php }?>
</div>

<!--弹窗-->
<form class="form-horizontal" action="/user/save/" method="post">
    <div class="modal fade" id="adminModal" tabindex="-1" role="dialog"></div>
</form>

<form class="form-horizontal" method="post" action="/user/editPassword/" >
    <div class="modal fade" id="formPasswordModal" tabindex="-1" role="dialog"></div>
</form>

<?php echo '<script'; ?>
 src="/public/tree/Validform_v5.3.2_min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    $(function() {
        $("[data-json]").bind('click', function() {
            var url   = $(this).attr('data-href');
            var msg   = $(this).attr('data-json');
            if(confirm(msg)) {
                $.getJSON(url, function(json) {
                    alert(json.info);
                    if ( json.status == 'y' )
                        setTimeout( function() {window.location.reload()}, 1000);
                });
            }

        });

        $("[data-toggle='modal']").bind('click', function(){
            var target = $(this).attr('data-target');
            var url    = $(this).attr('href');
            if ( url != 'undefined') {
                $(target).load(url);
            }
        });

        //重新分页样式
        $('.pagination a').each( function() {
            $(this).hasClass('current') ? $(this).wrap('<li class="disabled" />') : $(this).wrap('<li />');
        });

        $(".form-horizontal").Validform({
            ajaxPost: true,
            tipSweep: true,
            tiptype:function(msg,o,cssctl){
                if ( o.type == 3 ) {
                    o.obj.next('.help-inline').html(msg).addClass('Validform_error');
                } else {
                    o.obj.next('.help-inline').html('').addClass('Validform_success');
                }
            },
            callback:function(json){
                var alert = $('.alert').eq(0);
                alert.show();
                if ( json.status == 'y' ) {
                    alert.removeClass('alert-danger').addClass('alert-success').children('strong').html(json.info);
                    setTimeout( function() {window.location.reload()}, 1000);
                } else {
                    alert.addClass('alert-danger').children('strong').html(json.info);
                }
            }
        });
    });
<?php echo '</script'; ?>
>
</body>
</html><?php }
}
?>