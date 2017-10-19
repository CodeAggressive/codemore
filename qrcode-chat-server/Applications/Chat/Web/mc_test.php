<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-1-22
 * Time: 下午1:36
 */
use GatewayWorker\Lib\Db;

/*$mem  = new Memcache();

$serv  = $_SERVER['SERVER_ADDR'];

$mem->addServer($serv,11211);
if( $mem->add("mystr","this is a memcache test!"
,3600)){
    echo  '原始数据缓存成功!';
}else{
    echo '数据已存在：'.$mem->get("mystr");
}
*/


$leader_id = 13232;

$sql = 'SELECT COUNT(A.id) AS msg_count,A.C.group_id,C.group_name,C.group_avatar FROM `yd_unread_group_msg` AS A
                      LEFT JOIN `yd_groupmsg` AS B ON A.gmsg_id = B.id
                      LEFT JOIN `yd_group` AS C ON B.group_id = C.group_id
                      WHERE A.leader_id = "'.$leader_id.'" group by (C.id)';
$groups = Db::instance("db_yd")->query($sql);
$gids = array();
foreach($groups as $key=>$val){
    $obj = array(
        "group_id"=>$val["group_id"],
        "group_avatar"=>$val["group_avatar"],
        "group_name"=>$val["group_name"],
        "msg_count"=>$val["msg_count"],
        "newest_msg"=>'');
    $gids[$val["group_id"]] = $obj;
}
if(count($gids)>0){
    $str_gids = array();
    foreach($gids as $key=>$val){
        $str_gids.=$key.",";
    }
    $str_gids = rtrim($str_gids,",");
    $sql_2 = 'SELECT id, group_id,msg_content FROM `yd_groupmsg` WHERE
                          id in (SELECT MAX(id) FROM `yd_groupmsg` AS A  WHERE A.group_id in('.$str_gids.')
                           group by A.group_id)';
    $chats = Db::instance("db_yd")->query($sql_2);
    foreach($chats as $key=>$val){
        $gids[$val["group_id"]]["newest_msg"] = $val["msg_content"];
    }
}

var_dump($gids);

?>