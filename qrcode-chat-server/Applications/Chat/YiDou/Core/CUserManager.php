<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-28
 * Time: 下午1:44
 */
namespace YiDou\Core;
use GatewayWorker\Lib\Gateway;
use GatewayWorker\Lib\Db;
// 导入依赖类
use YiDou\Client\CJoinGroupSuccessMsg;
use YiDou\Util\CUtil;
use YiDou\Server\CYdChatApp;
use YiDou\Client\CRegisterMsg;
use YiDou\Client\CLoginInMsg;
use YiDou\Client\CLoginOutMsg;
use YiDou\Client\CJoinGroupMsg;
use YiDou\Client\CGeneralContactsMsg;
use YiDou\Client\CUserNoneExistMsg;
use YiDou\Client\CNoticeJoinGroupSuccessMsg;

require_once __DIR__."/CUser.php";


/**********************************
 * Class CUserManager 用户管理类
 * @package YiDou
 */
class CUserManager extends CSingleton
{
    private static $_all_users = array();  //所有使用手机号注册的用户,关联数组

    protected function __construct()
    {
        self::$_all_users = array();
    }

    public function GetAllUsers()
    {
        if (self::$_all_users == null) {
            $this->QueryAllUsersFromDb();
        }
        return self::$_all_users;
    }

    public function QueryAllUsersFromDb()
    {
        echo "\nInit Users From DB.";
        $users = Db::instance("db_yd")->query("SELECT * FROM `yd_user` ORDER BY `register_time` DESC");
        echo "\nUsers  " . ($users == null ? "is Empty" : "is not Empty");
        foreach ($users as $key => $val) {
            $leader_id = $val["leader_id"];
            $name = $val["user_name"];
            $mobile = $val["user_mobile"];
            $avatar = $val["avatar"];
            $is_online = $val["is_online"];
            $register_time = $val["register_time"];
            $lastLoginOutTime = '';
            $timeQuery = Db::instance("db_yd")->query("SELECT * FROM `yd_login_info` WHERE `leader_id` =$leader_id ORDER BY `login_out_time` DESC LIMIT 1");
            foreach ($timeQuery as $key => $val) {
                $lastLoginOutTime = $val["login_out_time"];
            }
            $user = new CUser();
            $user->InitFromDb($leader_id, $name, $mobile, $avatar, $register_time, $lastLoginOutTime, $is_online);
            $user->QueryUserGroupsFromDb(); //初始化用户加入的群组
            self::$_all_users[$leader_id] = $user;
        }
    }

    //注册用户

    public function UserRegister($user)
    {
        // step 1 添加用户到用户池
        $leader_id = $user->GetLeaderID();
        $name = $user->GetName();
        $mobile = $user->GetMobile();
        $avatar = $user->GetAvatarOnline();
        $register_time = $user->GetRegisterTime();
        self::$_all_users[$leader_id] = $user;

        echo "\n---------------------register new user start-------------------------\n";
        // step 2 加入公共群
        $user->JoinGroup(S_PUBLIC_GROUP_ID); //添加进公共群
        $join_group_name = CYdChatApp::Instance()->GetGroupManager()->GetGroupName(S_PUBLIC_GROUP_ID);
        // step 3 插入数据表 yd_user
        $sql_1 = 'INSERT INTO `yd_user`(`leader_id`,`user_name`,`user_mobile`,`avatar`,`register_time`)
					VALUES("' . $leader_id . '", "' . $name . '", "' . $mobile . '", "' . $avatar . '", "' . $register_time . '")';
        Db::instance('db_yd')->query($sql_1);

        $group_role = $user->GetGroupRole();
        // step 4 插入数据表 yd_group_member
        Db::instance('db_yd')->query('INSERT INTO `yd_group_member`(`group_id`,`leader_id`,`is_authentication`,`user_role`)
                    VALUES("' . S_PUBLIC_GROUP_ID . '", "' . $leader_id . '", 1, "' . $group_role . '")');

        $content_2 = $name . "加入本群";
        ///////////////////////////////////

        //获取公共群名称
        $gname = Db::instance('db_yd')->query('SELECT `group_name`,`group_avatar` FROM `yd_group` WHERE `group_id` = "'.S_PUBLIC_GROUP_ID.'" LIMIT 1');
        $public_group_name = '一斗投资公共群';
        $public_group_avatar = '';
        foreach($gname as $key=>$names){
            $public_group_name = $names["group_name"];
            $public_group_avatar = $names["group_avatar"];
        }

        $join_group_success = "你已经是群成员了,开始聊天吧!";
        // step 6 插入数据表 yd_group_notice
       /* Db::instance('db_yd')->query('INSERT INTO `yd_group_notice`(`group_id`,`notice_type`,`sender_id`,
                              `notice_title`,`notice_content`,`receiver_id`,`is_viewed`,`send_time`)
                              VALUES('.S_PUBLIC_GROUP_ID.','.NOTICE_TYPE_JOIN_GROUP.','.S_PUBLIC_GROUP_ID.' ,"'.$public_group_name.'",
                              "'.$join_group_success.'",'.$leader_id.',"1","'.$register_time.'")');*/
        $content = array(
            "leader_id" => $leader_id,
            "user_name" => $name,
            "user_mobile" => $mobile,
            "user_avatar" => $avatar,
            "user_register_time" => $register_time
        );
        $from = $user->GetClientID();
        $to = "all";
        $group_id = S_PUBLIC_GROUP_ID; //公共群ID号
        // step 6 添加群成员到 CGroupManager
        CYdChatApp::Instance()->GetGroupManager()->AddNewGroupMember($group_id, $leader_id);
        //注册成功消息
        $msg = new CRegisterMsg($content, $from, $to, $group_id);
        $msg->Send();
        //广播通知消息
        $content = array(
            "leader_id" => $leader_id,
            "icon"=>$public_group_avatar,
            "title"=>$public_group_name,
            "content"=>$join_group_success,
            "time"=>$register_time,
            "ext"=>S_PUBLIC_GROUP_ID
        );
        // step 7 向在线人员广播入群消息
        $msg = new CJoinGroupMsg($content_2, $from, $to, $group_id);
        $msg->Send();
        //向自己发送入群成功的消息
        $msg = new CNoticeJoinGroupSuccessMsg($content,$from,$from);
        $msg->Send();
        echo "\n---------------------register new user end-------------------------\n";
        return true;
    }

    public function UserLoginIn($leader_id, $client_id)
    {
        $user = isset(self::$_all_users[$leader_id]) ? (self::$_all_users[$leader_id]) : null;
        if($user == null){ //修复数据不同步的问题
            $msg = new CUserNoneExistMsg('user does not exist','','',0);
            $msg->Send();
            return;
        }
        $gidList = $user->GetGroupIDList(); //里面全是Group ID

        if ($user != null) {
            $user->SetClientID($client_id); //这一句非常关键!!!
            $user->SetLoginInTime(CUtil::GetCurrentTime());
            /************************************
             *  所有登录的成员都会出现在公共群，所有登录
             *  成员必须进入公共群10000
             *  1. 广播给所有的在线成员/离线成员，我上线的信息
             *  2. 更新缓存和数据库中的在线状态
             ************************************/
            $leader_id = $user->GetLeaderID();
            $from_client_id = $user->GetClientID();
            //更新缓存
            $user->Online(); //在线
            //更新数据库
            Db::instance("db_yd")->query('UPDATE `yd_user` SET `is_online` = 1 WHERE `leader_id` = "' . $leader_id . '"');
            //加入在线群组,用于转发消息
            for ($i = 0; $i < count($gidList); $i++) {
                $gid = $gidList[$i];
                Gateway::joinGroup($from_client_id, $gid); //加入所有的群，表示我已经在线了.
            }

            //登录信息只给在线成员转发，不保存到数据库中
            $sql = 'SELECT DISTINCT A.leader_id,A.user_name AS name,A.avatar,A.is_online AS online FROM `yd_user` AS A
                LEFT JOIN `yd_group_member` AS B ON A.leader_id = B.leader_id
                WHERE B.group_id = "' . S_PUBLIC_GROUP_ID . '" ORDER BY A.is_online DESC';
            $all_register_users = Db::instance("db_yd")->query($sql);
            $users = CYdChatApp::Instance()->GetUserManager()->GetAllUsers();
            foreach ($users as $key => $user) { //关联数组
                $to_client_id = $user->GetClientID();
                if ((strlen($to_client_id) == 20) && Gateway::isOnline($to_client_id)) {
                    //$content = $user->GetName() . "上线了!";
                    $msg = new CLoginInMsg($all_register_users, $from_client_id, $to_client_id);
                    $msg->Send();
                }
            }

            //获取常见联系人
            $sqlContact = 'SELECT B . leader_id,B . user_name,B . user_mobile,B . avatar,B . register_time FROM `yd_general_contacts` AS A
                      LEFT JOIN `yd_user` AS B ON A . leader_id = B . leader_id WHERE A . leader_id = "' . $leader_id . '" AND
            B . is_authentication = "1"';
            $persons = array();
            $contactPerson = Db::instance("db_yd")->query($sqlContact);
            $msg = new CGeneralContactsMsg($contactPerson, $from_client_id, $from_client_id);
            $msg->Send();

            /******************************************************************************
             * WARNING: IN FOLLOWING STATEMENT VARIABLE $gidList WOULD make equal 0
             * TO AVOID THIS,YOU SHOULD NEVER CALL SAME CLASS MEMBER FUNCTION TWICE
             * IN OUTER AND INNER BRACKET{}!!!
             ******************************************************************************/
            //$gidList = $user->GetGroupIDList(); //里面全是Group ID
            /*var_dump($gidList);
            $content = array();
            $groups = CYdChatApp::Instance()->GetGroupManager()->GetAllGroups(); //关联数组
            for ($i = 0; $i < count($gidList); $i++) {
                $gid = $gidList[$i];
                if (isset($groups[$gid])) {
                    $group_name = $groups[$gid]->GetGroupName();
                    $group_avatar = $groups[$gid]->GetGroupAvatar();
                    $group_intro = $groups[$gid]->GetGroupIntro();
                    $group_create_time = $groups[$gid]->GetCreateTime();
                    array_push($content, array(
                        "group_id" => $gid,
                        "group_name" => $group_name,
                        "group_avatar" => $group_avatar,
                        "group_intro" => $group_intro,
                        "group_create_time" => $group_create_time
                    ));
                }
            }
            $msg = new CGroupListMsg($content, $from_client_id, $from_client_id);
            $msg->Send();*/
            CYdChatApp::Instance()->GetMessageManager()->ProcessAboutMe($client_id, array("leader_id" => $leader_id));
            CYdChatApp::Instance()->GetMessageManager()->ProcessUnreadGroupChatList($client_id, array("leader_id"=>$leader_id));
            CYdChatApp::Instance()->GetMessageManager()->ProcessUnreadUserChatList($client_id, array("leader_id"=>$leader_id));
            CYdChatApp::Instance()->GetMessageManager()->ProcessGroupNoticeList($client_id,array("leader_id"=>$leader_id,"stage"=>"init"));
            //不要转发此条消息
            //CYdChatApp::Instance()->GetMessageManager()->ProcessAllRegisterUserList($client_id, S_PUBLIC_GROUP_ID);
        }
    }

    public function UserLoginOut($client_id)
    {
        $users = CYdChatApp::Instance()->GetUserManager()->GetAllUsers();
        foreach ($users as $key => $user) {
            $old_client_id = $user->GetClientID();
            if ($client_id == $old_client_id) {
                $user->ClearClientID();
                $user->Offline();
                $t_out = CUtil::GetCurrentTime();
                $user->SetLoginOutTime($t_out);
                $t_in = $user->GetLoginInTime();
                $leader_id = $user->GetLeaderID();
                //插入登录登出信息
                $sql = 'INSERT INTO `yd_login_info`(`leader_id`,`login_in_time`,`login_out_time`)
                VALUES("' . $leader_id . '","' . $t_in . '","' . $t_out . '")';
                Db::instance("db_yd")->query($sql); //插入一条登录记录
                //更新登录状态
                $sql = 'UPDATE `yd_user` SET `is_online` = 0 WHERE `leader_id` ="' . $leader_id . '"';
                Db::instance("db_yd")->query($sql);
            }
        }
        //向在线用户转发用户信息
        $sql = 'SELECT A.leader_id,A.user_name AS name,A.avatar,A.is_online AS online FROM `yd_user` AS A
                LEFT JOIN `yd_group_member` AS B ON A.leader_id = B.leader_id
                WHERE B.group_id = "' . S_PUBLIC_GROUP_ID . '" ORDER BY A.is_online DESC';
        $all_register_users = Db::instance("db_yd")->query($sql);
        $users = CYdChatApp::Instance()->GetUserManager()->GetAllUsers();
        foreach ($users as $key => $user) { //关联数组
            $to_client_id = $user->GetClientID();
            if ((strlen($to_client_id) == 20) && Gateway::isOnline($to_client_id)) {
                //$content = $user->GetName() . "上线了!";
                $msg = new CLoginOutMsg($all_register_users, $client_id, $to_client_id);
                $msg->Send();
            }
        }
    }

    public function GetUser($leader_id)
    {
        $user = isset(self::$_all_users[$leader_id]) ? self::$_all_users[$leader_id] : null;
        return $user;
    }

    public function SayGroupMessage($group_id, $leader_id, $msg)
    {
        $user = self::$_all_users[$leader_id];
        $user->SayGroupMessage($msg);
    }

    public function SayPrivateMessage($from_leader_id, $to_leader_id, $msg)
    {
        $from_user = self::$_all_users[$from_leader_id];
        $to_user = self::$_all_users[$to_leader_id];
        $from_user->SayPrivateMessage($to_user);
    }

    public function BanUserSpeak($start_time, $end_time, $group_id, $masterId = null)
    {
        $user_id = Db::instance('db_yd')->query("SELECT id FROM yd_user WHERE `user_mobile` = $this->_mobile LIMIT 1");
        if ($user_id != null) {
            Db::instance('db_yd')->query("INSERT INTO `yd_user`(`group_id`,`user_id`,`start_time`,`end_time`,`is_valid`)
					VALUES($group_id,$user_id,$start_time,$end_time,1)");
            return true;
        } else {
            return false;
        }
    }

    public function Init()
    {
        $this->QueryAllUsersFromDb();
    }
}
