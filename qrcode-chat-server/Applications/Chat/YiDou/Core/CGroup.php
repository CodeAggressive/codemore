<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-28
 * Time: 上午11:53
 */
namespace  YiDou\Core;
use GatewayWorker\Lib\Db;

/***************************
 * Class CGroup 群
 * @package YiDou
 */
class CGroup
{
    private $_group_id;     //群ID号
    private $_group_name;   //群名称
    private $_group_intro;  //群简介
    private $_group_avatar; //群头像
    private $_create_date;  //创建日期
    private $_leader_id_list;  //群成员ID列表

    public function __construct($groupName = '', $groupIntro = '', $group_avatar = '')
    {
        $this->_group_id = '';
        $this->_group_name = $groupName;
        $this->_group_intro = $groupIntro;
        $this->_group_avatar = $group_avatar; //群头像
        $this->_create_date = ''; //群创建日期
        $this->_leader_id_list = array();

    }

    public function InitFromDb($group_id, $groupName, $groupIntro, $groupAvatar, $createDate)
    {
        $this->_group_id = $group_id;
        $this->_group_name = $groupName;
        $this->_group_intro = $groupIntro;
        $this->_group_avatar = $groupAvatar;
        $this->_create_date = $createDate;
    }

    public function QueryGroupMembersFromDb()
    {
        $sql = 'SELECT DISTINCT `leader_id` FROM yd_group_member WHERE `group_id` = "' . $this->_group_id . '"';
        $ids = Db::instance("db_yd")->query($sql);
        foreach ($ids as $key => $val) {
            $leader_id = $val["leader_id"];
            $this->AddGroupMember($leader_id);
        }
    }

    public function AddGroupMember($leader_id) //增加群成员
    {
        $this->_leader_id_list[] = $leader_id;
    }

    public function GetCreateTime() //获取群创建时间
    {
        return $this->_create_date;
    }

    public function SetCreateTime($time)
    {
        $this->_create_date = $time;
    }

    public function GetGroupId()  //获取群成员ID号
    {
        return $this->_group_id;
    }

    public function SetGroupId($group_id)//设置群ID
    {
        $this->_group_id = $group_id;
    }

    public function GetGroupName()  //获取群名称
    {
        return $this->_group_name;
    }

    public function SetGroupName($groupName) //设置群名称
    {
        $this->_group_name = $groupName;
    }

    public function GetGroupIntro() //获取群简介
    {
        return $this->_group_intro;
    }

    public function SetGroupIntro($groupIntro) //设置群简介
    {
        $this->_group_intro = $groupIntro;
    }

    public function GetGroupAvatar() //获取群头像
    {
        return $this->_group_avatar;
    }

    public function SetGroupAvatar($groupAvatar) //设置群头像
    {
        $this->_group_avatar = $groupAvatar;
    }

    public function RemoveGroupMember($leader_id) //移除群成员
    {
        $idx = array_search($leader_id, $this->_leader_id_list);
        if (false !== $idx) {
            array_splice($this->_leader_id_list, $idx);
        }
    }

    public function GetGroupMemberIDList()
    { //获取群成员ID列表
        return $this->_leader_id_list;
    }
}