<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-28
 * Time: 下午1:45
 */
namespace YiDou\Core;

use GatewayWorker\Lib\Db;
use YiDou\Client\CAboutMeMsg;
use YiDou\Client\CAllRegisterUserListMsg;
use YiDou\Client\CCreatePrivateGroupMsg;
use YiDou\Client\CFollowMultiUserMsg;
use YiDou\Client\CFollowSingleUserMsg;
use YiDou\Client\CGroupChatHistoryMsg;
use YiDou\Client\CGroupChatMsg;
use YiDou\Client\CGroupDetailMsg;
use YiDou\Client\CGroupListMsg;
use YiDou\Client\CGroupNoticeListMsg;
use YiDou\Client\CGroupNoticeMsg;
use YiDou\Client\CInviteNewGroupMemberMsg;
use YiDou\Client\CModifyUserCompanyMsg;
use YiDou\Client\CModifyUserFieldMsg;
use YiDou\Client\CModifyUserJobMsg;
use YiDou\Client\CNewPostMsg;
use YiDou\Client\CPostFavoriteMsg;
use YiDou\Client\CPostListMsg;
use YiDou\Client\CPostReviewMsg;
use YiDou\Client\CPostUnFavoriteMsg;
use YiDou\Client\CResetUnReadUserMsgMsg;
use YiDou\Client\CUnFollowSingleUserMsg;
use YiDou\Client\CUnreadGroupChatListMsg;
use YiDou\Client\CUnreadUserChatListMsg;
use YiDou\Client\CUserChatHistoryMsg;
use YiDou\Client\CUserChatMsg;
use YiDou\Client\CUserDetailMsg;
use YiDou\Client\CUserFollowListMsg;
use YiDou\Client\CUserListAboutFollowMsg;
use YiDou\Client\CUserListAboutInviteMsg;
use YiDOu\Client\EnumGroupRole;
use YiDou\Server\CYdChatApp;
use YiDou\Util\CUtil;
use YiDou\Client\CGroupAnnounceListMsg;
use YiDou\Client\CNewGroupAnnounceMsg;
use YiDou\Client\CEditGroupAnnounceMsg;
use YiDou\Client\CDeleteGroupAnnounceMsg;
use YiDou\Client\CGroupFileListMsg;
use YiDou\Client\CNewGroupFileMsg;
use YiDou\Client\CDeleteGroupFileMsg;
use YiDou\Client\CGroupAlbumListMsg;
use YiDou\Client\CNewGroupAlbumMsg;
use YiDou\Client\CGroupImageListMsg;
use YiDou\Client\CEditGroupAlbumNameMsg;
use YiDou\Client\CEditGroupAlbumDescMsg;
use YiDou\Client\CUploadImgToGroupAlbumMsg;
use YiDou\Client\CDeleteGroupAlbumMsg;
use YiDou\Client\CDeleteGroupAlbumImgMsg;


require_once __DIR__ . "/../Client/msg.client.php";

const MT_REGISTER = 1; //用户注册
const MT_LOGIN_IN = 2; //用户登录
const MT_LOGIN_OUT = 3; //用户退出
const MT_JOIN_GROUP = 4; //用户加入群组
const MT_LEAVE_GROUP = 5; //用户离开群组
const MT_USER_CHAT = 6; //用户聊天
const MT_GROUP_CHAT = 7; //群聊
const MT_USER_CHAT_HISTORY = 8; // 群聊天记录
const MT_GROUP_CHAT_HISTORY = 9; //群聊记录
const MT_GENERAL_CONTACTS = 10;//用户常用联系人
const MT_UPDATE_GROUP_AVATAR = 11; //更新群头像
const MT_UPDATE_USER_AVATAR = 12; //更新用户头像
const MT_RECENT_CONTACTS = 13; //常用联系人
const MT_GROUP_LIST = 14; //用户加入的群列表
const MT_GROUP_MEMBER_LIST = 15; //群所有成员列表
const MT_USER_DETAIL = 16; //用户详细资料
const MT_MODIFY_USER_COMPANY = 17; //修改用户公司
const MT_MODIFY_USER_JOB = 18; //修改用户工作
const MT_MODIFY_USER_FIELD = 19; //修改用户行业
const MT_UNREAD_USER_CHAT_LIST = 20;  //查看未读的私聊记录
const MT_UNREAD_GROUP_CHAT_LIST = 21; //查看未读的群聊记录
const MT_ABOUT_ME = 22; //获取个人信息
const MT_ALL_REGISTER_USER_LIST = 23; //所有注册用户列表
const MT_USER_FOLLOW_LIST = 24; //用户的关注列表
const MT_CREATE_PRIVATE_GROUP = 25; //创建用户私聊群
const MT_GROUP_DETAIL = 26; //群详细资料
const MT_FOLLOW_SINGLE_USER = 27; //关注单个用户
const MT_UNFOLLOW_SINGLE_USER = 28; //取消关注单个用户
const MT_FOLLOW_MULTI_USER = 29; //关注多个用户
const MT_UNFOLLOW_MULTI_USER = 30; //取消关注多个用户
const MT_USER_LIST_ABOUT_FOLLOW = 31; //获取带关注的用户列表
const MT_RESET_UNREAD_USER_MSG = 32; //清空未读消息数据
const MT_RESET_UNREAD_GROUP_MSG = 33; //清空未读群消息数据
const MT_INVITE_NEW_GROUP_MEMBER = 34; //邀请新的群成员
const MT_USER_LIST_ABOUT_INVITE = 35; //邀请新群成员的时候进行的查询
const MT_GROUP_NOTICE = 36; //群通知
const MT_GROUP_NOTICE_DETAIL = 37; //群通知详情
const MT_GROUP_NOTICE_LIST = 38; //群通知列表
const MT_SYS_NOTICE = 39; //系统通知
const MT_SYS_NOTICE_DETAIL = 40; //系统通知详情
const MT_NOTICE_LIST = 41; //系统通知列表
const MT_NEW_POST = 42; //发布朋友圈说说
const MT_DELETE_POST = 43; //删除朋友圈说说
const MT_POST_FAVORITE = 44; //朋友圈说说点赞
const MT_POST_UN_FAVORITE = 45; //取消朋友圈说说点赞
const MT_POST_REVIEW = 46; //朋友圈说说评论
const MT_DELETE_POST_REVIEW = 47; //删除朋友圈说说评论
const MT_POST_IMG_FAVORITE = 48; //朋友圈说说图片点赞
const MT_POST_IMG_UN_FAVORITE = 49; //取消朋友圈说说图片点赞
const MT_POST_IMG_REVIEW = 50; //朋友圈说说图片评论
const MT_DELETE_POST_IMG_REVIEW = 51; //删除朋友圈说说图片评论
const MT_POST_LIST = 52; //获取朋友圈列表
// 群功能选项
const MT_GROUP_ANNOUNCE_LIST = 53;   //群公告列表
const MT_NEW_GROUP_ANNOUNCE = 54;    //新群公告
const MT_EDIT_GROUP_ANNOUNCE= 55; //编辑群公告
const MT_DELETE_GROUP_ANNOUNCE = 56; //删除群公告
const MT_GROUP_FILE_LIST = 57; //群文件列表
const MT_NEW_GROUP_FILE = 58;  //新群文件
const MT_DELETE_GROUP_FILE = 59; //删除群文件
const MT_GROUP_ALBUM_LIST = 60;  //群相册列表
const MT_NEW_GROUP_ALBUM = 61;   //创建新的群相册
const MT_EDIT_GROUP_ALBUM_NAME = 62; //编辑群相册名字
const MT_EDIT_GROUP_ALBUM_DESC = 63; //编辑群相册的描述
const MT_DELETE_GROUP_ALBUM = 64; //删除创建的的群相册
const MT_UPLOAD_IMG_TO_GROUP_ALBUM = 65; //删除照片至群相册
const MT_DELETE_GROUP_ALBUM_IMG = 66; //删除群相册里面的图片
const MT_GROUP_IMAGE_LIST = 67; //群相册

//同意加入新群组
const MT_AGREE_JOIN_NEW_GROUP = 66; //同意加入新群组

const CHAT_TYPE_NORMAL_CHAT = 1;
const CHAT_TYPE_JOIN_GROUP = 2;
const CHAT_TYPE_SYSTEM = 2;
const CHAT_TYPE_REGISTER = 2;
const CHAT_TYPE_PICTURE = 4;
const CHAT_TYPE_VIDEO = 5;
const CHAT_TYPE_ATTACHMENT = 6;
// Notice 类型
const NOTICE_TYPE_JOIN_GROUP = 100;
const GROUP_NOTICE_INVITE = 101;
const GROUP_NOTICE_AGREE_INVITE = 102;
const GROUP_NOTICE_REJECT_INVITE = 103;

//通知事件
const S_PUBLIC_GROUP_ID = 10000; //不能修改，必须和数据库保持一致

/***********************************
 * Class CMessageManager 消息处理中心
 * @package YiDou
 ***********************************/
class CMessageManager extends CSingleton
{
    //内部维护消息处理的
    private static $_received_msgs = 0;
    private static $_bad_msgs = 0;
    private static $_good_msgs = 0;
    private static $_unrecognize_msgs = 0;

    protected function __construct()
    {
        self::$_received_msgs = 0;
        self::$_bad_msgs = 0;
        self::$_good_msgs = 0;
        self::$_unrecognize_msgs = 0;
    }

    /**************************
     * @param $msg_type 消息类型
     * @param $data 传递的数据
     **************************/
    public function ProcessMessage($msg_type, $client_id, $data)
    {
        self::$_received_msgs++;
        switch ($msg_type) {
            case MT_REGISTER: //用户注册
                $name = htmlspecialchars($data['client_name']);
                $mobile = htmlspecialchars($data['mobile']);
                $avatar = htmlspecialchars($data["avatar"]);
                $user = new CUser($name, $mobile, $avatar);
                $user->SetClientID($client_id); //这一步一定要设置，要不然注册信息无法广播出去
                CYdChatApp::Instance()->GetUserManager()->UserRegister($user); //保存注册信息到数据
                break;
            case MT_JOIN_GROUP: //用户入群

                break;
            case MT_LOGIN_IN: //用户登录
                $leader_id = $data["leader_id"];
                CYdChatApp::Instance()->GetUserManager()->UserLoginIn($leader_id, $client_id);
                break;
            case MT_LOGIN_OUT: //用户退出
                CYdChatApp::Instance()->GetUserManager()->UserLoginOut($client_id);
                break;
            case MT_GROUP_LIST: //获取用户加入的群信息
                $this->ProcessGroupList($client_id, $data);
                break;
            case MT_ALL_REGISTER_USER_LIST: //所有注册用户列表
                $this->ProcessAllRegisterUserList($client_id, S_PUBLIC_GROUP_ID);
                break;
            case MT_GROUP_MEMBER_LIST: //获取群里所有成员的信息
                $group_id = $data["group_id"];
                CYdChatApp::Instance()->GetGroupManager()->GetGroupMemberList($group_id, $client_id);
                break;
            case MT_GENERAL_CONTACTS: //获取用户常用联系人
                break;
            case MT_GROUP_CHAT: //群聊信息
                $this->ProcessGroupChat($client_id, $data);
                break;
            case MT_USER_CHAT: //私聊信息
                $this->ProcessUserChat($client_id, $data);
                break;
            case MT_GROUP_CHAT_HISTORY: //群聊消息历史记录
                $this->ProcessGroupChatHistory($client_id, $data);
                break;
            case MT_USER_CHAT_HISTORY: //私聊消息历史记录_
                $this->ProcessUserChatHistory($client_id, $data);
                break;
            case MT_USER_DETAIL: //用户详细资料
                $this->ProcessUserDetail($client_id, $data);
                break;
            case MT_MODIFY_USER_COMPANY: //修改用户公司
                $this->ProcessModifyUserCompany($client_id, $data);
                break;
            case MT_MODIFY_USER_JOB: //修改用户工作
                $this->ProcessModifyUserJob($client_id, $data);
                break;
            case MT_MODIFY_USER_FIELD: //修改用户行业
                $this->ProcessModifyUserField($client_id, $data);
                break;
            case MT_UNREAD_USER_CHAT_LIST://用户未读消息列表
                $this->ProcessUnreadUserChatList($client_id, $data);
                break;
            case MT_UNREAD_GROUP_CHAT_LIST: //群未读消息列表
                $this->ProcessUnreadGroupChatList($client_id, $data);
                break;
            case MT_ABOUT_ME:
                $this->ProcessAboutMe($client_id, $data);
                break;
            case MT_USER_FOLLOW_LIST:
                $this->ProcessUserFollowList($client_id, $data);
                break;
            case MT_CREATE_PRIVATE_GROUP:
                $this->ProcessCreatePrivateGroup($client_id, $data);
                break;
            case MT_GROUP_DETAIL:
                $this->ProcessGroupDetail($client_id, $data);
                break;
            case MT_FOLLOW_SINGLE_USER:
                $this->ProcessFollowSingleUser($client_id, $data);
                break;
            case MT_UNFOLLOW_SINGLE_USER:
                $this->ProcessUnFollowSingleUser($client_id, $data);
                break;
            case MT_FOLLOW_MULTI_USER:
                $this->ProcessFollowMultiUser($client_id, $data);
                break;
            case MT_UNFOLLOW_MULTI_USER:
                $this->ProcessUnfollowMultiUser($client_id, $data);
                break;
            case MT_USER_LIST_ABOUT_FOLLOW:
                $this->ProcessUserListAboutFollow($client_id, $data);
                break;
            case MT_RESET_UNREAD_USER_MSG:
                $this->ProcessUnreadUserMsg($client_id, $data);
                break;
            case MT_RESET_UNREAD_GROUP_MSG:
                $this->ProcessResetUnreadGroupMsg($client_id, $data);
                break;
            case MT_INVITE_NEW_GROUP_MEMBER:
                $this->ProcessInviteNewGroupMember($client_id, $data);
                break;
            case MT_USER_LIST_ABOUT_INVITE:
                $this->ProcessUserListAboutInvite($client_id, $data);
                break;
            case MT_GROUP_NOTICE:
                $this->ProcessGroupNotice($client_id, $data);
                break;
            case MT_GROUP_NOTICE_DETAIL:
                $this->ProcessGroupNoticeDetail($client_id, $data);
                break;
            case MT_GROUP_NOTICE_LIST:
                $this->ProcessGroupNoticeList($client_id, $data);
                break;
            case MT_SYS_NOTICE:
                $this->ProcessSysNotice($client_id, $data);
                break;
            case MT_SYS_NOTICE_DETAIL:
                $this->ProcessSysNoticeDetail($client_id, $data);
                break;
            case MT_NOTICE_LIST:
                $this->ProcessNoticeList($client_id, $data);
                break;
            case MT_NEW_POST: // 发表朋友圈 说说
                $this->ProcessNewPost($client_id, $data);
                break;
            case MT_DELETE_POST: //删除 朋友圈说说
                $this->ProcessDeletePost($client_id, $data);
                break;
            case MT_POST_FAVORITE: // 朋友圈 点赞
                $this->ProcessPostFavorite($client_id, $data);
                break;
            case MT_POST_UN_FAVORITE: // 朋友圈 取消点赞
                $this->ProcessPostUnFavorite($client_id, $data);
                break;
            case MT_POST_REVIEW: // 朋友圈 评论
                $this->ProcessPostReview($client_id, $data);
                break;
            case MT_DELETE_POST_REVIEW: //删除 朋友圈 评论
                $this->ProcessDeletePostReview($client_id, $data);
                break;
            case MT_POST_IMG_FAVORITE: //朋友圈 说说图片 点赞
                $this->ProcessPostImgFavorite($client_id, $data);
                break;
            case MT_POST_IMG_UN_FAVORITE: //朋友圈 说说图片 取消点赞
                $this->ProcessPostImgUnFavorite($client_id, $data);
                break;
            case MT_POST_IMG_REVIEW: //朋友圈 说说图片 评论
                $this->ProcessPostImgReview($client_id, $data);
                break;
            case MT_DELETE_POST_IMG_REVIEW: //删除朋友圈 说说图片 评论
                $this->ProcessDeletePostImgReview($client_id, $data);
                break;
            case MT_POST_LIST: // 获取朋友圈列表
                $this->ProcessPostList($client_id, $data);
                break;
            case MT_GROUP_ANNOUNCE_LIST:   //群公告列表
                $this->ProcessGroupAnnounceList($client_id, $data);
                break;
            case MT_NEW_GROUP_ANNOUNCE:    //新群公告
                $this->ProcessNewGroupAnnounce($client_id, $data);
                break;
            case MT_EDIT_GROUP_ANNOUNCE: //编辑群公告
                $this->ProcessEditGroupAnnounce($client_id, $data);
                break;
            case MT_DELETE_GROUP_ANNOUNCE: //删除群公告
                $this->ProcessDeleteGroupAnnounce($client_id, $data);
                break;
            case MT_GROUP_FILE_LIST: //群文件列表
                $this->ProcessGroupFileList($client_id, $data);
                break;
            case MT_NEW_GROUP_FILE:  //新群文件
                $this->ProcessNewGroupFile($client_id, $data);
                break;
            case MT_DELETE_GROUP_FILE: //删除群文件
                $this->ProcessDeleteGroupFile($client_id, $data);
                break;
            case MT_GROUP_ALBUM_LIST:  //群相册列表
                $this->ProcessGroupAlbumList($client_id, $data);
                break;
            case MT_GROUP_IMAGE_LIST:  //群照片列表
                $this->ProcessGroupImageList($client_id, $data);
                break;
            case MT_NEW_GROUP_ALBUM:  //创建新的群相册
                $this->ProcessNewGroupAlbum($client_id,$data);
                break;
            case MT_EDIT_GROUP_ALBUM_NAME: //编辑群相册名字
                $this->ProcessEditGroupAlbumName($client_id,$data);
                break;
            case MT_EDIT_GROUP_ALBUM_DESC: //编辑群相册的描述
                $this->ProcessEditGroupAlbumDesc($client_id,$data);
                break;
            case MT_DELETE_GROUP_ALBUM: //删除创建的的群相册
                $this->ProcessDeleteGroupAlbum($client_id,$data);
                break;
            case MT_UPLOAD_IMG_TO_GROUP_ALBUM: //删除照片至群相册
                $this->ProcessUploadImgToGroupAlbum($client_id,$data);
                break;
            case MT_DELETE_GROUP_ALBUM_IMG: //删除群相册里面的图片
                $this->ProcessDeleteGroupAlbumImg($client_id,$data);
                break;
            case MT_AGREE_JOIN_NEW_GROUP: //同意加入新群组
                $this->ProcessAgreeJoinNewGroup($client_id,$data);
            default: //不识别的消息
                self::$_unrecognize_msgs++;
                break;
        }
    }
    //同意加入新的群组
    public function ProcessAgreeJoinNewGroup($client_id,$data){
        $user_name = $data['user_name'];
        $user_avatar = $data['user_avatar'];
        $group_id = $data['group_id'];
        $group_name = $data['group_name'];
        $leader_id = $data['leader_id'];
        $inviter_id = $data['inviter_id'];
        $sqlJoin = 'INSERT INTO `yd_group_member`(`group_id`,`leader_id`,`is_authentication`,`user_role`)VALUES(
              $group_id,$leader_id,1,'.EnumGroupRole::ROLE_USER.')';
        Db::instance('db_yd')->query($sqlJoin);
        $nc = $user_name.'同意入群'.$group_name;
        $sqlNotice = 'INSERT INTO `yd_group_notice`(`group_id`,`notice_type`,`sender_id`,`notice_title`,
            `notice_content`,`receiver_id`,`is_viewed`)VALUES('.$group_id.','.GROUP_NOTICE_AGREE_INVITE.'
            ,'.$leader_id.','.$user_name.','.$nc.','.$inviter_id.','.',0)';
        Db::instance('db_yd')->query($sqlNotice);
        $content = array(
            'notice_type'=> GROUP_NOTICE_AGREE_INVITE,
            'notice_title'=>$group_name,
            'notice_content'=>$nc,
            'notice_time'=>Cutil::GetCurrentTime(),
            );
        $msg = new CGroupNoticeMsg($content,$inviter_id,$inviter_id);
        $msg->Send();
    }
    //编辑群相册名字
    public function ProcessEditGroupAlbumName($client_id,$data){

    }
    //编辑群相册描述
    public function ProcessEditGroupAlbumDesc($client_id,$data){

    }
    //删除群相册
    public function ProcessDeleteGroupAlbum($client_id,$data){

    }
    //上传照片至群相册
    public function ProcessUploadImgToGroupAlbum($client_id,$data){
        $path = $data['path'];
        $group_id = $data['group_id'];
        $leader_id = $data['leader_id'];
        $album_id = $data['album_id'];
        $str = '';
        if($album_id ==0){
            $sql1 = 'SELECT album_id FROM `yd_group_album` WHERE `group_id` = '.$group_id;
            $res = Db::instance('db_yd')->query($sql1);
            if($res){
                foreach($res as $k=>$v){
                    $album_id = $v['album_id'];
                    break;
                }
            }else{
                $sql2 = 'INSERT INTO `yd_group_album`(`group_id`,`album_name`,`album_desc`,`create_by`)
                    VALUES('.$group_id.',"默认相册","默认相册",'.$leader_id.')';
                $album_id = Db::instance('db_yd')->query($sql2);
            }
        }
        foreach($path as $k=>$v){
            $str .= '('.$album_id.','.$group_id.',"'.$v.'",'.$leader_id.'),';
        }
        $str = rtrim($str,',');
        $sql = 'INSERT INTO `yd_group_album_image` (`group_album_id`,`group_id`,`path`,`create_by`)VALUES'.$str;
        CUtil::Log('上传群图片',$sql);
        Db::instance('db_yd')->query($sql);
        $content = array('album_id'=>$album_id,"image_path"=>$path);
        $msg = new CUploadImgToGroupAlbumMsg($content,$client_id,$client_id,$group_id);
        $msg->Send();
    }
    //删除群相册里面的图片
    public function ProcessDeleteGroupAlbumImg($client_id,$data){

    }
    //新群相册
    public function ProcessNewGroupAlbum($client_id,$data){
        $group_id = $data['group_id'];
        $album_name = $data['album_name'];
        $album_desc = $data['album_desc'];
        $leader_id = $data['leader_id'];
        $sql = 'INSERT INTO `yd_group_album`(`group_id`,`album_name`,`album_desc`,`create_by`)
              VALUES('.$group_id.',"'.$album_name.'","'.$album_desc.'",'.$leader_id.')';
        $album_id = Db::instance('db_yd')->query($sql);
        $content = array(
            "group_id"=>$group_id,
            "album_name"=>$album_name,
            "album_desc"=>$album_desc,
            "leader_id"=>$leader_id,
            "album_id"=>$album_id
        );
        $msg = new CNewGroupAlbumMsg($content,$client_id,$client_id);
        $msg->Send();
    }
    //群相册列表
    public function ProcessGroupAlbumList($client_id,$data){
        $group_id = $data['group_id'];
        $stage = $data['stage'];
        //获取所有的相册名字
        $sql= 'SELECT count(B.group_album_id) AS img_count,A.album_id,A.group_id,A.album_name,A.album_desc,A.create_time,B.path
             FROM `yd_group_album` AS A LEFT JOIN `yd_group_album_image` AS B
             ON A.album_id = B.group_album_id WHERE A.is_valid = 1 AND A.group_id = '.$group_id.'
             GROUP BY A.album_id ORDER BY B.create_time DESC ';
        CUtil::Log('群相册列表',$sql);
        $list = Db::instance('db_yd')->query($sql);
        $content = array(
            "album_list"=>$list,
            "group_id"=>$group_id,
            "stage"=>$stage
        );
        $msg = new CGroupAlbumListMsg($content,$client_id,$client_id);
        $msg->Send();
    }
    //群照片列表
    public function ProcessGroupImageList($client_id,$data){
        $group_id = $data['group_id'];
        $sql = 'SELECT A.path,A.create_time FROM `yd_group_album_image` AS A
               LEFT JOIN `yd_group_album` AS B ON A.group_album_id = B.album_id
               WHERE B.group_id = '.$group_id.' AND A.is_valid = 1 AND B.is_valid = 1 ORDER BY A.create_time DESC';
        CUtil::Log("群照片列表",$sql);
        $list = Db::instance('db_yd')->query($sql);
        CUtil::Log("群照片列表",JSON_ENCODE($list,JSON_UNESCAPED_UNICODE));
        $content = array('imageList'=>$list,'group_id'=>$group_id);
        $msg = new CGroupImageListMsg($content,$client_id,$client_id,$group_id);
        $msg->Send();
    }
    //群公告列表
    public function ProcessGroupAnnounceList($client_id,$data){
        $group_id = $data['group_id'];
        $sql = 'SELECT A.id as announce_id, A.group_id,A.leader_id,B.user_name,A.title,A.content,A.create_time FROM `yd_group_announce`
              AS A LEFT JOIN `yd_user` AS B ON A.leader_id = B.leader_id WHERE A.is_valid = 1 AND A.group_id = '.$group_id.' ORDER BY A.create_time DESC';
        CUtil::Log("群公告列表",$sql);
        $list = Db::instance('db_yd')->query($sql);
        $content = array('announce'=>$list,'group_id'=>$group_id);
        $msg = new CGroupAnnounceListMsg($content,$client_id,$client_id);
        $msg->Send();
    }
    //新群公告
    public function ProcessNewGroupAnnounce($client_id,$data){
        $leader_id = $data['leader_id'];
        $user_name = $data['user_name'];
        $user_avatar = $data['user_avatar'];
        $group_id = $data['group_id'];
        $title = htmlspecialchars(str_replace("'","\'",$data['title']));
        $content = htmlspecialchars(str_replace("'","\'",$data['content']));
        $sql = 'INSERT INTO `yd_group_announce`(`group_id`,`leader_id`,`title`,`content`)VALUES(
                '.$group_id.','.$leader_id.',"'.$title.'","'.$content.'")';
        CUtil::Log("新群公告",$sql);
        $insert_id = Db::instance('db_yd')->query($sql);
        $d = array('group_id'=>$group_id,
            'leader_id'=>$leader_id,
            'user_name'=>$user_name,
            'user_avatar'=>$user_avatar,
            'title'=>$title,
            'content'=>$content,
            'announce_id'=>$insert_id);
        $msg = new CNewGroupAnnounceMsg($d,$client_id,$client_id,$group_id);
        $msg->Send();
    }
    //编辑群公告
    public function ProcessEditGroupAnnounce($client_id,$data){
        $announce_id = $data['announce_id'];
        $title = $data['title'];
        $content = $data['content'];
        $leader_id = $data['leader_id'];
        $group_id = $data['group_id'];
        $editor_name = $data['editor_name'];
        $sql = 'UPDATE `yd_group_announce` SET `title`='.$title.',`content`='.$content.',`leader_id`='.$leader_id.' WHERE
                id = '.$announce_id;
        Db::instance('db_yd')->query($sql);
        $content = array('group_id'=>$group_id,
            'leader_id'=>$leader_id,
            'editor_name'=>$editor_name,
            'edit_time'=>CUtil::GetCurrentTime(),
            'title'=>$title,
            'content'=>$content,
            'announce_id'=>$announce_id);
        $msg = new CEditGroupAnnounceMsg($content,$client_id,$client_id,$group_id);
        $msg->Send();
    }
    //删除群公告
    public function ProcessDeleteGroupAnnounce($client_id,$data){
        $announce_id = $data['announce_id'];
        $leader_id = $data['leader_id'];
        $sql = 'UPDATE `yd_group_announce` SET `is_valid`=0 ,`leader_id` = '.$leader_id.' WHERE id = '.$announce_id;
        Db::instance('db_yd')->query($sql);
        $msg =new CDeleteGroupAnnounceMsg('',$client_id,$client_id);
        $msg->Send();
    }
    //群文件列表
    public function ProcessGroupFileList($client_id,$data){
        $group_id = $data['group_id'];
        $sql = 'SELECT A.id AS file_id,A.group_id,A.leader_id,B.user_name,A.file_name,A.file_path,A.file_type,A.file_size,A.create_time
          FROM `yd_group_file` AS A LEFT JOIN `yd_user` AS B ON A.leader_id = B.leader_id
          WHERE A.is_valid = 1 AND A.group_id = '.$group_id." ORDER BY A.create_time DESC";
        $list = Db::instance('db_yd')->query($sql);
        $content = array('fileList'=>$list,'group_id'=>$group_id);
        $msg = new CGroupFileListMsg($content,$client_id,$client_id,$group_id);
        $msg->Send();
    }
    //上传群文件
    public function ProcessNewGroupFile($client_id,$data){
        $file_name = $data['file_name'];//原始文件名
        $file_path = $data['file_path'];//服务器端文件名
        $file_type = $data['file_type'];//文件类型
        $file_size = $data['file_size'];//文件大小
        $group_id = $data['group_id']; //group_id
        $leader_id = $data['leader_id']; //leader_id
        $sql = 'INSERT INTO `yd_group_file`(`group_id`,`leader_id`,`file_name`,
                `file_path`,`file_type`,`file_size`)VALUES('.$group_id.','.$leader_id.',"'.
                $file_name.'","'.$file_path.'","'.$file_type.'","'.$file_size.'")';
        CUtil::Log('上传群文件',$sql);
        $insert_id = Db::instance('db_yd')->query($sql);
        $content = array('insert_id'=>$insert_id,'group_id'=>$group_id,'leader_id'=>$leader_id,
            'file_name'=>$file_name,'file_path'=>$file_path,'file_type'=>$file_type,'file_size'=>
            $file_size);
        $msg = new CNewGroupFileMsg($content,$client_id,$client_id,$group_id);
        $msg->Send();
    }
    //删除群文件
    public function ProcessDeleteGroupFile($client_id,$data){

    }
    public function ProcessGroupList($client_id, $data)
    {
        $leader_id = $data["leader_id"];
        $sql = 'SELECT  DISTINCT A.group_id,A.group_name,A.group_intro,A.group_avatar,A.create_by,A.create_date
        FROM `yd_group` AS A LEFT JOIN `yd_group_member` AS B ON A.group_id = B.group_id WHERE B.is_valid = 1 AND A.is_valid =1 AND B.leader_id = "' . $leader_id . '"';
        $content = Db::instance("db_yd")->query($sql);
        $msg = new CGroupListMsg($content, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessAllRegisterUserList($client_id, $public_group_id)
    {
        $sql = 'SELECT A.leader_id,A.user_name AS name,A.avatar,A.is_online AS online FROM `yd_user` AS A
                LEFT JOIN `yd_group_member` AS B ON A.leader_id = B.leader_id
                WHERE B.group_id = "' . $public_group_id . '" ORDER BY A.is_online DESC';
        $content = Db::instance("db_yd")->query($sql);
        $msg = new CAllRegisterUserListMsg($content, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessGroupChat($client_id, $data)
    {
        $group_id = intval($data["group_id"]); //必须进行转换
        $group_name = $data["group_name"];

        $user_name = $data["client_name"];
        $avatar = $data["avatar"];
        $leader_id = $data["leader_id"];
        $chat = nl2br(htmlspecialchars($data['chat']));
        $chat_type = $data['chat_type'];
        $chat_time = CUtil::GetCurrentTime();
        //插入聊天记录到数据库
        $sql = 'INSERT INTO `yd_groupmsg`(`group_id`,`sender_id`,`msg_content`,`msg_type`,send_time)VALUES
                ("' . $group_id . '","' . $leader_id . '","' . $chat . '","' . $chat_type . '","' . $chat_time . '")';
        $db_chat_id = Db::instance("db_yd")->query($sql);
        //查找群的所有成员
        $sql2 = 'SELECT `leader_id` FROM `yd_group_member` WHERE `group_id`='.$group_id.
            ' AND is_authentication = 1 AND is_valid = 1';
        $retMembers = Db::instance("db_yd")->query($sql2);
        //查找群头像
        $sqlAvatar = 'SELECT `group_avatar` FROM `yd_group` WHERE `group_id`='.$group_id;
        $retAvatar = Db::instance('db_yd')->query($sqlAvatar);
        $group_avatar = '';
        foreach($retAvatar as $key => $val){
            $group_avatar = $val['group_avatar'];
        }
        //插入一条记录到未读消息数表格
        foreach($retMembers as $key=>$val) {
            $member_id = $val['leader_id'];
            $sql3 = 'INSERT INTO `yd_unread_group_msg`(`group_id`,`leader_id`,`count`)
                    VALUES (' . $group_id . ',' . $member_id . ',1) ON DUPLICATE KEY UPDATE count=count+1';
            Db::instance('db_yd')->query($sql3);
        }
        //转发消息给在线群成员
        $content = array(
            "group_id" => $group_id,
            "group_name" => $group_name,
            "group_avatar"=>$group_avatar,
            "leader_id" => $leader_id,
            "user_avatar" => $avatar,
            "user_name" => $user_name,
            "chat" => $chat,
            "chat_type" => $chat_type,
            "chat_time"=>$chat_time,
            "db_chat_id"=>$db_chat_id
        );
        $msg = new CGroupChatMsg($content, $client_id, "all", $group_id);
        $msg->Send();
    }

    public function ProcessUserChat($client_id, $data)
    {
        $from_leader_id = $data["from_leader_id"];
        $to_leader_id = $data["to_leader_id"];
        $from_user_name = $data["from_user_name"];
        $to_user_name = $data["to_user_name"];
        $from_avatar = $data["from_user_avatar"];
        $chat = nl2br(htmlspecialchars($data['chat']));
        $chat_type = $data['chat_type'];
        $from_client_id = $client_id;

        $chat_time = CUtil::GetCurrentTime();
        //插入聊天记录到数据库
        $sql = 'INSERT INTO `yd_chatmsg`(`sender_id`,`receiver_id`,`msg_content`,`msg_type`,`send_time`)VALUES
               ("' . $from_leader_id . '","' . $to_leader_id . '","' . $chat . '","' . $chat_type . '","' . $chat_time . '")';
        Db::instance("db_yd")->query($sql);

        //插入一条记录到未读消息数表格
        $sql2 = 'INSERT INTO `yd_unread_user_msg`(`sender_id`,`receiver_id`,`count`)
                    VALUES ("' . $from_leader_id . '","' . $to_leader_id . '",1) ON DUPLICATE KEY UPDATE count=count+1';
        $db_chat_id = Db::instance("db_yd")->query($sql2);
        //发送消息给对方
        $content = array(
            "from_leader_id" => $from_leader_id,
            "to_leader_id" => $to_leader_id,
            "from_user_avatar" => $from_avatar,
            "from_user_name" => $from_user_name,
            "to_user_name" => $to_user_name,
            "chat" => $chat,
            "chat_type" => $chat_type,
            "chat_time" => $chat_time,
            "db_chat_id" =>$db_chat_id
        );
        $user = CYdChatApp::Instance()->GetUserManager()->GetUser($to_leader_id);
        $to_client_id = $user->GetClientID();
        $other_is_online = false;
        if ($user) {
            $other_is_online = $user->IsOnline();
        }
        $msg = new CUserChatMsg($content, $from_client_id, $to_client_id, $other_is_online);
        $msg->Send();
    }

    public function ProcessGroupChatHistory($client_id, $data)
    {
        $group_id = intval($data["group_id"]); //当前群ID
        $group_name = $data["group_name"]; //当前群的名称
        //$leader_id = $data["leader_id"]; //用户ID，用户比较消息是否是自己的
        $register_time = $data["register_time"]; //用户注册时间
        $last_chat_id = $data["last_chat_id"]; //上次查询的最大ID
        $sql = '';
        if ($last_chat_id == "max") {
            $sql = 'SELECT A.id AS chat_id, A.msg_content AS chat_content, A.msg_type AS chat_type, A.send_time AS chat_time,
                    C.user_name AS name,C.leader_id,C.avatar FROM `yd_groupmsg` AS A
                    LEFT JOIN `yd_group` AS B ON A.group_id = B.group_id
                    LEFT JOIN `yd_user` AS C ON A.sender_id = C.leader_id
                    WHERE A.send_time >"'.$register_time.'" AND A.group_id ="' . $group_id . '" AND A.id > (SELECT MAX(id) FROM `yd_groupmsg`) -10';
            //查询最近十条记录
        } else {
            $sql = 'SELECT A.id AS chat_id, A.msg_content AS chat_content,A.msg_type AS chat_type, A.send_time AS chat_time,
                    C.user_name AS name, C.leader_id, C.avatar FROM `yd_groupmsg` AS A
                    LEFT JOIN `yd_group` AS B ON A.group_id = B.group_id
                    LEFT JOIN `yd_user` AS C ON A.sender_id = C.leader_id  WHERE A.send_time > "' . $register_time . '"
                    AND A.group_id="'.$group_id.'" AND A.id < "' . $last_chat_id . '"  ORDER BY A.send_time DESC  LIMIT 0,10'; //每次查询十条记录
        }
        CUtil::Log("群聊天历史记录",$sql);
        $data = Db::instance("db_yd")->query($sql);
        $content = array("group_name" => $group_name, "data" => $data);
        $msg = new CGroupChatHistoryMsg($content, $client_id, $client_id, $group_id);
        $msg->Send();
    }
    //处理用户聊天历史记录
    public function ProcessUserChatHistory($client_id, $data)
    {
        $self_leader_id = $data["self_leader_id"];
        $other_leader_id = $data["other_leader_id"];
        $last_chat_id = $data["last_chat_id"];
        $other_user_name = $data["other_user_name"];
        $sql = "";
        if ($last_chat_id == "max") {
            $sql = 'SELECT A.id,A.sender_id,A.receiver_id,A.msg_content AS chat_content,A.msg_type AS chat_type,A.send_time,B.leader_id,B.user_name,B.user_mobile,B.avatar FROM `yd_chatmsg` A
                LEFT JOIN `yd_user` B ON A.sender_id = B.leader_id
                LEFT JOIN `yd_user` C ON A.receiver_id = C.leader_id
                WHERE (A.sender_id ="' . $self_leader_id . '"  AND A.receiver_id ="' . $other_leader_id . '")
                OR (A.receiver_id = "' . $self_leader_id . '" AND A.sender_id ="' . $other_leader_id . '") ORDER BY A.send_time DESC LIMIT 0,10';
        } else {
            $sql = 'SELECT A.id,A.sender_id,A.receiver_id,A.msg_content AS chat_content,A.msg_type AS chat_type,A.send_time,B.leader_id,B.user_name,B.user_mobile,B.avatar FROM `yd_chatmsg` A
                LEFT JOIN `yd_user` B ON A.sender_id = B.leader_id
                LEFT JOIN `yd_user` C ON A.receiver_id = C.leader_id
                WHERE ((A.sender_id ="' . $self_leader_id . '"  AND A.receiver_id ="' . $other_leader_id . '")
                OR (A.receiver_id = "' . $self_leader_id . '" AND A.sender_id ="' . $other_leader_id . '"))
                AND A.id <"' . $last_chat_id . '" ORDER BY A.send_time DESC LIMIT 0,10';
        }
        CUtil::Log("私聊历史记录",$sql);
        $content = Db::instance("db_yd")->query($sql);
        $packet = array(
            "self_leader_id" => $self_leader_id,
            "other_leader_id" => $other_leader_id,
            "other_user_name" => $other_user_name,
            "history" => $content
        );
        $msg = new CUserChatHistoryMsg($packet, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessUserDetail($client_id, $data)
    {
        $leader_id = $data["leader_id"]; //用户自己的Leader Id
        $other_leader_id = $data["other_leader_id"]; //要查看的用户的详情的Leader Id
        $sql = 'SELECT * FROM `yd_user` WHERE leader_id = "' . $other_leader_id . '"';
        $sql2 = 'SELECT `follow_id` FROM `yd_user_follow` WHERE `leader_id` = "' . $leader_id . '" AND `is_valid`="1"';
        $user_info = Db::instance("db_yd")->query($sql);
        $follow_list = Db::instance("db_yd")->query($sql2);
        $content = array("user_info" => $user_info, "my_follow_list" => $follow_list);
        $msg = new CUserDetailMsg($content, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessModifyUserCompany($client_id, $data)
    {
        $company = htmlspecialchars($data["company"]);
        $leader_id = $data["leader_id"];
        Db::instance("db_yd")->query('UPDATE `yd_user` SET `user_company`="' . $company . '" WHERE leader_id ="' . $leader_id . '"');
        $msg = new CModifyUserCompanyMsg($company, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessModifyUserJob($client_id, $data)
    {
        $job = htmlspecialchars($data["job"]);
        $leader_id = $data["leader_id"];
        Db::instance("db_yd")->query('UPDATE `yd_user` SET `user_job` = "' . $job . '" WHERE leader_id ="' . $leader_id . '"');
        $msg = new CModifyUserJobMsg($job, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessModifyUserField($client_id, $data)
    {
        $field = htmlspecialchars($data["field"]);
        $leader_id = $data["leader_id"];
        Db::instance("db_yd")->query('UPDATE `yd_user` SET `user_field` ="' . $field . '" WHERE leader_id ="' . $leader_id . '"');
        $msg = new CModifyUserFieldMsg($field, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessUnreadUserChatList($client_id, $data)
    {
        $leader_id = $data["leader_id"];
        //用户头像 || 用户名称 || 最后一条发送的聊天记录 || 该聊天记录的时间 || 未读消息数
        /*$sql = 'SELECT B.leader_id AS sender_leader_id, COUNT(A.id) AS msg_count, B.user_name AS sender_name,
                D.user_name AS receiver_name,	B.avatar AS sender_avatar
                FROM `yd_chatmsg` AS A
                JOIN `yd_user` AS B ON A.sender_id = B.leader_id
                JOIN `yd_unread_user_msg` AS C ON C.umsg_id = A.id
                JOIN `yd_user` AS D ON A.receiver_id = D.leader_id
                WHERE C.status = 0 AND A.receiver_id = "' . $leader_id . '" GROUP BY A.sender_id';*/
        $sql = 'SELECT  A.leader_id AS sender_leader_id,B.count AS msg_count,
C.user_name AS receiver_name,A.user_name AS sender_name,
A.avatar AS sender_avatar FROM `yd_user` AS A  JOIN `yd_unread_user_msg` AS B ON A.leader_id = B.sender_id
 JOIN `yd_user` AS C ON C.leader_id = B.receiver_id WHERE B.receiver_id = "' . $leader_id . '" AND B.count >=0';
        //var_dump($sql);
        $umsgs = Db::instance("db_yd")->query($sql);
        $uids = array();
        foreach ($umsgs as $key => $msg) {
            $obj = array(
                "sender_leader_id" => $msg["sender_leader_id"],
                "sender_name" => $msg["sender_name"],
                "sender_avatar" => $msg["sender_avatar"],
                "msg_count" => $msg["msg_count"],
                "msg_newest" => '',
                "msg_time" => ''
            );
            $uids[$msg["sender_leader_id"]] = $obj;
        }
        if (count($uids) > 0) {
            $str_uids = '';
            foreach ($uids as $key => $id) {
                $str_uids .= $id["sender_leader_id"] . ",";
            }
            $str_uids = rtrim($str_uids, ",");
            $sql_2 = 'SELECT id,sender_id AS sender_leader_id,msg_content,msg_type,send_time FROM `yd_chatmsg` WHERE
                          id in (SELECT MAX(id) FROM `yd_chatmsg` AS A WHERE A.sender_id in(' . $str_uids . ')
                           group by A.sender_id)';
            $chats = Db::instance("db_yd")->query($sql_2);
            foreach ($chats as $key => $val) {
                $uids[$val["sender_leader_id"]]["msg_newest"] = $val["msg_content"];
                $uids[$val["sender_leader_id"]]["msg_time"] = $val["send_time"];
            }
        }
        $msg = new CUnreadUserChatListMsg($uids, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessUnreadGroupChatList($client_id, $data)
    {
        $leader_id = $data["leader_id"];
        //群头像 || 群名称 || 群最后一条未读的聊天记录 || 该聊天记录的时间 || 未读消息数
        /*$sql = 'SELECT COUNT(A.id) AS msg_count,C.group_id,C.group_name,C.group_avatar FROM `yd_unread_group_msg` AS A
                      JOIN `yd_groupmsg` AS B ON A.gmsg_id = B.id
                      JOIN `yd_group` AS C ON B.group_id = C.group_id
                      WHERE A.leader_id = "' . $leader_id . '" group by (C.id)';*/
        $sql = 'SELECT  A.group_id ,A.group_name ,A.group_avatar,
        B.count AS msg_count FROM `yd_group` AS A
		JOIN `yd_unread_group_msg` AS B ON A.group_id = B.group_id
        WHERE B.leader_id = "' . $leader_id . '" AND B.count >=0';
        $gmsgs = Db::instance("db_yd")->query($sql);
        $gids = array();
        foreach ($gmsgs as $key => $msg) {
            $obj = array(
                "group_id" => $msg["group_id"],
                "group_avatar" => $msg["group_avatar"],
                "group_name" => $msg["group_name"],
                "msg_count" => $msg["msg_count"],
                "msg_newest" => '',
                "msg_time" => '');
            $gids[$msg["group_id"]] = $obj;
        }
        if (count($gids) > 0) {
            $str_gids = '';
            foreach ($gids as $key => $id) {
                $str_gids .= $id["group_id"] . ",";
            }
            $str_gids = rtrim($str_gids, ",");

            $sql_2 = 'SELECT id, group_id,msg_content,msg_type,send_time FROM `yd_groupmsg` WHERE
                          id in (SELECT MAX(id) FROM `yd_groupmsg` AS A  WHERE A.group_id in(' . $str_gids . ')
                           group by A.group_id)';
            $chats = Db::instance("db_yd")->query($sql_2);
            foreach ($chats as $key => $val) {
                $gids[$val["group_id"]]["msg_newest"] = $val["msg_content"];
                $gids[$val["group_id"]]["msg_time"] = $val["send_time"];
            }
        }
        $msg = new CUnreadGroupChatListMsg($gids, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessAboutMe($client_id, $data)
    {
        $leader_id = $data["leader_id"];
        $content = Db::instance("db_yd")->query('SELECT * FROM `yd_user` WHERE leader_id = "' . $leader_id . '"');
        $msg = new CAboutMeMsg($content, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessUserFollowList($client_id, $data)
    {
        $leader_id = $data["leader_id"];
        $sql = 'SELECT A.leader_id AS follow_id,A.avatar AS user_avatar,A.user_name,A.is_online FROM `yd_user` AS A JOIN
	`yd_user_follow` AS B ON A.leader_id = B.follow_id WHERE B.is_valid="1" AND B.leader_id = "' . $leader_id . '" ORDER BY A.is_online DESC ';
        $content = Db::instance("db_yd")->query($sql);
        $msg = new CUserFollowListMsg($content, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessCreatePrivateGroup($client_id, $data)
    {
        $group_avatar = $data["avatar"];
        $group_name = $data["name"];
        $group_intro = $data["intro"];
        $create_leader_id = $create_by = $data["create_by"];
        $create_date = Cutil::GetCurrentTime();
        $new_gid = S_PUBLIC_GROUP_ID + 1;
        $sql = 'SELECT MAX(group_id) AS max_group_id FROM `yd_group`';
        $gids = Db::instance("db_yd")->query($sql);
        foreach ($gids as $key => $val) {
            $new_gid = $val["max_group_id"] + 1;
        }
        $sql2 = 'INSERT INTO `yd_group`(`group_id`,`group_name`,`group_intro`,`group_avatar`,`create_by`,`create_date`)
                  VALUES("' . $new_gid . '" ,"' . $group_name . '" ,"' . $group_intro . '" ,"' . $group_avatar . '", "' . $create_by . '","' . $create_date . '")';
        Db::instance("db_yd")->query($sql2);//新群插入数据表yd_group

        $sql3 = 'INSERT INTO `yd_group_member`(`group_id`,`leader_id`,`is_authentication`,`user_role`,`is_valid`)
                  VALUES("' . $new_gid . '","' . $create_leader_id . '","1","' . EnumGroupRole::ROLE_CREATOR . '","1")';
        Db::instance("db_yd")->query($sql3); //创建者添加进数据表yd_group_member;
        //更新缓存
        $user = CYdChatApp::Instance()->GetUserManager()->GetUser($create_by); //用户已经存在
        if ($user != null) {
            $user->joinGroup($new_gid);
        }
        $group = new CGroup();
        $group->InitFromDb($new_gid, $group_name, $group_intro, $group_avatar, $create_date);
        CYdChatApp::Instance()->GetGroupManager()->AddNewGroup($new_gid, $group);
        CYdChatApp::Instance()->GetGroupManager()->AddNewGroupMember($new_gid, $create_leader_id);
        $cd = array("group_name" => $group_name,
            "group_id" => $new_gid,
            "create_leader_id" => $create_leader_id);
        $msg = new CCreatePrivateGroupMsg($cd, $client_id, $client_id, $new_gid);
        $msg->Send();
    }

    public function ProcessGroupDetail($client_id, $data)
    {
        $group_id = $data["group_id"];
        $sql = 'SELECT * FROM `yd_group` WHERE group_id = "' . $group_id . '"';
        $group_info = Db::instance("db_yd")->query($sql);
        $sql2 = 'SELECt DISTINCT A.leader_id,A.user_name,A.avatar As user_avatar FROM `yd_user` AS A
        LEFT JOIN `yd_group_member` AS B ON A.leader_id = B.leader_id WHERE B.group_id = "' . $group_id . '"';
        $group_member_info = Db::instance("db_yd")->query($sql2);
        $content = array("group_info" => $group_info,
            "group_member_info" => $group_member_info);
        $msg = new CGroupDetailMsg($content, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessFollowSingleUser($client_id, $data)
    {
        $leader_id = $data["leader_id"];
        $follow_leader_id = $data["follow_leader_id"];
        $page = $data["page"];
        $sql = 'INSERT INTO `yd_user_follow`(leader_id,follow_id,is_valid)
      VALUES("' . $leader_id . '","' . $follow_leader_id . '","1")';
        Db::instance("db_yd")->query($sql);
        $msg = new CFollowSingleUserMsg($page, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessUnFollowSingleUser($client_id, $data)
    {
        $leader_id = $data["leader_id"];
        $follow_leader_id = $data["follow_leader_id"];
        $page = $data["page"];
        $sql = 'UPDATE `yd_user_follow` SET `is_valid` = "0"
        WHERE `leader_id` = "' . $leader_id . '" AND `follow_id` = "' . $follow_leader_id . '"';
        Db::instance("db_yd")->query($sql);
        $msg = new CUnFollowSingleUserMsg($page, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessFollowMultiUser($client_id, $data)
    {
        $leader_id = $data["leader_id"];
        $follow_list = $data["follow_list"];
        $str = '';
        for ($i = 0; $i < count($follow_list); $i++) {
            $str = $str . '("' . $leader_id . '","' . $follow_list[$i] . '","1"),';
        }
        $str = rtrim($str, ",");
        $sql = "INSERT INTO `yd_user_follow`(`leader_id`,`follow_id`,`is_valid`)VALUES" . $str;
        Db::instance("db_yd")->query($sql);
        $msg = new CFollowMultiUserMsg($follow_list, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessUnfollowMultiUser($client_id, $data)
    {
        $leader_id = $data["leader_id"];
        $unfollow_list = $data["unfollow_list"];
    }
    //用户关注列表
    public function ProcessUserListAboutFollow($client_id, $data)
    {
        $leader_id = $data["leader_id"];
        $sql = 'SELECT A.leader_id,A.user_name,A.avatar,1 as isFollow FROM `yd_user` A
          WHERE EXISTS(SELECT 1 FROM yd_user_follow AS B  WHERE A.leader_id = B.follow_id AND B.is_valid=1 AND leader_id="' . $leader_id . '")
          UNION ALL SELECT A.leader_id ,A.user_name,A.avatar,0 as isFollow FROM yd_user AS A  WHERE not EXISTS
        (SELECT 1 FROM yd_user_follow AS B  WHERE A.leader_id = B.follow_id AND B.is_valid=1 AND leader_id="' . $leader_id . '")';
        $content = Db::instance("db_yd")->query($sql);
        $msg = new CUserListAboutFollowMsg($content, $client_id, $client_id);
        $msg->Send();
    }
    //重置未读用户信息
    public function ProcessUnreadUserMsg($client_id, $data)
    {
        $sender_id = $data["sender_id"];
        $receiver_id = $data["receiver_id"];
        $sql = 'UPDATE `yd_unread_user_msg` SET `count`=0 WHERE sender_id = "' . $sender_id . '" AND receiver_id = "' . $receiver_id . '"';
        Db::instance("db_yd")->query($sql);
        $content = array("sender_id" => $sender_id, "receiver_id" => $receiver_id);
        $msg = new CResetUnReadUserMsgMsg($content, $client_id, $client_id);
        $msg->Send();
    }
    // 重置未读群消息
    public function ProcessResetUnreadGroupMsg($client_id, $data)
    {
        $group_id = $data["group_id"];
        $leader_id = $data["leader_id"];
        $sql = 'UPDATE `yd_unread_group_msg` SET `count`=0 WHERE `group_id` = "' . $group_id . '" AND `leader_id` = "' . $leader_id . '"';
        Db::instance("db_yd")->query($sql);
        $content = array("group_id" => $group_id, "leader_id" => $leader_id);
        $msg = new CResetUnReadUserMsgMsg($content, $client_id, $client_id);
        $msg->Send();
    }
    // 获取群通知列表
    public function ProcessGroupNoticeList($client_id,$data){
        $leader_id = $data['leader_id'];
        $stage = isset($data['stage'])?$data['stage']:'';
        $sql = '';
        if($stage == '') {
            $sql= 'SELECT  DISTINCT A.group_id,A.send_time AS notice_time,B.group_name,B.group_avatar,C.leader_id AS user_id,
            C.user_name,C.avatar as user_avatar,A.notice_type,A.sender_id,A.notice_title,A.notice_content,
            A.receiver_id,A.is_viewed FROM `yd_group_notice` AS A
            LEFT JOIN `yd_group` AS B ON A.group_id = B.group_id
            LEFT JOIN `yd_user` AS C ON A.sender_id = C.leader_id WHERE B.is_valid =1 AND A.receiver_id=' . $leader_id . ' ORDER BY A.group_id';
        }else{
            $sql = 'SELECT DISTINCT A.group_id,A.notice_type,A.send_time AS notice_time,A.notice_title,A.notice_content,A.is_viewed
				FROM `yd_group_notice` AS A
                LEFT JOIN `yd_group` AS B ON A.group_id = B.group_id
                WHERE B.is_valid = 1 AND A.receiver_id ='.$leader_id.'  ORDER BY A.group_id';
        }
        $result = Db::instance('db_yd')->query($sql);
        $content = array(
            "stage" => $stage,
            "leader_id" => $leader_id,
            "notice_list" => $result
        );
        $msg = new CGroupNoticeListMsg($content,$client_id,$client_id);
        $msg->Send();
    }
    //邀请新群成员
    public function ProcessInviteNewGroupMember($client_id, $data)
    {
        $group_id = $data['group_id'];
        $group_name = $data["group_name"];
        $group_avatar = $data["group_avatar"];
        $invitor_id = $data["invitor_id"];
        $invitor_name = $data["invitor_name"];
        $invitee_id_list = $data["invitee_id_list"];
        $str = '';
        $invite_content = $invitor_name.' 邀请你加入群 '.$group_name;
        $str_ids = '';
        for($x=0; $x<count($invitee_id_list);$x++){
            $str_ids = $str_ids.$invitee_id_list[$x].',';
        }
        $str_ids = rtrim($str_ids,',');
        //先查询数据库是否已经存在邀请通知
        $sqlExist = 'SELECT DISTINCT receiver_id FROM yd_group_notice WHERE receiver_id in('.$str_ids.')
                       AND is_viewed = 0 AND group_id ='.$group_id;
        $existIds = Db::instance('db_yd')->query($sqlExist);
        $eids = array();
        CUtil::log('邀请新群成员 已存在用户',json_encode($eids));
        foreach($existIds as $k=>$v){
            array_push($eids,$v['receiver_id']);
        }
        CUtil::log('邀请新群成员 invitee_id_list before',json_encode($invitee_id_list));
        CUtil::Log('邀请新群成员 exist id list',json_encode($eids));
        $invitee_id_list = array_diff($invitee_id_list,$eids);
        CUtil::Log('邀请新群成员 invitee_id_list after',json_encode($invitee_id_list));
        if(count($invitee_id_list)) {
            for ($i = 0; $i < count($invitee_id_list); $i++) {
                $leader_id = $invitee_id_list[$i];
                $str = $str . '(' . $group_id . ',' . GROUP_NOTICE_INVITE . ',' . $invitor_id . '
                        ,"' . $group_name . '","' . $invite_content . '",' . $leader_id . ',1),';
            }
            $str = rtrim($str, ",");
            $sql = "INSERT INTO `yd_group_notice`(`group_id`,`notice_type`,`sender_id`,
              `notice_title`,`notice_content`,`receiver_id`,`is_valid`)VALUES" . $str;
            CUtil::Log("邀请成员加入私聊群", $sql);
            Db::instance("db_yd")->query($sql);
        }
        $content = array(
            'group_id'=>$group_id,
            'group_name'=>$group_name,
            'group_avatar'=>$group_avatar,
            'notice_type'=>GROUP_NOTICE_INVITE,
            'sender_id'=>$invitor_id,
            'notice_title'=>$group_name,
            'notice_content'=>$invite_content,
            'notice_time'=>Cutil::GetCurrentTime(),
            'invitee_id_list'=>$invitee_id_list //客户端进行过滤
        );
        //查看公共群是否在线
        $msg = new CInviteNewGroupMemberMsg($content,$client_id,"all",S_PUBLIC_GROUP_ID);
        $msg->Send();
    }

    //邀请用户加入列表
    public function ProcessUserListAboutInvite($client_id, $data)
    {
        $group_id = $data["group_id"];
        if ($group_id == S_PUBLIC_GROUP_ID) {
            $msg = new CUserListAboutInviteMsg("error", $client_id, $client_id);
            $msg->Send();
        }
        $sql = 'SELECT B.group_id,A.leader_id,A.user_name,A.avatar,1 as isInGroup
                FROM yd_user A
                JOIN yd_group_member B on B.leader_id=A.leader_id
                WHERE B.group_id = "' . $group_id . '" AND A.is_authentication=1 AND A.is_valid=1 and B.is_valid=1
                UNION ALL
                SELECT B.group_id,A.leader_id,A.user_name,A.avatar,0 as isInGroup
                FROM yd_user A
                JOIN yd_group_member B on B.leader_id=A.leader_id
                WHERE B.group_id="' . S_PUBLIC_GROUP_ID . '"
                AND NOT EXISTS(SELECT 1 FROM yd_group_member A WHERE A.group_id="' . $group_id . '" and A.leader_id=B.leader_id)
                AND A.is_authentication=1 AND A.is_valid=1';
        $content = Db::instance("db_yd")->query($sql);
        $msg = new CUserListAboutInviteMsg($content, $client_id, $client_id, $group_id);
        $msg->Send();
    }

    //获取群通知

    public function ProcessGroupNotice($client_id, $data)
    {

    }

    // 查看群通知详情
    public function ProcessGroupNoticeDetail($client_id, $data)
    {

    }

    //创建用户私聊群
    public function ProcessSysNotice($client_id, $data)
    {

    }

    //查看系统通知详情
    public function ProcessSysNoticeDetail($client_id, $data)
    {

    }

    //查看通知列表
    public function ProcessNoticeList($client_id, $data)
    {
        // $sql = "SELECT * FROM ";
    }

    //发表朋友圈新说说
    public function ProcessNewPost($client_id, $data)
    {
        $leader_id = $data["leader_id"];
        $avatar = $data["avatar"];
        $user_name = $data["user_name"];
        $text = $data["text"];
        $imgs = $data["imgs"];
        $imgCount = count($imgs);
		$imgIds = array();
        $now = CUtil::GetCurrentTime();
        $post_id = Db::instance('db_yd')->insert('yd_post')->cols(array(
            'leader_id' => $leader_id,
            'content' => $text,
            'share_id' => 1
        ))->query();
        if ($imgCount > 0) {
            $sql = 'INSERT INTO `yd_post_img`(`post_id`,`img_url`)VALUES';
            foreach ($imgs as $key => $img) {
                $sql .= '("' . $post_id . '","' . $img . '"),';
            }
            $sql = rtrim($sql, ',');
            $imgIds = Db::instance('db_yd')->query($sql);
        }
        $arrImgs = array();
        foreach ($imgs as $key => $val) {
            $obj["post_img"] = $val;
            $arrImgs[] = $obj;
        }
        $content = array("post_id" => $post_id, 'leader_id' => $leader_id, 'avatar' => $avatar, 'user_name' => $user_name, 'text' => $text, 'imgs' => $arrImgs, 'imgIds' => $imgIds, 'post_time' => $now);
        $msg = new CNewPostMsg($content, $client_id, $client_id);
        $msg->Send();
    }

    //删除朋友圈新说说
    public function ProcessDeletePost($client_id, $data)
    {
        $post_id = $data['post_id'];
        $review_id = $data["review_id"];
        $sql = 'UPDATE `yd_post_review SET `is_valid`=0 WHERE review_id = ' . $review_id;
        Db::instance('db_yd')->query($sql);
        $sqlReview = '';
    }

    //朋友圈说说点赞
    public function ProcessPostFavorite($client_id, $data)
    {
        $post_id = $data['post_id'];
        $leader_id = $data['leader_id'];
        $sql = 'INSERT INTO `yd_post_favorite`(`post_id`,`leader_id`)
              VALUES(' . $post_id . ',' . $leader_id . ') ON DUPLICATE KEY UPDATE `is_valid`=1';
        Db::instance('db_yd')->query($sql);
        CUtil::Log('朋友圈点赞', $sql);
        $content = array('post_id' => $post_id, 'leader_id' => $leader_id);
        $msg = new CPostFavoriteMsg($content, $client_id, $client_id);
        $msg->Send();
    }

    //取消朋友圈说说点赞
    public function ProcessPostUnFavorite($client_id, $data)
    {
        $post_id = $data['post_id'];
        $leader_id = $data['leader_id'];
        $sql = 'UPDATE `yd_post_favorite` SET `is_valid`=0 WHERE `post_id`=' . $post_id . ' AND `leader_id`=' . $leader_id;
        CUtil::Log('朋友圈取消点赞', $sql);
        Db::instance('db_yd')->query($sql);
        $content = array('post_id' => $post_id, 'leader_id' => $leader_id);
        $msg = new CPostUnFavoriteMsg($content, $client_id, $client_id);
        $msg->Send();
    }

    //评论别人的说说或者自己的说说
    public function ProcessPostReview($client_id, $data)
    {
        $post_id = $data['post_id'];
        $leader_id = $data['leader_id'];
        $review = $data['review'];
        $sql = 'INSERT INTO `yd_post_review`(`post_id`,`leader_id`,`content`)
              VALUES("' . $post_id . '","' . $leader_id . '","' . $review . '")';
        Db::instance('db_yd')->query($sql);
        CUtil::Log('评论朋友圈说说', $sql);
        $sqlReview = 'SELECT A.post_id,A.review_id,A.leader_id,B.user_name AS reviewer_name,B.avatar AS reviewer_avatar,A.content AS review_content,A.review_time
                      FROM `yd_post_review` AS A
                      LEFT JOIN `yd_user` AS B ON A.leader_id = B.leader_id
                      WHERE A.post_id =' . $post_id . ' AND A.is_valid = 1 ORDER BY A.review_time';
        CUtil::Log('说说说有评论', $sqlReview);
        $reviews = Db::instance('db_yd')->query($sqlReview);
        $content = array(
            'post_id' => $post_id,
            'leader_id' => $leader_id,
            'reviews' => $reviews
        );
        //消息没有广播
        $msg = new CPostReviewMsg($content, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessDeletePostReview($client_id, $data)
    {

    }

    public function ProcessPostImgFavorite($client_id, $data)
    {

    }

    public function ProcessPostImgUnFavorite($client_id, $data)
    {

    }

    public function ProcessPostImgReview($client_id, $data)
    {

    }

    public function ProcessDeletePostImgReview($client_id, $data)
    {

    }

    // 获取朋友圈说说列表
    public function ProcessPostList($client_id, $data)
    {
        CUtil::Log("*********** ProcessPostList  Start ***********", '');
        $circle_type = $data["circle_type"];
        $leader_id = $data["leader_id"];
        $avatar = $data["avatar"];
        $name = $data["name"];
        $direction = $data["direction"];
        $post_id = $data["post_id"];
        if ($post_id == "max") {
            $post_id = 0;
        }
        $strPostIds = $post_ids = $follow_ids = '';
        $sqlPost = 'SELECT A.post_id,A.leader_id,B.user_name AS poster_name,B.avatar AS poster_avatar,A.post_time,A.content AS post_content
                    FROM `yd_post` AS A
                    LEFT JOIN `yd_user` AS B ON A.leader_id = B.leader_id
                    WHERE A.leader_id ';
        if ($circle_type == "all") {
            $sqlFollow = 'SELECT `follow_id` FROM `yd_user_follow` WHERE `is_valid`=1 AND `leader_id` ="' . $leader_id . '"';
            $followIds = Db::instance('db_yd')->query($sqlFollow);
            CUtil::Log("@sqlQueryFollows@", $sqlFollow);
            $strFollowIds = CUtil::ResultIdToStr($followIds, "follow_id", $leader_id);
            if ($direction == "dir_up") {
                $sqlPost = $sqlPost . ' in (' . $strFollowIds . ') AND A.post_id >"' . $post_id . '" ORDER BY A.post_time DESC LIMIT 0,5';
            } else {
                $sqlPost = $sqlPost . ' in (' . $strFollowIds . ') AND A.post_id <"' . $post_id . '" ORDER BY A.post_time DESC LIMIT 0,5';
            }
        } else if ($circle_type == "single") {
            if ($direction == "dir_up") {
                $sqlPost = $sqlPost . ' ="' . $leader_id . '" AND A.post_id >"' . $post_id . '"  ORDER BY A.post_time DESC LIMIT 0,5';
            } else {
                $sqlPost = $sqlPost . ' ="' . $leader_id . '" AND A.post_id <"' . $post_id . '"  ORDER BY A.post_time DESC LIMIT 0,5';
            }
        }
        $list = array();
        CUtil::Log("@sqlPost@", $sqlPost);
        $resultPost = Db::instance('db_yd')->query($sqlPost);
        $strPostIds = CUtil::ResultIdToStr($resultPost, "post_id");
        if ($resultPost) {
            $sqlPostImage = 'SELECT post_id,img_id,img_url AS post_img
                         FROM yd_post_img WHERE `is_valid` =1 AND post_id in (' . $strPostIds . ') ORDER BY post_id';
            $sqlPostReview = 'SELECT A.post_id,A.review_id,A.leader_id,B.user_name AS reviewer_name,B.avatar AS reviewer_avatar,A.content AS review_content,A.review_time
                      FROM `yd_post_review` AS A
                      LEFT JOIN `yd_user` AS B ON A.leader_id = B.leader_id
                      WHERE A.post_id in (' . $strPostIds . ') AND A.is_valid = 1 ORDER BY A.post_id';
            $sqlPostFavorite = 'SELECT A.post_id,A.favorite_id,A.leader_id,B.user_name AS favoriter_name,B.avatar AS favoriter_avatar,A.favorite_date
                        FROM yd_post_favorite AS A
                        LEFT JOIN `yd_user` AS B ON A.leader_id = B.leader_id
                        WHERE A.is_valid = 1 AND A.post_id in (' . $strPostIds . ') ORDER BY A.favorite_date DESC';
            CUtil::Log("@sqlPostImage@", $sqlPostImage);
            CUtil::Log("@sqlPostReview@", $sqlPostReview);
            CUtil::Log("@sqlPostFavorite@", $sqlPostFavorite);
            CUtil::Log("*********** ProcessPostList  End ***********", '');
            $resultPostImage = Db::instance('db_yd')->query($sqlPostImage);
            $resultPostReview = Db::instance('db_yd')->query($sqlPostReview);
            $resultPostFavorite = Db::instance('db_yd')->query($sqlPostFavorite);
            if ($resultPost) {
                foreach ($resultPost as $key => $post) {
                    $item = array(
                        'post_id' => $post['post_id'],
                        'leader_id' => $post['leader_id'],
                        'poster_avatar' => $post['poster_avatar'],
                        'poster_name' => $post['poster_name'],
                        'post_time' => $post['post_time'],
                        'post_content' => $post['post_content'],
                        'post_favorites' => array(),
                        'post_imgs' => array(),
                        'post_reviews' => array());
                    $list[$post['post_id']] = $item;
                }
            }
            if ($resultPostImage) {
                foreach ($resultPostImage as $key => $img) {
                    $item_img = array(
                        'img_id' => $img['img_id'],
                        'post_img' => $img['post_img']
                    );
                    $list[$img['post_id']]['post_imgs'][] = $item_img;
                }
            }
            if ($resultPostFavorite) {
                foreach ($resultPostFavorite as $key => $favorite) {
                    $item_favorite = array(
                        'favorite_id' => $favorite['favorite_id'],
                        'leader_id' => $favorite['leader_id'],
                        'favoriter_name' => $favorite['favoriter_name'],
                        'favoriter_avatar' => $favorite['favoriter_avatar'],
                        'favorite_date' => $favorite['favorite_date']
                    );
                    $list[$favorite['post_id']]['post_favorites'][] = $item_favorite;
                }
            }
            if ($resultPostReview) {
                foreach ($resultPostReview as $key => $review) {
                    $item_review = array(
                        'review_id' => $review['review_id'],
                        'leader_id' => $review['leader_id'],
                        'reviewer_name' => $review['reviewer_name'],
                        'reviewer_avatar' => $review['reviewer_avatar'],
                        'review_content' => $review['review_content'],
                        'review_time' => $review['review_time']
                    );
                    $list[$review['post_id']]['post_reviews'][] = $item_review;
                }
            }
        }
        $arrList = array();
        foreach ($list as $k => $v) {
            $arrList[] = $v;
        }
        $post = array(
            'circle_type' => $circle_type,
            'leader_id' => $leader_id,
            'post_id' => $post_id,
            'avatar' => $avatar,
            'name' => $name,
            'direction' => $direction,
            'list' => $arrList
        );
        $msg = new CPostListMsg($post, $client_id, $client_id);
        $msg->Send();
    }

    public function ProcessSysNoticeList($client_id, $data)
    {

    }

    public function DumpMsg($title, $content)
    {
        echo "\n---------------------" . $title . "-------------------------\n";
        echo "\n" . $content . "\n";
        echo "\n---------------------message process end-------------------------\n";
    }
}
