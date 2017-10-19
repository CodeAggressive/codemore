<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-28
 * Time: 上午11:51
 */
namespace YiDou\Core;
use GatewayWorker\Lib\Db;
use YiDou\Util\CUtil;
use YiDou\Server\CYdChatApp;
use YiDou\Client\EnumGroupRole;
//use YiDou\Client\EnumGroupRight;

/********************
 * Class CUser 用户
 * @package YiDou
 */
class CUser
{
    private static $GROUP_MASTER_MOBILE = "18902835726";      //用户版本号
    private $_version;       //用户头像，变灰由PHP程序处理，在线头像图片命名，在线:xxx.png 离线:xxx_off.png,用户可以上传图片
    private $_avatar;         //用户名称
    private $_name;       //手机号
    private $_mobile;    //是否在线
    private $_is_online;    //用户注册时间
    private $_register_time;  //上传登录的时间
    private $_lastLoginInTime; //上次退出登录的时间
    private $_lastLoginOutTime;      //加入的群ID列表
    private $_group_id_list;          //用户在数据表 yd_user 中的ID号
    private $_user_id;        //对外的Leader_ID表示,全局唯一
    private $_leader_id;        //client_id 会话 临时的 id
    private $_client_id;

    public function __construct($name = '', $mobile = '', $avatar = '')
    {
        $this->_version = "1.0.0";
        $this->_name = $name == '' ? 'NONE' : $name;
        $this->_mobile = $mobile == '' ? 'NONE' : $mobile;
        $this->_avatar = $avatar == '' ? 'NONE' : $avatar;
        $this->_lastLoginInTime = '';
        $this->_lastLoginOutTime = ''; //上次登出时间
        $this->_is_online = false;       //是否在线
        $this->_group_id_list = array();
        $this->_user_id = '';
        $this->_leader_id = '';
        $this->_client_id = '';
        $this->_register_time = CUtil::GetCurrentTime();
    }

    public function InitFromDb($leaderId, $name, $mobile, $avatar, $register_time, $lastLoginOutTime, $is_online)
    {
        $this->_leader_id = $leaderId;
        $this->_name = $name;
        $this->_mobile = $mobile;
        $this->_avatar = $avatar;
        $this->_register_time = $register_time;
        $this->_lastLoginOutTime = $lastLoginOutTime;
        $this->_is_online = ($is_online == 1) ? true : false;
    }

    public function QueryUserGroupsFromDb()
    { //初始化用户加入的群表
        $groups = Db::instance("db_yd")->query('SELECT DISTINCT `group_id` FROM `yd_group_member` WHERE `leader_id` = "' . $this->_leader_id . '"');
        foreach ($groups as $key => $val) {
            $this->JoinGroup($val["group_id"]);
        }
    }

    public function JoinGroup($group_id) //用户加入群
    {
        $this->_group_id_list[] = $group_id;
    }

    public function GetVersion() ///获取用户版本
    {
        return $this->_version;
    }

    public function SetVersion($version) //设置用户版本
    {
        $this->_version = $version;
    }

    public function GetName() //获取用户名称
    {
        return $this->_name;
    }

    public function SetName($name) //设置用户名称
    {
        $this->_name = $name;
    }

    public function GetAvatar()
    { //获取用户在线头像
        return $this->GetAvatarOnline();
    }

    public function GetAvatarOnline()//获取用户在线头像
    {
        return $this->_avatar;
    }

    public function GetAvatarOffline()//获取用户离线头像
    {
        $dot = strripos($this->_avatar, ".");
        return substr($this->_avatar, 0, $dot) . "_off" . substr($this->_avatar, $dot, strlen($this->_avatar));
    }

    public function IsOnLine() //判断用户是否在线
    {
        return $this->_is_online;
    }

    public function Online() //用户上线
    {
        $this->_is_online = true;
    }

    public function Offline() //用户下线
    {
        $this->_is_online = false;
    }

    public function GetClientID() //获取用户会话ID
    {
        return $this->_client_id;
    }

    public function SetClientID($client_id) //设置用户会话ID
    {
        $this->_client_id = $client_id;
    }

    public function ClearClientID() //清空用户会话ID
    {
        $this->_client_id = '';
    }

    public function GetLeaderID() //获取用户ID
    {
        if ($this->_leader_id == NULL) {
            $this->SetLeaderID(CYdChatApp::Instance()->GetLeaderIDManager()->GetNewID());
        }
        return $this->_leader_id;
    }

    public function SetLeaderID($leader_id) //设置用户ID
    {
        $this->_leader_id = $leader_id;
    }

    public function GetUserId() //获取用户在数据库表中的ＩＤ号
    {
        return $this->_user_id;
    }

    public function GetRegisterTime() //获取用户的注册时间
    {
        return $this->_register_time;
    }

    public function SetLoginInTime($login_in_time) //设置用户登录时间
    {
        return $this->_lastLoginInTime = $login_in_time;
    }

    public function GetLoginInTime() //获取用户登录时间
    {
        return $this->_lastLoginInTime;
    }

    public function SetLoginOutTime($login_out_time)//设置用户退出时间
    {
        return $this->_lastLoginOutTime = $login_out_time;
    }

    public function GetLoginOutTime() //获取上次用户退出时间
    {
        return $this->_lastLoginOutTime;
    }

    public function LeaveGroup($group_id) //用户离开群
    {
        $idx = array_search($group_id, $this->_group_id_list);
        if (false !== $idx) { // the right way to compare the ret code.
            array_splice($this->_group_id_list, $idx, 1);
        }
    }

    public function GetGroupRole() //获取群角色
    {
        $mobile = $this->GetMobile();
        $role = ($mobile == self::$GROUP_MASTER_MOBILE) ? EnumGroupRole::ROLE_CREATOR : EnumGroupRole::ROLE_USER;
        return $role;
    }

    public function GetMobile() //获取用户手机号
    {
        return $this->_mobile;
    }

    protected function SetMobile($mobile) //用户手机号不能随意变更
    {
        $this->_mobile = $mobile;
    }

    public function GetGroupIDList() //获取用户加入的私密群ID
    {
        return $this->_group_id_list;
    }
}
