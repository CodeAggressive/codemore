<!DOCTYPE html>
<html>
<head>
    <title>蔡依林演唱会</title>
    <script src="../js/dengbili.js" type="text/javascript"></script>
    <meta content="telephone=no" name="format-detection" />   <!--去除iPhone端默认数字为a-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <!--编码格式-->
    <meta name="viewport" content="initial-scale=1,maximum-scale=1, minimum-scale=0.5">
    <meta name="format-detection" content="telephone=no">
    <link href="../css/global.css" type="text/css" rel="stylesheet"> <!--公共CSS-->
    <link href="../css/caiyilin.css" type="text/css" rel="stylesheet"> <!--css-->
    <script type="text/javascript" src="../../js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="../../js/toastr.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../css/toastr.min.css">
	<style type="text/css">
		/**{margin:0;padding:0;}*/
		/*html,body{width:100%;height:100%;background-color:#F2F2F2;}*/
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
            /*height: 12.8125rem;*/
        }
	</style>
	<script src="../js/zepto.min.js" type="text/javascript"></script>
    <script src="../js/fastclick.js" type="text/javascript"></script>
	<script type="text/javascript">
		<?php  require_once ("../../../wx/getsign.php"); ?>
	</script>
	<script src="../../js/wxshare-3.js" type="text/javascript"></script>	
	<script type="text/javascript">
	
<!--				-->
			var html5Init = function () {
				var wWin = $(window).width();
				var wHei = $(window).height();
				var ratio = wWin / 320;
				var htmlFontSize = parseInt(ratio * 16);
				$("html").css("font-size", htmlFontSize + "px");
			}
	  $(function(){
//			html5Init();
			$("#fenxiang").click(function(){
				ShowWxTip();
				var wxParam = JSON.parse(wxSign);
				var shareData = {
					appid : "wx2786ce187bdd15c0",
					title : "蔡依林演唱会",
					desc : "蔡依林2016PLAY世界巡回演唱会北京站",
					link : wxParam.url,
					imgUrl : "http://ld-kj.cn/ticket/images/poster-1.png",
					need_insert : false
				};
				var wxApi = new WeixinShare(shareData);
			});


			function ShowWxTip() {
				var ua = navigator.userAgent.toLowerCase();

					if (/micromessenger/.test(ua)) {
						$(".popup-weixin").css({
							"display" : "block",
							"opacity" : "0.9"
						});
					}else{
                        toastr.remove();
                        toastr.error(' ','请使用微信扫码,然后再分享!');
                    }

			}
			function HideWxTip() {
				$(".popup-weixin").trigger("click");
			}

			$(".popup-weixin").click(function () {
//                alert("click");
				$(".popup-weixin").hide();
			});
	  });
	</script>
</head>
<body>
<div id="herder">
    <div class="main">
        <div id="title">
            <p id="name">蔡依林2016</p>
            <p id="area">PLAY世界巡回演唱会北京站</p>
        </div>
    </div>
</div>
<div id="content_video">
    <video id="video" controls="controls" preload="none" poster="../image/ads.png">
        <source src="../mp4/caiyilin.mp4" type="video/mp4" />
    </video>
</div>
<div id="present">
    <p>这次动用来自世界各地的精英团队打造前所未有演唱会规格，有请曾与“流行乐之王”迈克杰克逊和LadyGaga合作的演唱会双人导演Travis和Stacy操刀，藉由其过去打造西洋巨星等级演唱会经验，为“亚洲流行天后”开创前所未见的国际舞台视野！演唱会总预算估计高达新台币一亿，折合约两千万人民币！如此巨资的大制作，绝对亮瞎眼！</p>
    <i><img src="../image/page.png"/></i>
</div>
<div class="main">
    <div id="content_diqu">
        <ul>
            <li id="diqu">-北京,鸟巢体育馆</li>
            <li id="time">-2016年-1月26日@19:00PM</li>
        </ul>
    </div>
</div>
<div id="foot">
    <i id="left"></i>
    <i id="right"></i>
    <input type="button" value="分享到微信朋友圈" id="fenxiang">
</div>
		<div class="popup-weixin">
			<img src="../../images/popup_weixin2.png"/>
		</div>
</body>
</html>