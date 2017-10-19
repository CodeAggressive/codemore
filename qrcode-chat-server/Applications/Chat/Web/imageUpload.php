<?php

//脚本执行时间就由默认的30秒变为180秒
/*ini_set('max_execution_time', '180');
//Post变量由2M修改为8M，此值改为比upload_max_filesize要大
ini_set('post_max_size', '40M');
//上传文件修改也为8M，和上面这个有点关系，大小不等的关系。
ini_set('upload_max_filesize','40M');
//正在运行的脚本大量使用系统可用内存,上传图片给多点，最好比post_max_size大1.5倍
ini_set('memory_limit','40M'); */

/*function create_guid()
{
    $charid = strtoupper(md5(uniqid(mt_rand(), true)));
    $hyphen = chr(45);// "-"
    //$uuid = //chr(123)// "{"
      $uuid=  substr($charid, 0, 8) . $hyphen
        . substr($charid, 8, 4) . $hyphen
        . substr($charid, 12, 4) . $hyphen
        . substr($charid, 16, 4) . $hyphen
        . substr($charid, 20, 12);
    //.chr(125);// "}"
    return $uuid;
}*/

/*
function getFileType($filename)
{
    return substr($filename, strrpos($filename, '.') + 1);
}*/

/*
$ret = array();
if ($_FILES['file']['size'] != 0) {
    $destFile = "/img/friend_circle/" . create_guid() . "." . getFileType($_FILES["file"]["name"]);
    $destFilePath = $_SERVER['HTTP_HOST'] . $destFile;
    $result = move_uploaded_file($_FILES['file']['tmp_name'], $destFile);
    if ($result) {
        $ret = array("img_url" => $destFilePath, "status" => STATE_SUCCESS);
    } else {
        $ret = array("img_url" => $destFilePath, "status" => STATE_FAIL);
    }
} else {
    $ret = array("desc" => $_FILES["file"], "status" => STATE_FAIL);
}
*/

$img = $_POST["post_img"];
$post_index = $_POST["post_index"];
$ret = array();
//var_export($_FILES);
if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $img, $result)) {
    $type = $result[2];
    $new_file_base = "img/friend_circle/" . date("Y_m_d-H_i_s-") . rand(1000, 9999);
    $new_file = $new_file_base . ".{$type}";
    if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $img)))) {
        $ret["status"] = "success";
        $ret["path"] = $new_file;
        $ret["post_index"] = $post_index;
        $ret["image_type"] = $type;
        echo json_encode($ret);
    } else {
        $ret["status"] = "error";
        $ret["path"] = "";
        echo json_encode($ret);
    }
}

