/**
 * Created by Administrator on 16-3-29.
 */
(function ($) {
    var _me = function(options){
        var errors = [];
        var defaults = {
            category: 'qq', //表情类别
            default_category: 'qq', //默认表情类别
            convert: 'text', //将表情转化为文字还是图片
            row: '3', //一个模块显示多上行表情
            col: '7', //每行显示多少个表情
            path: 'emotion/qq/png/', //表情默认的保存地址
            target: '', //需要输入表情的输入框,或可编辑DIV
            container: 'body',
        };
        var options = $.extend({},defaults, options);
        $this = $(this);
        initOptions = options;
        var $target = $(options.target);
        var $container = $(options.container);
        var category = options.category ? options.category : options.default_category;
        if ($target.length <= 0) {
            errors.push("缺少表情赋值对象");
            return false;
        }
        if (options.row <= 0 || options.column <= 0) {
            errors.push("表情行列设置错误");
            return false;
        }
        init($container, options);
        $(document).on("click", options.container+" .ld-em-face", function (event) {
            var $target = $(options.target);
            var isInput = ($target[0].tagName[0] == "INPUT") ? true : false;
            var emotion = parseEmotion(this);
            if (isInput) {
                $target.setCaret();
                $target.insertAtCaret(emotion[0]);
            } else if (!isInput && initOptions.convert == "text") {
                $target.append(emotion[0]);
            } else if (!isInput && initOptions.convert == "image") {
                $target.append(emotion[1]);
            }
        });
    }

    $.fn.mobileEmotion = function (options) {
        var me = new _me(options);
    };// end of emotion
    var initOptions = {};
    var $this = null || $(this);


    var qq_face = [
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
    ];

    var init = function ($container, options) {
        console.log("\n\n************* mobile emotion initing....");
        if (options.category == "qq") {
            var sCount = (options.row * options.col - 1);
            var res = qq_face.length % sCount;
            var iBlock = parseInt(qq_face.length / sCount);
            iBlock = (res == 0) ? iBlock : iBlock + 1;
            var qq = '';
            if (!$container.hasClass('swiper-container')) {
                $container.addClass('swiper-container');
            }
            for (var i = 0; i < iBlock; i++) {
                qq += '<div class="swiper-slide">';
                for (var j = sCount * i; j < sCount * (i + 1); j++) {
                    qq = qq + '<img class="ld-em-face" face_id="' + qq_face[j] + '" src="' + options.path + "emb_" + j + '.gif"/>';
                }
                qq += '<img class="ld-em-delete" face_id = "' + qq_face[j] + '" src="' + options.path + 'delete.png"/>';
                qq += '</div>';
            }
            var qqSwiper = '<div class="swiper-wrapper">' + qq + '</div>' +
                '<div class="swiper-pagination"></div>';
            $container.empty().html(qqSwiper);
            $container.css({
                "padding-top": "0.9rem",
                "padding-left": "0.5rem",
                "padding-right": "0.5rem",
                "width":"100%",
                "height":"10.4rem"
            })
            $container.find(".swiper-slide").css({
                "width": "20rem",
                "height": "10.4rem"
            });
            var mySwiper = new Swiper('.swiper-container', {
                direction: 'horizontal',
                loop: false,
                pagination: '.swiper-pagination',
                paginationClickable: true,
                longSwipesRatio: 0.3,
                observer: true,//修改swiper自己或子元素时，自动初始化swiper
                observeParents: true,//修
                touchRatio: 1,
            });
        }
    };

    $(document).on("click", ".ld-em-delete", function (event) {
        console.log("click me");
        var $target = $(initOptions.target);
        var content = $target.html();
        $target.empty().append(DeleteLastEmotion(content));
    });

    $(document).on("click", ".textarea", function (event) {
        event.preventDefault();
        /*if ($(initOptions.container).is(":visible")) { //如果元素可见
            $(this).attr("contenteditable", "false");
        } else {
            $(this).attr("contenteditable", "true");
        }*/
        if($(initOptions.container).is(":visible")){
            $(initOptions.container).hide();
            $(this).focus();
        }
        console.log($(this).attr("contenteditable"));
        console.log("container: "+initOptions.container);
    });

    var DeleteLastEmotion = function (chat) {
        var newStr = chat;
        var reg = new RegExp("\\[.*?\\]", "g"); //全局匹配,懒惰模式只匹配一次
        var matches = []
            , match;
        while (match = reg.exec(chat)) {
            matches.push(match[0].substr(1, match[0].length - 2));
        }
        console.log(matches);
        var last = matches[matches.length - 1];
        if (matches.length) {
            if (qq_face.indexOf(last, 0) != -1) {
                var len = last.length + 2;
                chat.substr(0, chat.length - len);
            } else {
                return chat.substr(0, chat.length - 1);
            }
        } else {
            return chat.substr(0, chat.length - 1);
        }
    }

    var parseEmotion = function (face) {
        var text = "[" + $(face).attr("face_id") + "]";
        var img = '<img class="emotion-face" src="' + $(face).attr("src") + '"/>';
        return [text, img];
    }

    console.log($this);

})(jQuery);
