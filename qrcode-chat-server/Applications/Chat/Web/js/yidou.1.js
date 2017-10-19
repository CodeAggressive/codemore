/************************************************
 * Leader-tech(BeiJin) Co.Ltd All Rights Reserved
 * Version: 1.0.0
 * Author:  Tom Song
 * Create Date : 2016-1-11 2:36
 ************************************************/
 var html5Init = function () {
			var wWin = $(window).width();
			var wHei = $(window).height();
			var ratio = wWin / 320;
			var htmlFontSize = parseInt(ratio * 16);
			$("html").css("font-size", htmlFontSize + "px");
		}
  var links = [
	"http://www.yidousz.com/files/shuimofang.pdf",
	"http://www.yidousz.com/projects1.html",
	"http://www.tencrwin.com/",
	"http://ld-kj.cn/yidou/fucheng.html",
	"http://www.yidousz.com/projects2.html", 
	"http://ld-kj.cn/yidou/xinyijia.html",
	"http://ld-kj.cn/yidou/henanxin.html",
	"http://www.leader-tech.cn/",
  ];
$(function () {
	html5Init();
	var baseUrl = location.href;
	var curIdx = 0;
	if(baseUrl.lastIndexOf("#")!=-1){
		curIdx = parseInt(baseUrl.substr(baseUrl.lastIndexOf('#')+1));
		baseUrl = baseUrl.substr(0,baseUrl.lastIndexOf('#'));
	}else{
		location.href = baseUrl + "#0";
	}
	var mySwiper = new Swiper ('.swiper-container', {
		direction: 'horizontal',
		loop: false,
		effect : 'slide',
		onSlideChangeEnd: function(swiper){
			location.href = baseUrl +'#'+(mySwiper.activeIndex);
		}
	})
	if(curIdx!=0){
		mySwiper.slideTo(curIdx);
	}
	
	$(".menu-item").click(function () {
		var idx = $(this).index();
		mySwiper.slideTo(idx);
	});

	$(".go_chatroom").click(function(){
		console.log("go_chatroom");
		location.href="index.php";
	});
	
	$(".project").click(function(){
		var idx = $(this).index();
		location.href = links[idx];
	});

});
