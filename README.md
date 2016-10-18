# scheduledTask-workerman
**基于workerman和yaf开发的计划任务系统。web端管理计划任务，查看任务日志，异常报警。 如果计划任务很少，直接用linux的crontab即可。**

**功能列表:**
 1. yaf cli命令行模式执行php程序（也支持curl模式）；
 2. web在线管理计划任务，主要功能管理计划任务列表，添加用户，查看任务日志，任务异常报警提醒；
 3. 使用workerman的定时器执行计划任务：任务循环执行，只执行一次，每天执行一次三种模式，最小 间隔时间精确到 1分钟。

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
php start.php start -d
```

![image](https://github.com/moxiaobai/scheduledTask-workerman/blob/master/doc/workerman-console.png)

