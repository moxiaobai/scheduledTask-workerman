<?php /* Smarty version 3.1.27, created on 2016-09-23 14:38:07
         compiled from "/mnt/outsource/timer/cronWeb/application/views/user/form.html" */ ?>
<?php
/*%%SmartyHeaderCode:175885147057e4cdcf0db0a7_34904576%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e47051a02e500fe58b710a47c7ad074c3d567861' => 
    array (
      0 => '/mnt/outsource/timer/cronWeb/application/views/user/form.html',
      1 => 1474272410,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '175885147057e4cdcf0db0a7_34904576',
  'variables' => 
  array (
    'id' => 0,
    'username' => 0,
    'realname' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e4cdcf16d860_84723251',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e4cdcf16d860_84723251')) {
function content_57e4cdcf16d860_84723251 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '175885147057e4cdcf0db0a7_34904576';
?>
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="passportModalLabel"><?php if ($_smarty_tpl->tpl_vars['id']->value) {?>修改管理员<?php } else { ?>添加管理员<?php }?></h4>
        </div>
        <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" />
        <div class="modal-body">
            <div class="alert alert-dismissible" role="alert" style="display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong></strong>
            </div>
            <div class="control-group">
                <label class="control-label">用户名</label>
                <div class="controls">
                    <input type="text" name="u_username" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['username']->value;?>
" placeholder="用户名" datatype="s6-18" nullmsg="请填写用户名"  />
                    <span class="help-inline" style="color:red;">*</span>
                </div>

            </div>
            <?php if (!$_smarty_tpl->tpl_vars['id']->value) {?>
            <div class="control-group">
                <label class="control-label">登录密码</label>
                <div class="controls">
                    <input type="password" name="u_password" class="form-control" value="" placeholder="登录密码" datatype="*6-18" nullmsg="请填写登录密码" />
                    <span class="help-inline" style="color:red;">*</span>
                </div>

            </div>
            <?php }?>
            <div class="control-group">
                <label class="control-label">真实姓名</label>
                <div class="controls">
                    <input type="text" name="u_realname" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['realname']->value;?>
" placeholder="真实姓名" datatype="*" nullmsg="请填写真实姓名" />
                    <span class="help-inline" style="color:red;">*</span>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            <button type="submit" class="btn btn-primary btn-submit">确认修改</button>
        </div>
    </div>
</div><?php }
}
?>