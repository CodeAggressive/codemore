<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-28
 * Time: 下午12:36
 */
namespace YiDou\Util;
class CUtil
{
    public function __construct()
    {

    }

    public static function GetCurrentTime()
    {
        date_default_timezone_set("Asia/Shanghai");
        return date("Y-m-d H:i:s");
    }

    public static function Log($cmd,$content){
        $now = self::GetCurrentTime();
        $log = dirname(__FILE__)."/../../log/".substr($now,0,10).".log";
        file_put_contents($log,PHP_EOL."[ ".$cmd." ]  ".$now,FILE_APPEND|LOCK_EX);
        file_put_contents($log,PHP_EOL.$content.PHP_EOL,FILE_APPEND|LOCK_EX);
    }

    public static function ResultIdToStr($result,$col,$id =''){
        $ids = array();
        foreach ($result as $key => $val) {
            array_push($ids, $val[$col]);
        }
        if($id!='') {
            array_push($ids, $id);
        }
        $strIds = implode(',', $ids);
        return $strIds;
    }
    public static function GetCombineId($from,$to){
        $ret = '';
        for($i=$from; $i<$to; $i++){
            $ret =$ret.($i.",");
        }
        $ret = implode(',',$ret);
        return $ret;
    }
}
