<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/13
 * Time: 13:03
 */

$ids = [3,43,16,40,11,30,29,7,17];
$s= '';
for($i=0; $i<count($ids);$i++){
    $s.=$ids[$i].'%2C';
}
$s = substr($s,0,-3);
echo $s;