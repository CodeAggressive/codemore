<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-28
 * Time: 下午1:42
 */
namespace YiDou\Core;
use GatewayWorker\Lib\Db;
use YiDou\Client\CGroupMemberListMsg;
require_once __DIR__."/CGroup.php";

/*****************************
 * Class CGroupManager 群管理类
 * @package YiDou
 *****************************/
class CGroupManager extends CSingleton
{
    private static $_all_groups = array(); //超级管理员创建的私密群,关联数组

    protected function __construct()
    {
        self::$_all_groups = array();
    }

    public function Init()
    {
        $this->QueryAllGroupsFromDb();
    }

    public function QueryAllGroupsFromDb()
    {
        echo "\nInit Groups From DB.";
        $groups = Db::instance("db_yd")->query("SELECT * FROM `yd_group` WHERE `is_valid` = 1 ORDER BY `create_date` DESC");
        echo "\nGroups " . ($groups == null ? "is empty" : "is not empty");
        foreach ($groups as $key => $val) {
            $group_id = $val["group_id"];
            $group_name = $val["group_name"];
            $group_intro = $val["group_intro"];
            $group_avatar = $val["group_avatar"];
            $group_create_date = $val["create_date"];
            $group = new CGroup();
            $group->InitFromDb($group_id, $group_name, $group_intro, $group_avatar, $group_create_date);
            $group->QueryGroupMembersFromDb(); //查询数据库，获取群用户的 leader_id
            self::$_all_groups[$group_id] = $group;//json_encode($group);
        }
    }

    public function AddNewGroupMember($group_id, $leader_id)
    {
        $group = isset(self::$_all_groups[$group_id]) ? self::$_all_groups[$group_id] : null;
        if ($group != null) {
            $group->AddGroupMember($leader_id);
        }
    }

    public function GetGroup($group_id)
    {
        $group = isset(self::$_all_groups[$group_id]) ? self::$_all_groups[$group_id] : null;
        return $group;
    }

    public function AddNewGroup($group_id,$group){
        self::$_all_groups[$group_id] = $group;
    }

    public function RemoveGroupMember($group_id, $leader_id)
    {
        $group = isset(self::$_all_groups[$group_id]) ? (self::$_all_groups[$group_id]) : null;
        $user = CYdChatApp::Instance()->GetUserManager()->GetUser($leader_id);
        if ($group != null && $user != null) {
            $group->RemoveMember($user);
        }
    }

    public function GetAllGroups()
    {
        if (self::$_all_groups == null) {
            $this->QueryAllGroupsFromDb();
        }
        return self::$_all_groups;
    }

    public function GetGroupMemberList($group_id, $client_id)
    {
        /* ******************************************************
         * Step 1, 在GroupManager中找到所有成员的leader_id,再根据leader_id
         * 遍历，查找是否在UserManager中，如果有就返回信息
         ******************************************************/
        $member_list = array();
        $group = isset(self::$_all_groups[$group_id]) ? self::$_all_groups[$group_id] : null;
        if ($group) {
            $ids = $group->GetGroupMemberIdList();
            $userArr = CYdChatApp::Instance()->GetUserManager()->GetAllUsers(); // leader_id => CUser
            foreach ($ids as $key => $leader_id) {
                $user = isset($userArr[$leader_id]) ? $userArr[$leader_id] : null;
                if ($user) {
                    $member = array(
                        "group_id" => $group_id,
                        "leader_id" => $user->GetLeaderId(),
                        "name" => $user->GetName(),
                        "mobile" => $user->GetMobile(),
                        "avatar" => $user->GetAvatarOnline(),
                        "register_time" => $user->GetRegisterTime()
                    );
                    array_push($member_list, $member);
                } // end of user
            } // end if
        }// end of group
        $msg = new CGroupMemberListMsg($member_list, $client_id, $client_id);
        $msg->Send();
    }

    public function GetGroupName($group_id)
    {
        $group = isset(self::$_all_groups[$group_id]) ? self::$_all_groups[$group_id] : null;
        if ($group) {
            return $group->GetGroupName();
        } else {
            return "";
        }
    }
}