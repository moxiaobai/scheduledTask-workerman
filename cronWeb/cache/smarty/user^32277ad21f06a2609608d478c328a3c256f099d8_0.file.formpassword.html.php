<?php /* Smarty version 3.1.27, created on 2016-09-26 16:22:06
         compiled from "/mnt/outsource/timer/cronWeb/application/views/user/formpassword.html" */ ?>
<?php
/*%%SmartyHeaderCode:114727770157e8daae27cd88_52043555%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '32277ad21f06a2609608d478c328a3c256f099d8' => 
    array (
      0 => '/mnt/outsource/timer/cronWeb/application/views/user/formpassword.html',
      1 => 1474271541,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '114727770157e8daae27cd88_52043555',
  'variables' => 
  array (
    'id' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e8daae34a4b0_29286331',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e8daae34a4b0_29286331')) {
function content_57e8daae34a4b0_29286331 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '114727770157e8daae27cd88_52043555';
?>
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="passportModalLabel">修改密码</h4>
        </div>
        <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" />
        <div class="modal-body">
            <div class="alert alert-dismissible" role="alert" style="display: none;">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <strong></strong>
            </div>
            <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['id']->value;?>
" />
            <div class="control-group">
                <label class="control-label">登录密码</label>
                <div class="controls">
                    <input type="password" name="password" value="" placeholder="登录密码" datatype="*6-18" nullmsg="请填写登录密码" />
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