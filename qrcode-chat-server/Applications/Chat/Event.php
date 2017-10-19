<?php
/**
 * This file is part of workerman.
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author walkor<walkor@workerman.net>
 * @copyright walkor<walkor@workerman.net>
 * @link http://www.workerman.net/
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */

/**
 * 聊天主逻辑
 * 主要是处理 onMessage onClose
 */
use GatewayWorker\Lib\Store;
use YiDou\Core as Core;
use YiDou\Server\CYdChatApp;

const MSG_C_PING = 'pong'; //心跳包
const MSG_C_REGISTER = "c_register";     //用户注册
const MSG_C_LOGIN_IN = "c_login_in";     //用户登录
const MSG_C_LOGIN_OUT = "c_login_out";   //用户登出
const MSG_C_JOIN_GROUP = "c_join_group"; //用户要求加入群组
const MSG_C_LEAVE_GROUP = "c_leave_group"; //用户要求离开群组
const MSG_C_ALL_REGISTER_USER_LIST = "c_all_register_user_list"; //所有注册用户
const MSG_C_GROUP_NOTICE_LIST = 'c_group_notice_list'; //群通知列表
const MSG_C_GROUP_LIST = "c_group_list";   //用户加入的群列表
const MSG_C_GROUP_MEMBER_LIST = "c_group_member_list";   //群成员列表
const MSG_C_USER_CHAT_HISTORY = "c_user_chat_history";   //用户私聊记录
const MSG_C_GROUP_CHAT_HISTORY = "c_group_chat_history"; //群聊记录
const MSG_C_USER_CHAT = "c_user_chat";   //用户私聊记录
const MSG_C_GROUP_CHAT = "c_group_chat"; //用户群聊记录
const MSG_C_UPDATE_USER_AVATAR = "c_update_user_avatar";   //更新用户头像
const MSG_C_UPDATE_GROUP_AVATAR = "c_update_group_avatar"; //更新群头像
const MSG_C_USER_DETAIL = "c_user_detail"; //获取用户详细资料
const MSG_C_MODIFY_USER_COMPANY = "c_modify_user_company"; //修改公司
const MSG_C_MODIFY_USER_FIELD = "c_modify_user_field"; //修改行业
const MSG_C_MODIFY_USER_JOB = "c_modify_user_job"; //修改工作
const MSG_C_UNREAD_USER_CHAT_LIST = "c_unread_user_chat_list"; //未读用户信息列表
const MSG_C_UNREAD_GROUP_CHAT_LIST = "c_unread_group_chat_list"; //未读群信息列表
const MSG_C_UPDATE_UNREAD_CHAT_STATUS = "c_update_unread_chat_status"; //更新未读消息状态
const MSG_C_ABOUT_ME = "c_about_me"; //个人信息
const MSG_C_USER_FOLLOW_LIST = "c_user_follow_list"; //用户关注列表
const MSG_C_CREATE_PRIVATE_GROUP = "c_create_private_group"; //创建用户私聊群
const MSG_C_GROUP_DETAIL = "c_group_detail"; //群详细资料
const MSG_C_FOLLOW_SINGLE_USER = "c_follow_single_user"; //关注单个用户
const MSG_C_UNFOLLOW_SINGLE_USER = "c_unfollow_single_user"; //取消关注单个用户
const MSG_C_FOLLOW_MULTI_USER = "c_follow_multi_user"; //关注多个用户
const MSG_C_UNFOLLOW_MULTI_USER = "c_unfollow_multi_user"; //取消关注多个用户
const MSG_C_USER_LIST_ABOUT_FOLLOW = "c_user_list_about_follow"; //需要关注的所有用户列表
const MSG_C_RESET_UNREAD_USER_MSG = "c_reset_unread_user_msg"; //清空未读用户消息数据
const MSG_C_RESET_UNREAD_GROUP_MSG = "c_reset_unread_group_msg"; //清空未读群消息数据
const MSG_C_INVITE_NEW_GROUP_MEMBER = "c_invite_new_group_member"; //邀请新成员
const MSG_C_USER_LIST_ABOUT_INVITE = "c_user_list_about_invite"; //群里面现有成员
const MSG_C_GROUP_NOTICE = "c_group_notice"; //群公告
const MSG_C_GROUP_NOTICE_DETAIL = "c_group_notice_detail";//群公告详情
const MSG_C_SYS_NOTICE = "c_sys_notice"; //系统通知
const MSG_C_SYS_NOTICE_DETAIL = "c_sys_notice_detail"; //系统通知详情
const MSG_C_NOTICE_LIST = "c_notice_list"; //通知列表，系统首页展示
//朋友圈
const MSG_C_NEW_POST = "c_new_post"; //发布朋友圈说说
const MSG_C_DELETE_POST = "c_delete_post"; //删除朋友圈说说
const MSG_C_POST_FAVORITE = "c_post_favorite"; //朋友圈说说点赞
const MSG_C_POST_UN_FAVORITE = "c_post_un_favorite"; //取消朋友圈说说点赞
const MSG_C_POST_REVIEW = "c_post_review"; //朋友圈说说评论
const MSG_C_DELETE_POST_REVIEW = "c_delete_post_review"; //删除朋友圈说说评论
const MSG_C_POST_IMG_FAVORITE = "c_post_img_favorite"; //朋友圈说说图片点赞
const MSG_C_POST_IMG_UN_FAVORITE = "c_post_un_img_favorite"; //取消朋友圈说说图片点赞
const MSG_C_POST_IMG_REVIEW = "c_post_img_review"; //朋友圈说说图片评论
const MSG_C_DELETE_POST_IMG_REVIEW = "c_delete_post_img_review"; //删除朋友圈说说图片评论
const MSG_C_POST_LIST = "c_post_list"; //朋友圈说说列表
//群公告，群相册，群文件
const MSG_C_GROUP_ANNOUNCE_LIST = 'c_group_announce_list';   //群公告列表
const MSG_C_GROUP_ALBUM_LIST = 'c_group_album_list';  //群相册列表
const MSG_C_GROUP_IMAGE_LIST = 'c_group_image_list';  //群相册列表
const MSG_C_GROUP_FILE_LIST = 'c_group_file_list'; //群文件列表
const MSG_C_NEW_GROUP_ANNOUNCE = 'c_new_group_announce';    //新群公告
const MSG_C_EDIT_GROUP_ANNOUNCE= 'c_edit_group_announce'; //编辑群公告
const MSG_C_DELETE_GROUP_ANNOUNCE = 'c_delete_group_announce'; //删除群公告
const MSG_C_NEW_GROUP_FILE = 'c_new_group_file';  //新群文件
const MSG_C_DELETE_GROUP_FILE = 'c_delete_group_file'; //删除群文件
const MSG_C_UPLOAD_GROUP_IMAGE = 'c_upload_group_image'; //上传群照片


const MSG_C_NEW_GROUP_ALBUM = 'c_new_group_album';   //创建新的群相册
const MSG_C_EDIT_GROUP_ALBUM_NAME = 'c_edit_group_album_name'; //编辑群相册名字
const MSG_C_EDIT_GROUP_ALBUM_DESC = 'c_edit_group_album_desc'; //编辑群相册的描述
const MSG_C_DELETE_GROUP_ALBUM = 'c_delete_group_album'; //删除创建的的群相册
const MSG_C_UPLOAD_IMG_TO_GROUP_ALBUM = 'c_upload_img_to_group_album'; //上传照片至群相册
const MSG_C_DELETE_GROUP_ALBUM_IMG = 'c_delete_group_album_img'; //删除群相册里面的图片
const MSG_C_AGREE_JOIN_NEW_GROUP = 'c_agree_join_new_group'; //同意加入新群组



class Event
{

    public static function onMessage($client_id, $message)
    {
        // debug
        //echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id session:" . json_encode($_SESSION) . " onMessage:" . $message . "\n";
        echo "onMessage:" . iconv("UTF-8", "gbk//TRANSLIT", $message) . "\n";

        // 客户端传递的是json数据
        $data = json_decode($message, true);
        if (!$data) {
            return;
        }

        // 根据类型执行不同的业务
        switch ($data['type']) {

            case MSG_C_PING:    // 客户端回应服务端的心跳
            {
                return;
            }
            case MSG_C_REGISTER: //用户注册
            {
                self::ProcMsg(Core\MT_REGISTER, $client_id, $data);
                return;
            }
            case MSG_C_LOGIN_IN: //用户登录
            {
                self::ProcMsg(Core\MT_LOGIN_IN, $client_id, $data);
                return;
            }
            case MSG_C_GROUP_LIST: //获取群列表
            {
                self::ProcMsg(Core\MT_GROUP_LIST, $client_id, $data);
                return;
            }
            case MSG_C_ALL_REGISTER_USER_LIST: { //获取所有注册用户列表
                self::ProcMsg(Core\MT_ALL_REGISTER_USER_LIST, $client_id, $data);
                return;
            }
            case MSG_C_GROUP_MEMBER_LIST: //获取群成员列表
            {
                self::ProcMsg(Core\MT_GROUP_MEMBER_LIST, $client_id, $data);
                return;
            }
            case MSG_C_JOIN_GROUP:   //用户加入群组
            {
                self::ProcMsg(Core\MT_JOIN_GROUP, $client_id, $data);
                break;
            }
            case MSG_C_LEAVE_GROUP:  //用户离开群组
            {
                self::ProcMsg(Core\MT_LEAVE_GROUP, $client_id, $data);
                break;
            }
            case MSG_C_GROUP_CHAT:   //群聊信息
            {
                self::ProcMsg(Core\MT_GROUP_CHAT, $client_id, $data);
                break;
            }
            case MSG_C_USER_CHAT:    //用户私聊信息
            {
                self::ProcMsg(Core\MT_USER_CHAT, $client_id, $data);
                break;
            }
            case MSG_C_UPDATE_GROUP_AVATAR: //更新群头像
            {
                self::ProcMsg(Core\MT_UPDATE_GROUP_AVATAR, $client_id, $data);
                break;
            }
            case MSG_C_UPDATE_USER_AVATAR:  //更新用户头像
            {
                self::ProcMsg(Core\MT_UPDATE_USER_AVATAR, $client_id, $data);
                break;
            }
            case MSG_C_GROUP_CHAT_HISTORY: //用户群聊历史记录
            {
                self::ProcMsg(Core\MT_GROUP_CHAT_HISTORY, $client_id, $data);
                break;
            }
            case MSG_C_USER_CHAT_HISTORY: //用户私聊历史记录
            {
                self::ProcMsg(Core\MT_USER_CHAT_HISTORY, $client_id, $data);
                break;
            }
            case MSG_C_USER_DETAIL: //用户详细资料
            {
                self::ProcMsg(Core\MT_USER_DETAIL, $client_id, $data);
                break;
            }
            case MSG_C_MODIFY_USER_COMPANY: //修改用户公司
            {
                self::ProcMsg(Core\MT_MODIFY_USER_COMPANY, $client_id, $data);
                break;
            }
            case MSG_C_MODIFY_USER_FIELD: //修改用户行业
            {
                self::ProcMsg(Core\MT_MODIFY_USER_FIELD, $client_id, $data);
                break;
            }
            case MSG_C_MODIFY_USER_JOB: //修改用户职位
            {
                self::ProcMsg(Core\MT_MODIFY_USER_JOB, $client_id, $data);
                break;
            }
            case MSG_C_UNREAD_GROUP_CHAT_LIST: //未读群消息列表
            {
                self::ProcMsg(Core\MT_UNREAD_GROUP_CHAT_LIST, $client_id, $data);
                break;
            }
            case MSG_C_UNREAD_USER_CHAT_LIST: //未读用户消息列表
            {
                self::ProcMsg(Core\MT_UNREAD_USER_CHAT_LIST, $client_id, $data);
                break;
            }
            case MSG_C_ABOUT_ME: //个人信息
            {
                self::ProcMsg(Core\MT_ABOUT_ME, $client_id, $data);
                break;
            }
            case MSG_C_USER_FOLLOW_LIST: //用户关注列表
            {
                self::ProcMsg(Core\MT_USER_FOLLOW_LIST, $client_id, $data);
                break;
            }
            case MSG_C_CREATE_PRIVATE_GROUP://创建用户私聊群
            {
                self::ProcMsg(Core\MT_CREATE_PRIVATE_GROUP, $client_id, $data);
                break;
            }
            case MSG_C_GROUP_DETAIL: //获取用户详细资料
            {
                self::ProcMsg(Core\MT_GROUP_DETAIL, $client_id, $data);
                break;
            }
            case MSG_C_FOLLOW_SINGLE_USER: //关注单个用户
            {
                self::ProcMsg(Core\MT_FOLLOW_SINGLE_USER, $client_id, $data);
                break;
            }
            case MSG_C_UNFOLLOW_SINGLE_USER: //取消关注单个用户
            {
                self::ProcMsg(Core\MT_UNFOLLOW_SINGLE_USER, $client_id, $data);
                break;
            }
            case MSG_C_FOLLOW_MULTI_USER: //同时关注多个用户
            {
                self::ProcMsg(Core\MT_FOLLOW_MULTI_USER, $client_id, $data);
                break;
            }
            case MSG_C_UNFOLLOW_MULTI_USER: //同时取消关注多个用户
            {
                self::ProcMsg(Core\MT_UNFOLLOW_MULTI_USER, $client_id, $data);
                break;
            }
            case MSG_C_USER_LIST_ABOUT_FOLLOW: //获取用户相互关注的信息
            {
                self::ProcMsg(Core\MT_USER_LIST_ABOUT_FOLLOW, $client_id, $data);
                break;
            }
            case MSG_C_RESET_UNREAD_USER_MSG: //清空未读消息数据
            {
                self::ProcMsg(Core\MT_RESET_UNREAD_USER_MSG, $client_id, $data);
                break;
            }
            case MSG_C_RESET_UNREAD_GROUP_MSG: //清空未读群消息数据
            {
                self::ProcMsg(Core\MT_RESET_UNREAD_GROUP_MSG, $client_id, $data);
                break;
            }
            case MSG_C_INVITE_NEW_GROUP_MEMBER: //邀请新群成员
            {
                self::ProcMsg(Core\MT_INVITE_NEW_GROUP_MEMBER, $client_id, $data);
                break;
            }
            case MSG_C_USER_LIST_ABOUT_INVITE: //获取现有成员
            {
                self::ProcMsg(Core\MT_USER_LIST_ABOUT_INVITE, $client_id, $data);
                break;
            }
            case MSG_C_NEW_POST: //发布朋友圈说说
            {
                self::ProcMsg(Core\MT_NEW_POST, $client_id, $data);
                break;
            }
            case MSG_C_DELETE_POST: //删除朋友圈说说
            {
                self::ProcMsg(Core\MT_DELETE_POST, $client_id, $data);
                break;
            }
            case MSG_C_POST_FAVORITE: //朋友圈说说点赞
            {
                self::ProcMsg(Core\MT_POST_FAVORITE, $client_id, $data);
                break;
            }
            case MSG_C_POST_UN_FAVORITE: //取消朋友圈说说点赞
            {
                self::ProcMsg(Core\MT_POST_UN_FAVORITE, $client_id, $data);
                break;
            }
            case MSG_C_POST_REVIEW: //朋友圈说说评论
            {
                self::ProcMsg(Core\MT_POST_REVIEW, $client_id, $data);
                break;
            }
            case MSG_C_DELETE_POST_REVIEW: //删除朋友圈说说评论
            {
                self::ProcMsg(Core\MT_DELETE_POST_REVIEW, $client_id, $data);
                break;
            }
            case MSG_C_POST_IMG_FAVORITE: //朋友圈说说图片点赞
            {
                self::ProcMsg(Core\MT_POST_IMG_FAVORITE, $client_id, $data);
                break;
            }
            case MSG_C_POST_IMG_UN_FAVORITE: //取消朋友圈说说图片点赞
            {
                self::ProcMsg(Core\MT_POST_IMG_UN_FAVORITE, $client_id, $data);
                break;
            }
            case MSG_C_POST_IMG_REVIEW: //朋友圈说说图片评论
            {
                self::ProcMsg(Core\MT_POST_IMG_REVIEW, $client_id, $data);
                break;
            }
            case MSG_C_DELETE_POST_IMG_REVIEW: //删除朋友圈说说图片评论
            {
                self::ProcMsg(Core\MT_DELETE_POST_IMG_REVIEW, $client_id, $data);
                break;
            }
            case MSG_C_POST_LIST: //朋友圈说说列表
            {
                self::ProcMsg(Core\MT_POST_LIST, $client_id, $data);
                break;
            }
            case MSG_C_GROUP_NOTICE_LIST: //群通知列表
            {
                self::ProcMsg(Core\MT_GROUP_NOTICE_LIST,$client_id,$data);
                break;
            }
            case MSG_C_GROUP_ANNOUNCE_LIST :   //群公告列表
            {
                self::ProcMsg(Core\MT_GROUP_ANNOUNCE_LIST,$client_id,$data);
                break;
            }
            case MSG_C_NEW_GROUP_ANNOUNCE:    //新群公告
            {
                self::ProcMsg(Core\MT_NEW_GROUP_ANNOUNCE,$client_id,$data);
                break;
            }
            case MSG_C_EDIT_GROUP_ANNOUNCE: //编辑群公告
            {
                self::ProcMsg(Core\MT_EDIT_GROUP_ANNOUNCE,$client_id,$data);
                break;
            }
            case MSG_C_DELETE_GROUP_ANNOUNCE : //删除群公告
            {
                self::ProcMsg(Core\MT_DELETE_GROUP_ANNOUNCE,$client_id,$data);
                break;
            }
            case MSG_C_GROUP_FILE_LIST: //群文件列表
            {
                self::ProcMsg(Core\MT_GROUP_FILE_LIST,$client_id,$data);
                break;
            }
            case MSG_C_NEW_GROUP_FILE : //新群文件
            {
                self::ProcMsg(Core\MT_NEW_GROUP_FILE,$client_id,$data);
                break;
            }
            case MSG_C_DELETE_GROUP_FILE: //删除群文件
            {
                self::ProcMsg(Core\MT_DELETE_GROUP_FILE,$client_id,$data);
                break;
            }
            case MSG_C_GROUP_ALBUM_LIST:  //群相册列表
            {
                self::ProcMsg(Core\MT_GROUP_ALBUM_LIST,$client_id,$data);
                break;
            }
            case MSG_C_GROUP_IMAGE_LIST: //群相册列表
            {
                self::ProcMsg(Core\MT_GROUP_IMAGE_LIST,$client_id,$data);
                break;
            }
            case MSG_C_NEW_GROUP_ALBUM :   //创建新的群相册
            {
                self::ProcMsg(Core\MT_NEW_GROUP_ALBUM,$client_id,$data);
                break;
            }
            case MSG_C_EDIT_GROUP_ALBUM_NAME: //编辑群相册名字
            {
                self::ProcMsg(Core\MT_EDIT_GROUP_ALBUM_NAME,$client_id,$data);
                break;
            }
            case MSG_C_EDIT_GROUP_ALBUM_DESC : //编辑群相册的描述
            {
                self::ProcMsg(Core\MT_EDIT_GROUP_ALBUM_DESC,$client_id,$data);
                break;
            }
            case MSG_C_DELETE_GROUP_ALBUM ://删除创建的的群相册
            {
                self::ProcMsg(Core\MT_DELETE_GROUP_ALBUM,$client_id,$data);
                break;
            }
            case MSG_C_UPLOAD_IMG_TO_GROUP_ALBUM: //上传照片至群相册
            {
                self::ProcMsg(Core\MT_UPLOAD_IMG_TO_GROUP_ALBUM,$client_id,$data);
                break;
            }
            case MSG_C_DELETE_GROUP_ALBUM_IMG://删除群相册里面的图片
            {
                self::ProcMsg(Core\MT_DELETE_GROUP_ALBUM_IMG,$client_id,$data);
                break;
            }
            default:
                break;
        }
    }

    /**
     * 有消息时
     * @param int $client_id
     * @param string $message
     */
    public static function ProcMsg($message_type, $client_id, $data)
    {
        CYdChatApp::Instance()->GetMessageManager()->ProcessMessage($message_type, $client_id, $data);
    }

    /**
     * 当客户端断开连接时
     * @param integer $client_id 客户端id
     */
    public static function onClose($client_id)
    {
        // debug
        echo "client:{$_SERVER['REMOTE_ADDR']}:{$_SERVER['REMOTE_PORT']} gateway:{$_SERVER['GATEWAY_ADDR']}:{$_SERVER['GATEWAY_PORT']}  client_id:$client_id onClose:''\n";
        self::ProcMsg(Core\MT_LOGIN_OUT, $client_id, '');
    }
}
