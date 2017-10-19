/**
 * Created by Tom Song on 16-3-18.
 */
function IsMobile() {
    var browser = {
        versions: function () {
            var u = navigator.userAgent,
                app = navigator.appVersion;
            return { //移动终端浏览器版本信息
                trident: u.indexOf('Trident') > -1, //IE内核
                presto: u.indexOf('Presto') > -1, //opera内核
                webKit: u.indexOf('appleWebKit') > -1, //苹果、谷歌内核
                gecko: u.indexOf('Gecko') > -1 && u.indexOf('KHTML') == -1, //火狐内核
                mobile: !!u.match(/appleWebKit.*Mobile.*/) || !!u.match(/appleWebKit/), //是否为移动终端
                ios: !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/), //ios终端
                android: u.indexOf('Android') > -1 || u.indexOf('Linux') > -1, //android终端或者uc浏览器
                iPhone: u.indexOf('iPhone') > -1 || u.indexOf('Mac') > -1, //是否为iPhone或者QQHD浏览器
                iPad: u.indexOf('iPad') > -1, //是否iPad
                webapp: u.indexOf('Safari') == -1 //是否web应该程序，没有头部与底部
            };
        }
        (),
        language: (navigator.browserLanguage || navigator.language).toLowerCase()
    };
    return browser.versions.mobile;
}
var gDebug = {
    "open": false,
    "isMobile": IsMobile()
};
function AutoLog(content) {
    if (gDebug.open) {
        if (gDebug.isMobile) {
            swal("", content, "success");
        } else {
            console.log(content);
        }
    }
}

function GetUploadFileIcon(filetype){
    var  file_types = ['pdf','ppt','doc','docx','unknown','zip','rar','flv','txt'];
    var icon  = '';
    for(var i=0; i<file_types.length; i++){
        if(filetype == file_types[i]){
            icon = 'img/'+file_types[i]+'.png';
            break;
        }
    }
    if(icon == ''){
        if(filetype=='mov'||filetype =='mp4'||filetype == 'mp3'){
            icon = 'img/flv.png';
        }else {
            icon = 'img/unknown.png';
        }
    }
    return icon;
}
function ShowPage($page) {
    $(".page").hide();
    $page.show();
}
function htmlspecialchars_decode(str) {
    str = str.replace(/&amp;/g, '&');
    str = str.replace(/&lt;/g, '<');
    str = str.replace(/&gt;/g, '>');
    str = str.replace(/&quot;/g, "''");
    str = str.replace(/&#039;/g, "'");
    return str;
}
function trim(strVal) {
    return strVal.replace(/(^\s+)|(\s+$)/g, "");
}
function initHtml5() {
    var wWin = $(document).width();
    var ratio = wWin / 320;
    $("html").css("font-size", 16 * ratio + "px");
}
function GetRandCode() {
    var code = '';
    for (var i = 0; i < 6; i++) {
        code += Math.floor(Math.random() * 10);
    }
    return code;
}
/****************************************
 *将用户信息存入LocalStorage
 *存入的是JSON对象字符串
 ****************************************/
function SetDataToLocalStorage(arrUser) {
    var userinfo = JSON.stringify(arrUser);
    if (CheckLocalStorageSupport()) {
        localStorage.setItem("stoYiDouUserInfo", userinfo);
    }
}
/**************************************
 * 访问SVN权限
 **************************************/
function filterEmotion(str) {
    /*var data = [
     "微笑", "撇嘴", "色", "发呆", "得意", "流泪", "害羞",
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
     "怄火", "转圈", "磕头", "回头", "跳绳", "投降"
     ];*/
    var newStr = str;
    var reg = new RegExp("\\[.*?\\]", "g"); //全局匹配,懒惰模式只匹配一次
    var matches = []
        , match;
    while (match = reg.exec(str)) {
        matches.push(match[0].substr(1, match[0].length - 2));
    }
    if (matches.length > 0) {
        for (var i = 0; i < matches.length; i++) {
            newStr = newStr.replace("[" + matches[i] + "]", GetEmotionPath(matches[i]));
        }
    }
    return newStr;
}

function GetEmotionPath(key) {
    var data = {
        "微笑":0,"撇嘴":1,"色":2,"发呆":3,"得意":4,
        "流泪":5,"害羞":6,"闭嘴":7,"睡":8,"大哭":9,
        "尴尬":10,"发怒":11,"调皮":12,"呲牙":13,"惊讶":14,
        "难过":15,"酷":16,"冷汗":17,"抓狂":18,"吐":19,
        "偷笑":20,"愉快":21,"白眼":22,"傲慢":23,"饥饿":24,
        "困":25,"惊恐":26,"流汗":27,"憨笑":28,"悠闲":29,
        "奋斗":30,"咒骂":31,"疑问":32,"嘘":33,"晕":34,
        "疯了":35,"衰":36,"骷髅":37,"敲打":38,"再见":39,
        "擦汗":40,"抠鼻":41,"鼓掌":42,"糗大了":43,"坏笑":44,
        "左哼哼":45,"右哼哼":46,"哈欠":47,"鄙视":48,"委屈":49,
        "快哭了":50,"阴险":51,"亲亲":52,"吓":53,"可怜":54,
        "菜刀":55,"西瓜":56,"啤酒":57,"篮球":58,"兵乓":59,
        "咖啡":60,"饭":61,"猪头":62,"玫瑰":63,"凋谢":64,
        "嘴唇":65,"爱心":66,"心碎":67,"蛋糕":68,"闪电":69,
        "炸弹":70,"刀":71,"足球":72,"瓢虫":73,"便便":74,
        "月亮":75,"太阳":76,"礼物":77,"拥抱":78,"强":79,
        "弱":80,"握手":81,"胜利":82,"抱拳":83,"勾引":84,
        "拳头":85,"差劲":86,"爱你":87,"NO":88,"OK":89,
        "爱情":90,"飞吻":91,"跳跳":92,"发抖":93,"怄火":94,
        "转圈":95,"磕头":96,"回头":97,"跳绳":98,"投降":99
    };
    if (data[key] != undefined) {
        return '<img class="emotion_qq" src="emotion/qq/gif/emb_' + data[key] + '.gif"/>';
    } else {
        return "[" + key + "]";
    }
}
/**************************************
 *检查浏览人是否支持HTML LocalStorage
 **************************************/
function CheckLocalStorageSupport() {
    try {
        return 'localStorage' in window && window['localStorage'] !== null;
    } catch (e) {
        return false;
    }
}
/****************************************
 *清除LocalStorage缓存
 ****************************************/
function ClearAllLocalStorageData() {
    if (CheckLocalStorageSupport()) {
        SetDataToLocalStorage([]);
        localStorage.clear();
    }
}
/****************************************
 *将数据从LocalStorage取出用户信息
 *取出的是用户信息JSON对象
 ****************************************/
function GetDataFromLocalStorage() {
    if (CheckLocalStorageSupport()) {
        return localStorage.getItem("stoYiDouUserInfo");
    }
}


//格式化日期
function FormatTime(time) {
    var past = new Date(time.replace(/-/g, '/'));
    var now = new Date();
    var now_day = now.getDate();
    var past_day = past.getDate();
    var days = now_day - past_day;
    if(gDebug.open) {
        console.log("\n*******now_day = " + now_day + ",past_day = " + past_day + "*********\n");
    }
    if (days == 0) {
        return time.substr(11, 5);
    } else if (days == 1) {
        return "昨天";
    } else if (days >= 2 && days <= 5) {
        return GetDateWeek(time);
    } else {
        return time.substr(5, 5);
    }
}
//格式化日期
function FormatTime2(time){
    var past = new Date(time.replace(/-/g, '/'));
    var now = new Date();
    var now_day = now.getDate();
    var past_day = past.getDate();
    var days = now_day - past_day;
    if(gDebug.open) {
        console.log("\n*******now_day = " + now_day + ",past_day = " + past_day + "*********\n");
    }
    if (days == 0) {
        return time.substr(11, 5);
    } else if (days >=1 && days <= 5) {
        return days+"天前";
    } else {
        return time.substr(5, 5);
    }
}

//格式化文件大小
function FormatFileSize(file){
    var unit;

    units = units || [ 'B', 'K', 'M', 'G', 'TB' ];

    while ( (unit = units.shift()) && size > 1024 ) {
        size = size / 1024;
    }

    return (unit === 'B' ? size : size.toFixed( pointLength || 2 )) +
        unit;
}

//格式化日期
function FormatTime3(time){
    var t = new Date(time.replace(/-/g,'/'));
    var y = t.getFullYear();
    var m = t.getMonth();
    var d = t.getDate();
    return y+"年"+m+"月"+d+"日";
}
//比较两个日期是否是同一天
function IsSameDay(time1,time2){
    if(time1 == '' || time2 == ''){
        return false;
    }
    var t1 = new Date(time1.replace(/-/g, '/'));
    var t2 = new Date(time2.replace(/-/g, '/'));
    var d1 = t1.getDate();
    var d2 = t2.getDate();
    return (d1-d2)==0?true:false;
}
function GetDateWeek(time) {
    var d = new Date(time.replace(/-/g, '/'));
    var weekday = new Array(7);
    weekday[0] = "星期天";
    weekday[1] = "星期一";
    weekday[2] = "星期二";
    weekday[3] = "星期三";
    weekday[4] = "星期四";
    weekday[5] = "星期五";
    weekday[6] = "星期六";
    return weekday[d.getDay()];
}
function Log(content){
    if(window.console){
        if(typeof(content)!="object"){
            console.log("[服务器]"+content);
        }else {
            console.log(JSON.stringify(content));
        }
    }
}
function Log1(content){
    if(window.console){
        console.log("*******"+content+"*********");
    }
}
function Log2(content){
    if(window.console){
        console.log(content);
    }
}
function FormatNotice(content){
    return content.length>14?content.substr(0,14)+'...':content;
}

function Now(){
    var d = new Date();
    var year = d.getFullYear();
    var month = d.getMonth();
    var day = d.getDay();
    var hour = d.getHours();
    var minute = d.getMinutes();
    var second = d.getSeconds();
    return year+'_'+month+'_'+day+"_"+hour+"_"+minute+"_"+second;
}