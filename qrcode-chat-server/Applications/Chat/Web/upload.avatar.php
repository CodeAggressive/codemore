<?php
session_start();
$avatar = $_POST["avatar"];
$avatar_type = $_POST["type"];
$ret = array();
if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $avatar, $result)) {
    $type = $result[2];
    $new_file_base = "img/avatar_upload/" . date("Y_m_d-H_i_s-") . rand(1000, 9999);
    $new_file = $new_file_base . ".{$type}";
    if (file_put_contents($new_file, base64_decode(str_replace($result[1], '', $avatar)))) {
        if ($avatar_type == "user_avatar") {
            $gray_file = imagecreatefromstring(base64_decode(str_replace($result[1], '', $avatar)));
            $gray_file_path = $new_file_base . "_off.{$type}";
            if ($gray_file && imagefilter($gray_file, IMG_FILTER_GRAYSCALE)) {
                $status = false;
                if ($type == "jpeg" || $type == "jpg") {
                    $status = imagejpeg($gray_file, $gray_file_path);
                } else if ($type == "png") {
                    $status = imagepng($gray_file, $gray_file_path);
                } else if ($type == "gif") {
                    $status = imagegif($gray_file, $gray_file_path);
                } else {
                    $status = imagepng($gray_file, $gray_file_path);
                }
                $ret["save_gray_file_ok"] = $status;
                imagedestroy($gray_file);
            }
        }
        $ret["status"] = "success";
       // $ret["path"] = "http://" . $_SERVER["HTTP_HOST"] . "/" . $new_file;
        $ret["path"] = $new_file;
        $ret["image_type"] = $type;
        echo json_encode($ret);
    } else {
        $ret["status"] = "error";
        $ret["path"] = "";
    }
}