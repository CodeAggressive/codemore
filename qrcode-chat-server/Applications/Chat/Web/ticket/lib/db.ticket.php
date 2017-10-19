<?php

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 15-12-25
 * Time: 下午2:26
 */
class CDbTicket
{
    private $_db;
    private $_errors; //错误
    private $_debug_mode;
    static $_debug_db_host = '115.28.54.23';
    static $_debug_db_port = '3306';
    static $_debug_db_table = 'ld_ticket_sys';
    static $_debug_db_user = 'root';
    static $_debug_db_pass = 'Ld123456BJ';
    static $_db_host = '115.28.54.23';
    static $_db_port = '3306';
    static $_db_table = 'ld_ticket_sys';
    static $_db_user = 'root';
    static $_db_pass = 'Ld123456BJ';

    public function __construct()
    {
        $this->_errors = array();
        $this->_debug_mode = true;
        $this->ConnDb();
    }

    public function ExecuteQuery($sql)
    {
        if ($sql != null && $sql != '') {
            $ret = array();
            $result = $this->_db->query($sql);
            if ($result && $result->num_rows > 0) {
                //$result = $result->fetch_all(MYSQLI_ASSOC);
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $ret[] = $row;
                }
                $result->free();
            } else {
                $this->_errors[]  = "Query SQL Failure " . $sql;
            }
            return $ret;
        }
    }

    public function ExecuteUpdate($sql){

        if ($sql != null && $sql != '') {
            $update_id = -1;
            $result = $this->_db->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                    $update_id = $row["@update_id"];
                }
                $result->free();
            } else {
                $this->_errors[]  = "Query SQL Failure " . $sql;
                return $update_id;
            }
            return $update_id;
        }
    }

    public function ExecuteEdit($sql)
    {
        if ($sql != null && $sql != '') {
            $result = $this->_db->query($sql);
            if ($this->_db->affected_rows) {
                return true;
            }
            return false;
        } else {
            return false;
        }
    }

    public function ExecuteInsert($sql)
    {
        if ($sql != null) {
            $result = $this->_db->query($sql);
            if ($result && $this->_db->affected_rows) {
                return true;
            }else {
                $this->_errors[] = 'Insert SQL Failure ! '.$sql;
                return false;
            }
        } else {
            return false;
        }
    }

    public function GetInsertId()
    {
        return $this->_db->insert_id;
    }

    public function IsErrorExist()
    {
        if (count($this->_errors) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function GetErrorDesc()
    {
        if ($this->IsErrorExist()) {
            return $this->_errors;
        } else {
            return '';
        }
    }

    public function ConnDb()
    {
        if ($this->_debug_mode) {
            $this->_db = new mysqli(self::$_debug_db_host, self::$_debug_db_user, self::$_debug_db_pass,
                self::$_debug_db_table, self::$_debug_db_port);
            if (mysqli_connect_error()) {
                array_push($this->_errors, '连接数据库失败  ' . self::$_debug_db_host . ' ' . self::$_debug_db_table);
                $this->_db = null;
            }
        } else {
            $this->_db = new mysqli(self::$_db_host, self::$_db_user, self::$_db_pass,
                self::$_db_table, self::$_db_port);
            if (mysqli_connect_error()) {
                array_push($this->_errors, '连接数据库失败  ' . self::$_db_host . ' ' . self::$_db_table);
                $this->_db = null;
            }
        }
    }

    public function CloseDb()
    {
        if ($this->_db != null) {
            $this->_db->close();
            $this->_db = null;
        }
    }
}