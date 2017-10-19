/**
 * Created by Tom Song on 2016-3-18.
 */
var IsPageExist = function (page) {
    return $(page).length;
}
var NewIScroll = function (id, exceptionElem, callback) {
    setTimeout(function () {
        var iScroll = new IScroll(id, {
            preventDefault: true,
            click: true,
            topOffset: 0,
            probeType: 2,
            bindToWrapper: true,
            preventDefaultException: {
                tagName: /^(img)$/,
                className: exceptionElem
            }
        });
        callback(iScroll);
    }, 0);
}
var CFriendCircle = function (type, leader_id, avatar, name) {
    this._type = type;
    this._leader_id = leader_id;
    this._avatar = avatar;
    this._name = name;
    this._iScroll = null;
    this._newestPostId = "max";
    this._oldestPostId = "max";
    this._moreNewData = true;
    this._moreOldData = true;
    this._bInited = false;
    this._loadingNewData = false;
    this._loadingOldData = false;
}
CFriendCircle.prototype = {
    UpdateNewestPostId: function (postId) {
        this._newestPostId = postId;
    },
    UpdateOldestPostId: function (postId) {
        this._oldestPostId = postId;
    },
    _newWnd: function () {
        var btn = '<div class="btn-new-post">写说说</div>';
        if (this._leader_id != gUserInfo.leader_id) {
            btn = '';
        }
        var wnd = '<div class="page" class="page-friend-circle" id="pfc-' + this._type + '-' + this._leader_id + '">' +
            '<div class="pfc-wrapper"><div class="fc-cover">' +
            '<img class="cover-bk" src="img/cover.3.jpg"/>' +
            '<img class="cover-avatar" src="' + this._avatar + '"/>' +
            '<div class="cover-name">' + this._name + '</div>' + btn +
            '</div><div class="friend-post"></div></div></div>';
        $(document.body).append(wnd);
        return $('#pfc-' + this._type + '-' + this._leader_id);
    },
    _newIScroll: function () {
        var id = '#pfc-' + this._type + '-' + this._leader_id;
        var exceptElem = /(^|\s)post_avatar|btn-new-post|btn_post_favorite|btn_post_review(\s|$)/;
        var that = this;
        var init = function (iScroll) {
            console.log("_newIScroll");
            that._iScroll = iScroll;
            console.log(that._iScroll);
            that._iScroll.on('scroll', function () {
                var y = this.y;
                Log("max y = "+this.maxScrollY);
                if(this.y>40){
                    that._loadingNewData = true;
                }
                if(this.y<(this.maxScrollY-40)){
                    that._loadingOldData = true;
                }
            });
            that._iScroll.on('scrollEnd', function () {
                if(that._loadingNewData){
                    SendPostListMsg(that._type,gUserInfo.leader_id,gUserInfo.avatar,gUserInfo.nickname,"dir_up",that._newestPostId);
                    that._loadingNewData = false;
                }
                if(that._loadingOldData){
                    SendPostListMsg(that._type,gUserInfo.leader_id,gUserInfo.avatar,gUserInfo.nickname,"dir_down",that._oldestPostId);
                    that._loadingOldData = false;
                }
            });
        }
        NewIScroll(id, exceptElem, init);
        console.log(this._iScroll);
    },
    GetWnd: function () {
        var $wnd = $('#pfc-' + this._type + '-' + this._leader_id);
        if ($wnd.length == 0) {
            $wnd = this._newWnd();
            this._newIScroll();
        }
        return $wnd;
    },
    SetPostId: function (id, bNewest) {
        bNewest ? (this._newestPostId = id) : (this._oldestPostId = id);
        console.log("this._newestPostId = "+this._newestPostId);
        console.log("this._oldestPostId = "+this._oldestPostId);
    },
    GetPostId: function (bNewest) {
        return bNewest ? this._newestPostId : this._oldestPostId;
    },
    NoMoreData: function (bNewest) {
        bNewest ? (this._moreNewData = false) : (this._moreOldData = false);
    },
    AppendData: function (content, bDirection) {
        var $container = this.GetWnd().find(".friend-post");
        if (bDirection) {
            $container.append(content);
        } else {
            $container.after(content);
        }
    },
    ReInit: function () {
        this._bInited = false;
    },
    Refresh: function () {
        var that = this;
        setTimeout(function () {
            that._iScroll.refresh(); // We should avoid this pitfall here.
            //that._iScroll.scrollToElement(".post:last-child", 1000);
        }, MIN_ISCROLL_DELAY);
    }
}
var CFriendCircleManager = function () {
}
CFriendCircleManager.prototype = {
    _pages: [],
    _enter: [],
    GetFriendCircleWnd: function (type, leader_id, avatar, name) {
        console.log("circle_type = " + type + ",leader_id = " + leader_id + ",name = " + name);
        if (IsPageExist("#pfc-" + type + '-' + leader_id)) {
            return this._pages[type + leader_id].GetWnd();
        } else {
            var wnd = new CFriendCircle(type, leader_id, avatar, name);
            this._pages[type + leader_id] = wnd;
            console.log(this._pages);
            return wnd.GetWnd();
        }
    },
    EnterFriendCircle: function (type, leader_id, avatar, name) {
        this._enter[leader_id] = true;
        var page = this._pages[type + leader_id];
        console.log("进入用户朋友圈: " + page._leader_id + "," + page._name);
        if (page._bInited == false) {
            SendPostListMsg(type, leader_id, avatar, name, "dir_up", page._newestPostId);
            this._pages[type + leader_id]._bInited = true;
        }
    },// end of EnterFriendCircle
    RefreshWnd: function (type, leader_id) {
        if (this._pages[type + leader_id]) {
            this._pages[type + leader_id].Refresh();
        }
    },
    RefreshAllWnd:function(){
        for(key in this._pages){
            this._pages[key].Refresh();
        }
    },
    UpdatePostId: function (type, leader_id, post_id, bNewest) {
        var page = this._pages[type + leader_id];
        page.SetPostId(post_id,bNewest);
    },
    ReInit: function () {
        for (var i = 0, l = this._pages.length; i < l; i++) {
            this._pages[i].ReInit();
        }
    }
}

var getWinRatio = function () {
    var wWin = $(window).width();
    var ratio = wWin / 320;
    return ratio;
}
var thumbnailWidth = getWinRatio() * 16 * 5.3; //5rem;
var thumbnailHeight = getWinRatio() * 16 * 5.3; //5rem;
var MAX_UPLOAD_COUNT = 6;
var circleDimBtn = ["emotion", "btn-img"];
var circleActBtn = ["emotion.1", "btn-img.2"];

var gQueuePostImg = 0;
var base64Result = [];
function UploadYdPostImg(index, strBase64) {
    function callback(data) {
        $("#" + data.post_index).siblings(".file-url").val(data.path);
    };
    UploadBase64Data(index, strBase64, callback);
}

function UploadBase64Data(index, strBase64, callback) {
    $.ajax({
        type: 'POST',
        url: 'imageUpload.php',
        data: {
            post_index: index,
            post_img: strBase64
        },
        cache: false,
        async: true,
        dataType: "json",
        success: function (data) {
            callback(data);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            var jsonData = '{"status":false,"path":""}';
            callback(jsonData);
        }
    });
}

$(function () { //朋友圈图片上传
    $(document).on('click', "#page-publish-circle .delete-w-thumb", function () {
        console.log("click me");
        var fileId = $(this).siblings(".file-item").attr("id");
        uploader.removeFile(fileId, true);
        var idx = $(this).parent().index();
        $(this).parent().remove();

        /*$.post("imageDelete.php", {
            index: idx
        }, function (data) {

        });*/

        if ($(".thumbnail-container").length < MAX_UPLOAD_COUNT) {
            $(".upload-icon").css("display", "block");
        }
    });
    var uploader = WebUploader.create({
        auto: false, // 选完文件后，是否自动上传。
        quality: 90,// 图片质量，只有type为`image/jpeg`的时候才有效。
        duplicate: true,
        allowMagnify: false, // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
        preserveHeaders: true, // 是否保留头部meta信息。
        fileNumLimit: 6, //验证文件总数量, 超出则不允许加入队列。
        // swf文件路径
        swf: 'js/webuploader-0.1.5/Uploader.swf',
        server: 'imageUpload.php',

        // 选择文件的按钮。可选。
        // 内部根据当前运行是创建，可能是input元素，也可能是flash.
        pick: {id: '#file-picker', multiple: true},
        accept: {   // 只允许选择图片文件。
            title: 'Images',
            extensions: 'gif,jpg,jpeg,bmp,png',
            mimeTypes: 'image/*'
        },
        sendAsBinary: false,
        thumb: {
            width: 1,
            height: 1,
            quality: 90, // 图片质量，只有type为`image/jpeg`的时候才有效。
            allowMagnify: false, // 是否允许放大，如果想要生成小图的时候不失真，此选项应该设置为false.
            crop: true,// 是否允许裁剪。
            type: 'image/png'
        }
    });
    uploader.on('fileQueued', function (file) {
        var $li = $(
                '<div class="w-thumb-container">' +
                '<input class="file-url" type="hidden" value=""/>' +
                '<div id="' + file.id + '" class="file-item w-thumbnail">' +
                '<img class="w-thumb-img">' +
                '</div>' +
                '<div class="delete-w-thumb"><img src="img/delete.png"/></div>' +
                '<div class="pic-progress"><span></span></div>'),
            $img = $li.find('.w-thumb-img'),
            $delete = $li.find(".delete-w-thumb");

        // $list为容器jQuery实例
        $(".uploader-list").append($li);
        if ($(".w-thumb-container").length == MAX_UPLOAD_COUNT) {
            $(".upload-icon").css("display", "none");
        }
        uploader.makeThumb(file, function (error, src) {
            if (error) {
                $img.replaceWith('<span>不能预览</span>');
                return;
            }
            $img.attr('src', src);
            UploadYdPostImg(file.id, src);
            $img.jqthumb({
                width: thumbnailWidth,
                height: thumbnailHeight
            });
            $delete.show();
        });
    });
    uploader.on('uploadProgress', function (file, percentage) {
        var $li = $('#' + file.id),
            $percent = $li.siblings('.pic-progress span');
        $percent.empty().append($percent * 100 + '%');
    });
    uploader.on('uploadSuccess', function (file, response) {
        $('#' + file.id).addClass('upload-state-done');
        var $li = $('#' + file.id);
        $li.siblings('.pic-progress').hide();
    });
    uploader.on('uploadError', function (file) {
        var $li = $('#' + file.id),
            $error = $li.find('div.error');
        if (!$error.length) {
            $error = $('<div class="error"></div>').appendTo($li);
        }

        $error.text('上传失败');
    });
    uploader.on('uploadComplete', function (file) {
        $('#' + file.id).find('.progress').remove();
    });



});
