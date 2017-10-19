<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-28
 * Time: 上午9:18
 */

namespace YiDou\Client;

use GatewayWorker\Lib\Gateway;
use YiDou\Util\CUtil;

class EnumGroupRole  //群里面用户扮演的角色
{
    const ROLE_USER = 1;          //普通用户
    const ROLE_ADMINISTRATOR = 2; //管理员
    const ROLE_CREATOR = 3;      //群创建者
}

class EnumGroupRight
{ //
    const RIGHT_CREATE_GROUP = 1; //创建群
    const RIGHT_DELETE_GROUP = 2; //解散群
    const RIGHT_ACCEPT_JOIN_GROUP = 3; //同意加入群
    const RIGHT_DELETE_MEMBER = 4; //删除群成员
    const RIGHT_UPLOAD_GROUP_PICTURE = 5; //上传群照片
    const RIGHT_EDIT_GROUP_NAME = 6; //更新群名称
    const RIGHT_EDIT_GROUP_INTRO = 7; //更新群简介
    const RIGHT_REQUEST_JOIN_GROUP = 8; //加入群
    const RIGHT_BAN_MEMBER_SPEAK = 9; //禁止群成员发声
    const RIGHT_UNBAN_MEMBER_SPEAK = 10; //解除群成员发声
}

/*********************************
 * class CMsg 发往客户端的消息包
 * @package Yidou
 *********************************/
class CMsg
{
    public static $MSG_USER_NONE_EXIST = "s_user_none_exist"; //用户不存在
    public static $MSG_ABOUT_ME = "s_about_me"; //返回个人信息
    public static $MSG_ALL_REGISTER_USER_LIST = "s_all_register_user_list"; //获取所有注册用户列表
    public static $MSG_CREATE_PRIVATE_GROUP = "s_create_private_group"; //创建用户私聊群
    public static $MSG_FOLLOW_SINGLE_USER = "s_follow_single_user"; //关注单个用户
    public static $MSG_FOLLOW_MULTI_USER = "s_follow_multi_user"; //关注多个用户
    public static $MSG_GROUP_CHAT_HISTORY = "s_group_chat_history"; //获取更多群聊历史记录
    public static $MSG_GROUP_CHAT = "s_group_chat"; //群聊信息
    public static $MSG_GROUP_DETAIL = "s_group_detail"; //群详细资料
    public static $MSG_GROUP_LIST = "s_group_list";   //群列表
    public static $MSG_GROUP_NOTICE_LIST = 's_group_notice_list'; //群通知列表
    public static $MSG_GROUP_MEMBER_LIST = "s_group_member_list"; //下载群成员列表
    public static $MSG_GENERAL_CONTACTS = "s_download_general_contacts"; //下载常用联系人
    public static $MSG_INVITE_NEW_GROUP_MEMBER = "s_invite_new_group_member"; //邀请新的群成员
    public static $MSG_INVITE_JOIN_GROUP = "s_invite_join_group"; //邀请加入群
    public static $MSG_JOIN_GROUP = "s_join_group";   //加入群组
    public static $MSG_LOGIN_IN = "s_login_in";       //用户登录
    public static $MSG_LOGIN_OUT = "s_login_out";     //用户登出
    public static $MSG_LEAVE_GROUP = "s_leave_group"; //离开群组
    public static $MSG_MODIFY_USER_COMPANY = "s_modify_user_company"; //修改公司
    public static $MSG_MODIFY_USER_JOB = "s_modify_user_job"; //修改职位
    public static $MSG_MODIFY_USER_FIELD = "s_modify_user_field"; //修改行业
    public static $MSG_RESET_UNREAD_USER_MSG = "s_reset_unread_user_msg"; //清空未读用户消息数据
    public static $MSG_RESET_UNREAD_GROUP_MSG = "s_reset_unread_group_msg"; //清空未读群消息数据
    public static $MSG_REGISTER = "s_register";       //用户注册
    public static $MSG_USER_DETAIL = "s_user_detail"; //用户详细资料
    public static $MSG_USER_CHAT = "s_user_chat"; // 私聊信息
    public static $MSG_UPDATE_USER_AVATAR = "s_modify_user_avatar"; //更换用户头像
    public static $MSG_UPDATE_GROUP_AVATAR = "s_modify_group_avatar"; //更改群头像
    public static $MSG_USER_CHAT_HISTORY = "s_user_chat_history";//用户私聊历史记录
    public static $MSG_UNREAD_USER_CHAT_LIST = "s_unread_user_chat_list"; //查看未读私聊列表
    public static $MSG_UNREAD_GROUP_CHAT_LIST = "s_unread_group_chat_list"; //查看未读群聊列表
    public static $MSG_USER_FOLLOW_LIST = "s_user_follow_list"; //获取用户关注列表
    public static $MSG_UNFOLLOW_SINGLE_USER = "s_unfollow_single_user"; //取消特别关注
    public static $MSG_UNFOLLOW_MULTI_USER = "s_unfollow_multi_user"; //取消关注多个用户
    public static $MSG_USER_LIST_ABOUT_FOLLOW = "s_user_list_about_follow"; //获取我和群里面其他人的关注关系
    public static $MSG_USER_LIST_ABOUT_INVITE = "s_user_list_about_invite"; //邀请新的群成员
    public static $MSG_GROUP_NOTICE = "s_group_notice"; //群通知
    public static $MSG_NOTICE_JOIN_GROUP_SUCCESS = "s_notice_join_group_success"; //入群成功的消息
    //朋友圈
    public static $MSG_NEW_POST = "s_new_post"; //发布朋友圈说说
    public static $MSG_DELETE_POST = "s_delete_post"; //删除朋友圈说说
    public static $MSG_POST_FAVORITE = "s_post_favorite"; //朋友圈说说点赞
    public static $MSG_POST_UN_FAVORITE = "s_post_un_favorite"; //取消朋友圈说说点赞
    public static $MSG_POST_REVIEW = "s_post_review"; //朋友圈说说评论
    public static $MSG_DELETE_POST_REVIEW = "s_delete_post_review"; //删除朋友圈说说评论
    public static $MSG_POST_IMG_FAVORITE = "s_post_img_favorite"; //朋友圈说说图片点赞
    public static $MSG_POST_IMG_UN_FAVORITE = "s_post_un_img_favorite"; //取消朋友圈说说图片点赞
    public static $MSG_POST_IMG_REVIEW = "s_post_img_review"; //朋友圈说说图片评论
    public static $MSG_DELETE_POST_IMG_REVIEW = "s_delete_post_img_review"; //删除朋友圈说说图片评论
    public static $MSG_POST_LIST = "s_post_list"; //朋友圈说说列表
    public static $MSG_ERROR_MSG = "s_error_msg"; //发生错误
    //群功能
    public static $MSG_GROUP_ANNOUNCE_LIST = 's_group_announce_list'; //群公告列表
    public static $MSG_NEW_GROUP_ANNOUNCE = 's_new_group_announce';   //新群公告
    public static $MSG_EDIT_GROUP_ANNOUNCE = 's_edit_group_announce'; //编辑群公告
    public static $MSG_DELETE_GROUP_ANNOUNCE = 's_delete_group_announce'; //删除群公告
    public static $MSG_GROUP_FILE_LIST = 's_group_file_list'; //群文件列表
    public static $MSG_NEW_GROUP_FILE = 's_new_group_file';  //新群文件
    public static $MSG_DELETE_GROUP_FILE = 's_delete_group_file'; //删除群文件
    public static $MSG_GROUP_ALBUM_LIST = 's_group_album_list';  //群相册列表
    public static $MSG_GROUP_IMAGE_LIST = 's_group_image_list';  //群照片列表
    public static $MSG_NEW_GROUP_ALBUM = 's_new_group_album';   //创建新的群相册
    public static $MSG_EDIT_GROUP_ALBUM_NAME = 's_edit_group_album_name'; //编辑群相册名字
    public static $MSG_EDIT_GROUP_ALBUM_DESC = 's_edit_group_album_desc'; //编辑群相册的描述
    public static $MSG_DELETE_GROUP_ALBUM = 's_delete_group_album'; //删除创建的的群相册
    public static $MSG_UPLOAD_IMG_TO_GROUP_ALBUM = 's_upload_img_to_group_album'; //删除照片至群相册
    public static $MSG_DELETE_GROUP_ALBUM_IMG = 's_delete_group_album_img'; //删除群相册里面的图片

    protected $_version; // 消息版本号
    protected $_type;    // 消息类型
    protected $_content; // 消息发送内容
    protected $_from_client_id;    // 消息发送人
    protected $_to_client_id;      // 消息接受人/群
    protected $_time;     // 消息发送时间
    protected $_group_id; // 群ID号

    public function __construct($type, $content, $from_client_id, $to_client_id, $group_id = '', $version = '1.0.0')
    {
        $this->_version = $version;
        $this->_type = $type;
        $this->_content = $content;
        $this->_from_client_id = $from_client_id;
        $this->_to_client_id = $to_client_id;
        $this->_group_id = $group_id;
        $this->_time = CUtil::GetCurrentTime();
    }

    protected function Send()
    {
    }

    protected function GetMsgPacket()
    {
        return json_encode(array(
            "version" => $this->_version,
            "type" => $this->_type,
            "content" => $this->_content,
            "from" => $this->_from_client_id,
            "to" => $this->_to_client_id,
            "group_id" => $this->_group_id,
            "time" => $this->_time
        ));
    }
}

// 下载未读消息
class CDownloadUnreadMsg extends CMsg
{
    public function __construct($type, $content, $from_client_id, $to_client_id)
    {
        parent::__construct($type, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $package = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($package);
    }
}

//用户不存在
class CUserNoneExistMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_USER_NONE_EXIST, $content, $from_client_id, $to_client_id, $group_id);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 朋友圈说说列表
class CPostListMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_POST_LIST, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 朋友圈说说
class CNewPostMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_NEW_POST, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 删除朋友圈说说
class CDeletePostMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_DELETE_POST, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 朋友圈说说点赞
class CPostFavoriteMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_POST_FAVORITE, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 朋友圈说说取消点赞
class CPostUnFavoriteMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_POST_UN_FAVORITE, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 朋友圈说说评论
class CPostReviewMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_POST_REVIEW, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 删除朋友圈说说评论
class CDeletePostReviewMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_DELETE_POST_REVIEW, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 朋友圈图片点赞
class CPostImgFavoriteMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_POST_IMG_FAVORITE, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 取消朋友圈图片点赞
class CPostImgUnFavoriteMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_POST_IMG_UN_FAVORITE, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 朋友圈图片评论
class CPostImgReviewMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_POST_IMG_REVIEW, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 删除朋友圈图片评论
class CDeletePostImgReviewMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_DELETE_POST_IMG_REVIEW, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 用户加入群组
class CJoinGroupMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_JOIN_GROUP, $content, $from_client_id, $to_client_id, $group_id);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::joinGroup($this->_from_client_id, $this->_group_id); //加入群
        Gateway::sendToGroup($this->_group_id, $packet); //向群里所有在线成员广播加入群消息
    }
}

//入群成功的消息
class CNoticeJoinGroupSuccessMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_NOTICE_JOIN_GROUP_SUCCESS, $content, $from_client_id, $to_client_id);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//群通知消息
class CGroupNoticeMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_GROUP_NOTICE, $content, $from_client_id, $to_client_id, $group_id);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToGroup($this->_group_id, $packet); //向群里所有在线成员广播通知
    }
}

//用户退出群组
class CLeaveGroupMsg extends CMsg
{
    public function __construct($type, $content, $from_client_id, $to_client_id, $group_id, $version)
    {
        parent::__construct($type, $content, $from_client_id, $to_client_id, $group_id, $version);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::leaveGroup($this->_from_client_id, $this->_group_id); //离开群
        Gateway::sendToGroup($this->_group_id, $packet);//向群里所有在线成员广播消息
    }
}

// 用户注册
class CRegisterMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_REGISTER, $content, $from_client_id, $to_client_id, $group_id);
    }

    public function Send()
    {
        $msg = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($msg); //只向当前客户发送是否注册成功的消息
    }
}

// 用户登录
class CLoginInMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_LOGIN_IN, $content, $from_client_id, $to_client_id, "");
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToClient($this->_to_client_id, $packet);
    }
}

// 用户退出
class CLoginOutMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_LOGIN_OUT, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToClient($this->_to_client_id, $packet); //发送登出消息给所有ID用户
    }
}

// 获取用户加入的群列表
class CGroupListMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_GROUP_LIST, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet); //发送消息给当前用户
    }
}

// 获取群成员列表
class CGroupMemberListMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_GROUP_MEMBER_LIST, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 获取用户私聊记录
class CUserChatHistoryMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_USER_CHAT_HISTORY, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 获取群聊记录
class CGroupChatHistoryMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_GROUP_CHAT_HISTORY, $content, $from_client_id, $to_client_id, $group_id);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 更新用户头像
class CUpdateUserAvatarMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_UPDATE_USER_AVATAR, $content, $from_client_id, $to_client_id, $group_id);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 更新群头像
class CUpdateGroupAvatarMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_UPDATE_GROUP_AVATAR, $content, $from_client_id, $to_client_id, $group_id);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToGroup($this->_groupId, $packet);
    }
}

// 常用联系人列表
class CGeneralContactsMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_GENERAL_CONTACTS, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

// 用户私聊
class CUserChatMsg extends CMsg
{
    private $_is_other_online;

    public function __construct($content, $from_client_id, $to_client_id, $is_other_online)
    {
        $this->_is_other_online = $is_other_online;
        parent::__construct(parent::$MSG_USER_CHAT, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
        if ($this->_is_other_online) { //如果在线就发送消息，否则不发送，直接将消息插入数据库中
            Gateway::sendToClient($this->_to_client_id, $packet);
        }
    }
}

// 群聊
class CGroupChatMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_GROUP_CHAT, $content, $from_client_id, $to_client_id, $group_id);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToGroup($this->_group_id, $packet);
    }
}

//用户详细资料
class CUserDetailMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_USER_DETAIL, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//修改用户公司
class CModifyUserCompanyMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_MODIFY_USER_COMPANY, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//修改用户职位
class CModifyUserJobMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_MODIFY_USER_JOB, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//修改用户行业
class CModifyUserFieldMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_MODIFY_USER_FIELD, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//未读用户聊天列表
class CUnreadUserChatListMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_UNREAD_USER_CHAT_LIST, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//未读群聊天列表
class CUnreadGroupChatListMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_UNREAD_GROUP_CHAT_LIST, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//获取个人信息
class CAboutMeMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_ABOUT_ME, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//获取所有注册用户列表
class CAllRegisterUserListMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_ALL_REGISTER_USER_LIST, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::SendToCurrentClient($packet);
    }
}

//获取用户的关注用户列表
class CUserFollowListMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_USER_FOLLOW_LIST, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//创建用户私聊群
class CCreatePrivateGroupMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_CREATE_PRIVATE_GROUP, $content, $from_client_id, $to_client_id, $group_id);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::joinGroup($this->_from_client_id, $this->_group_id); //加入新群
        Gateway::sendToCurrentClient($packet);
    }
}

//查看群详细资料
class CGroupDetailMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_GROUP_DETAIL, $content, $from_client_id, $to_client_id);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//添加特别关注
class CFollowSingleUserMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_FOLLOW_SINGLE_USER, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//取消特别关注
class CUnFollowSingleUserMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_UNFOLLOW_SINGLE_USER, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//添加多个关注
class CFollowMultiUserMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_FOLLOW_MULTI_USER, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

class CUnfollowMultiUserMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_UNFOLLOW_MULTI_USER, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

class CUserListAboutFollowMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_USER_LIST_ABOUT_FOLLOW, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

class CResetUnReadUserMsgMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_RESET_UNREAD_USER_MSG, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

class CResetUnReadGroupMsgMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id, $group_id, $version)
    {
        parent::__construct(parent::$MSG_RESET_UNREAD_GROUP_MSG, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

class CUserListAboutInviteMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_USER_LIST_ABOUT_INVITE, $content, $from_client_id, $to_client_id, $group_id);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

class CInviteNewGroupMemberMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_INVITE_NEW_GROUP_MEMBER, $content, $from_client_id, $to_client_id, $group_id);
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToGroup($this->_group_id, $packet);
    }
}

class CErrorMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_ERROR_MSG, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}

//群通知列表
class CGroupNoticeListMsg extends CMsg
{
    public function __construct($content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_GROUP_NOTICE_LIST, $content, $from_client_id, $to_client_id, '');
    }

    public function Send()
    {
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
// 群公告列表
class CGroupAnnounceListMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_GROUP_ANNOUNCE_LIST, $content, $from_client_id, $to_client_id);
    }
    public function Send(){
        $packet= $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
//新群公告
class CNewGroupAnnounceMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_NEW_GROUP_ANNOUNCE, $content, $from_client_id, $to_client_id, $group_id);
    }
    public function Send(){
        $packet= $this->GetMsgPacket();
        Gateway::sendToGroup($this->_group_id,$packet);
    }
}
//编辑群公告
class CEditGroupAnnounceMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_EDIT_GROUP_ANNOUNCE, $content, $from_client_id, $to_client_id, $group_id);
    }
    public function Send(){
        $packet= $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
//删除群公告
class CDeleteGroupAnnounceMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_DELETE_GROUP_ANNOUNCE, $content, $from_client_id, $to_client_id, $group_id);
    }
    public function Send(){
        $packet= $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
//群文件列表
class CGroupFileListMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_GROUP_FILE_LIST, $content, $from_client_id, $to_client_id, $group_id);
    }
    public function Send(){
        $packet= $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
// 新群文件
class CNewGroupFileMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_NEW_GROUP_FILE, $content, $from_client_id, $to_client_id, $group_id);
    }
    public function Send(){
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
//删除群文件
class CDeleteGroupFileMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_DELETE_GROUP_FILE, $content, $from_client_id, $to_client_id, $group_id);
    }
    public function Send(){
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
//群相册列表
class CGroupAlbumListMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_GROUP_ALBUM_LIST, $content, $from_client_id, $to_client_id, '');
    }
    public function Send(){
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
//群照片列表
class CGroupImageListMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_GROUP_IMAGE_LIST, $content, $from_client_id, $to_client_id, $group_id);
    }
    public function Send(){
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
//创建新的群相册
class CNewGroupAlbumMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id)
    {
        parent::__construct(parent::$MSG_NEW_GROUP_ALBUM, $content, $from_client_id, $to_client_id,'');
    }
    public function Send(){
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
//编辑群相册名字
class CEditGroupAlbumNameMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_EDIT_GROUP_ALBUM_NAME, $content, $from_client_id, $to_client_id, $group_id);
    }
    public function Send(){
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
//编辑群相册的描述
class CEditGroupAlbumDescMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_EDIT_GROUP_ALBUM_DESC, $content, $from_client_id, $to_client_id, $group_id);
    }
    public function Send(){
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
//删除创建的群相册
class CDeleteGroupAlbumMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_DELETE_GROUP_ALBUM, $content, $from_client_id, $to_client_id, $group_id);
    }
    public function Send(){
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
//上传照片至群相册
class CUploadImgToGroupAlbumMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_UPLOAD_IMG_TO_GROUP_ALBUM, $content, $from_client_id, $to_client_id, $group_id);
    }
    public function Send(){
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}
//删除群相册里面的图片
class CDeleteGroupAlbumImgMsg extends CMsg{
    public function __construct( $content, $from_client_id, $to_client_id, $group_id)
    {
        parent::__construct(parent::$MSG_DELETE_GROUP_ALBUM_IMG, $content, $from_client_id, $to_client_id, $group_id);
    }
    public function Send(){
        $packet = $this->GetMsgPacket();
        Gateway::sendToCurrentClient($packet);
    }
}