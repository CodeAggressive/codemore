<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-28
 * Time: 下午1:40
 */
namespace YiDou\Core;
use GatewayWorker\Lib\Db;

/**************************
 * Class CLeaderIDManager
 * @package Yidou
 */
//立德ID号，6位数，全局唯一
class CLeaderIDManager extends CSingleton //因为最大随机数
{
    private static $BASE_MIN = 10000;
    private static $BASE_MAX = 99999;
    private static $BASE_DIGIT_COUNT = 5;
    private static $_used_id = array(); //已经申请过的QQ号
    private static $_unused_id = array(); //没有申请过的QQ号
    private static $_digit_count = 5; //立德QQ号位数

    protected function __construct()
    {
        //查询数据库是否已经申请过
        self::$_digit_count = self::$BASE_DIGIT_COUNT;
        self::$_used_id = array();
        self::$_unused_id = array();
    }

    public function GetNewID()
    {   //获取ID号
        srand((float)microtime() * 1000000);
        $pos = array_rand(self::$_unused_id, 1);
        $id = self::$_unused_id[$pos];
        array_splice(self::$_unused_id, $pos, 1);
        array_push(self::$_used_id, $id);
        if (count(self::$_unused_id) == 0) {
            self::$_digit_count++;
            $min = $this->GetMinMax(self::$_digit_count)[0];
            $max = $this->GetMinMax(self::$_digit_count)[1];
            for ($i = $min; $i < $max; $i++) {
                self::$_unused_id[] = $i;
            }
        }
        return $id;
    }

    public function GetMinMax($digitCount)
    {
        $base_min = self::$BASE_MIN;
        $base_max = self::$BASE_MAX;
        if ($digitCount <= self::$BASE_DIGIT_COUNT) {
            return array($base_min, $base_max);
        }
        for ($i = self::$BASE_DIGIT_COUNT; $i < $digitCount; $i++) {
            $base_min = $base_min * 10;
            $base_max = $base_max * 10 + 9;
        }
        return array($base_min, $base_max);
    }

    public function Init()
    {
        ini_set("memory_limit", "100M"); //最多支持5位的Leader ID 号
        $ids = Db::instance("db_yd")->query("SELECT `leader_id` FROM `yd_user` WHERE is_valid=1");
        foreach ($ids as $key => $val) {
            self::$_used_id[] = $val["leader_id"];
        }
        $min = $this->GetMinMax(self::$_digit_count)[0];
        $max = $this->GetMinMax(self::$_digit_count)[1];

        $bCode = true;
        do {
            for ($i = $min; $i <= $max; $i++) {
                self::$_unused_id[] = $i; //没有分配的立德ID号
            }
            self::$_unused_id = array_diff(self::$_unused_id, self::$_used_id);
            if (count(self::$_unused_id)) {
                $bCode = false;
            } else {
                self::$_digit_count++;
                $min = $this->GetMinMax(self::$_digit_count)[0];
                $max = $this->GetMinMax(self::$_digit_count)[1];
            }
        } while ($bCode);
        echo "\nInit Leader ID Pool Finished.\n";
    }

    public function Debug()
    {
        //echo "Used Leader ID Pool:\n";
        //var_dump(self::$_used_id);
        //echo "Unsed ID Pool:\n";
        //var_dump(self::$_unused_id);
    }
}