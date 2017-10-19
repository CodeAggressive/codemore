/*
 * 智能机浏览器版本信息:
 */
var browser = {
	versions : function () {
		var u = navigator.userAgent,
		app = navigator.appVersion;
		return { //移动终端浏览器版本信息
			trident : u.indexOf('Trident') > -1, //IE内核
			presto : u.indexOf('Presto') > -1, //opera内核
			webKit : u.indexOf('AppleWebKit') > -1, //苹果、谷歌内核
			gecko : u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
			mobile : !!u.match(/AppleWebKit.*Mobile.*/) || !!u.match(/AppleWebKit/), //是否为移动终端
			ios : !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
			android : u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
			iPhone : u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQ HD浏览器
			iPad : u.indexOf('iPad') > -1, //是否iPad
			webApp : u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
		};
	}
	(),
	language : (navigator.browserLanguage || navigator.language).toLowerCase()
}

var html5Init = function () {
	var wWin = $(window).width();
	var wHei = $(window).height();
	var ratio = wWin / 320;
	var htmlFontSize = parseInt(ratio * 16);
	$("html").css("font-size", htmlFontSize + "px");
}

var getRatio = function () {
	var wWin = $(window).width();
	var ratio = wWin / 320;
	return ratio;
}

function orientationChange() {
	switch (window.orientation) {
	case 0:
		html5Init();
		break;
	case -90:
		html5Init();
		break;
	case 90:
		html5Init();
		break;
	case 180:
		html5Init();
		break;
	}
}

function AutoResizeImage(wWin, hWin, wImg, hImg) {
	var percentL = percentT = percentW = percentH = 0;
	if (wWin >= wImg && hWin >= hImg) { //情形一
		percentW = wImg / wWin;
		percentH = hImg / hWin;
		percentL = (1 - percentW) / 2;
		percentT = (1 - percentH) / 2;
		console.log("[情形一][wWin > wImg && hWin > hImg]\n");
	} else if (wWin <= wImg && hWin >= hImg) { //情形二
		percentW = 1;
		percentL = 0;
		percentH = (hImg * (wWin / wImg)) / hWin;
		percentT = (1 - percentH) / 2;
		console.log("[情形二][wWin < wImg && hWin > hImg]\n");
	} else if (wWin >= wImg && hWin <= hImg) { //情形三
		percentH = 1;
		percentT = 0;
		percentW = (wImg * (hWin / hImg)) / wWin;
		percentL = (1 - percentW) / 2;
		console.log("[情形三][wWin >= wImg && hWin <= hImg]\n");
	} else if (wWin < wImg && hWin < hImg) { //情形四
		var ratioW = wImg / wWin;
		var ratioH = hImg / hWin;
		if (ratioW > ratioH) {
			percentW = 1;
			percentL = 0;
			percentH = (hImg * (wWin / wImg)) / hWin;
			percentT = (1 - percentH) / 2;
			console.log("[情形四][wWin < wImg && hWin < hImg]\n");
		} else {
			percentH = 1;
			percentT = 0;
			percentW = (wImg * (hWin / hImg)) / wWin;
			percentL = (1 - percentW) / 2;
			console.log("[情形五][wWin < wImg && hWin < hImg]\n");
		}
	}
	if (true) {
		console.log("[wWin,hWin,wImg,hImg]=" + "[" + wWin + "," + hWin + "," + wImg + "," + hImg + "]\n");
		console.log("[L,T,W,H]=" + "[" + percentL + "," + percentT + "," + percentW + "," + percentH + "]\n");
	}
	return [percentL, percentT, percentW, percentH];
}

function ShowResizeImage(arrPercent) {
	$(".popup-photo img").css({
		"left" : arrPercent[0] * 100 + "%",
		"top" : arrPercent[1] * 100 + "%",
		"width" : arrPercent[2] * 100 + "%",
		"height" : arrPercent[3] * 100 + "%",
		"position" : "relative",
		"opacity" : 0,
		"display" : "block"
	});
	$(".popup-photo").css({
		"top" : "0px",
		"opacity" : 1
	});
	$(".popup-photo img").animate({
		"opacity" : 1
	}, 300);
}

$(function () {
	html5Init();
	if (ticket_upload == 1) {
		var ratio = getRatio();
		var w = parseInt(5.3 * 16 * ratio);
		$(".uploaded-img-container img").jqthumb({
			width : w,
			height : w
		});
		$(".jqthumb").css({
			"float" : "left",
			"margin-top" : "0.5rem",
			"margin-bottom" : "0.5rem"
		});
		$(".store-btn").css("display","none");
		$(".share-wx").css("height","5.3rem");
		$(".share-btn").css("top","1.4rem");
	}

	$(document).on("click", ".jqthumb", function () {
		var imgsrc = $(this).next(".uploaded-image").attr("src");
		var img = '<div class="popup-photo"><img src="' + imgsrc + '"/></div>';
		$("body").append(img);
		$(".popup-photo").css({
			"position" : "fixed",
			"left" : "0",
			"top" : "0",
			"width" : "100%",
			"height" : "100%",
			"backgroundColor" : "#000"
		});
		var wWin = $(window).width();
		var hWin = $(window).height() * 0.88;
		$(".popup-photo img").load(function () {
			wImg = this.width;
			hImg = this.height;
			var arrPercent = AutoResizeImage(wWin, hWin, wImg, hImg);
			ShowResizeImage(arrPercent);
		});
	});
	$(document).on("click", ".popup-photo", function () { //关闭图片
		$(".popup-photo").animate({
			"opacity" : 0
		}, 20, function () {
			$(".popup-photo").remove();
		});
	});
	$(document).on("click", ".popup-photo img", function () {
		$(".popup-photo").trigger("click");
	});
	// 添加事件监听
	addEventListener('load', function () {
		orientationChange();
		window.onorientationchange = orientationChange;
	});
	var wWin = $(window).width();
	var ratio = wWin / 320;
	var $list = $(".uploader-list");
	var thumbnailWidth = 5.3 * 16 * ratio;
	var thumbnailHeight = 5.3 * 16 * ratio;

	$(document).on('click', ".delete-thumbnail", function () {
		var fileId = $(this).siblings(".file-item").attr("id");
		uploader.removeFile(fileId, true);
		var idx = $(this).parent().index();
		$(this).parent().remove();
		
		$.post("imageDelete.php", {
				index: idx
		}, function (data) {
		
		});
		
		if ($(".thumbnail-container").length < 3) {
			$(".upload-icon").css("display", "block");
		}
	});

	// 初始化Web Uploader
	var uploader = WebUploader.create({

			// 选完文件后，是否自动上传。
			auto : true,
			// 图片质量，只有type为`image/jpeg`的时候才有效。
			quality : 90,
			// 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
			allowMagnify : false,
			// 是否保留头部meta信息。
			preserveHeaders : true,
			//验证文件总数量, 超出则不允许加入队列。
			fileNumLimit : 3,
			// swf文件路径
			swf : 'js/webuploader-0.1.5/Uploader.swf',

			// 文件接收服务端。
			server : 'fileupload.php',

			// 选择文件的按钮。可选。
			// 内部根据当前运行是创建，可能是input元素，也可能是flash.
			pick : '#filePicker',

			// 只允许选择图片文件。
			accept : {
				title : 'Images',
				extensions : 'gif,jpg,jpeg,bmp,png',
				mimeTypes : 'image/*'
			}
		});

	// 当有文件添加进来的时候
	uploader.on('fileQueued', function (file) {
		var $li = $(
				'<div class="thumbnail-container">' +
				'<div id="' + file.id + '" class="file-item thumbnail">' +
				'<img class="thumb-img">' +
				/* '<div class="info">' + file.name + '</div>' + */
				'</div>' +
				'<div class="delete-thumbnail"><img src="images/close.png"/></div>'),
		$img = $li.find('.thumb-img');

		// $list为容器jQuery实例
		$list.append($li);
		if ($(".thumbnail-container").length == 3) {
			$(".upload-icon").css("display", "none");
		}
		// 创建缩略图
		// 如果为非图片文件，可以不用调用此方法。
		// thumbnailWidth x thumbnailHeight 为 100 x 100
		uploader.makeThumb(file, function (error, src) {
			if (error) {
				$img.replaceWith('<span>不能预览</span>');
				return;
			}
			$img.attr('src', src);
		}, thumbnailWidth, thumbnailHeight);
	});
	// 文件上传过程中创建进度条实时显示。
	uploader.on('uploadProgress', function (file, percentage) {
		var $li = $('#' + file.id),
		$percent = $li.find('.progress span');

		// 避免重复创建
		if (!$percent.length) {
			$percent = $('<p class="progress"><span></span></p>')
				.appendTo($li)
				.find('span');
		}

		$percent.css('width', percentage * 100 + '%');
	});

	// 文件上传成功，给item添加成功class, 用样式标记上传成功。
	uploader.on('uploadSuccess', function (file) {
		$('#' + file.id).addClass('upload-state-done');
		$('#' + file.id).next('.delete-thumbnail').css("display",'block');
	});

	// 文件上传失败，显示上传出错。
	uploader.on('uploadError', function (file) {
		var $li = $('#' + file.id),
		$error = $li.find('div.error');

		// 避免重复创建
		if (!$error.length) {
			$error = $('<div class="error"></div>').appendTo($li);
		}

		$error.text('上传失败');
	});

	// 完成上传完了，成功或者失败，先删除进度条。
	uploader.on('uploadComplete', function (file) {
		$('#' + file.id).find('.progress').remove();
	});
	//收藏上传图片
	$(".store-btn").click(function(){
		//插入图片记录
		if ($(".thumbnail-container").length == 0) {
			toastr.remove();
			toastr.error(" ", "亲!你还没有添加图片.");			
			return;
		}else{
			if($(".thumbnail-container .progress").length>0){
				toastr.remove();
				toastr.error(" ", "图片上传中,请稍后收藏.");			
				return;
			}
			$.post("imageInsert.php", {
					cv : code
			}, function (data) {
				$(".popup-weixin").trigger("click");
				toastr.remove();
				toastr.success(" ", "收藏上传图片成功!");
				$(".delete-thumbnail").css("display","none");
				$(".upload-icon").css("display","none");
			});
		}
	});
	//分享到朋友圈
	$(".share-btn").click(function () {
		var ua = navigator.userAgent.toLowerCase();
		if (/micromessenger/.test(ua) == false) {
			toastr.remove();
			toastr.error(" ", "请使用微信扫码,再进行分享!");
			return;
		}
		if (ticket_upload == -1) { //没有码值不允许分享
			toastr.remove();
			toastr.error(" ", "码值不对,不允许分享!");
		} else if (ticket_upload == 1) { //已经上传过图片
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
		} else if (ticket_upload == 0) { //还没有上传过图片
			if ($(".thumbnail-container").length == 0) {	
				toastr.remove();			
				toastr.info(" ", "亲!上传照片后才能分享.");
				return;
			}
			ShowWxTip();
			var wxParam = JSON.parse(wxSign);
			var shareData = {
				appid : "wx2786ce187bdd15c0",
				title : "蔡依林演唱会",
				desc : "蔡依林2016PLAY世界巡回演唱会北京站",
				link : wxParam.url,
				imgUrl : "http://ld-kj.cn/ticket/images/poster-1.png",
				need_insert : true
			};
			var wxApi = new WeixinShare(shareData);
		}
	});

	function ShowWxTip() {
		var ua = navigator.userAgent.toLowerCase();
			if (/micromessenger/.test(ua)) {
				$(".popup-weixin").css({
					"display" : "block",
					"opacity" : "0.9"
				});
			}
	}
	function HideWxTip() {
		$(".popup-weixin").trigger("click");
	}

	$(".popup-weixin").click(function () {
		$(".popup-weixin").fadeOut();
	});

}); // end of jQuery Wrapper
