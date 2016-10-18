<?php /* Smarty version 3.1.27, created on 2016-09-26 16:21:34
         compiled from "/mnt/outsource/timer/cronWeb/application/views/index/addcron.html" */ ?>
<?php
/*%%SmartyHeaderCode:170262345857e8da8eb8f114_28003202%%*/
if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'caf9723f8d873f62a2568834f9e105da89a39755' => 
    array (
      0 => '/mnt/outsource/timer/cronWeb/application/views/index/addcron.html',
      1 => 1474878086,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '170262345857e8da8eb8f114_28003202',
  'variables' => 
  array (
    'row' => 0,
    'type' => 0,
    'noticeUser' => 0,
    'status' => 0,
  ),
  'has_nocache_code' => false,
  'version' => '3.1.27',
  'unifunc' => 'content_57e8da8ed16ba7_14233222',
),false);
/*/%%SmartyHeaderCode%%*/
if ($_valid && !is_callable('content_57e8da8ed16ba7_14233222')) {
function content_57e8da8ed16ba7_14233222 ($_smarty_tpl) {

$_smarty_tpl->properties['nocache_hash'] = '170262345857e8da8eb8f114_28003202';
echo $_smarty_tpl->getSubTemplate ("common/page_header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0);
?>



<ul class="breadcrumb">
    <li><a href="/">首页</a> <span class="divider">/</span></li>
    <li><a href="/index/help/">计划任务说明</a> <span class="divider">/</span></li>
    <li>计划任务</li>
</ul>
<div class="clear"></div>

<form class="form-horizontal" id="form-save" action="/index/saveCron/">
    <input type="hidden" name="id" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_id'];?>
">
    <div class="control-group">
        <label class="control-label">任务标题</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="title" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_title'];?>
" datatype="*" nullmsg="请输入任务标题" />
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">任务类型</label>
        <div class="controls">
            <select name="type" id="type" class="input-medium" datatype="*" nullmsg="请选择任务类型">
                <?php echo $_smarty_tpl->tpl_vars['type']->value;?>

            </select>
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">任务内容</label>
        <div class="controls">
            <input class="input-xxlarge" type="text" name="url" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_content'];?>
" datatype="*" nullmsg="请输入任务内容" />
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>

    <?php if ($_smarty_tpl->tpl_vars['row']->value['c_persistent'] == 1) {?>
    <input type="hidden" name="persistent" value="1" />
    <div class="alert alert-success" style="margin-bottom:30px;">
        <button type="button" class="close" data-dismiss="alert">×</button>
        循环执行
    </div>
    <div class="control-group">
        <label class="control-label">任务开始时间</label>
        <div class="controls">
            <input id="startTimeOne" name="startTimeOne" size="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_start_time'];?>
" class="span2" placeholder="任务开始时间">
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">任务结束时间</label>
        <div class="controls">
            <input id="endTimeOne" name="endTimeOne" size="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_end_time'];?>
" class="span2" placeholder="任务结束时间">
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">任务执行间隔时间</label>
        <div class="controls">
            <input class="span2" type="text" name="interval" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_interval']/60;?>
" /> 单位：分
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>
    <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['c_persistent'] == 2) {?>
    <input type="hidden" name="persistent" value="2" />
    <div class="alert alert-success" style="margin-bottom:30px;">
        <button type="button" class="close" data-dismiss="alert">×</button>
        每天执行一次
    </div>
    <div class="control-group">
        <label class="control-label">任务开始时间</label>
        <div class="controls">
            <input id="startTimeTwo" name="startTimeTwo" size="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_start_time'];?>
" class="span2" placeholder="任务开始时间">
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">任务结束时间</label>
        <div class="controls">
            <input id="endTimeTwo" name="endTimeTwo" size="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_end_time'];?>
" class="span2" placeholder="任务结束时间">
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label">任务执行时间</label>
        <div class="controls">
            <input id="executeTime" name="executeTime" size="16" type="text"  value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_execute_time'];?>
" class="span2" placeholder="任务执行时间">
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>
    <?php } elseif ($_smarty_tpl->tpl_vars['row']->value['c_persistent'] == 3) {?>
    <input type="hidden" name="persistent" value="3" />
    <div class="alert alert-success" style="margin-bottom:30px;">
        <button type="button" class="close" data-dismiss="alert">×</button>
        只执行一次
    </div>
    <div class="control-group">
        <label class="control-label">任务执行时间</label>
        <div class="controls">
            <input id="executeDateTime" name="executeDateTime" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_execute_time'];?>
" size="16" type="text" class="span2" placeholder="任务执行时间">
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>
    <?php } else { ?>
    <div class="tabbable">
        <ul class="nav nav-tabs">
            <input type="hidden" name="persistent" value="1" />
            <li class="active"><a href="#tab1" data-toggle="tab" type="1">循环执行</a></li>
            <li><a href="#tab2" data-toggle="tab" type="2">每天执行一次</a></li>
            <li><a href="#tab3" data-toggle="tab" type="3">只执行一次</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab1">
                <div class="control-group">
                    <label class="control-label">任务开始时间</label>
                    <div class="controls">
                        <input id="startTimeOne" name="startTimeOne" size="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_start_time'];?>
" class="span2" placeholder="任务开始时间">
                        <span class="help-inline" style="color:red;">*</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">任务结束时间</label>
                    <div class="controls">
                        <input id="endTimeOne" name="endTimeOne" size="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_end_time'];?>
" class="span2" placeholder="任务结束时间">
                        <span class="help-inline" style="color:red;">*</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">任务执行间隔时间</label>
                    <div class="controls">
                        <input class="span2" type="text" name="interval" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_interval'];?>
" /> 单位：分
                        <span class="help-inline" style="color:red;">*</span>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab2">
                <div class="control-group">
                    <label class="control-label">任务开始时间</label>
                    <div class="controls">
                        <input id="startTimeTwo" name="startTimeTwo" size="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_start_time'];?>
" class="span2" placeholder="任务开始时间">
                        <span class="help-inline" style="color:red;">*</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">任务结束时间</label>
                    <div class="controls">
                        <input id="endTimeTwo" name="endTimeTwo" size="16" type="text" value="<?php echo $_smarty_tpl->tpl_vars['row']->value['c_end_time'];?>
" class="span2" placeholder="任务结束时间">
                        <span class="help-inline" style="color:red;">*</span>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">任务执行时间</label>
                    <div class="controls">
                        <input id="executeTime" name="executeTime" size="16" type="text"  class="span2" placeholder="任务执行时间">
                        <span class="help-inline" style="color:red;">*</span>
                    </div>
                </div>
            </div>
            <div class="tab-pane" id="tab3">
                <div class="control-group">
                    <label class="control-label">任务执行时间</label>
                    <div class="controls">
                        <input id="executeDateTime" name="executeDateTime" size="16" type="text" class="span2" placeholder="任务执行时间">
                        <span class="help-inline" style="color:red;">*</span>
                    </div>
                </div>
            </div>
            <?php }?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">通知人员列表</label>
        <div class="controls">
            <select name="uid" class="input-medium" datatype="*" nullmsg="请选择通知人员列表">
                <?php echo $_smarty_tpl->tpl_vars['noticeUser']->value;?>

            </select>
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">任务每天报警次数</label>
        <div class="controls">
            <input class="span2" type="text" name="alarm" value="<?php if ($_smarty_tpl->tpl_vars['row']->value['c_alarm']) {
echo $_smarty_tpl->tpl_vars['row']->value['c_alarm'];
} else { ?>20<?php }?>" datatype="n" nullmsg="请输入任务每天报警次数" />
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">任务状态</label>
        <div class="controls">
            <select name="status" class="input-medium" datatype="*" nullmsg="请选择任务状态">
                <?php echo $_smarty_tpl->tpl_vars['status']->value;?>

            </select>
            <span class="help-inline" style="color:red;">*</span>
        </div>
    </div>

    <div>
        <label class="control-label"></label>
        <div class="controls">
            <button type="submit" class="btn btn-primary"><?php if ($_smarty_tpl->tpl_vars['row']->value['c_id']) {?>更新任务<?php } else { ?>添加任务<?php }?></button>
        </div>
    </div>
</form>

<link href="/public/tree/bootstrap-datetimepicker.css" rel="stylesheet" />
<?php echo '<script'; ?>
 src="/public/tree/bootstrap-datetimepicker.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="/public/tree/Validform_v5.3.2_min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
    $(function(){
        //时间选择
        $("#startTimeOne,#endTimeOne,#startTimeTwo,#endTimeTwo,#executeDateTime").datetimepicker({
            format: "yyyy-mm-dd hh:ii",
            autoclose: true,
            todayBtn: true,
            pickerPosition: "bottom-left"
        });
        $("#executeTime").datetimepicker({
            format: "hh:ii",
            autoclose: true,
            startView:1,
            pickerPosition: "bottom-left"
        });

        $("[data-toggle='tab']").bind('click', function(){
            var type = $(this).attr('type');
            $("input[name='persistent']").val(type);
        });
    });

    $("#form-save").Validform({
        ajaxPost: true,
        tipSweep: true,
        tiptype:function(msg,o,cssctl){
            if(!o.obj.is("form")){
                if ( o.type == 3 ) {
                    o.obj.next('.help-inline').html(msg).addClass('Validform_error');
                } else {
                    o.obj.next('.help-inline').html('').addClass('Validform_success');
                }
            }
        },
        callback:function(response){
            swal({   title: response.info,timer: 2000 });
            if ( response.status == 'y' ) {
                window.setTimeout(function(){
                    window.location.href = "/index/";
                }, 2000)
            }
            return false;
        }
    });
<?php echo '</script'; ?>
>
</body>
</html><?php }
}
?>