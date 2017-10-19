<?php 
	$cv = isset($_GET["cv"])?$_GET["cv"]:"";
	if($cv == "474"){
		header("Location:http://".$_SERVER["HTTP_HOST"]."/ticket/other/html/caiyilin.php?cv=".$cv);
	}else if($cv == "475"){
		header("Location:http://".$_SERVER["HTTP_HOST"]."/ticket/other/html/luozhixiang.php?cv=".$cv);
	}else{
		$url = "http://".$_SERVER["HTTP_HOST"]."/ticket/ticket-2.php?cv=".$cv;
		header("Location:http://".$_SERVER["HTTP_HOST"]."/ticket/ticket-2.php?cv=".$cv);
	}
	echo "something wrong!";
?>