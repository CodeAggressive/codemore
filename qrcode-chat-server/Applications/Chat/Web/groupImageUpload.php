<?php

//脚本执行时间就由默认的30秒变为180秒
//ini_set('max_execution_time', '180');
//上传文件修改也为8M，和上面这个有点关系，大小不等的关系。
ini_set('upload_max_filesize','1024M');
//正在运行的脚本大量使用系统可用内存,上传图片给多点，最好比post_max_size大1.5倍
ini_set('memory_limit','2048M');

foreach($_FILES as $file_info)
{
    date_default_timezone_set('PRC');
    $now = date('YmdHis',time());
    $id = $_POST['id'];
    $rand = rand(100000,999999);
    $file_name = $file_info['file_name'];
    $file_type = substr($file_name,strrpos($file_name,'.')+1);
    $dest_path = 'img/group/'.$now.$rand.substr($id,8).'.'.$file_type;
    file_put_contents($dest_path, $file_info['file_data']);
    $ret = array('dest_path'=>$dest_path,'id'=>$id);
    echo json_encode($ret);
};

