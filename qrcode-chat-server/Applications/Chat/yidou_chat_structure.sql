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

-- Dump completed on 2017-04-20 15:37:49
