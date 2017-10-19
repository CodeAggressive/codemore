<?php 
	require_once ("lib/db.ticket.php");
	define("TICKET_WRONG","TICKET_WRONG");
	define("TICKET_EMPTY","TICKET_EMPTY");
	define("TICKET_UPLOAD","TICKET_UPLOAD");
	$cvState = TICKET_EMPTY;
	$cv = isset($_GET["cv"])?$_GET["cv"]:"";
	if($cv){
		$cvState = TICKET_EMPTY;
		$db = new CDbTicket();
		$sql = "SELECT Resource_URL FROM ld_bus_user_resource WHERE Qrcode_Value = '$cv' AND LENGTH(Resource_URL)>0 AND Resource_Type = 2 LIMIT 3";
		$images = $db->ExecuteQuery($sql);
		if(count($images) == 0){
			$cvState = TICKET_EMPTY;
		}else{
			$cvState = TICKET_UPLOAD;
		}
	}else{
		$cvState = TICKET_WRONG;
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>蔡依林演唱会</title>
		<meta http-equiv = "Content-Type" content = "text/html;charset=utf-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0 user-scalable=no">
		<meta HTTP-EQUIV="Pragma" content="no-cache">
		<meta name="format-detection" content="telephone=no" />
		<link rel="stylesheet" type="text/css" href="js/webuploader-0.1.5/webuploader.css">
		<link rel="stylesheet" type="text/css" href="css/ticket-2.css">
		<link rel="stylesheet" type="text/css" href="css/toastr.min.css">
		<style type="text/css">
		.popup-weixin {
            position: fixed;
            left: 0px;
            top: 0px;
            width: 100%;
            height: 100%;
            background-color: #000;
            display: none;
        }

        .popup-weixin img {
            display: block;
            position: relative;
            left:0;
			top:0;
            width: 100%;
            height: 12.8125rem;
        }
		</style>
		<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
		<script type="text/javascript" src="js/toastr.min.js"></script>
		<script type="text/javascript" src="js/jqthumb.js"></script>
		<script type="text/javascript">
			<?php
				//require_once ("../wx/getsign.php");
				$location = "- 北京，鸟巢体育馆";
				$date = "- 2016年1月26日@19:00PM";
				$upload_title = "- 我要分享照片(三张)";
				if($cvState==TICKET_EMPTY){
					echo "var ticket_upload = 0;";
				}else if($cvState == TICKET_WRONG){
					echo "var ticket_upload = -1;";
				}else if($cvState == TICKET_UPLOAD){
					$upload_title = "- 蔡依林演唱会现场照片";
					echo "var ticket_upload = 1;";
				}
				echo "var code = '$cv';";
			?>
		</script>
		<script type="text/javascript" src="js/webuploader-0.1.5/webuploader.nolog.min.js"></script>
		<script type="text/javascript" src="js/wxshare-3.js"></script>
		<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
		<script type="text/javascript" src="js/ticket-15.js"></script>
		<!-- SWF 在初始化的时候指定，在后面将展示 --->
	</head>
	<body>
		<div class="page">
			<div class="top_banner">
				<div class="star_name">蔡依林2016</div>
				<div class="video_title"><span class="bold">PLAY世界巡回演唱会</span><span>&nbsp;-&nbsp;北京站</span></div>
			</div>
			<div class="live_video">
				<video id="live_video_back" src="video/精彩回放.mp4" controls="controls" poster="images/poster-1.png"></video>
			</div>
			<div class="icon-bar" id="location"><img src="images/map.png"/><div> <?php echo $location; ?> </div></div>
			<div class="icon-bar" id="date"><img src="images/date.png"/><div> <?php echo $date; ?> </div></div>
			<div class="icon-bar" id="upload"><img src="images/pic.png"/><div> <?php echo $upload_title; ?> </div></div>
			<?php if($cvState == TICKET_UPLOAD){ ?>
					<div class="uploaded-img-container">
						<?php foreach($images as $key=>$val){
								foreach($val as $k=>$v){
									echo '<img class="uploaded-image" src="'.$v.'"/>';
								}
						}						
						?>
					</div>
			<?php }else{ ?>
					<div class="upload-img-container">
						<div id="fileList" class="uploader-list"></div>
						<div class="upload-icon"><img src="images/add.png"/><div id="filePicker"></div></div>				
					</div>
			<?php } ?>
			<div class="share-wx">
				<div class="share-circle-left"></div>
				<div class="share-circle-right"></div>
				<div class="store-btn">
					<img src="images/store.png"/>
					<span>收藏上传图片</span>
				</div>
				<div class="share-btn">
					<img src="images/circle.png"/>
					<span>分享到朋友圈</span>
				</div>
			</div>
		</div>
		<div class="popup-weixin">
			<img src="images/popup_weixin2.png"/>
		</div>
	</body>
</html>