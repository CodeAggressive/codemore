/************************************************
 * Leader-tech(BeiJin) Co.Ltd All Rights Reserved
 * Version: 1.0.0
 * Author:  Tom Song
 * Create Date : 2016-1-11 2:36
 ************************************************/
$(function () {
	var mySwiper = new Swiper ('.swiper-container', {
		direction: 'horizontal',
		loop: false,
		effect : 'coverflow'
	})
	$(".menu-item").click(function () {
		var idx = $(this).index();
		mySwiper.slideTo(idx+1);
	});

	$(".go_chatroom").click(function(){
		location.href="index.php";
	});

});
