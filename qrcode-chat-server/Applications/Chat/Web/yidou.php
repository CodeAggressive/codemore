<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <title>一斗投资</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1.0 user-scalable=no">
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
    <meta name="format-detection" content="telephone=no, email=no"/>
    <link href="js/swiper-3.3.1.min.css" type="text/css" rel="stylesheet">
    <link href="css/yidou.3.css" rel="stylesheet">
    <!-- Include these three JS files: -->
    <script type="text/javascript" src="js/jquery-1.12.1.min.js"></script>
    <script type="text/javascript" src="js/swiper-3.3.1.jquery.min.js"></script>
    <script type="text/javascript" src="js/yidou.1.js"></script>
    <style type="text/css">
        html, body {
            width: 100%;
            height: 100%;
			background-color:#08171C;
        }

        .swiper-container {
            width: 100%;
            overflow: hidden;
        }
        .swiper-slide:nth-child(1){width:100%;height:100%;}
        .swiper-slide:nth-child(2){width:100%; height:100%;}
        .swiper-slide:nth-child(3){width:100%; height:100%;}
        .swiper-slide:nth-child(4){width:100%; height:100%;}
		.item-img{
			position:relative;
			display:block;
			margin-top:1rem;
			width:100%;
		}
		
		.slider{
				width:100%;
				height:8rem;
				overflow:hidden;
			}
			.slider .slide_image{width:300%;height:100%;}
			.slider .slide_image img{display:block;width:33.3333%;height:100%;float:left;}
			.slide_indicator{
				position:absolute;
				left:70%;
				top:7rem;
				width:25%;
				heihgt:2rem;
			}
			.slide_indicator .slide_item{
				position:relative;
				float:left;
				width:30%;
				height:0.5rem;
				margin-right:0rem;
			}
			.slide_active{background-color:#0968AE;}
			.slide_unactive{background-color:#FFF;}
			.slide_indicator div:nth-child(1){margin-right:5%;}
			.slide_indicator div:nth-child(2){margin-right:5%;}
			.clear_both{clear:both;}
			
			.go_chatroom{
				position:absolute;
				top:4rem;
				left:11rem;
				width:9.5rem;
				height:12rem;
				background-color:#FFF;
				opacity:0;
				-webkit-opacity:0;
			}
			.project_wrapper{
				background-color:#F7F7F7;
			}
			.project_wrapper:after{
				clear:both;
				content:'';
				display:block;
				width:0;
			}
			.project{
				width:4.5rem;
				margin-left:0.4rem;
				display:block;
				float:left;
				margin-top:1rem;
			}
			
			.yd-bom{
				position:relative;
				width:100%;
				display:block;
			}
			#center-item-2 .proj_title{
				position:relative;
				margin-top:1rem;
				padding-top:3.5rem;
				left:0rem;
				padding-left:0.5rem;
				width:100%;
				height:0.8rem;
				background-color:#F7F7F7;
				font-size:0.8rem;
			}
			.project_wrapper{
				width:100%;
				padding-bottom:6%;
			}
			
    </style>
</head>
<body>
<div class="swiper-container">
    <div class="swiper-wrapper">
        <div class="swiper-slide">
			<div class="slider" id="slider_1">
				<div class="slide_image">
					<img src="img/yd_0.png"/>
					<img src="img/yd_1.png"/>
					<img src="img/yd_2.png"/>
				</div>
				<div class="slide_indicator">
					<div class="slide_item slide_active"></div>
					<div class="slide_item slide_unactive"></div>
					<div class="slide_item slide_unactive"></div>
					<div class="clear_both"></div>
				</div>
			</div>
            <div class="menu">
                <div class="menu-item"><img src="img/home-1.png"/>
                    <div>一斗投资</div>
                </div>
                <div class="menu-item"><img src="img/circle-1.png"/>
                    <div>投资项目</div>
                </div>
                <div class="menu-item"><img src="img/groups.png"/>
                    <div>一斗团队</div>
                </div>
                <div class="menu-item"><img src="img/contact-1.png"/>
                    <div>联系我们</div>
                </div>
            </div>
            <div class="yd-center">
                <div class="center-item">
						<img class="item-img" src="img/2.png"/>
                </div>
            </div>
            <!--<img class="yd-bom" src="img/yd-bom.png"/>-->
        </div>
        <div class="swiper-slide">
            <div class="slider" id="slider_2">
				<div class="slide_image">
					<img src="img/yd_0.png"/>
					<img src="img/yd_1.png"/>
					<img src="img/yd_2.png"/>
				</div>
				<div class="slide_indicator">
					<div class="slide_item slide_active"></div>
					<div class="slide_item slide_unactive"></div>
					<div class="slide_item slide_unactive"></div>
					<div class="clear_both"></div>
				</div>
			</div>
            <div class="menu">
                <div class="menu-item"><img src="img/home-1.png"/>
                    <div>一斗投资</div>
                </div>
                <div class="menu-item"><img src="img/circle-1.png"/>
                    <div>投资项目</div>
                </div>
                <div class="menu-item"><img src="img/groups.png"/>
                    <div>一斗团队</div>
                </div>
                <div class="menu-item"><img src="img/contact-1.png"/>
                    <div>联系我们</div>
                </div>
            </div>
            <div class="yd-center">
                <div class="center-item" id="center-item-2">
					<div class="proj_title">投资项目</div>
					<div class="project_wrapper">
                    <img class="project" src="img/project/p1.png"/>
                    <img class="project" src="img/project/p2.png"/>
                    <img class="project" src="img/project/p3.png"/>
                    <img class="project" src="img/project/p4.png"/>
                    <img class="project" src="img/project/p5.png"/>
                    <img class="project" src="img/project/p6.png"/>
                    <img class="project" src="img/project/p7.png"/>
                    <img class="project" src="img/project/p8.png"/>
					<!--<a href="weixin://profile/gh_8bcd0b159443">关注</a>-->
					</div>
                </div>
            </div>
            <img class="yd-bom" src="img/yd-bom.png"/>
        </div>
        <div class="swiper-slide">
           	<div class="slider" id="slider_3">
				<div class="slide_image">
					<img src="img/yd_0.png"/>
					<img src="img/yd_1.png"/>
					<img src="img/yd_2.png"/>
				</div>
				<div class="slide_indicator">
					<div class="slide_item slide_active"></div>
					<div class="slide_item slide_unactive"></div>
					<div class="slide_item slide_unactive"></div>
					<div class="clear_both"></div>
				</div>
			</div>
            <div class="menu">
                <div class="menu-item"><img src="img/home-1.png"/>
                    <div>一斗投资</div>
                </div>
                <div class="menu-item"><img src="img/circle-1.png"/>
                    <div>投资项目</div>
                </div>
                <div class="menu-item"><img src="img/groups.png"/>
                    <div>一斗团队</div>
                </div>
                <div class="menu-item"><img src="img/contact-1.png"/>
                    <div>联系我们</div>
                </div>
            </div>
            <div class="yd-center">
                <div class="center-item">
                   <img class="item-img" src="img/3.png"/>
                </div>
            </div>
            <!--<img class="yd-bom" src="img/yd-bom.png"/>-->
        </div>
        <div class="swiper-slide">
            <div class="slider" id="slider_4">
				<div class="slide_image">
					<img src="img/yd_0.png"/>
					<img src="img/yd_1.png"/>
					<img src="img/yd_2.png"/>
				</div>
				<div class="slide_indicator">
					<div class="slide_item slide_active"></div>
					<div class="slide_item slide_unactive"></div>
					<div class="slide_item slide_unactive"></div>
					<div class="clear_both"></div>
				</div>
			</div>
            <div class="menu">
                <div class="menu-item"><img src="img/home-1.png"/>
                    <div>一斗投资</div>
                </div>
                <div class="menu-item"><img src="img/circle-1.png"/>
                    <div>投资项目</div>
                </div>
                <div class="menu-item"><img src="img/groups.png"/>
                    <div>一斗团队</div>
                </div>
                <div class="menu-item"><img src="img/contact-1.png"/>
                    <div>联系我们</div>
                </div>
            </div>
            <div class="yd-center">
                <div class="center-item">
                   <img class="item-img" src="img/4.png"/>
                </div>
				<div class="go_chatroom"></div>
                <!--<img class="yd-bom" src="img/yd-bom.png"/>-->
            </div>
        </div>
    </div>
</div>
</body>
<script type="text/javascript">
		
	    var active_index = 0;
		var MAX_INDEX = 2;
		var slider = function(){
			active_index++;
			if(active_index>MAX_INDEX){
				active_index = 0;
			}
			$("#slider_1 .slide_image img").eq(0).animate({"margin-left":"-33.3333%"},1000,function(){
				$item = $("#slider_1 .slide_image img").eq(0);
				$("#slider_1 .slide_image").append($item.clone());
				$item.remove();
				$("#slider_1 .slide_image img").eq(MAX_INDEX).css("margin-left","0");
				$("#slider_1 .slide_active").removeClass("slide_active").addClass("slide_unactive");
				$("#slider_1 .slide_item").eq(active_index).removeClass("#slider_1 slide_active slide_unactive").addClass("slide_active");
				setTimeout(function(){slider();},2000);
			});
			$("#slider_2 .slide_image img").eq(0).animate({"margin-left":"-33.3333%"},1000,function(){
				$item = $("#slider_2 .slide_image img").eq(0);
				$("#slider_2 .slide_image").append($item.clone());
				$item.remove();
				$("#slider_2 .slide_image img").eq(MAX_INDEX).css("margin-left","0");
				$("#slider_2 .slide_active").removeClass("slide_active").addClass("slide_unactive");
				$("#slider_2 .slide_item").eq(active_index).removeClass("#slider_2 slide_active slide_unactive").addClass("slide_active");
				setTimeout(function(){slider();},2000);
			});
			$("#slider_3 .slide_image img").eq(0).animate({"margin-left":"-33.3333%"},1000,function(){
				$item = $("#slider_3 .slide_image img").eq(0);
				$("#slider_3 .slide_image").append($item.clone());
				$item.remove();
				$("#slider_3 .slide_image img").eq(MAX_INDEX).css("margin-left","0");
				$("#slider_3 .slide_active").removeClass("slide_active").addClass("slide_unactive");
				$("#slider_3 .slide_item").eq(active_index).removeClass("#slider_3 slide_active slide_unactive").addClass("slide_active");
				setTimeout(function(){slider();},2000);
			});
			$("#slider_4 .slide_image img").eq(0).animate({"margin-left":"-33.3333%"},1000,function(){
				$item = $("#slider_4 .slide_image img").eq(0);
				$("#slider_4 .slide_image").append($item.clone());
				$item.remove();
				$("#slider_4 .slide_image img").eq(MAX_INDEX).css("margin-left","0");
				$("#slider_4 .slide_active").removeClass("slide_active").addClass("slide_unactive");
				$("#slider_4 .slide_item").eq(active_index).removeClass("#slider_4 slide_active slide_unactive").addClass("slide_active");
				setTimeout(function(){slider();},2000);
			});
		}
	$(function(){
		setTimeout(function(){slider();},3000);
	});
</script>
</html>
