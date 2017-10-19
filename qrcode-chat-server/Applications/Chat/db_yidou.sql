CREATE DATABASE  IF NOT EXISTS `yidou_chat` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `yidou_chat`;

DROP TABLE IF EXISTS `yd_chatmsg`;
/*******  私聊信息表  **********/
CREATE TABLE IF NOT EXISTS `yd_chatmsg`(
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
	`sender_id` int(11) NOT NULL COMMENT '消息发送者ID号',
	`receiver_id` int(11) NOT NULL COMMENT '消息接收者ID号',
	`msg_content` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '消息发送的内容',
	`send_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '消息发送的时间',
	PRIMARY KEY(`id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='私聊消息表';

DROP TABLE IF EXISTS  `yd_groupmsg`;
/********  群聊信息表  **********/
CREATE TABLE IF NOT EXISTS `yd_groupmsg`(
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',      		 
	`group_id` int(11) NOT NULL COMMENT '所属群ID',
	`sender_id` int(11) NOT NULL COMMENT '发送者ID',
	`receiver_id` int(11) NOT NULL COMMENT '接受者ID',
	`msg_content` VARCHAR(255) NOT NULL DEFAULT '' COMMENT '发送的消息内容',
	`send_time` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '消息发送的时间',
	PRIMARY KEY (`id`,`group_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='群聊消息表';

DROP TABLE IF EXISTS `yd_user`;
/******** 用户表  **********/
CREATE TABLE IF NOT EXISTS `yd_user`(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
	`leader_id` INT(11) NOT NULL COMMENT '立德ID号',
	`user_name` VARCHAR(25) NOT NULL COMMENT '用户名称',
	`user_mobile` VARCHAR(25) NOT NULL COMMENT '用户手机',
	`user_job` VARCHAR(25) NOT NULL COMMENT '用户工作', 
	`user_company` VARCHAR(255) NOT NULL COMMENT '用户所在单位',
	`user_field` VARCHAR(255) NOT NULL COMMENT '用户所在行业领域',
	`avatar` VARCHAR(255) NOT NULL COMMENT '用户头像',
	`is_allow_speak` INT(11) COMMENT '是否允许发言 0禁言中 1禁言解除',
	`is_online` INT(11) NOT NULL COMMENT '是否在线',
	`register_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '用户注册时间',
	`is_authentication` INT (11) NOT NULL COMMENT '用户是否通过验证',
	`is_valid` INT(11) NOT NULL DEFAULT '1' COMMENT '是否有效',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='用户表';

DROP TABLE IF EXISTS `yd_login_info`;
/************ 用户登录信息表 ***************/
CREATE TABLE IF NOT EXISTS `yd_login_info`(
	`id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
	`leader_id` INT(11) NOT NULL COMMENT '用户ID',
	`login_in_time` TIMESTAMP NOT NULL COMMENT '用户上次登录时间',
	`login_out_time` TIMESTAMP NOT NULL COMMENT '用户上次登出时间',
	`is_valid` INT(11) NOT NULL DEFAULT '1' COMMENT '是否有效',
	PRIMARY KEY (`id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='登录信息表,用于记录登录时长';

DROP TABLE IF EXISTS `yd_role`;
/******** 用户角色表 ***********/
CREATE TABLE IF NOT EXISTS `yd_role`(
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
	`role_code` VARCHAR(20) COMMENT '角色代号',
	`role_name` VARCHAR(50) COMMENT '角色名称',
	`role_desc` VARCHAR(255) COMMENT '角色描述',
	`is_valid` INT(11) DEFAULT '1' COMMENT '是否有效',
	`create_by` INT(11) DEFAULT NULL COMMENT '创建人',
	`create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
	PRIMARY KEY(`id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='角色表';

DROP TABLE IF EXISTS `yd_right`;
/******** 用户权限表 *********/
CREATE TABLE IF NOT EXISTS `yd_right`(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
	`right_code` VARCHAR(30) DEFAULT NULL COMMENT '权限代号',
	`right_name` VARCHAR(50) DEFAULT NULL COMMENT '权限名称',
	`right_desc` VARCHAR(255) DEFAULT NULL COMMENT '权限描述',
	`is_valid` INT(11) DEFAULT '1' COMMENT '是否有效',
	`create_by` INT(11) DEFAULT NULL COMMENT '创建人',
	`create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
	PRIMARY KEY(`id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='权限表';

/******** 角色信息表  *********/
DROP TABLE IF EXISTS `yd_role_right`;
CREATE TABLE IF NOT EXISTS `yd_role_right`(
	`id` int(11) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
	`role_id` INT(11) NOT NULL COMMENT '关联的角色ID',
	`right_id` INT(11) NOT NULL COMMENT '关联的权限ID',
	`is_valid` INT(11) NOT NULL COMMENT '是否有效',
	`create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP  COMMENT '创建日期',
	PRIMARY KEY(`id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='角色权限关联表';

DROP TABLE IF EXISTS `yd_group_member`;
/******* 用户--群关联表 *********/
CREATE TABLE IF NOT EXISTS `yd_group_member`(
	`id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键', 
	`group_id` BIGINT(20) NOT NULL COMMENT '群ID号',
	`leader_id` BIGINT(20) NOT NULL COMMENT '用户ID号',
	`is_master` INT(11) NOT NULL COMMENT '是否是群主',
	`is_authentication` INT(11) COMMENT '是否已经是群成员 0正在申请 1申请通过',
	`user_role` INT(11) COMMENT '群成员角色',
	`is_valid` INT(11) DEFAULT '1' COMMENT '是否有效',
	`create_by` INT(11) DEFAULT NULL COMMENT '创建人',
	`create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
	PRIMARY KEY(`id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='群成员关联表';

DROP TABLE IF EXISTS `yd_group`;
/******** 群表 *********/
CREATE TABLE IF NOT EXISTS `yd_group`(
	`id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
	`group_id` INT(11) NOT NULL COMMENT '群ID',
	`group_name` VARCHAR(50) NOT NULL COMMENT '群名称',
	`group_intro` VARCHAR(255) NOT NULL COMMENT '群简介',
	`group_avatar` VARCHAR(255) NOT NULL COMMENT '群头像',
	`is_valid` INT(11) DEFAULT '1' COMMENT '是否有效',
	`create_by` INT(11) DEFAULT NULL COMMENT '创建人',
	`create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
	PRIMARY KEY(`id`),
	UNIQUE KEY(`group_id`)
)ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8 COMMENT='群表';

DROP TABLE IF EXISTS `yd_to_join_group`;
/********* 等待客户同意加入群的消息列表 ***********/
CREATE TABLE IF NOT EXISTS `yd_to_join_group`(
	`id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
	`group_id` BIGINT(20) NOT NULL COMMENT '群ID号',
	`is_approve` INT(11) DEFAULT '0' COMMENT '客户是否已同意加入私密群',
	`is_valid` INT(11) DEFAULT '1' COMMENT '是否有效',
	`approve_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '客户同意加入私密群的日期',
	PRIMARY KEY (`id`,`group_id`)
)ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET=utf8 COMMENT='等待客户同意加入群的消息列表';

DROP TABLE IF EXISTS `yd_group_announce`;
/********  群公告列表 *********/
CREATE TABLE IF NOT EXISTS `yd_group_announce`(
	`id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
	`group_id` BIGINT(20) NOT NULL COMMENT '群ID号',
	`content` VARCHAR(6000) NOT NULL COMMENT '群公告信息',
	PRIMARY KEY(`id`,`group_id`)
)ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET=utf8 COMMENT= '群公告信息列表';

DROP TABLE IF EXISTS `yd_group_ban_speak`;
/********  群禁言列表 ********/
CREATE TABLE IF NOT EXISTS 	`yd_group_ban_speak`(
	`id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
	`group_id` INT(11) NOT NULL COMMENT '群ID号',
	`leader_id` INT(11) NOT NULL COMMENT '用户ID号',
	`start_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '禁言起始时间',
	`end_time` TIMESTAMP NOT NULl DEFAULT CURRENT_TIMESTAMP COMMENT '禁言结束时间',
	`is_valid` INT(11) DEFAULT '1' COMMENT '是否有效',
	`create_by` INT(11) DEFAULT NULL COMMENT '创建人',
	`create_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建日期',
	PRIMARY KEY(`id`,`group_id`,`user_id`)
)ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COMMENT = '群禁言列表';

DROP TABLE IF EXISTS `yd_general_contacts`;
CREATE TABLE IF NOT EXISTS `yd_general_contacts`(
	`id` INT(11) NOT NULL AUTO_INCREMENT COMMENT '自增ID',
	`leader_id` INT(11) NOT NULL COMMENT '用户ID',
	`contact_id` INT(11) NOT NULL COMMENT '关联的联系人的用户ID',
	`is_valid` INT(11) NOT NULL DEFAULT '1' COMMENT '是否有效',
    `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
     PRIMARY KEY (`id`)
)ENGINE = InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET = utf8 COMMENT="常用联系人";


DROP TABLE  IF EXISTS `yd_post`;
CREATE TABLE IF NOT EXISTS `yd_post`(
 `post_id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '说说逻辑主键',
 `leader_id` INT(11) NOT NULL COMMENT '用户leader_id号',
 `content` VARCHAR(500) DEFAULT '' COMMENT '用户上传的文字',
 `share_id` TINYINT NOT NULL DEFAULT 1 COMMENT '是否转发的标志，可以扩展,为0 表示第三方分享',
 `post_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '说说发表时间',
 `is_valid` INT(11) NOT NULL DEFAULT 1 COMMENT '是否有效',
  PRIMARY KEY(`post_id`)
)ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET=utf8 COMMENT= '朋友圈说说';

DROP TABLE IF EXISTS  `yd_post_review`;
CREATE TABLE IF NOT EXISTS  `yd_post_review`(
 `review_id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
 `post_id` BIGINT(20) NOT NULL COMMENT '说说ID',
 `leader_id` INT(11) NOT NULL COMMENT '评论用户leader_id号',
 `content` VARCHAR(255) NOT NULL COMMENT '评论内容',
 `review_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '评论时间',
  PRIMARY KEY(`review_id`)
)ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COMMENT='朋友圈说说评论';

DROP TABLE IF EXISTS  `yd_post_img`;
CREATE TABLE IF NOT EXISTS  `yd_post_img`(
 `img_id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '说说照片ID',
 `post_id` BIGINT(20) NOT NULL COMMENT '朋友圈post_id',
 `img_url` VARCHAR(255) NOT NULL COMMENT '用户上传的图片',
 `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '图片上传时间',
 `is_valid` TINYINT NOT NULL DEFAULT 1 COMMENT '是否有效',
  PRIMARY KEY(`img_id`)
)ENGINE = InnoDB AUTO_INCREMENT =1 DEFAULT CHARSET = utf8 COMMENT ='朋友圈说说照片';

DROP TABLE IF EXISTS  `yd_post_favorite`;
CREATE TABLE IF NOT EXISTS  `yd_post_favorite`(
  `favorite_id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '用户点赞ID',
  `post_id` BIGINT(20) NOT NULL COMMENT '说说id',
  `leader_id` INT(11) NOT NULL COMMENT '点赞的好友leader_id',
  `favorite_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '点赞的时间',
  `is_valid` TINYINT NOT NULL DEFAULT 1 COMMENT '是否有效',
  PRIMARY KEY(`favorite_id`)
)ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COMMENT = '朋友圈说说点赞';

DROP TABLE IF EXISTS `yd_post_img_review`;
CREATE TABLE IF NOT EXISTS  `yd_post_img_review`(
 `review_id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
 `img_id` BIGINT(20) NOT NULL COMMENT '图片id',
 `leader_id` INT(11) NOT NULL COMMENT '评论用户leader_id号',
 `review_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '评论时间',
 `content` VARCHAR(255) NOT NULL COMMENT '评论内容',
  PRIMARY KEY(`review_id`)
)ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COMMENT='朋友圈说说图片评论';

DROP TABLE IF EXISTS `yd_post_img_favorite`;
CREATE TABLE IF NOT EXISTS `yd_post_img_favorite`(
  `favorite_id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '图片点赞id',
  `img_id` BIGINT(20) NOT NULL COMMENT '图片id',
  `leader_id` INT(11) NOT NULL COMMENT '点赞的好友leader_id',
  `favorite_date` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '点赞的时间',
   PRIMARY KEY(`favorite_id`)
)ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COMMENT='朋友圈说说图片点赞';

DROP TABLE IF EXISTS `yd_unread_group_msg`;
/******** 未读群聊列表 *********/
CREATE TABLE IF NOT EXISTS `yd_unread_group_msg`(
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `gmsg_id` INT(11) NOT NULL COMMENT '群消息ID号',
  `leader_id` INT(11) NOT NULL COMMENT '用户ID号',
  `status` TINYINT NOT NULL DEFAULT '0' COMMENT '上次读取的时间',
  PRIMARY KEY(`id`)
)ENGINE = InnoDB AUTO_INCREMENT = 1 DEFAULT CHARSET = utf8 COMMENT = '未读群聊列表';

DROP TABLE IF EXISTS `yd_unread_user_msg`;
/******** 未读私聊列表 ***********/
CREATE TABLE IF NOT EXISTS `yd_unread_user_msg`(
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `sender_id` INT(11) NOT NULL COMMENT '发送者ID号',
  `receiver_id` INT(11) NOT NULL COMMENT '接受者ID号',
  `count` INT(11) NOT NULL DEFAULT '1' COMMENT '未读消息数',
  PRIMARY KEY(`id`)
)ENGINE = InnoDB AUTO_INCREMENT =1 DEFAULT CHARSET = utf8 COMMENT = '未读私聊列表';


DROP TABLE IF EXISTS  `yd_user_follow`;
/********* 用户关注 **********/
CREATE TABLE IF NOT EXISTS `yd_user_follow`(
  `id` BIGINT(20) NOT NULL AUTO_INCREMENT COMMENT '逻辑主键',
  `leader_id` INT(11) NOT NULL COMMENT '用户leader_id号',
  `follow_id` INT(11) NOT NULL DEFAULT '0' COMMENT '被关注的用户leader_id号',
  `is_valid` TINYINT NOT NULL DEFAULT  '1' COMMENT '是否有效',
  PRIMARY KEY(`id`)
)ENGINE = InnoDB AUTO_INCREMENT =1 DEFAULT CHARSET = utf8 COMMENT = '用户关注列表';

//群通知
CREATE TABLE `yidou_chat`.`yd_group_notice` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `group_id` INT NOT NULL,
  `notice_type` TINYINT NOT NULL,
  `sender_id` INT NOT NULL,
  `notice_title` VARCHAR(45) NULL,
  `notice_content` VARCHAR(45) NULL,
  `receiver_id` INT NOT NULL,
  `is_viewed` TINYINT NOT NULL DEFAULT 0,
  `is_valid` TINYINT NOT NULL DEFAULT 1,
  `send_time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
  )ENGINE = InnoDB COMMENT = '群通知';

//群公告列表
CREATE TABLE `yd_group_announce` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `group_id` INT(11) NOT NULL,
  `leader_id` INT(11) NOT NULL,
  `title` VARCHAR(255) NOT NULL,
  `content` VARCHAR(4500) NOT NULL,
  `cover` VARCHAR(255) NULL DEFAULT '',
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_valid` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
COMMENT = '群公告列表';

//群文件
CREATE TABLE `yd_group_file` (
  `id` INT(11) NOT NULL,
  `group_id` INT(11) NOT NULL,
  `leader_id` INT(11) NOT NULL,
  `file_name` VARCHAR(255) NOT NULL,
  `file_size` VARCHAR(255) NOT NULL,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_valid` TINYINT NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`))
COMMENT = '群文件';

//群相册
CREATE TABLE `yd_group_album` (
  `album_id` INT NOT NULL AUTO_INCREMENT,
  `group_id` INT(11) NOT NULL,
  `album_name` VARCHAR(45) NOT NULL,
  `album_desc` VARCHAR(1024) NOT NULL,
  `create_by` VARCHAR(45) NULL,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_valid` VARCHAR(45) NOT NULL DEFAULT '1',
  PRIMARY KEY (`album_id`))
COMMENT = '群相册';

//群相册里面的照片
CREATE TABLE `yd_group_album_image` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `group_album_id` INT(11) NOT NULL,
  `path` VARCHAR(255) NOT NULL,
  `create_by` INT(11) NOT NULL,
  `create_time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_valid` TINYINT NULL DEFAULT 1,
  PRIMARY KEY (`id`))
COMMENT = '群相册照片';




INSERT INTO `yd_role`(`role_code`,`role_name`,`role_desc`,`is_valid`)
	VALUES("ROLE_USER","一般用户","一般用户",1)
	,("ROLE_ADMINISTRATOR","群管理员","群管理员",1)
	,("ROLE_CREATOR","群创建者","群创建者",1);



INSERT INTO `yd_right`(`right_code`,`right_name`,`right_desc`,`is_valid`)
	VALUES("RIGHT_CREATE_GROUP","创建群","创建私密聊天群",1)
	,("RIGHT_DELETE_GROUP","解散群","解散私密聊天群",1)
	,("RIGHT_ACCEPT_JOIN_GROUP","同意加入群请求","同意加入群请求",1)
	,("RIGHT_DELETE_MEMBER","删除群成员","删除群成员",1)
	,("RIGHT_UPLOAD_GROUP_PICTURE","上传群照片","上传群照片",1)
	,("RIGHT_EDIT_GROUP_NAME","编辑群名称","编辑群名称",1)
	,("RIGHT_EDIT_GROUP_INTRO","编辑群简介","编辑群简介",1)
	,("RIGHT_REQUEST_JOIN_GROUP","申请加入群","申请加入群",1)
  ,("RIGHT_BAN_MEMBER_SPEAK","禁止群成员发言","禁止群成员发言",1)
	,("RIGHT_UNBAN_MEMBER_SPEAK","解除群成员发言","解除群成员发言",1);

INSERT INTO `yd_role_right`(`role_id`,`right_id`,`is_valid`)
	VALUES(1,8,1)
		,(2,1,1)
		,(2,2,1)
		,(2,3,1)
		,(2,4,1)
		,(2,5,1)
		,(2,6,1)
		,(2,7,1)
		,(2,8,1)
		,(2,9,1)
		,(2,10,1)
		,(3,1,1)
		,(3,2,1)
		,(3,3,1)
		,(3,4,1)
		,(3,5,1)
		,(3,6,1)
		,(3,7,1)
		,(3,8,1)
		,(3,9,1)
		,(3,10,1);