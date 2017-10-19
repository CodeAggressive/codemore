<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-28
 * Time: 上午11:50
 */
namespace YiDou\Core;

/********************************
 * Class CSingleton 可派生多个子类的单例
 * @package Yidou
 ********************************/
class CSingleton
{ //单例模式,单例继承模式，需要采用static 后期静态绑定技术, 要求 PHP >5.3
    protected static $_instanceArr = array();

    protected function __construct()
    {
    }

    final public static function Instance()
    {
        $cls = get_called_class();
        if (!isset(self::$_instanceArr[$cls])) {
            self::$_instanceArr[$cls] = new static;
        }
        return self::$_instanceArr[$cls];
    }

    public function __wakeup()
    {
        throw new Exception("Cannot unserialize singleton");
    }

    protected function __clone()
    {

    }
}

