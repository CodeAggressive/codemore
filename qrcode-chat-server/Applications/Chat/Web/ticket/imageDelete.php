<?php 
	session_start();

	$index = isset($_POST["index"])?$_POST["index"]:"";
	if(isset($_SESSION['uploaded_files'])){
		$imgs = $_SESSION['uploaded_files'];
		$cnt = count($imgs);
		if($cnt>0 && $cnt >= $index){
			array_splice($imgs, $index, 1); 
		}
		$_SESSION['uploaded_files'] = $imgs;
	}
?>