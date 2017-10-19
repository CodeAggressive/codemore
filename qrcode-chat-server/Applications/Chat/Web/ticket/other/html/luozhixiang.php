<!DOCTYPE html>
<html>
<head>
    <title>罗志祥演唱会</title>
    <script src="../js/dengbili.js" type="text/javascript"></script>
    <meta content="telephone=no" name="format-detection" />   <!--去除iPhone端默认数字为a-->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> <!--编码格式-->
    <meta name="viewport" content="initial-scale=1,maximum-scale=1, minimum-scale=0.5">
    <meta name="format-detection" content="telephone=no">
    <link href="../css/global.css" type="text/css" rel="stylesheet"> <!--公共CSS-->
    <link href="../css/luozhixiang.css" type="text/css" rel="stylesheet"> <!--css-->
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
					title : "罗志祥演唱会",
					desc : "罗志祥演唱会天津站",
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
				$(".popup-weixin").hide();
			});

            $("#piao").click(function(){
                location.href="goumai.php";
            })
	  });
	</script>
</head>
<body>
<div id="herder">
    <div class="main">
        <div id="title">
            <p id="name">罗志祥</p>
            <p id="area">天津演唱会<em>-预告片</em></p>
        </div>
    </div>
</div>
<div id="content_video">
    <video id="video" controls="controls" preload="none" poster="../image/3_02.png">
        <source src="../mp4/luozhixiang.mp4" type="video/mp4" />
    </video>
</div>
<div id="present">
    <p>罗志祥（Show Lo），1979年7月30日出生于台湾基隆市，华语流行男歌手、主持人、舞者、演员、“STAGE”老板。
        于1994年出道，03年罗志祥推出首张个人专辑《Show Time》。
        2005年举行首场演唱会成为第一位踏上台北小巨蛋的流行歌手。
        2008年发行第六张专辑《潮男正传》，获MTV亚洲音乐大奖。
        2010年专辑《罗生门》获“五白金”。</p>
</div>
<div class="main">
    <div id="content_diqu">
        <ul>
            <li id="diqu">-天津,市区体育馆</li>
            <li id="time">-2016年-2月22日@19:00PM</li>
        </ul>
    </div>
</div>
<!--票-->
<div id="ticket">
    <input type="button" value="立即购买门票" id="piao">
</div>
<!--票end-->
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