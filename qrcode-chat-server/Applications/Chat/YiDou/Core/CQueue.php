<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16-3-28
 * Time: 下午12:54
 */
namespace YiDou\Core;
/*********************
 * Class CQueue 消息队列
 * @package Yidou
 *********************/
class CQueue
{ //消息队列
    private $queue;
    private $size;

    public function __construct()
    {
        $this->queue = array();
        $this->size = 0;
    }

    public function EnQueue($data)
    {
        $this->queue[$this->size++] = $data;
        return $this;
    }

    public function DeQueue($count = 1)
    { //返回的是数组
        if ($this->IsEmpty() || $count > $this->GetSize()) {
            return FALSE;
        }
        $this->size -= $count;
        $front = array_splice($this->queue, 0, $count);
        return $front;
    }

    public function IsEmpty()
    {
        return 0 === $this->size;
    }

    public function GetSize()
    {
        return $this->size;
    }

    public function GetQueue()
    {
        return $this->queue;
    }

    public function GetFront()
    {
        if (!$this->isEmpty()) {
            return $this->queue[0];
        }
        return FALSE;
    }
}