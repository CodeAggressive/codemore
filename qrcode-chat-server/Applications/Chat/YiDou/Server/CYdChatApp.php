<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-28
 * Time: 下午1:41
 */
namespace YiDou\Core;
use YiDou\Core\CLeaderIDManager;
use YiDou\Core\CUserManager;
use YiDou\Core\CGroupManager;
use YiDou\Core\CMessageManager;
    /**
     * This file is part of Leader-Tech
     *
     * Licensed under The MIT License
     * For full copyright and license information, please see the MIT-LICENSE.txt
     * Redistributions of files must retain the above copyright notice.
     *
     * @author Tom Song
     * @QQ 981326632
     * @copyright Leader-Tech Beijing Co.Ltd Reserved
     */
    /*************************************
     * 群消息缓存策略
     * 内存缓存中只保存当天的群消息记录
     * 其他时间的消息记录不缓存
     * 理由:我们很少去查看昨天的群消息
     * 其他日期的消息记录不缓存
     * 消息记录在插入数据库的时候需要进行更新
     * 采用的技术 memcached
     *************************************/
/**********************************************
 * 群消息插入缓存策略
 * 当群消息记录超过10条的时候执行批量插入数据库
 * 所有的消息记录都在一个进程中。
 * 为了避免服务器退出的时候，缓存消息记录丢失
 * 在服务器退出事件中，保存所有的数据库
 * 批量插入完成后要做的两个动作
 * ① 更新群消息缓存，将新增加的群消息添加到memcache
 * ② 插入消息缓存，需要出列10条记录
 * ③ 因为有可能在数据写入的时候，有进入队列的事件发生
 * ④ 所以队列的最大容量是200条最近的记录
 **********************************************/
namespace YiDou\Server;
require_once __DIR__."/../Core/CSingleton.php";
require_once __DIR__."/../Core/CLeaderIDManager.php";
require_once __DIR__."/../Core/CMessageManager.php";
require_once __DIR__."/../Core/CUserManager.php";
require_once __DIR__."/../Core/CGroupManager.php";

use YiDou\Core\CSingleton;
use YiDou\Core\CLeaderIDManager;
use YiDou\Core\CMessageManager;
use YiDou\Core\CUserManager;
use YiDou\Core\CGroupManager;

/*************************
 * Class CYdChatApp
 * 应用程序入口类
 * @package Yidou
 *************************/
class CYdChatApp extends CSingleton
{
    private static $_group_manager = null; //群管理
    private static $_user_manager = null;  //用户管理
    private static $_leader_id_manager = null; //leader_id 发生器
    private static $_msg_manager = null; //消息处理中心

    protected function __construct()
    {
        self::$_leader_id_manager = CLeaderIDManager::Instance();
        self::$_msg_manager = CMessageManager::Instance();
        self::$_group_manager = CGroupManager::Instance();
        self::$_user_manager = CUserManager::Instance();
    }

    //用户ID发生器
    public function GetLeaderIDManager()
    {
        return self::$_leader_id_manager;
    }

    //获取消息处理中心
    public function GetMessageManager()
    {
        return self::$_msg_manager;
    }

    //获取用户管理器
    public function GetUserManager()
    {
        return self::$_user_manager;
    }

    //获取群管理器
    public function GetGroupManager()
    {
        return self::$_group_manager;
    }

    public function InitApp()
    {
        self::$_group_manager->Init();
        self::$_user_manager->Init();
        self::$_leader_id_manager->Init();
    }
}