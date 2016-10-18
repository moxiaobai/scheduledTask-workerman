
## 功能说明

 1. 定时执行任务： 循环执行，只执行一次，每天执行一次三种模式。请求的地址可以是http 地址，也可以是php cli程序
 2. 报警机制：邮件报警，企业号报警，其他自己开发：比如短信，公众号消息模板，RTX等等
 3. 自定义配置：/cronWork/Applications/Cron/Config/application.ini


##配置说明

 1. 数据库配置：节点[mysql.cron]
 2. Cli执行目录:  节点[cli]
 3. 报警通知开关: 节点[notice.switch]
