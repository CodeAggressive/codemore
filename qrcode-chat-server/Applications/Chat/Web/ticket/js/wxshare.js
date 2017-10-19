/**
@shareData: {
	appid: string/function
	title: string/function
	desc: string/function
	link: string/function
	imgUrl: string/function
}
**/
function WeixinShare(shareData)
{
	this.shareData = shareData;
	if(wx && wx.checkJsApi)
	{
		this.shareType = "api";
		this.getConfigParam(this.initByAPI);
	}
	else
	{
		this.shareType = "bridge";
		this.getConfigParam(this.initByBridge);
	}
}

WeixinShare.prototype.getConfigParam = function(callback){
	var wxConfig = {
		'debug':'',
		'appId':'',
		'timestamp':'',
		'nonceStr':'',
		'signature':'',
		'jsAppList':''
	};
	$.post('jsWxConfig.php',function(data){
		var jsApiInterface = ['onMenuShareTimeline','onMenuShareAppMessage',
							'onMenuShareQQ','onMenuShareWeibo',
							'onMenuShareQZone','startRecord',
							'stopRecord','onVoiceRecordEnd',
							'playVoice','pauseVoice',
							'stopVoice','onVoicePlayEnd',
							'uploadVoice','downloadVoice',
							'chooseImage','previewImage',
							'uploadImage','downloadImage',
							'translateVoice','getNetworkType',
							'openLocation','getLocation',
							'hideOptionMenu','showOptionMenu',
							'hideMenuItems','showMenuItems',
							'hideAllNonBaseMenuItem','showAllNonBaseMenuItem',
							'closeWindow','scanQRCode',
							'chooseWXPay','openProductSpecificView',
							'addCard','chooseCard','openCard'];
		wxConfig.debug = true;
		wxConfig.appId = data.appId;
		wxConfig.timestamp = data.timestamp;
		wxConfig.nonceStr = data.nonceStr;
		wxConfig.signature = data.signature;
		wxConfig.jsApiList = jsApiInterface;
		
		wx.config(this.wxConfig);
		
		this.shareData.appid = data.appId;
		this.shareData.title = data.title;
		this.shareData.desc = data.desc;
		this.shareData.link = data.link;
		this.shareData.imgUrl = data.imgUrl;
		callback();
	});
}

WeixinShare.prototype.initByAPI = function()
{
	var me = this;
	alert("WeixinShare");
	wx.ready(function()
	{
		var shareData = {
			title: me.getParam("title"),
			desc: me.getParam("desc"),
			link: me.getParam("link"),
			imgUrl: me.getParam("imgUrl"),
			success: function (res) 
			{
				this.title = me.getParam("title");
				this.desc = me.getParam("desc");
				this.link = me.getParam("link");
				this.imgUrl = me.getParam("imgUrl");
			}
		};
		wx.onMenuShareAppMessage(shareData);
		wx.onMenuShareTimeline(shareData);
	});
};

WeixinShare.prototype.initByBridge = function()
{
	var me = this;
	document.addEventListener('WeixinJSBridgeReady', 
	function onBridgeReady() 
	{
		WeixinJSBridge.on('menu:share:appmessage', 
						  function (argv) { me.shareFriend()}
		);
		WeixinJSBridge.on('menu:share:timeline', 
						  function (argv) { me.shareTimeline()}
		);
	}, false);
};

WeixinShare.prototype.getParam = function(name)
{
	var val = this.shareData[name];
	if(typeof val == "function")
	{
		return val();
	}

	return val;
};

WeixinShare.prototype.shareFriend = function()
{
	WeixinJSBridge.invoke('sendAppMessage', {
		appid: this.getParam("appid"),
		img_url: this.getParam("imgUrl"),
		img_width: 120,
		img_height: 120,
		link: this.getParam("link"),
		title: this.getParam("title"),
		desc: this.getParam("desc")
	},
	function(res)
	{
		_report('send_msg', res.err_msg);
	});
};

WeixinShare.prototype.shareTimeline = function()
{
	WeixinJSBridge.invoke('shareTimeline', {
		appid: this.getParam("appid"),
		img_url: this.getParam("imgUrl"),
		img_width: 120,
		img_height: 120,
		link: this.getParam("link"),
		title: this.getParam("title"),
		desc: this.getParam("desc")
	},
	function(res)
	{
		_report('timeline', res.err_msg);
	});
};