<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/12 0012
 * Time: 下午 13:40
 */
class CDumpData
{
    private $_host;
    private $_db;
    private $_user;
    private $_pass;
    private $_port;
    private $_tbl;
    private $_errors;
    private $_link;
    private $_fields;
    private $_shortTimeStamp;
    public function __construct($config){
        $this->_host = isset($config['host'])?$config['host']:'';
        $this->_db = isset($config['db'])?$config['db']:'';
        $this->_user = isset($config['user'])?$config['user']:'';
        $this->_pass = isset($config['pass'])?$config['pass']:'';
        $this->_port = isset($config['port'])?$config['port']:'3306';
        //$this->_tbl = isset($config['table'])?$config['table']:'';
        $this->_errors = [];
        $this->_link = null;
        $this->_fields = [];
        $this->_shortTimeStamp = false;
        $this->conn_db();
    }

    public function conn_db()
    {
        $this->_link = new mysqli($this->_host,$this->_user,$this->_pass,$this->_db,$this->_port);
        if(!$this->_link){
            $this->_errors[] = $mysqli->connect_error;
            $this->_errors[] = $mysqli->connect_errno;
        }
    }
    public function setTable($table){
        $this->_tbl = $table;
    }
    public function setShortTimeStamp(){
        $this->_shortTimeStamp = true;
    }
    protected function getFields()
    {
        $this->_fields = [];
        $str = '';
        $sql = "select COLUMN_NAME as name,data_type from information_schema.COLUMNS
        where table_name = '{$this->_tbl}' and table_schema = '{$this->_db}'";
        $result = $this->_link->query($sql);
        if($result){
            while($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $str .= '`' . $row['name'] . '`,';
                $this->_fields[] = ['name'=>$row['name'],'type'=>$row['data_type']];
            }
            $str = rtrim($str,',');
        }
        return $str;
    }
    public function dump()
    {
        $pre = $this->getFields();
        $str = '';
        $sql = "SELECT * FROM {$this->_tbl} lIMIT 0,1000";
        $result = $this->_link->query($sql);
        if($result){
            while($row = $result->fetch_array(MYSQLI_ASSOC)){
                $str.='(';
                foreach($this->_fields as $k=>$v) {
                    $quotes = ['timestamp','varchar','char','text'];
                    $col = in_array($v['type'],$quotes)?'"'.$row[$v['name']].'"':$row[$v['name']];
                    if($v['type'] == 'timestamp' && $this->_shortTimeStamp){
                        $col = substr($col,0,11).'"';
                    }
                    $str .= $col.',';
                }
                $str = rtrim($str,',');
                $str.='),<br/>';
            }
            $str = rtrim($str,',<br/>');
        }
        $str = "INSERT INTO `{$this->_tbl}`(".$pre.")values<br/>".$str;
        echo $str;
    }
}

$config = [
    'host'=>'localhost',
    'db'=>'dest',
    'user'=>'root',
    'pass'=>'root',
    'port'=>'3306',
];
$dump = new CDumpData($config);
$dump->setTable('automobile_1');
$dump->setShortTimeStamp();
$dump->dump();