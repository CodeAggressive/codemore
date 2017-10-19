<!DOCTYPE html>
<html>
<head>
<title>avatar string output</title>
</head>
<body>
	<?php 
		$avatar  = array("微笑", "撇嘴", "色", "发呆", "得意", "流泪", "害羞",
        "闭嘴", "睡", "大哭", "尴尬", "发怒", "调皮", "呲牙",
        "惊讶", "难过", "酷", "冷汗", "抓狂", "吐",
        "偷笑", "愉快", "白眼", "傲慢", "饥饿", "困", "惊恐",
        "流汗", "憨笑", "悠闲", "奋斗", "咒骂", "疑问", "嘘",
        "晕", "疯了", "衰", "骷髅", "敲打", "再见",
        "擦汗", "抠鼻", "鼓掌", "糗大了", "坏笑", "左哼哼", "右哼哼",
        "哈欠", "鄙视", "委屈", "快哭了", "阴险", "亲亲", "吓",
        "可怜", "菜刀", "西瓜", "啤酒", "篮球", "兵乓",
        "咖啡", "饭", "猪头", "玫瑰", "凋谢", "嘴唇", "爱心",
        "心碎", "蛋糕", "闪电", "炸弹", "刀", "足球", "瓢虫",
        "便便", "月亮", "太阳", "礼物", "拥抱", "强",
        "弱", "握手", "胜利", "抱拳", "勾引", "拳头", "差劲",
        "爱你", "NO", "OK", "爱情", "飞吻", "跳跳", "发抖",
        "怄火", "转圈", "磕头", "回头", "跳绳", "投降");
		for($i=0; $i<count($avatar);$i++){
			if(($i+1)%5 ==0){
				echo '"'.$avatar[$i].'":'.$i.",".PHP_EOL."<br/>";
			}else{
				echo '"'.$avatar[$i].'":'.$i.",";
			}
		}
	?>



</body>
</html>



<div class="page" id="page-1">
	<div class="chat-room"></div>
	<div class="chat-submit">
		<div class="btn-setting"><img src="img/setting.png"/>
			<div class="notify-priv-msg"></div>
		</div>
		<div contenteditable="true" class="textarea" placeholder="请输入文字"></div>
		<div class="btn-send-msg">发送</div>
		<div class="setting-more">
			<div class="setting-about"></div>
			<div class="setting-qrcode"></div>
			<div class="setting-group">
				<div class="notify-priv-msg"></div>
			</div>
		</div>
	</div>
</div>

<div class="page" id="page-4">
	<div class="go-back"></div>
	<div class="qrcode-tip">长按图片保存二维码</div>
	<img class="yidou-qrcode" src="img/yidou.jpg"/>
</div>
<div class="page" id="page-5">
	<div class="member-list">
		<div class="go-back"></div>
		<div class="member-list-top">
			<div><span>群ID:</span><span>888888</span></div>
			<div><span>群二维码:</span><img class="group-qrcode" src="img/qrcode.png"/></div>
		</div>
		<div class="member-list-bottom">
			<div class="member-list-title">全部成员</div>
			<div class="self-window"></div>
			<div class="member-list-window"></div>
			<div class="offline-member-list-window"></div>
		</div>
	</div>
</div>