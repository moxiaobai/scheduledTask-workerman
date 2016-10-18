# scheduledTask-workerman
基于workerman和yaf开发的计划任务系统

**功能列表:**
 1. yaf cli命令行模式开发
 2. web在线管理计划任务
 3. workerman定时器

## cronCli 基于php yaf开发的php cli命令行程序
**示例程序:**
``` php
php request.php request_uri="/pay/message/list/"''interpreter
```


## cronWeb 基于php yaf开发的web管理工具

**计划任务列表**
![image](https://github.com/moxiaobai/scheduledTask-workerman/blob/master/doc/task-list.png)

**添加计划任务**
![image](https://github.com/moxiaobai/scheduledTask-workerman/blob/master/doc/add-task.png)

**用户管理**
![image](https://github.com/moxiaobai/scheduledTask-workerman/blob/master/doc/user-manage.png)

**报警日志**
![image](https://github.com/moxiaobai/scheduledTask-workerman/blob/master/doc/alarm-log.png)

## cronWorker基于workerman开发的计划任务
**开启计划任务**
``` php
php start.php start
```

![image](https://github.com/moxiaobai/scheduledTask-workerman/blob/master/doc/workerman-console.png)

