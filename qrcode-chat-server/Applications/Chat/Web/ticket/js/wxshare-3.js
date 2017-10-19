/**
@shareData: {
appid: string/function
title: string/function
desc: string/function
link: string/function
imgUrl: string/function
}
 **/
 
function isFunction(fn) {
   return Object.prototype.toString.call(fn)=== '[object Function]';
}
 
function WeixinShare(shareData) {
	this.shareData = shareData;
	this.wxConfig = {
		'debug' : '',
		'appId' : '',
		'timestamp' : '',
		'nonceStr' : '',
		'signature' : '',
		'jsAppList' : ''
	};
	if (wx && wx.checkJsApi) {
		this.shareType = "api";
		this.getConfigParam(this.initByAPI);
	} else {
		this.shareType = "bridge";
		this.getConfigParam(this.initByBridge);
	}
}

WeixinShare.prototype.getConfigParam = function (callback) {
	var me = this;
	/*var jsApiInterface = ['onMenuShareTimeline', 'onMenuShareAppMessage',
	'onMenuShareQQ', 'onMenuShareWeibo',
	'onMenuShareQZone', 'startRecord',
	'stopRecord', 'onVoiceRecordEnd',
	'playVoice', 'pauseVoice',
	'stopVoice', 'onVoicePlayEnd',
	'uploadVoice', 'downloadVoice',
	'chooseImage', 'previewImage',
	'uploadImage', 'downloadImage',
	'translateVoice', 'getNetworkType',
	'openLocation', 'getLocation',
	'hideOptionMenu', 'showOptionMenu',
	'hideMenuItems', 'showMenuItems',
	'hideAllNonBaseMenuItem', 'showAllNonBaseMenuItem',
	'closeWindow', 'scanQRCode',
	'chooseWXPay', 'openProductSpecificView',
	'addCard', 'chooseCard', 'openCard'];*/

	var wxParam = JSON.parse(wxSign);
	wx.config({
		debug : false,
		appId : wxParam.appId,
		timestamp : wxParam.timestamp,
		nonceStr : wxParam.nonceStr,
		signature : wxParam.signature,
		jsApiList : ['onMenuShareTimeline']
	});
	callback(me.shareData);
}

WeixinShare.prototype.initByAPI = function (param) {
	var me = this;
	wx.ready(function () {
		var shareData = {
			title : param.title,
			desc : param.desc,
			link : param.link,
			imgUrl : param.imgUrl,
			success : function (res) {
				if (param.need_insert) {
					//插入图片记录
					$.post("imageInsert.php", {
						cv : code
					}, function (data) {
						$(".popup-weixin").trigger("click");
						toastr.remove();
						toastr.success(' ', '分享朋友圈成功!');
						$(".delete-thumbnail").css("display","none");
						$(".upload-icon").css("display","none");
					});
				}				
			},
			cancel : function (res) {
				$(".popup-weixin").trigger("click");
				toastr.remove();
				toastr.info(' ', '您已取消分享.');
			}
		};
		//wx.onMenuShareAppMessage(shareData);
		wx.onMenuShareTimeline(shareData);
	});
};

WeixinShare.prototype.initByBridge = function () {
	var me = this;
	document.addEventListener('WeixinJSBridgeReady',
		function onBridgeReady() {
		WeixinJSBridge.on('menu:share:appmessage',
			function (argv) {
			me.shareFriend()
		});
		WeixinJSBridge.on('menu:share:timeline',
			function (argv) {
			me.shareTimeline()
		});
	}, false);
};

WeixinShare.prototype.getParam = function (name) {
	var val = this.shareData[name];
	if (typeof val == "function") {
		return val();
	}

	return val;
};

WeixinShare.prototype.shareFriend = function () {
	WeixinJSBridge.invoke('sendAppMessage', {
		appid : this.getParam("appid"),
		img_url : this.getParam("imgUrl"),
		img_width : 120,
		img_height : 120,
		link : this.getParam("link"),
		title : this.getParam("title"),
		desc : this.getParam("desc")
	},
		function (res) {
		_report('send_msg', res.err_msg);
	});
};

WeixinShare.prototype.shareTimeline = function () {
	WeixinJSBridge.invoke('shareTimeline', {
		appid : this.getParam("appid"),
		img_url : this.getParam("imgUrl"),
		img_width : 120,
		img_height : 120,
		link : this.getParam("link"),
		title : this.getParam("title"),
		desc : this.getParam("desc")
	},
		function (res) {
		_report('timeline', res.err_msg);
	});
};
