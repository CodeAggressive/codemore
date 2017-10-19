<?php
namespace Config;
/**
 * mysql配置
 * @author walkor
 */
class Db
{
    /**
     * 数据库的一个实例配置，则使用时像下面这样使用
     * $user_array = Db::instance('db_yd')->select('name,age')->from('users')->where('age>12')->query();
     * 等价于
     * $user_array = Db::instance('db_yd')->query('SELECT `name`,`age` FROM `users` WHERE `age`>12');
     * @var array
     */
     public static $db_yd = array(
        'host'    => '115.28.54.23',
        'port'    => 3306,
        'user'    => 'root',
        'password' => 'Ld123456BJ',
        'dbname'  => 'yidou_chat',
        'charset'    => 'utf8',
    );
	 /*  public static $db_yd = array(
        'host'    => '127.0.0.1',
        'port'    => 3306,
        'user'    => 'root',
        'password' => '',
        'dbname'  => 'yidou_chat',
        'charset'    => 'utf8',
    );*/
}