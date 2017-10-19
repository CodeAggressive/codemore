<?php 
	session_start();
	require_once ("lib/db.ticket.php");
	$cv = isset($_POST["cv"])?$_POST["cv"]:"";
	$imgs = $_SESSION['uploaded_files'];
	if(count($imgs)>0 && $cv != ""){
		$db = new CDbTicket();
		$sql = "INSERT INTO ld_bus_user_resource(Qrcode_Value,Resource_Type,Resource_URL,isValid)VALUES";
		foreach($imgs as $img){
				$sql .= "('$cv','2','$img','1'),";
		}
		$sql = rtrim($sql,',');
		if($db->ExecuteInsert($sql)){
			unset($_SESSION['uploaded_files']); 
			echo "true";
		}else{
			echo "false";
		}
	}
?>