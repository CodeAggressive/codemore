<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-28
 * Time: 下午1:46
 */
namespace YiDou\Core;
use GatewayWorker\Lib\Db;

/*****************************
 * Class CPrivateMsgManager
 * @package Yidou
 *****************************/
class CPrivateMsgManager extends CSingletonQueue
{
    //添加新的消息
    public function AddNewMsg($msg)
    {
        $this->EnQueue($msg);
    }

    public function FlushMsgToDb()
    {
        $msg_size = $this->GetSize();
        $sql = "INSERT INTO `yd_chatmsg`(`sender_id`,`receiver_id`,`msg_content`,`msg_type`,`send_time`)VALUES";
        for ($i = 0; $i < $msg_size; $i++) {
            $msg = $this->DeQueue();
            $senderId = $msg->GetSenderId();
            $receiverId = $msg->GetReceiverId();
            $content = $msg->GetContent();
            $time = $msg->GetTime();
            $sql .= "($senderId,$receiverId,$content,$time),";
        }
        $sql = rtrim($sql, ",");
        Db::instance('db_yd')->query($sql);
    }

    public function GetMorePrivateMessage($receiverId, $time)
    {
        /********************
         * @发送人的头像
         * @发送人的名称
         * @发送人的消息内容
         ********************/
        $sql = "SELECT A.msg_content,B.user_name,B.avatar FROM　`yd_chatmsg`
                    AS A LEFT JOIN `yd_user` AS B ON A.sender_id=B.leader_id
                    WHERE A.receiverId = $receiverId AND `A . send_time` > $time LIMIT";
    }

    public function GetUnReadPrivateMsgCount($receiverId, $lastTime)
    {
        $sql = "SELECT COUNT(*) FROM `yd_chatmsg` AS A WHERE `receiver_id` = $receiverId
                AND `send_time` >UNIX_TIMESTAM($lastTime) AND `send_time` <UNIX_TIMESTAM(now())
                ORDER BY send_time ASC LIMIT 0,10"; //查询最近的十条记录
    }
}