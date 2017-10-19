-- MySQL dump 10.13  Distrib 5.7.12, for Win64 (x86_64)
--
-- Host: isc.leader-tech.cn    Database: yidou_chat
-- ------------------------------------------------------
-- Server version	5.6.14

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `yd_chatmsg`
--

DROP TABLE IF EXISTS `yd_chatmsg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_chatmsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `sender_id` int(11) NOT NULL COMMENT '消息发送者ID号',
  `receiver_id` int(11) NOT NULL COMMENT '消息接收者ID号',
  `msg_content` varchar(255) NOT NULL DEFAULT '' COMMENT '消息发送的内容',
  `msg_type` tinyint(4) NOT NULL DEFAULT '1',
  `send_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '消息发送的时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='私聊消息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_chatmsg`
--

LOCK TABLES `yd_chatmsg` WRITE;
/*!40000 ALTER TABLE `yd_chatmsg` DISABLE KEYS */;
INSERT INTO `yd_chatmsg` VALUES (1,32164,24252,'Tom',1,'2016-04-18 05:42:24'),(2,32164,30747,'[调皮]',1,'2016-04-23 01:47:13'),(3,30747,32164,'[呲牙]',1,'2016-04-23 01:47:50'),(4,34932,33939,'[呲牙]',1,'2017-03-01 09:30:25'),(5,33939,34932,'你下班了吗？',1,'2017-03-01 09:31:20'),(6,33939,34932,'还没呢？',1,'2017-03-01 09:31:35'),(7,34932,33939,'嗯',1,'2017-03-01 09:32:51'),(8,33939,34932,'你在干嘛呢？',1,'2017-03-01 09:40:27'),(9,33939,36008,'你下班了吗？',1,'2017-03-01 09:54:03'),(10,33939,36008,'我打算今晚去西乡天虹看电影，你要一起不？[呲牙]',1,'2017-03-01 09:55:33'),(11,36008,33939,'嗯，可以噢。',1,'2017-03-01 09:56:24'),(12,33939,36008,'有妹纸吗？[偷笑]',1,'2017-03-01 09:56:56'),(13,36008,33939,'必须滴！',1,'2017-03-01 09:57:31'),(14,37579,34932,'[悠闲]',1,'2017-04-14 03:09:48'),(15,19337,37579,'你最近在忙啥？[呲牙]',1,'2017-04-14 03:13:42'),(16,37579,19337,'在码字中...',1,'2017-04-14 03:14:44'),(17,19337,37579,'知道高级群里有一群妖孽麽？',1,'2017-04-14 03:15:38'),(18,37579,19337,'谁？',1,'2017-04-14 03:15:50'),(19,37579,19337,'uhuh~ ?',1,'2017-04-14 03:16:02'),(20,19337,37579,'就是那货！[发怒]',1,'2017-04-14 03:16:20');
/*!40000 ALTER TABLE `yd_chatmsg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_general_contacts`
--

DROP TABLE IF EXISTS `yd_general_contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_general_contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `leader_id` int(11) NOT NULL COMMENT '用户ID',
  `contact_id` int(11) NOT NULL COMMENT '关联的联系人的用户ID',
  `is_valid` int(11) NOT NULL DEFAULT '1' COMMENT '是否有效',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='常用联系人';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_general_contacts`
--

LOCK TABLES `yd_general_contacts` WRITE;
/*!40000 ALTER TABLE `yd_general_contacts` DISABLE KEYS */;
/*!40000 ALTER TABLE `yd_general_contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_group`
--

DROP TABLE IF EXISTS `yd_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `group_id` int(11) NOT NULL,
  `group_name` varchar(50) NOT NULL COMMENT '群名称',
  `group_intro` varchar(255) DEFAULT NULL,
  `group_avatar` varchar(255) NOT NULL COMMENT '群头像',
  `is_valid` int(11) DEFAULT '1' COMMENT '是否有效',
  `create_by` int(11) DEFAULT NULL COMMENT '创建人',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  PRIMARY KEY (`id`),
  UNIQUE KEY `group_id_UNIQUE` (`group_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='群表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_group`
--

LOCK TABLES `yd_group` WRITE;
/*!40000 ALTER TABLE `yd_group` DISABLE KEYS */;
INSERT INTO `yd_group` VALUES (1,10000,'一斗投资公共群','所有注册用户可以加入的群','img/yidou.png',1,0,'2016-04-13 08:21:46'),(2,10001,'恒安兴','公司是国内领先的全域空间软装饰方案提供商。集研发设计、产品开发、销售、软装全案设计及服务为一体，通过将布艺织品、陶瓷器具','img/avatar_upload/2016_04_14-22_57_30-7246.png',1,30646,'2016-04-14 14:59:28');
/*!40000 ALTER TABLE `yd_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_group_album`
--

DROP TABLE IF EXISTS `yd_group_album`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_group_album` (
  `album_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `album_name` varchar(45) NOT NULL,
  `album_desc` varchar(1024) NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_valid` varchar(45) NOT NULL DEFAULT '1',
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='群相册';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_group_album`
--

LOCK TABLES `yd_group_album` WRITE;
/*!40000 ALTER TABLE `yd_group_album` DISABLE KEYS */;
INSERT INTO `yd_group_album` VALUES (1,10000,'默认相册','默认相册',30646,'2016-04-25 05:12:31','1');
/*!40000 ALTER TABLE `yd_group_album` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_group_album_image`
--

DROP TABLE IF EXISTS `yd_group_album_image`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_group_album_image` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_album_id` int(11) NOT NULL,
  `group_id` int(11) NOT NULL,
  `path` varchar(255) NOT NULL,
  `create_by` int(11) DEFAULT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_valid` tinyint(4) DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COMMENT='群相册照片';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_group_album_image`
--

LOCK TABLES `yd_group_album_image` WRITE;
/*!40000 ALTER TABLE `yd_group_album_image` DISABLE KEYS */;
INSERT INTO `yd_group_album_image` VALUES (1,1,10000,'img/group/201604251312291866540.jpeg',30646,'2016-04-25 05:12:31',1),(2,1,10000,'img/group/201604251312305047361.jpeg',30646,'2016-04-25 05:12:31',1),(3,1,10000,'img/group/201604251312302303252.jpeg',30646,'2016-04-25 05:12:31',1);
/*!40000 ALTER TABLE `yd_group_album_image` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_group_announce`
--

DROP TABLE IF EXISTS `yd_group_announce`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_group_announce` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `leader_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` varchar(4500) NOT NULL,
  `cover` varchar(255) DEFAULT '',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_valid` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='群公告列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_group_announce`
--

LOCK TABLES `yd_group_announce` WRITE;
/*!40000 ALTER TABLE `yd_group_announce` DISABLE KEYS */;
/*!40000 ALTER TABLE `yd_group_announce` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_group_ban_speak`
--

DROP TABLE IF EXISTS `yd_group_ban_speak`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_group_ban_speak` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `group_id` bigint(20) NOT NULL COMMENT '群ID号',
  `user_id` bigint(20) NOT NULL COMMENT '用户ID号',
  `start_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '禁言起始时间',
  `end_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '禁言结束时间',
  `is_valid` int(11) DEFAULT '1' COMMENT '是否有效',
  `create_by` int(11) DEFAULT NULL COMMENT '创建人',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  PRIMARY KEY (`id`,`group_id`,`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='群禁言列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_group_ban_speak`
--

LOCK TABLES `yd_group_ban_speak` WRITE;
/*!40000 ALTER TABLE `yd_group_ban_speak` DISABLE KEYS */;
/*!40000 ALTER TABLE `yd_group_ban_speak` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_group_file`
--

DROP TABLE IF EXISTS `yd_group_file`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_group_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `leader_id` int(11) NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `file_type` varchar(10) DEFAULT NULL,
  `file_size` varchar(255) NOT NULL,
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_valid` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='群文件';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_group_file`
--

LOCK TABLES `yd_group_file` WRITE;
/*!40000 ALTER TABLE `yd_group_file` DISABLE KEYS */;
/*!40000 ALTER TABLE `yd_group_file` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_group_member`
--

DROP TABLE IF EXISTS `yd_group_member`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_group_member` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `group_id` bigint(20) NOT NULL COMMENT '群ID号',
  `leader_id` bigint(20) NOT NULL COMMENT '用户ID号',
  `is_authentication` int(11) DEFAULT NULL COMMENT '是否已经是群成员 0正在申请 1申请通过',
  `user_role` int(11) NOT NULL,
  `is_valid` int(11) DEFAULT '1' COMMENT '是否有效',
  `create_by` int(11) DEFAULT NULL COMMENT '创建人',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8 COMMENT='群成员关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_group_member`
--

LOCK TABLES `yd_group_member` WRITE;
/*!40000 ALTER TABLE `yd_group_member` DISABLE KEYS */;
INSERT INTO `yd_group_member` VALUES (1,10000,14358,1,1,1,NULL,'2016-04-13 10:30:47'),(2,10000,19713,1,1,1,NULL,'2016-04-13 10:45:47'),(3,10000,14327,1,1,1,NULL,'2016-04-13 11:00:47'),(4,10000,34943,1,1,1,NULL,'2016-04-13 11:15:47'),(5,10000,15467,1,1,1,NULL,'2016-04-13 11:23:07'),(6,10000,21516,1,1,1,NULL,'2016-04-13 13:18:56'),(7,10000,14288,1,1,1,NULL,'2016-04-13 13:24:40'),(8,10000,33202,1,1,1,NULL,'2016-04-13 13:43:38'),(9,10000,30646,1,1,1,NULL,'2016-04-13 13:44:47'),(10,10000,24849,1,1,1,NULL,'2016-04-14 00:57:25'),(11,10000,42657,1,1,1,NULL,'2016-04-14 01:16:15'),(12,10000,31175,1,3,1,NULL,'2016-04-14 06:23:58'),(14,10000,31981,1,1,1,NULL,'2016-04-14 13:42:23'),(15,10001,30646,1,3,1,NULL,'2016-04-14 14:59:28'),(17,10000,32164,1,1,1,NULL,'2016-04-18 05:40:52'),(19,10000,30747,1,3,1,NULL,'2016-04-21 01:39:01'),(20,10000,30139,1,1,1,NULL,'2016-04-23 07:05:28'),(21,10000,18166,1,1,1,NULL,'2016-06-06 10:26:48'),(22,10000,16855,1,3,1,NULL,'2016-10-23 02:39:58'),(23,10000,34932,1,3,1,NULL,'2017-03-01 09:26:11'),(24,10000,33939,1,3,1,NULL,'2017-03-01 09:28:42'),(25,10000,36008,1,3,1,NULL,'2017-03-01 09:36:58'),(26,10000,21546,1,3,1,NULL,'2017-04-10 09:17:07'),(27,10000,37579,1,3,1,NULL,'2017-04-14 03:08:17'),(28,10000,19337,1,3,1,NULL,'2017-04-14 03:12:46');
/*!40000 ALTER TABLE `yd_group_member` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_group_notice`
--

DROP TABLE IF EXISTS `yd_group_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_group_notice` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `group_id` int(11) NOT NULL,
  `notice_type` tinyint(4) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `notice_title` varchar(45) DEFAULT NULL,
  `notice_content` varchar(45) DEFAULT NULL,
  `receiver_id` int(11) NOT NULL,
  `is_viewed` tinyint(4) NOT NULL DEFAULT '0',
  `is_valid` tinyint(4) NOT NULL DEFAULT '1',
  `send_time` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='群通知';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_group_notice`
--

LOCK TABLES `yd_group_notice` WRITE;
/*!40000 ALTER TABLE `yd_group_notice` DISABLE KEYS */;
INSERT INTO `yd_group_notice` VALUES (1,10001,101,30646,'恒安兴','一斗 邀请你加入群 恒安兴',31981,0,1,'2016-04-14 15:00:49');
/*!40000 ALTER TABLE `yd_group_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_groupmsg`
--

DROP TABLE IF EXISTS `yd_groupmsg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_groupmsg` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `group_id` int(11) NOT NULL COMMENT '所属群ID',
  `sender_id` int(11) NOT NULL COMMENT '发送者ID',
  `msg_content` varchar(255) NOT NULL DEFAULT '' COMMENT '发送的消息内容',
  `msg_type` tinyint(4) NOT NULL DEFAULT '1',
  `send_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '消息发送的时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COMMENT='群聊消息表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_groupmsg`
--

LOCK TABLES `yd_groupmsg` WRITE;
/*!40000 ALTER TABLE `yd_groupmsg` DISABLE KEYS */;
INSERT INTO `yd_groupmsg` VALUES (1,10000,42657,'[微笑]',1,'2016-04-14 01:17:14'),(2,10000,24849,'&lt;br&gt;[呲牙]',1,'2016-04-14 02:14:10'),(3,10000,31981,'[呲牙][呲牙]',1,'2016-04-14 13:43:46'),(4,10001,30646,'[冷汗]',1,'2016-04-14 15:04:26'),(5,10001,30646,'[微笑]',1,'2016-04-15 01:24:31'),(6,10001,30646,'文字发不上去',1,'2016-04-15 01:24:54'),(7,10000,30646,'三五十个字发不上去，也没提示',1,'2016-04-15 01:26:00'),(8,10001,30646,'我们都城……在线指导书、不会去往天堂与中国人就应该让我们这些在这儿呢、一定难度、一直到家后者更新一直想念我要不知道是从什么时候可以捏捏我也会是怎样炼成的是自己一直活该么！这么晚点了一点点的话，我们都城，你的时候可以捏捏肚子疼肚子里咽。我的心情了。我的人家不是你们想起你们的确很久了。我的心情是否还要去除黑头美白补水控油收缩毛孔男女的确是否有人在乎的人就应该是我的人家不是吗。我',1,'2016-04-15 12:27:04'),(9,10000,30646,'接电话都会或多或少感到尴尬的根深蒂固共商国是是哥哥哥哥哥哥哥哥哥哥哥哥哥哥刚上市公司哥哥哥哥哥哥说哥哥哥哥哥哥哥哥哥哥哥哥哥哥给德国德国德国德国德国德国德国咕咚咕咚哥哥哥哥哥哥的孤独感大动干戈大哥大哥大哥大哥大哥大哥个蛋糕蛋糕蛋糕蛋糕了很多咕咚咕咚的广告德国德国德国德国德国德国德国德国感动感动感动感动感动感动感动',1,'2016-04-17 14:20:55'),(10,10000,30747,'斗信已支持群公告，群图片和群文件的上传和查看功能。',1,'2016-04-22 19:09:10'),(11,10000,16855,'[呲牙]',1,'2016-10-23 02:45:43'),(12,10000,36008,'今天温度有点高啊！',1,'2017-03-01 09:53:18'),(13,10000,33939,'Yes, it is!',1,'2017-03-01 09:58:44'),(14,10000,36008,'深圳这天气我也是醉了！[流汗]',1,'2017-03-01 10:00:43'),(15,10000,21546,'[呲牙]',1,'2017-04-10 09:18:30');
/*!40000 ALTER TABLE `yd_groupmsg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_login_info`
--

DROP TABLE IF EXISTS `yd_login_info`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_login_info` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `leader_id` int(11) NOT NULL,
  `login_in_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '用户上次登录时间',
  `login_out_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '用户上次登出时间',
  `is_valid` int(11) NOT NULL DEFAULT '1' COMMENT '是否有效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=219 DEFAULT CHARSET=utf8 COMMENT='登录信息表,用于记录登录时长';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_login_info`
--

LOCK TABLES `yd_login_info` WRITE;
/*!40000 ALTER TABLE `yd_login_info` DISABLE KEYS */;
INSERT INTO `yd_login_info` VALUES (1,12676,'2016-04-13 08:19:54','2016-04-13 08:32:29',1),(2,15467,'2016-04-13 11:23:08','2016-04-13 11:23:10',1),(3,15467,'2016-04-13 11:34:26','2016-04-13 11:35:07',1),(4,21516,'2016-04-13 13:18:56','2016-04-13 13:23:41',1),(5,14288,'2016-04-13 13:24:40','2016-04-13 13:24:42',1),(6,33202,'2016-04-13 13:43:38','2016-04-13 13:43:51',1),(7,30646,'2016-04-13 13:44:47','2016-04-13 13:45:17',1),(8,30646,'2016-04-13 13:45:58','2016-04-13 13:48:24',1),(9,30646,'2016-04-13 13:55:20','2016-04-13 13:55:26',1),(10,33202,'2016-04-13 13:56:56','2016-04-13 13:57:44',1),(11,30646,'2016-04-13 13:57:29','2016-04-13 13:58:15',1),(12,15467,'2016-04-13 13:59:28','2016-04-13 13:59:34',1),(13,15467,'2016-04-13 14:04:47','2016-04-13 14:06:29',1),(14,15467,'2016-04-13 14:07:41','2016-04-13 14:08:31',1),(15,15467,'2016-04-13 14:11:26','2016-04-13 14:13:26',1),(16,33202,'2016-04-13 14:14:29','2016-04-13 14:14:49',1),(17,33202,'2016-04-14 01:23:04','2016-04-14 01:24:02',1),(18,42657,'2016-04-14 01:16:15','2016-04-14 01:39:06',1),(19,33202,'2016-04-14 01:40:53','2016-04-14 01:42:43',1),(20,24849,'2016-04-14 00:57:25','2016-04-14 02:14:19',1),(21,15467,'2016-04-14 05:05:41','2016-04-14 05:06:27',1),(22,15467,'2016-04-14 05:49:39','2016-04-14 05:49:54',1),(23,15467,'2016-04-14 06:05:35','2016-04-14 06:06:06',1),(24,15467,'2016-04-14 06:09:46','2016-04-14 06:09:50',1),(25,15467,'2016-04-14 06:11:17','2016-04-14 06:11:23',1),(26,15467,'2016-04-14 06:11:59','2016-04-14 06:12:07',1),(27,33202,'2016-04-14 06:12:31','2016-04-14 06:12:35',1),(28,33202,'2016-04-14 06:12:40','2016-04-14 06:12:54',1),(29,33202,'2016-04-14 06:13:33','2016-04-14 06:13:36',1),(30,33202,'2016-04-14 06:15:46','2016-04-14 06:15:49',1),(31,15467,'2016-04-14 06:18:42','2016-04-14 06:18:47',1),(32,15467,'2016-04-14 06:18:56','2016-04-14 06:18:58',1),(33,15467,'2016-04-14 06:18:59','2016-04-14 06:19:02',1),(34,33202,'2016-04-14 06:30:32','2016-04-14 06:30:54',1),(35,31175,'2016-04-14 06:23:58','2016-04-14 06:31:11',1),(36,24252,'2016-04-14 06:32:04','2016-04-14 06:32:32',1),(37,24252,'2016-04-14 06:32:34','2016-04-14 06:33:31',1),(38,24252,'2016-04-14 06:33:32','2016-04-14 06:33:45',1),(39,24252,'2016-04-14 06:45:34','2016-04-14 06:46:00',1),(40,33202,'2016-04-14 06:46:25','2016-04-14 06:46:32',1),(41,24252,'2016-04-14 06:55:00','2016-04-14 06:57:56',1),(42,24252,'2016-04-14 06:59:25','2016-04-14 07:02:29',1),(43,24252,'2016-04-14 07:06:33','2016-04-14 07:06:34',1),(44,24252,'2016-04-14 07:10:40','2016-04-14 07:10:41',1),(45,24252,'2016-04-14 07:11:32','2016-04-14 07:11:33',1),(46,33202,'2016-04-14 07:30:58','2016-04-14 07:31:05',1),(47,30646,'2016-04-14 08:55:57','2016-04-14 08:56:13',1),(48,33202,'2016-04-14 09:02:15','2016-04-14 09:02:20',1),(49,24252,'2016-04-14 09:44:39','2016-04-14 09:45:20',1),(50,24252,'2016-04-14 09:45:21','2016-04-14 09:45:30',1),(51,24252,'2016-04-14 09:45:47','2016-04-14 09:45:51',1),(52,24252,'2016-04-14 10:41:57','2016-04-14 10:42:28',1),(53,24252,'2016-04-14 10:50:44','2016-04-14 10:51:44',1),(54,24252,'2016-04-14 12:44:59','2016-04-14 12:46:03',1),(55,24252,'2016-04-14 12:48:24','2016-04-14 12:48:29',1),(56,30646,'2016-04-14 13:34:11','2016-04-14 13:35:17',1),(57,30646,'2016-04-14 13:44:04','2016-04-14 13:44:23',1),(58,31981,'2016-04-14 13:42:23','2016-04-14 13:44:38',1),(59,31981,'2016-04-14 13:46:33','2016-04-14 13:46:44',1),(60,30646,'2016-04-14 13:46:54','2016-04-14 13:47:35',1),(61,31981,'2016-04-14 13:47:00','2016-04-14 13:47:47',1),(62,31981,'2016-04-14 13:48:30','2016-04-14 13:48:42',1),(63,31981,'2016-04-14 13:48:52','2016-04-14 13:49:49',1),(64,31981,'2016-04-14 13:50:01','2016-04-14 13:50:53',1),(65,31981,'2016-04-14 13:52:46','2016-04-14 13:53:03',1),(66,30646,'2016-04-14 14:48:34','2016-04-14 14:53:20',1),(67,30646,'2016-04-14 14:53:37','2016-04-14 15:04:51',1),(68,30646,'2016-04-14 15:12:59','2016-04-14 15:14:26',1),(69,24252,'2016-04-14 16:52:21','2016-04-14 16:54:10',1),(70,24252,'2016-04-14 16:57:06','2016-04-14 16:59:36',1),(71,24252,'2016-04-14 23:52:42','2016-04-14 23:54:15',1),(72,30646,'2016-04-15 01:22:33','2016-04-15 01:26:28',1),(73,33202,'2016-04-15 01:30:46','2016-04-15 01:31:33',1),(74,33202,'2016-04-15 01:32:44','2016-04-15 01:34:31',1),(75,33202,'2016-04-15 01:36:18','2016-04-15 01:40:43',1),(76,24252,'2016-04-15 02:04:50','2016-04-15 02:05:42',1),(77,24252,'2016-04-15 02:05:43','2016-04-15 02:07:31',1),(78,30646,'2016-04-15 02:56:18','2016-04-15 02:56:39',1),(79,24252,'2016-04-15 03:48:49','2016-04-15 03:52:31',1),(80,24252,'2016-04-15 03:53:52','2016-04-15 03:56:49',1),(81,24252,'2016-04-15 03:59:47','2016-04-15 03:59:49',1),(82,33202,'2016-04-15 09:02:38','2016-04-15 09:03:17',1),(83,33202,'2016-04-15 09:12:04','2016-04-15 09:12:21',1),(84,24252,'2016-04-15 09:41:13','2016-04-15 09:41:45',1),(85,24252,'2016-04-15 09:54:54','2016-04-15 09:54:56',1),(86,33202,'2016-04-15 09:54:51','2016-04-15 09:55:06',1),(87,24252,'2016-04-15 10:22:26','2016-04-15 10:23:59',1),(88,24252,'2016-04-15 10:51:26','2016-04-15 10:51:52',1),(89,24252,'2016-04-15 10:51:53','2016-04-15 10:51:59',1),(90,24252,'2016-04-15 10:52:39','2016-04-15 10:53:18',1),(91,24252,'2016-04-15 10:53:22','2016-04-15 10:53:34',1),(92,24252,'2016-04-15 10:53:43','2016-04-15 10:56:12',1),(93,24252,'2016-04-15 11:15:47','2016-04-15 11:17:52',1),(94,24252,'2016-04-15 11:23:27','2016-04-15 11:23:38',1),(95,24252,'2016-04-15 12:00:29','2016-04-15 12:01:55',1),(96,30646,'2016-04-15 12:20:37','2016-04-15 12:21:11',1),(97,30646,'2016-04-15 12:26:09','2016-04-15 12:28:07',1),(98,33202,'2016-04-15 12:47:00','2016-04-15 12:47:22',1),(99,33202,'2016-04-15 12:47:23','2016-04-15 12:47:25',1),(100,24252,'2016-04-15 13:12:34','2016-04-15 13:13:01',1),(101,33202,'2016-04-15 13:21:26','2016-04-15 13:21:33',1),(102,30646,'2016-04-15 14:36:27','2016-04-15 14:37:01',1),(103,30646,'2016-04-15 15:44:26','2016-04-15 15:46:27',1),(104,30646,'2016-04-15 15:46:30','2016-04-15 15:46:36',1),(105,30646,'2016-04-16 00:22:27','2016-04-16 00:23:02',1),(106,24252,'2016-04-16 00:46:38','2016-04-16 00:47:40',1),(107,24252,'2016-04-16 01:04:15','2016-04-16 01:05:33',1),(108,33202,'2016-04-16 12:46:56','2016-04-16 12:47:05',1),(109,30646,'2016-04-16 14:58:51','2016-04-16 14:59:09',1),(110,16828,'2016-04-17 03:13:54','2016-04-17 03:15:44',1),(111,16828,'2016-04-17 03:15:45','2016-04-17 03:15:59',1),(112,16828,'2016-04-17 03:24:07','2016-04-17 03:24:17',1),(113,16828,'2016-04-17 03:39:57','2016-04-17 03:40:50',1),(114,16828,'2016-04-17 05:09:22','2016-04-17 05:09:26',1),(115,16828,'2016-04-17 06:10:44','2016-04-17 06:11:30',1),(116,33202,'2016-04-17 07:14:34','2016-04-17 07:14:46',1),(117,30646,'2016-04-17 14:20:02','2016-04-17 14:21:21',1),(118,16828,'2016-04-18 01:39:17','2016-04-18 01:39:19',1),(119,33202,'2016-04-18 01:48:16','2016-04-18 01:48:36',1),(120,32164,'2016-04-18 05:40:52','2016-04-18 05:43:01',1),(121,32164,'2016-04-18 05:43:12','2016-04-18 05:43:37',1),(122,32164,'2016-04-18 05:43:47','2016-04-18 05:43:53',1),(123,32164,'2016-04-18 05:45:29','2016-04-18 05:45:36',1),(124,33202,'2016-04-18 06:28:36','2016-04-18 06:28:55',1),(125,33202,'2016-04-18 07:18:51','2016-04-18 07:20:11',1),(126,30646,'2016-04-19 08:39:11','2016-04-19 08:39:53',1),(127,16828,'2016-04-21 01:28:11','2016-04-21 01:31:01',1),(128,30646,'2016-04-21 02:49:34','2016-04-21 02:51:42',1),(129,16828,'2016-04-22 07:12:00','2016-04-22 07:12:53',1),(130,33202,'2016-04-22 13:33:41','2016-04-22 13:34:04',1),(131,33202,'2016-04-22 14:04:25','2016-04-22 14:04:36',1),(132,33202,'2016-04-22 14:26:28','2016-04-22 14:26:42',1),(133,33202,'2016-04-22 14:26:43','2016-04-22 14:27:13',1),(134,23560,'2016-04-22 19:00:25','2016-04-22 19:01:48',1),(135,23560,'2016-04-22 19:01:51','2016-04-22 19:02:22',1),(136,23560,'2016-04-22 19:02:25','2016-04-22 19:09:25',1),(137,23560,'2016-04-22 19:09:28','2016-04-22 19:14:22',1),(138,23560,'2016-04-22 19:20:31','2016-04-22 19:21:46',1),(139,33202,'2016-04-23 01:25:58','2016-04-23 01:26:31',1),(140,32164,'2016-04-23 01:41:07','2016-04-23 01:42:03',1),(141,30747,'2016-04-23 01:39:01','2016-04-23 01:42:19',1),(142,30747,'2016-04-23 01:42:23','2016-04-23 01:43:06',1),(143,32164,'2016-04-23 01:44:13','2016-04-23 01:44:43',1),(144,30747,'2016-04-23 01:43:11','2016-04-23 01:45:04',1),(145,32164,'2016-04-23 01:44:56','2016-04-23 01:45:23',1),(146,30747,'2016-04-23 01:45:07','2016-04-23 01:46:01',1),(147,30747,'2016-04-23 01:46:04','2016-04-23 01:47:28',1),(148,32164,'2016-04-23 01:45:50','2016-04-23 01:49:42',1),(149,30747,'2016-04-23 01:47:32','2016-04-23 01:50:33',1),(150,30747,'2016-04-23 01:50:53','2016-04-23 01:52:59',1),(151,30747,'2016-04-23 05:16:18','2016-04-23 05:19:30',1),(152,30747,'2016-04-23 05:39:16','2016-04-23 05:41:38',1),(153,32164,'2016-04-23 07:02:06','2016-04-23 07:02:24',1),(154,32164,'2016-04-23 07:03:31','2016-04-23 07:03:42',1),(155,30139,'2016-04-23 07:05:28','2016-04-23 07:06:03',1),(156,30139,'2016-04-23 07:13:04','2016-04-23 07:13:39',1),(157,30747,'2016-04-23 07:41:24','2016-04-23 07:44:02',1),(158,30747,'2016-04-23 09:12:19','2016-04-23 09:12:47',1),(159,30747,'2016-04-23 09:15:22','2016-04-23 09:15:35',1),(160,30747,'2016-04-23 10:51:43','2016-04-23 10:54:00',1),(161,30747,'2016-04-23 11:29:24','2016-04-23 11:37:31',1),(162,30747,'2016-04-23 11:37:33','2016-04-23 11:39:01',1),(163,30747,'2016-04-23 11:39:49','2016-04-23 11:39:53',1),(164,30747,'2016-04-23 14:26:29','2016-04-23 14:33:01',1),(165,30747,'2016-04-23 14:35:02','2016-04-23 14:35:05',1),(166,30747,'2016-04-23 14:38:37','2016-04-23 14:41:38',1),(167,30747,'2016-04-23 14:42:17','2016-04-23 14:42:59',1),(168,33202,'2016-04-23 14:53:37','2016-04-23 14:53:54',1),(169,30747,'2016-04-24 04:33:57','2016-04-24 04:34:58',1),(170,30747,'2016-04-24 10:14:47','2016-04-24 10:15:33',1),(171,30747,'2016-04-25 02:19:59','2016-04-25 02:20:19',1),(172,30646,'2016-04-25 05:10:28','2016-04-25 05:13:18',1),(173,32164,'2016-04-25 08:29:22','2016-04-25 08:29:28',1),(174,30646,'2016-04-25 12:30:07','2016-04-25 12:31:25',1),(175,30747,'2016-04-26 04:20:30','2016-04-26 04:22:08',1),(176,30747,'2016-04-26 04:27:21','2016-04-26 04:28:03',1),(177,30747,'2016-04-26 04:28:05','2016-04-26 04:35:39',1),(178,30747,'2016-04-26 04:47:54','2016-04-26 04:48:04',1),(179,30747,'2016-04-26 12:46:14','2016-04-26 12:47:13',1),(180,30747,'2016-04-27 04:46:45','2016-04-27 04:46:58',1),(181,30747,'2016-04-27 04:47:02','2016-04-27 04:47:44',1),(182,30747,'2016-04-27 04:47:47','2016-04-27 04:48:37',1),(183,30747,'2016-04-27 09:29:11','2016-04-27 09:29:16',1),(184,30747,'2016-04-27 09:29:18','2016-04-27 09:30:08',1),(185,30747,'2016-04-28 02:34:24','2016-04-28 02:34:47',1),(186,30747,'2016-04-28 02:34:51','2016-04-28 02:35:26',1),(187,30747,'2016-04-28 09:02:24','2016-04-28 09:03:06',1),(188,30747,'2016-04-28 09:03:23','2016-04-28 09:03:49',1),(189,30747,'2016-04-28 09:03:50','2016-04-28 09:09:02',1),(190,30747,'2016-04-28 09:23:03','2016-04-28 09:29:06',1),(191,30747,'2016-04-28 09:32:23','2016-04-28 09:32:25',1),(192,30747,'2016-04-28 09:50:51','2016-04-28 09:50:56',1),(193,30747,'2016-04-28 09:50:58','2016-04-28 09:51:21',1),(194,30747,'2016-04-29 10:58:01','2016-04-29 10:58:07',1),(195,30747,'2016-04-29 10:58:08','2016-04-29 10:58:35',1),(196,30747,'2016-04-29 11:12:19','2016-04-29 11:12:23',1),(197,33202,'2016-05-20 09:02:36','2016-05-20 09:02:44',1),(198,33202,'2016-05-20 09:02:47','2016-05-20 09:03:31',1),(199,33202,'2016-05-20 09:03:32','2016-05-20 09:05:17',1),(200,18166,'2016-06-06 10:26:49','2016-06-06 10:27:33',1),(201,33202,'2016-06-06 10:29:39','2016-06-06 10:29:43',1),(202,18166,'2016-06-30 14:49:54','2016-06-30 14:50:14',1),(203,16855,'2016-10-23 02:39:58','2016-10-23 02:41:05',1),(204,16855,'2016-10-23 02:41:29','2016-10-23 02:47:50',1),(205,33939,'2017-03-01 09:28:42','2017-03-01 09:30:54',1),(206,33939,'2017-03-01 09:31:00','2017-03-01 09:36:08',1),(207,34932,'2017-03-01 09:26:12','2017-03-01 09:36:51',1),(208,36008,'2017-03-01 09:36:58','2017-03-01 09:38:33',1),(209,33939,'2017-03-01 09:37:17','2017-03-01 09:40:03',1),(210,36008,'2017-03-01 09:38:39','2017-03-01 09:41:24',1),(211,33939,'2017-03-01 09:40:05','2017-03-01 09:41:30',1),(212,36008,'2017-03-01 09:42:45','2017-03-01 09:44:32',1),(213,33939,'2017-03-01 09:42:12','2017-03-01 09:50:37',1),(214,33939,'2017-03-01 09:50:37','2017-03-01 10:03:01',1),(215,36008,'2017-03-01 09:44:32','2017-03-01 10:03:38',1),(216,21546,'2017-04-10 09:17:07','2017-04-10 10:05:06',1),(217,37579,'2017-04-14 03:08:18','2017-04-14 03:18:25',1),(218,19337,'2017-04-14 03:12:46','2017-04-14 03:18:25',1);
/*!40000 ALTER TABLE `yd_login_info` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_notice`
--

DROP TABLE IF EXISTS `yd_notice`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_notice` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `notice_type` int(11) NOT NULL COMMENT '通知事件类型',
  `sender_id` int(11) NOT NULL COMMENT '发起人',
  `notice_title` varchar(255) NOT NULL COMMENT '通知时间的标题',
  `notice_content` varchar(520) NOT NULL COMMENT '通知事件具体内容20',
  `receiver_id` int(11) NOT NULL COMMENT '接收人',
  `is_viewed` int(11) NOT NULL DEFAULT '0' COMMENT '是否被查阅',
  `time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '发起时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='系统通知表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_notice`
--

LOCK TABLES `yd_notice` WRITE;
/*!40000 ALTER TABLE `yd_notice` DISABLE KEYS */;
/*!40000 ALTER TABLE `yd_notice` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_post`
--

DROP TABLE IF EXISTS `yd_post`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_post` (
  `post_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '说说逻辑主键',
  `leader_id` int(11) NOT NULL COMMENT '用户leader_id号',
  `content` varchar(500) DEFAULT '' COMMENT '用户上传的文字',
  `share_id` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否转发的标志，可以扩展,为0 表示第三方分享',
  `post_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '说说发表时间',
  `is_valid` int(11) NOT NULL DEFAULT '1' COMMENT '是否有效',
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COMMENT='朋友圈说说';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_post`
--

LOCK TABLES `yd_post` WRITE;
/*!40000 ALTER TABLE `yd_post` DISABLE KEYS */;
INSERT INTO `yd_post` VALUES (1,30646,'[微笑][微笑][微笑][偷笑]',1,'2016-04-13 13:47:34',1),(2,30646,'',1,'2016-04-14 14:51:54',1),(3,30646,'',1,'2016-04-14 14:52:16',1),(4,30646,'',1,'2016-04-15 15:45:51',1),(5,34932,'西乡天虹千味唰挤爆了！[吓][吓][吓]',1,'2017-03-01 09:35:40',1);
/*!40000 ALTER TABLE `yd_post` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_post_favorite`
--

DROP TABLE IF EXISTS `yd_post_favorite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_post_favorite` (
  `favorite_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '用户点赞ID',
  `post_id` bigint(20) NOT NULL COMMENT '说说id',
  `leader_id` int(11) NOT NULL COMMENT '点赞的好友leader_id',
  `favorite_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '点赞的时间',
  `is_valid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否有效',
  PRIMARY KEY (`favorite_id`),
  UNIQUE KEY `P_L_id_UNIQUE` (`post_id`,`leader_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='朋友圈说说点赞';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_post_favorite`
--

LOCK TABLES `yd_post_favorite` WRITE;
/*!40000 ALTER TABLE `yd_post_favorite` DISABLE KEYS */;
INSERT INTO `yd_post_favorite` VALUES (1,1,24252,'2016-04-14 09:45:08',1);
/*!40000 ALTER TABLE `yd_post_favorite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_post_img`
--

DROP TABLE IF EXISTS `yd_post_img`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_post_img` (
  `img_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '说说照片ID',
  `post_id` bigint(20) NOT NULL COMMENT '朋友圈post_id',
  `img_url` varchar(255) NOT NULL COMMENT '用户上传的图片',
  `create_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '图片上传时间',
  `is_valid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否有效',
  PRIMARY KEY (`img_id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='朋友圈说说照片';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_post_img`
--

LOCK TABLES `yd_post_img` WRITE;
/*!40000 ALTER TABLE `yd_post_img` DISABLE KEYS */;
INSERT INTO `yd_post_img` VALUES (1,2,'','2016-04-14 14:51:54',1),(2,2,'','2016-04-14 14:51:54',1),(3,2,'','2016-04-14 14:51:54',1),(4,2,'','2016-04-14 14:51:54',1),(5,2,'','2016-04-14 14:51:54',1),(6,3,'img/friend_circle/2016_04_14-22_51_58-4268.png','2016-04-14 14:52:16',1),(7,3,'','2016-04-14 14:52:16',1),(8,3,'','2016-04-14 14:52:16',1),(9,3,'','2016-04-14 14:52:16',1),(10,3,'img/friend_circle/2016_04_14-22_51_54-8174.png','2016-04-14 14:52:16',1),(11,4,'img/friend_circle/2016_04_15-23_45_50-4891.png','2016-04-15 15:45:51',1),(12,4,'','2016-04-15 15:45:51',1),(13,4,'','2016-04-15 15:45:51',1),(14,4,'','2016-04-15 15:45:51',1),(15,5,'','2017-03-01 09:35:41',1),(16,5,'','2017-03-01 09:35:41',1);
/*!40000 ALTER TABLE `yd_post_img` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_post_img_favorite`
--

DROP TABLE IF EXISTS `yd_post_img_favorite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_post_img_favorite` (
  `favorite_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '图片点赞id',
  `img_id` bigint(20) NOT NULL COMMENT '图片id',
  `leader_id` int(11) NOT NULL COMMENT '点赞的好友leader_id',
  `favorite_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '点赞的时间',
  PRIMARY KEY (`favorite_id`),
  UNIQUE KEY `I_L_id_UNIQUE` (`img_id`,`leader_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='朋友圈说说图片点赞';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_post_img_favorite`
--

LOCK TABLES `yd_post_img_favorite` WRITE;
/*!40000 ALTER TABLE `yd_post_img_favorite` DISABLE KEYS */;
/*!40000 ALTER TABLE `yd_post_img_favorite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_post_img_review`
--

DROP TABLE IF EXISTS `yd_post_img_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_post_img_review` (
  `review_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `img_id` bigint(20) NOT NULL COMMENT '图片id',
  `leader_id` int(11) NOT NULL COMMENT '评论用户leader_id号',
  `review_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '评论时间',
  `content` varchar(255) NOT NULL COMMENT '评论内容',
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='朋友圈说说图片评论';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_post_img_review`
--

LOCK TABLES `yd_post_img_review` WRITE;
/*!40000 ALTER TABLE `yd_post_img_review` DISABLE KEYS */;
/*!40000 ALTER TABLE `yd_post_img_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_post_review`
--

DROP TABLE IF EXISTS `yd_post_review`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_post_review` (
  `review_id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `post_id` bigint(20) NOT NULL COMMENT '说说ID',
  `leader_id` int(11) NOT NULL COMMENT '评论用户leader_id号',
  `content` varchar(255) NOT NULL COMMENT '评论内容',
  `review_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '评论时间',
  `is_valid` tinyint(4) NOT NULL DEFAULT '1',
  PRIMARY KEY (`review_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='朋友圈说说评论';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_post_review`
--

LOCK TABLES `yd_post_review` WRITE;
/*!40000 ALTER TABLE `yd_post_review` DISABLE KEYS */;
INSERT INTO `yd_post_review` VALUES (1,1,24252,'楼上的好帅！[鼓掌]','2016-04-14 06:26:07',1);
/*!40000 ALTER TABLE `yd_post_review` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_right`
--

DROP TABLE IF EXISTS `yd_right`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `right_code` varchar(30) DEFAULT NULL COMMENT '权限代号',
  `right_name` varchar(50) DEFAULT NULL COMMENT '权限名称',
  `right_desc` varchar(255) DEFAULT NULL COMMENT '权限描述',
  `is_valid` int(11) DEFAULT '1' COMMENT '是否有效',
  `create_by` int(11) DEFAULT NULL COMMENT '创建人',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_right`
--

LOCK TABLES `yd_right` WRITE;
/*!40000 ALTER TABLE `yd_right` DISABLE KEYS */;
/*!40000 ALTER TABLE `yd_right` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_role`
--

DROP TABLE IF EXISTS `yd_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_role` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `role_code` varchar(20) DEFAULT NULL COMMENT '角色代号',
  `role_name` varchar(50) DEFAULT NULL COMMENT '角色名称',
  `role_desc` varchar(255) DEFAULT NULL COMMENT '角色描述',
  `is_valid` int(11) DEFAULT '1' COMMENT '是否有效',
  `create_by` int(11) DEFAULT NULL COMMENT '创建人',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_role`
--

LOCK TABLES `yd_role` WRITE;
/*!40000 ALTER TABLE `yd_role` DISABLE KEYS */;
/*!40000 ALTER TABLE `yd_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_role_right`
--

DROP TABLE IF EXISTS `yd_role_right`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_role_right` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `role_id` int(11) NOT NULL COMMENT '关联的角色ID',
  `right_id` int(11) NOT NULL COMMENT '关联的权限ID',
  `is_valid` int(11) NOT NULL DEFAULT '1' COMMENT '是否有效',
  `create_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='角色权限关联表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_role_right`
--

LOCK TABLES `yd_role_right` WRITE;
/*!40000 ALTER TABLE `yd_role_right` DISABLE KEYS */;
/*!40000 ALTER TABLE `yd_role_right` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_to_join_group`
--

DROP TABLE IF EXISTS `yd_to_join_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_to_join_group` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `group_id` bigint(20) NOT NULL COMMENT '群ID号',
  `is_approve` int(11) DEFAULT '0' COMMENT '客户是否已同意加入私密群',
  `is_valid` int(11) DEFAULT '1' COMMENT '是否有效',
  `approve_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '客户同意加入私密群的日期',
  PRIMARY KEY (`id`,`group_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='等待客户同意加入群的消息列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_to_join_group`
--

LOCK TABLES `yd_to_join_group` WRITE;
/*!40000 ALTER TABLE `yd_to_join_group` DISABLE KEYS */;
/*!40000 ALTER TABLE `yd_to_join_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_unread_group_msg`
--

DROP TABLE IF EXISTS `yd_unread_group_msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_unread_group_msg` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `group_id` int(11) NOT NULL COMMENT '群ID号',
  `leader_id` int(11) NOT NULL COMMENT '用户ID号',
  `count` int(11) NOT NULL DEFAULT '1' COMMENT '未读消息数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `G_L_id_UNIQUE` (`group_id`,`leader_id`)
) ENGINE=InnoDB AUTO_INCREMENT=194 DEFAULT CHARSET=utf8 COMMENT='未读群聊列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_unread_group_msg`
--

LOCK TABLES `yd_unread_group_msg` WRITE;
/*!40000 ALTER TABLE `yd_unread_group_msg` DISABLE KEYS */;
INSERT INTO `yd_unread_group_msg` VALUES (1,10000,34525,1),(2,10000,12422,1),(3,10000,40986,1),(4,10000,22382,0),(5,10000,14358,11),(6,10000,19713,11),(7,10000,14327,11),(8,10000,34943,11),(9,10000,15467,9),(10,10000,21516,11),(11,10000,14288,11),(12,10000,33202,5),(13,10000,30646,6),(14,10000,24849,9),(15,10000,42657,10),(38,10000,31175,9),(39,10000,24252,2),(40,10000,31981,9),(41,10001,30646,0),(73,10000,16828,1),(89,10000,32164,5),(90,10000,30747,5),(106,10000,30139,5),(107,10000,18166,5),(108,10000,16855,4),(127,10000,34932,4),(128,10000,33939,4),(129,10000,36008,1),(193,10000,21546,1);
/*!40000 ALTER TABLE `yd_unread_group_msg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_unread_user_msg`
--

DROP TABLE IF EXISTS `yd_unread_user_msg`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_unread_user_msg` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `sender_id` int(11) NOT NULL COMMENT '发送者ID号',
  `receiver_id` int(11) NOT NULL COMMENT '接受者ID号',
  `count` int(11) NOT NULL DEFAULT '1' COMMENT '未读消息数',
  PRIMARY KEY (`id`),
  UNIQUE KEY `S_R_id_UNIQUE` (`sender_id`,`receiver_id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8 COMMENT='未读私聊列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_unread_user_msg`
--

LOCK TABLES `yd_unread_user_msg` WRITE;
/*!40000 ALTER TABLE `yd_unread_user_msg` DISABLE KEYS */;
INSERT INTO `yd_unread_user_msg` VALUES (1,32164,24252,1),(2,32164,30747,0),(3,30747,32164,0),(4,34932,33939,1),(5,33939,34932,1),(9,33939,36008,0),(11,36008,33939,2),(14,37579,34932,1),(15,19337,37579,0),(16,37579,19337,3);
/*!40000 ALTER TABLE `yd_unread_user_msg` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_user`
--

DROP TABLE IF EXISTS `yd_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `leader_id` int(11) NOT NULL COMMENT '立德ID号',
  `user_name` varchar(25) NOT NULL COMMENT '用户名称',
  `user_mobile` varchar(25) DEFAULT NULL COMMENT '用户手机',
  `user_job` varchar(25) DEFAULT NULL COMMENT '用户工作',
  `user_company` varchar(255) DEFAULT NULL COMMENT '用户所在单位',
  `user_field` varchar(255) DEFAULT NULL COMMENT '用户所在行业领域',
  `avatar` varchar(255) NOT NULL COMMENT '用户头像',
  `is_allow_speak` int(11) DEFAULT NULL COMMENT '是否允许发言 0禁言中 1禁言解除',
  `is_online` int(11) NOT NULL DEFAULT '0' COMMENT '是否在线',
  `register_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '用户注册时间',
  `is_authentication` int(11) NOT NULL DEFAULT '1' COMMENT '用户是否通过验证',
  `is_valid` int(11) NOT NULL DEFAULT '1' COMMENT '是否有效',
  PRIMARY KEY (`id`),
  UNIQUE KEY `leader_id_UNIQUE` (`leader_id`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8 COMMENT='用户表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_user`
--

LOCK TABLES `yd_user` WRITE;
/*!40000 ALTER TABLE `yd_user` DISABLE KEYS */;
INSERT INTO `yd_user` VALUES (6,21516,'小熊','13701298053',NULL,NULL,NULL,'img/avatar_upload/2016_04_13-21_18_53-1078.png',NULL,0,'2016-04-13 13:18:56',1,1),(7,14288,'小熊','13701298053',NULL,NULL,NULL,'img/avatar_upload/2016_04_13-21_18_53-1078.png',NULL,0,'2016-04-13 13:24:40',1,1),(8,33202,'Andy','13510141217',NULL,NULL,NULL,'img/avatar_upload/2016_04_13-21_43_06-4455.png',NULL,0,'2016-04-13 13:43:38',1,1),(9,30646,'一斗','13828708788',NULL,NULL,NULL,'img/avatar_upload/2016_04_13-21_44_23-7959.png',NULL,0,'2016-04-13 13:44:47',1,1),(10,24849,'Wendy','18070156910',NULL,NULL,NULL,'img/avatar_upload/2016_04_14-08_56_55-2338.png',NULL,0,'2016-04-14 00:57:25',1,1),(11,42657,'lixue','15210086872',NULL,NULL,NULL,'img/avatar_upload/2016_04_14-09_15_59-5122.png',NULL,0,'2016-04-14 01:16:15',1,1),(14,31981,'Miko','13560758393',NULL,NULL,NULL,'img/avatar_upload/2016_04_14-21_42_17-8430.png',NULL,0,'2016-04-14 13:42:22',1,1),(16,32164,'Wendy','18070156910',NULL,NULL,NULL,'img/avatar_upload/2016_04_18-13_40_14-2833.png',NULL,0,'2016-04-18 05:40:52',1,1),(18,30747,'runner','18902835726',NULL,'立德',NULL,'img/avatar_upload/2016_04_23-09_37_42-7366.png',NULL,0,'2016-04-20 16:39:01',1,1),(19,30139,'mabey','15170441255',NULL,NULL,NULL,'img/avatar_upload/2016_04_23-15_05_26-4674.png',NULL,0,'2016-04-23 07:05:27',1,1),(20,18166,'一斗','13828708788',NULL,NULL,NULL,'img/avatar_upload/2016_06_06-18_26_29-1903.png',NULL,0,'2016-06-06 10:26:47',1,1),(21,16855,'yui','18902835726',NULL,'空调',NULL,'img/avatar_upload/2016_10_23-10_39_26-7993.png',NULL,0,'2016-10-23 02:39:57',1,1),(22,34932,'tom','18902835726',NULL,NULL,NULL,'img/avatar_upload/2017_03_01-17_25_34-2850.png',NULL,0,'2017-03-01 09:26:11',1,1),(23,33939,'华为','18902835726','云计算工程师','华为技术有限公司','大数据分析','img/avatar_upload/2017_03_01-17_28_12-2315.png',NULL,0,'2016-04-01 09:28:41',1,1),(24,36008,'tom','18902835726','全栈工程师','立德高科','互联网','img/avatar_upload/2017_03_01-17_25_34-2850.png',NULL,0,'2016-05-01 09:36:58',1,1),(25,21546,'codewe','18902835726',NULL,NULL,NULL,'img/avatar_upload/2017_04_10-17_16_04-2463.png',NULL,0,'2017-04-10 09:17:07',1,1),(26,37579,'google','18902835726',NULL,NULL,NULL,'img/avatar_upload/2017_04_14-11_07_00-3134.png',NULL,0,'2017-04-14 03:08:17',1,1),(27,19337,'华为','18902835726',NULL,NULL,NULL,'img/avatar_upload/2017_04_14-11_11_59-3629.png',NULL,0,'2017-04-14 03:12:46',1,1);
/*!40000 ALTER TABLE `yd_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `yd_user_follow`
--

DROP TABLE IF EXISTS `yd_user_follow`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `yd_user_follow` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `leader_id` int(11) NOT NULL COMMENT '用户leader_id号',
  `follow_id` int(11) NOT NULL DEFAULT '0' COMMENT '被关注的用户leader_id号',
  `is_valid` tinyint(4) NOT NULL DEFAULT '1' COMMENT '是否有效',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COMMENT='用户关注列表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `yd_user_follow`
--

LOCK TABLES `yd_user_follow` WRITE;
/*!40000 ALTER TABLE `yd_user_follow` DISABLE KEYS */;
INSERT INTO `yd_user_follow` VALUES (1,42657,24849,1),(2,31175,21516,1),(3,31175,14288,1),(4,31175,33202,1),(5,31175,30646,1),(6,31175,24849,1),(7,31175,42657,1),(8,31175,31175,1),(9,24252,21516,1),(10,24252,14288,1),(11,24252,33202,1),(12,24252,30646,1),(13,24252,24849,1),(14,24252,42657,1),(15,24252,31175,1),(16,24252,24252,1),(17,24252,31981,1),(18,16828,21516,1),(19,16828,14288,1),(20,16828,33202,1),(21,16828,30646,1),(22,16828,24849,1),(23,16828,42657,1),(24,16828,24252,1),(25,16828,31981,1),(26,16828,16828,1),(27,32164,24252,1),(28,23560,30646,1),(29,30747,30646,1),(30,16855,30747,1),(31,34932,33939,1),(32,33939,34932,1),(33,36008,33939,1),(34,21546,30646,1),(35,21546,24849,1),(36,21546,30747,1);
/*!40000 ALTER TABLE `yd_user_follow` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping events for database 'yidou_chat'
--

--
-- Dumping routines for database 'yidou_chat'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2017-04-20 15:36:58
