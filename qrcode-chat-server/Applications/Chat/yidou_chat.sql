CREATE DATABASE  IF NOT EXISTS `yidou_chat` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `yidou_chat`;
-- MySQL dump 10.13  Distrib 5.6.13, for Win32 (x86)
--
-- Host: 218.17.71.42    Database: yidou_chat
-- ------------------------------------------------------
-- Server version	5.6.28

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
-- Table structure for table `ydct_base_right`
--

DROP TABLE IF EXISTS `ydct_base_right`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ydct_base_right` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `Right_Code` varchar(20) DEFAULT NULL COMMENT '权限编码',
  `Right_Name` varchar(50) DEFAULT NULL COMMENT '权限名称',
  `Right_Desc` varchar(255) DEFAULT NULL COMMENT '权限描述',
  `isValid` int(11) DEFAULT '1' COMMENT '是否有效1有效0无效',
  `CreateBy` int(11) DEFAULT NULL COMMENT '创建人',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `UpdateBy` int(11) DEFAULT NULL COMMENT '修改人',
  `UpdateDate` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COMMENT='权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ydct_base_right`
--

LOCK TABLES `ydct_base_right` WRITE;
/*!40000 ALTER TABLE `ydct_base_right` DISABLE KEYS */;
INSERT INTO `ydct_base_right` VALUES (1,'creategroup','创建群','创建聊天群',1,NULL,'2016-01-21 02:51:02',NULL,NULL),(2,'deletegroup','解散群','解散聊天群',1,NULL,'2016-01-21 02:51:02',NULL,NULL),(3,'deletemember','移除成员','移除聊天群成员',1,NULL,'2016-01-21 02:51:02',NULL,NULL),(4,'uploadgroupphoto','上传群照片','上传聊天群照片',1,NULL,'2016-01-21 02:51:02',NULL,NULL),(5,'updategroupbrief','更新群简介','更新群简介',1,NULL,'2016-01-21 02:51:02',NULL,NULL),(6,'joingroup','加入群','加入群',1,NULL,'2016-01-21 02:58:59',NULL,NULL);
/*!40000 ALTER TABLE `ydct_base_right` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ydct_base_role`
--

DROP TABLE IF EXISTS `ydct_base_role`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ydct_base_role` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `Role_Code` varchar(20) DEFAULT NULL COMMENT '角色编码',
  `Role_Name` varchar(50) DEFAULT NULL COMMENT '角色名称',
  `Role_Desc` varchar(255) DEFAULT NULL COMMENT '角色描述',
  `isValid` int(11) DEFAULT '1' COMMENT '是否有效1有效0无效',
  `CreateBy` int(11) DEFAULT NULL COMMENT '创建人',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `UpdateBy` int(11) DEFAULT NULL COMMENT '修改人',
  `UpdateDate` datetime DEFAULT NULL COMMENT '修改时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='角色表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ydct_base_role`
--

LOCK TABLES `ydct_base_role` WRITE;
/*!40000 ALTER TABLE `ydct_base_role` DISABLE KEYS */;
INSERT INTO `ydct_base_role` VALUES (1,'admin','超级管理员','超级管理员',1,NULL,'2016-01-21 02:52:59',NULL,NULL),(2,'user','一般用户','一般用户',1,NULL,'2016-01-21 02:52:59',NULL,NULL);
/*!40000 ALTER TABLE `ydct_base_role` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ydct_base_role_right`
--

DROP TABLE IF EXISTS `ydct_base_role_right`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ydct_base_role_right` (
  `ID` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `Role_ID` int(11) DEFAULT NULL COMMENT '角色ID',
  `Right_ID` int(11) DEFAULT NULL COMMENT '权限ID',
  `isValid` int(11) DEFAULT '1' COMMENT '是否有效1有效0无效',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COMMENT='角色权限表';
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ydct_base_role_right`
--

LOCK TABLES `ydct_base_role_right` WRITE;
/*!40000 ALTER TABLE `ydct_base_role_right` DISABLE KEYS */;
INSERT INTO `ydct_base_role_right` VALUES (1,1,1,1,'2016-01-21 02:58:00'),(2,1,2,1,'2016-01-21 02:58:01'),(3,1,3,1,'2016-01-21 02:58:01'),(4,1,4,1,'2016-01-21 02:58:01'),(5,1,5,1,'2016-01-21 02:58:01'),(6,1,6,1,'2016-01-21 02:59:16'),(7,2,6,1,'2016-01-21 02:59:16');
/*!40000 ALTER TABLE `ydct_base_role_right` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ydct_base_user`
--

DROP TABLE IF EXISTS `ydct_base_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ydct_base_user` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `User_Name` varchar(50) DEFAULT NULL COMMENT '用户姓名',
  `User_Mobile` varchar(20) DEFAULT NULL COMMENT '用户手机号',
  `User_Job` varchar(50) DEFAULT NULL COMMENT '职业',
  `User_Company` varchar(50) DEFAULT NULL COMMENT '公司名称',
  `User_Belong_Industry` varchar(50) DEFAULT NULL COMMENT '所属行业',
  `User_Head_Image` varchar(255) DEFAULT NULL COMMENT '用户头像',
  `Latest_Login` datetime DEFAULT NULL COMMENT '最近登录时间',
  `isValid` int(11) DEFAULT '1' COMMENT '是否有效1有效0无效',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  `User_Role` int(11) DEFAULT '2' COMMENT '用户角色',
  `isAuthentication` int(11) DEFAULT '0' COMMENT '是否经过认证1认证0未认证',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户表'
/*!50100 PARTITION BY LINEAR HASH (ID%100)
PARTITIONS 100 */;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ydct_base_user`
--

LOCK TABLES `ydct_base_user` WRITE;
/*!40000 ALTER TABLE `ydct_base_user` DISABLE KEYS */;
INSERT INTO `ydct_base_user` VALUES (1,'liarby','1233',NULL,NULL,NULL,NULL,NULL,1,'2016-01-21 09:13:31',2,1),(2,'liarby2','12334',NULL,NULL,NULL,NULL,NULL,1,'2016-01-21 09:13:33',2,1);
/*!40000 ALTER TABLE `ydct_base_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ydct_bus_chatrecord`
--

DROP TABLE IF EXISTS `ydct_bus_chatrecord`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ydct_bus_chatrecord` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `Group_ID` bigint(20) NOT NULL DEFAULT '0' COMMENT '群ID',
  `User_ID` bigint(20) DEFAULT NULL COMMENT '用户ID',
  `Chat_Text` text COMMENT '文字',
  `Chat_Img` varchar(255) DEFAULT NULL COMMENT '图片',
  `Chat_Voice` varchar(255) DEFAULT NULL COMMENT '声音',
  `Chat_Video` varchar(255) DEFAULT NULL COMMENT '视频',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`ID`,`Group_ID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='聊天记录'
/*!50100 PARTITION BY LINEAR HASH (Group_ID%100)
PARTITIONS 100 */;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ydct_bus_chatrecord`
--

LOCK TABLES `ydct_bus_chatrecord` WRITE;
/*!40000 ALTER TABLE `ydct_bus_chatrecord` DISABLE KEYS */;
/*!40000 ALTER TABLE `ydct_bus_chatrecord` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ydct_bus_group`
--

DROP TABLE IF EXISTS `ydct_bus_group`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ydct_bus_group` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `Group_Name` varchar(50) DEFAULT NULL COMMENT '群名称',
  `Groupmember_Count` int(11) DEFAULT NULL COMMENT '群成员数量',
  `isValid` int(11) DEFAULT '1' COMMENT '是否有效1有效0无效',
  `isRealGroup` int(11) DEFAULT '0' COMMENT '是否真实群0两人聊天虚拟群1真实群',
  `CreateBy` int(11) DEFAULT NULL COMMENT '创建人',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COMMENT='聊天群表'
/*!50100 PARTITION BY LINEAR HASH (ID%100)
PARTITIONS 100 */;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ydct_bus_group`
--

LOCK TABLES `ydct_bus_group` WRITE;
/*!40000 ALTER TABLE `ydct_bus_group` DISABLE KEYS */;
INSERT INTO `ydct_bus_group` VALUES (1,'123',2,1,0,NULL,'2016-01-21 09:14:42');
/*!40000 ALTER TABLE `ydct_bus_group` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `ydct_bus_groupmember`
--

DROP TABLE IF EXISTS `ydct_bus_groupmember`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `ydct_bus_groupmember` (
  `ID` bigint(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `Group_ID` bigint(20) NOT NULL DEFAULT '0' COMMENT '群ID',
  `User_ID` bigint(20) DEFAULT NULL COMMENT '用户ID',
  `isMaster` int(11) DEFAULT '0' COMMENT '是否群主1是0否',
  `isAuthentication` int(11) DEFAULT '0' COMMENT '是否经过认证1认证0未认证',
  `isAllowSpeak` int(11) DEFAULT '1' COMMENT '是否允许发言1允许0不允许',
  `isValid` int(11) DEFAULT '1' COMMENT '是否有效1有效0无效',
  `CreateBy` int(11) DEFAULT NULL COMMENT '创建人',
  `CreateDate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`ID`,`Group_ID`),
  KEY `idx_ydctbusgroupmember_UserID` (`User_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='群成员'
/*!50100 PARTITION BY LINEAR HASH (Group_ID%100)
PARTITIONS 100 */;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `ydct_bus_groupmember`
--

LOCK TABLES `ydct_bus_groupmember` WRITE;
/*!40000 ALTER TABLE `ydct_bus_groupmember` DISABLE KEYS */;
INSERT INTO `ydct_bus_groupmember` VALUES (1,1,1,0,1,1,1,NULL,'2016-01-21 09:15:56'),(2,1,2,0,1,1,1,NULL,'2016-01-21 09:15:56');
/*!40000 ALTER TABLE `ydct_bus_groupmember` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-01-21 18:16:57
