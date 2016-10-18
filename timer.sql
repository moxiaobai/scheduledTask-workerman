/*
Navicat MySQL Data Transfer

Source Server         : 192.168.1.5[外包]
Source Server Version : 50546
Source Host           : 192.168.1.5:3306
Source Database       : timer

Target Server Type    : MYSQL
Target Server Version : 50546
File Encoding         : 65001

Date: 2016-10-18 15:00:07
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for t_alarm
-- ----------------------------
DROP TABLE IF EXISTS `t_alarm`;
CREATE TABLE `t_alarm` (
  `a_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL COMMENT '任务ID',
  `d_id` int(11) NOT NULL COMMENT '报警人',
  `d_realname` varchar(50) NOT NULL COMMENT '负责人',
  `a_addtime` datetime NOT NULL,
  PRIMARY KEY (`a_id`),
  KEY `c_id` (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=760 DEFAULT CHARSET=utf8 COMMENT='报警日志';

-- ----------------------------
-- Records of t_alarm
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron
-- ----------------------------
DROP TABLE IF EXISTS `t_cron`;
CREATE TABLE `t_cron` (
  `c_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_title` varchar(255) NOT NULL COMMENT '任务标题',
  `c_type` tinyint(4) NOT NULL COMMENT '任务类型：1 url，2Cli',
  `c_content` varchar(255) NOT NULL COMMENT '执行内容',
  `c_interval` int(11) NOT NULL COMMENT '间隔执行时间',
  `c_start_time` int(11) NOT NULL COMMENT '任务开始时间',
  `c_end_time` bigint(11) NOT NULL,
  `c_execute_time` int(11) DEFAULT NULL COMMENT '程序执行时间',
  `c_persistent` int(1) NOT NULL DEFAULT '1' COMMENT '1循环执行,2每天执行一次，3只执行一次',
  `c_run_time` datetime DEFAULT NULL COMMENT '开始执行时间',
  `c_stop_time` datetime DEFAULT NULL COMMENT '停止运行时间',
  `c_timer_id` int(11) NOT NULL DEFAULT '0' COMMENT '定时程序ID',
  `c_status` tinyint(4) NOT NULL DEFAULT '1' COMMENT '状态：1正常，2禁用',
  `c_state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '运行状态：1未运行，2运行',
  `c_update_time` datetime DEFAULT NULL COMMENT '最后更新时间',
  `c_addtime` datetime NOT NULL COMMENT '添加时间',
  `c_alarm` int(11) NOT NULL DEFAULT '10' COMMENT '每天报警次数',
  `d_id` int(11) NOT NULL COMMENT '程序负责人ID',
  PRIMARY KEY (`c_id`)
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8 COMMENT='计划任务';

-- ----------------------------
-- Records of t_cron
-- ----------------------------
INSERT INTO `t_cron` VALUES ('22', '只执行一次的任务', '2', '/user/list/', '60', '1474880400', '1474881000', '1474880700', '3', '2016-09-26 17:02:58', '2016-09-27 17:38:07', '0', '1', '1', '2016-09-26 16:21:42', '2016-09-23 14:44:36', '10', '1001');
INSERT INTO `t_cron` VALUES ('23', '循环执行', '2', '/passport/user/stat/', '60', '1474613040', '1475217600', null, '1', '2016-09-29 08:54:19', '2016-09-23 18:15:52', '1', '1', '2', '2016-09-23 17:37:52', '2016-09-23 14:45:24', '10', '1041');

-- ----------------------------
-- Table structure for t_cron_log_0
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_0`;
CREATE TABLE `t_cron_log_0` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_0
-- ----------------------------
INSERT INTO `t_cron_log_0` VALUES ('1', '22', '2', '', '0.034477', '512', '1474623607');
INSERT INTO `t_cron_log_0` VALUES ('2', '22', '1', '{\"code\":1,\"info\":2}', '0.0690389', '1000', '1474877155');
INSERT INTO `t_cron_log_0` VALUES ('3', '22', '1', '{\"code\":1,\"info\":2}', '0.0583179', '1000', '1474880758');
INSERT INTO `t_cron_log_0` VALUES ('4', '22', '1', '{\"code\":1,\"info\":2}', '0.0733991', '1000', '1474880759');

-- ----------------------------
-- Table structure for t_cron_log_1
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_1`;
CREATE TABLE `t_cron_log_1` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_1
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_2
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_2`;
CREATE TABLE `t_cron_log_2` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_2
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_3
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_3`;
CREATE TABLE `t_cron_log_3` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_3
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_4
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_4`;
CREATE TABLE `t_cron_log_4` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_4
-- ----------------------------
INSERT INTO `t_cron_log_4` VALUES ('1', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.155769', '608', '1466478939');
INSERT INTO `t_cron_log_4` VALUES ('2', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.132609', '608', '1466482539');
INSERT INTO `t_cron_log_4` VALUES ('3', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.138587', '608', '1466486140');
INSERT INTO `t_cron_log_4` VALUES ('4', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.116076', '608', '1466489740');
INSERT INTO `t_cron_log_4` VALUES ('5', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.130038', '608', '1466493340');
INSERT INTO `t_cron_log_4` VALUES ('6', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.13792', '608', '1466496940');
INSERT INTO `t_cron_log_4` VALUES ('7', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.123851', '608', '1466500540');
INSERT INTO `t_cron_log_4` VALUES ('8', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.132289', '608', '1466504140');
INSERT INTO `t_cron_log_4` VALUES ('9', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.141207', '608', '1466507740');
INSERT INTO `t_cron_log_4` VALUES ('10', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.138908', '608', '1466511340');
INSERT INTO `t_cron_log_4` VALUES ('11', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.126036', '608', '1466514940');
INSERT INTO `t_cron_log_4` VALUES ('12', '14', '1', '{\"code\":1,\"info\":\"ID: 12,13,14,15,17,18\"}', '0.30367', '624', '1469072976');
INSERT INTO `t_cron_log_4` VALUES ('13', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.084969', '608', '1469076576');
INSERT INTO `t_cron_log_4` VALUES ('14', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.0843151', '608', '1469082539');
INSERT INTO `t_cron_log_4` VALUES ('15', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.091238', '608', '1469086139');
INSERT INTO `t_cron_log_4` VALUES ('16', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.0809231', '608', '1469090493');
INSERT INTO `t_cron_log_4` VALUES ('17', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.100396', '608', '1469094093');
INSERT INTO `t_cron_log_4` VALUES ('18', '14', '1', '{\"code\":1,\"info\":\"No data processing\"}', '0.114952', '608', '1469097693');

-- ----------------------------
-- Table structure for t_cron_log_5
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_5`;
CREATE TABLE `t_cron_log_5` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_5
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_6
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_6`;
CREATE TABLE `t_cron_log_6` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_6
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_7
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_7`;
CREATE TABLE `t_cron_log_7` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_7
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_8
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_8`;
CREATE TABLE `t_cron_log_8` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_8
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_9
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_9`;
CREATE TABLE `t_cron_log_9` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_9
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_A
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_A`;
CREATE TABLE `t_cron_log_A` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_A
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_B
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_B`;
CREATE TABLE `t_cron_log_B` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_B
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_C
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_C`;
CREATE TABLE `t_cron_log_C` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_C
-- ----------------------------
INSERT INTO `t_cron_log_C` VALUES ('1', '11', '1', '{\"code\":1,\"info\":2}', '0.052999', '544', '1461726615');

-- ----------------------------
-- Table structure for t_cron_log_D
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_D`;
CREATE TABLE `t_cron_log_D` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_D
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_E
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_E`;
CREATE TABLE `t_cron_log_E` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_E
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_F
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_F`;
CREATE TABLE `t_cron_log_F` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_F
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_G
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_G`;
CREATE TABLE `t_cron_log_G` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_G
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_H
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_H`;
CREATE TABLE `t_cron_log_H` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_H
-- ----------------------------
INSERT INTO `t_cron_log_H` VALUES ('1', '12', '1', '{\"code\":1,\"info\":17587}', '0.129746', '544', '1461868247');
INSERT INTO `t_cron_log_H` VALUES ('2', '12', '1', '{\"code\":1,\"info\":10828}', '0.150774', '544', '1461954636');
INSERT INTO `t_cron_log_H` VALUES ('3', '12', '1', '{\"code\":1,\"info\":13534}', '0.113525', '544', '1462041024');
INSERT INTO `t_cron_log_H` VALUES ('4', '12', '1', '{\"code\":1,\"info\":10708}', '0.113744', '544', '1462127411');
INSERT INTO `t_cron_log_H` VALUES ('5', '12', '1', '{\"code\":1,\"info\":13646}', '0.138839', '544', '1462213856');
INSERT INTO `t_cron_log_H` VALUES ('6', '12', '1', '{\"code\":1,\"info\":11075}', '0.471775', '544', '1462300242');
INSERT INTO `t_cron_log_H` VALUES ('7', '12', '1', '{\"code\":1,\"info\":15245}', '0.0934451', '544', '1462386627');
INSERT INTO `t_cron_log_H` VALUES ('8', '12', '1', '{\"code\":1,\"info\":12172}', '0.441084', '544', '1462473014');
INSERT INTO `t_cron_log_H` VALUES ('9', '12', '1', '{\"code\":1,\"info\":10403}', '0.160736', '544', '1462559455');
INSERT INTO `t_cron_log_H` VALUES ('10', '12', '1', '{\"code\":1,\"info\":15044}', '0.118175', '544', '1462645840');

-- ----------------------------
-- Table structure for t_cron_log_I
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_I`;
CREATE TABLE `t_cron_log_I` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_I
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_J
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_J`;
CREATE TABLE `t_cron_log_J` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_J
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_K
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_K`;
CREATE TABLE `t_cron_log_K` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_K
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_L
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_L`;
CREATE TABLE `t_cron_log_L` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_L
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_M
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_M`;
CREATE TABLE `t_cron_log_M` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_M
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_N
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_N`;
CREATE TABLE `t_cron_log_N` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_N
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_O
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_O`;
CREATE TABLE `t_cron_log_O` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_O
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_P
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_P`;
CREATE TABLE `t_cron_log_P` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_P
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_Q
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_Q`;
CREATE TABLE `t_cron_log_Q` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_Q
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_R
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_R`;
CREATE TABLE `t_cron_log_R` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_R
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_S
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_S`;
CREATE TABLE `t_cron_log_S` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_S
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_T
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_T`;
CREATE TABLE `t_cron_log_T` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_T
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_U
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_U`;
CREATE TABLE `t_cron_log_U` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_U
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_V
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_V`;
CREATE TABLE `t_cron_log_V` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_V
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_W
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_W`;
CREATE TABLE `t_cron_log_W` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_W
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_X
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_X`;
CREATE TABLE `t_cron_log_X` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_X
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_Y
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_Y`;
CREATE TABLE `t_cron_log_Y` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_Y
-- ----------------------------

-- ----------------------------
-- Table structure for t_cron_log_Z
-- ----------------------------
DROP TABLE IF EXISTS `t_cron_log_Z`;
CREATE TABLE `t_cron_log_Z` (
  `cl_id` int(11) NOT NULL AUTO_INCREMENT,
  `c_id` int(11) NOT NULL,
  `cl_status` tinyint(4) NOT NULL COMMENT '任务执行结果：1成功，2失败',
  `cl_result` varchar(255) NOT NULL COMMENT '任务执行结果',
  `cl_consume_time` float NOT NULL COMMENT '程序消耗时间,单位秒',
  `cl_consume_memory` int(11) NOT NULL COMMENT '消耗内存,单位字节',
  `cl_datetime` int(11) unsigned NOT NULL,
  PRIMARY KEY (`cl_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COMMENT='任务日志表';

-- ----------------------------
-- Records of t_cron_log_Z
-- ----------------------------

-- ----------------------------
-- Table structure for t_user
-- ----------------------------
DROP TABLE IF EXISTS `t_user`;
CREATE TABLE `t_user` (
  `u_id` smallint(6) unsigned NOT NULL AUTO_INCREMENT COMMENT '员工id',
  `u_username` varchar(20) NOT NULL COMMENT '员工用户名',
  `u_realname` varchar(20) NOT NULL COMMENT '员工真实名称',
  `u_password` char(32) NOT NULL COMMENT '密码',
  `u_phone` varchar(11) NOT NULL COMMENT '电话',
  `u_email` varchar(50) NOT NULL COMMENT '邮件',
  `u_role` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '员工权限： 1-普通员工; 2-系统管理员',
  `u_status` tinyint(1) unsigned NOT NULL DEFAULT '1' COMMENT '用户状态，1: 可用，2:禁用',
  `u_addtime` datetime NOT NULL COMMENT '添加时间',
  PRIMARY KEY (`u_id`),
  KEY `username` (`u_username`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=1042 DEFAULT CHARSET=utf8 COMMENT='员工登陆相关信息表';

-- ----------------------------
-- Records of t_user
-- ----------------------------
INSERT INTO `t_user` VALUES ('1001', 'mlkom', 'mlkom', 'cc8a15d31a04d375382b2f2b32169193', '13509351822', '262756784@qq.com', '2', '1', '2016-09-19 11:40:52');
INSERT INTO `t_user` VALUES ('1041', 'moxiaobai', '莫小白', '2d2d95373ee0ecda657ad8575a110aab', '13509351822', 'xiaogangren@comylife', '1', '1', '2016-09-19 16:15:06');
