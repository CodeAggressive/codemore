<?php

ini_set('upload_max_filesize','40M');
//正在运行的脚本大量使用系统可用内存,上传图片给多点，最好比post_max_size大1.5倍
ini_set('memory_limit','80M');

$bUploadDone = true;
foreach($_FILES as $file_info)
{
    // Chunking might be enabled
    $chunk = isset($_REQUEST["chunk"]) ? intval($_REQUEST["chunk"]) : 0;
    $chunks = isset($_REQUEST["chunks"]) ? intval($_REQUEST["chunks"]) : 1;
    // 传过来的id号
    $id = $_POST['id'];
    $guid = $_POST['guid'];
    //临时目录
    $tmpDir = 'img'.DIRECTORY_SEPARATOR.'upload_tmp';
    $unique_file_name = $guid;
    //当前要保存的临时文件路径
    $tmpFilePath = $tmpDir.DIRECTORY_SEPARATOR.$unique_file_name."_".$chunk.".part";
    //先保存到临时目录中先
    file_put_contents($tmpFilePath,$file_info['file_data']);
    //开始检查是否上传完成
    for($i=0; $i<$chunks; $i++){
        $tmpFile = $tmpDir.DIRECTORY_SEPARATOR.$unique_file_name."_".$i.".part";
        if(!file_exists($tmpFile)){
            $bUploadDone = false;
            break;
        }
    }
    if(!$bUploadDone){ //没有上传完，保存到临时目录
        $ret = array('tmp_path'=>$tmpFilePath,'id'=>$id,'guid'=>$unique_file_name);
        echo json_encode($ret);
    }else { //上传完成后，开始文件合并
        date_default_timezone_set('PRC');
        $now = date('YmdHis', time());
        $rand = rand(100000, 999999);
        $file_name = $file_info['file_name'];
        $file_type = substr($file_name, strrpos($file_name, '.') + 1);
        $dest_path = 'img/group/' . $now . $rand . substr($id, 8) . '.' . $file_type;
        for($i=0; $i<$chunks; $i++){
            $file = $tmpDir.DIRECTORY_SEPARATOR.$unique_file_name."_".$i.".part";
            if(file_exists($file)){
                $hChunkFile = fopen($file, "r");
                $chunk_content = fread($hChunkFile, filesize($file));
                fclose($hChunkFile);
                $hDestFile = fopen($dest_path, 'ab');
                $write = fwrite($hDestFile, $chunk_content);
                fclose($hDestFile);
                unlink($file);
            }
        }
        $ret = array('dest_path' => $dest_path, 'id' => $id);
        echo json_encode($ret);
    }
};