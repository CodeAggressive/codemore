<?php 
	session_start();
	function create_guid() {  
		$charid = strtoupper(md5(uniqid(mt_rand(), true)));  
		$hyphen = chr(45);// "-"  
		$uuid = ""//chr(123)// "{"  
		.substr($charid, 0, 8).$hyphen  
		.substr($charid, 8, 4).$hyphen  
		.substr($charid,12, 4).$hyphen  
		.substr($charid,16, 4).$hyphen  
		.substr($charid,20,12);
		//.chr(125);// "}"  
		return $uuid;  
	}  
	function getFileType($filename) {
		return substr($filename, strrpos($filename, '.') + 1);
	}
	
	if($_FILES['file']['size']!=0){
		$destFile = create_guid().".".getFileType($_FILES["file"]["name"]);
		$destFilePath = "http://ld-kj.cn/ticket/upload/".$destFile;
		$result = move_uploaded_file($_FILES['file']['tmp_name'], "./upload/".$destFile); 
		//date_default_timezone_set(PRC);
		if($result){
			$out = "上传图片成功 -- ".$destFile."-- ".date("Y-m-d H:i:s")."\n";
			file_put_contents("upload.pic.log", $out,FILE_APPEND);
		}else{
			$out = "上传图片失败 -- ".$destFile."-- ".date("Y-m-d H:i:s")."\n";
			file_put_contents("upload.pic.log", $out,FILE_APPEND);
		}
		if(!isset($_SESSION['uploaded_files']))
		{
			$arr = array();
			array_push($arr,$destFilePath);
			$_SESSION['uploaded_files'] = $arr;
		}else{
			$uploadedFiles = $_SESSION['uploaded_files'];
			array_push($uploadedFiles,$destFilePath);
			$_SESSION['uploaded_files'] = $uploadedFiles;
		}
	}else{
		$file_size = $_FILES['file']['size'];
		file_put_contents("upload.pic.log", "图片尺寸有问题 ---  ".$file_size,FILE_APPEND);
	}
	print_r($_SESSION['uploaded_files']);
?>