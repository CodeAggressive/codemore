/************************************************
 * Leader-tech(BeiJin) Co.Ltd All Rights Reserved
 * Version: 1.0.0
 * Author:  Tom Song
 * Create Date : 2016-1-11 2:36
 ************************************************/
var MIN_ISCROLL_DELAY = 500;


var ISCROLL_TAB_RELATION = "iscroll_tab_relation";
var ISCROLL_TAB_NOTICE = "iscroll_tab_notice";
var ISCROLL_TAB_ME = "iscroll_tab_me";

var gChatRoomManager = new CChatRoomManager();
var gNoticeManager = new CNoticeManager();
var gFriendCircleManager = new CFriendCircleManager();

var gEnableSendSm = true; //允许发送短信
var gSendSmStep = 30;     //发送验证码间隔时间
var gKeepAliveCount = 7;  //保活次数
var gUserAvatarUploadSuccess = false; //用户头像是否上传 成功
var gUserNeedRegister = false;  //用户是否需要注册
var gUserAvatarUploadPath = ""; //用户头像上传路径

var gIScrollContainer = [];
var gIScrollIndex = 0;
var gISAllRegisterUser = 1; //是否是所有注册用户
var gInRegister = false; //正在注册中
var gVerifyCode = ''; //验证码
var gMobile = ''; //注册手机号

var gCreatePrivateGroup = {
    avatarUploadSuccess: false,
    in_register: false,
    avatarPath: '',
    name: '',
    intro: '',
}

var t1FixIScroll = null;

function fireIScroll(callback, that) {
    if (t1FixIScroll == null) {
        t1FixIScroll = new Date().getTime();
    } else {
        var t2FixIScroll = new Date().getTime();
        if (t2FixIScroll - t1FixIScroll < 450) {
            t1FixIScroll = t2FixIScroll;
            return;
        } else {
            t1FixIScroll = t2FixIScroll;
        }
    }
    callback(that);//自己的代码
}

var gUserInfo = {
    "version": '1.0.0', // 当前版本号
    "leader_id": '', // 用户Leader ID
    "nickname": '', // 昵称
    "mobile": '', // 注册手机号
    "avatar": '', // 用户头像
    "register_time": '' // 注册时间
};

function RemoveNoNoticeTip() {
    if ($("#page-index .tab-notice-inner .no-notice").length) {
        $("#page-index .tab-notice-inner .no-notice").remove();
    }
}

function NewEditableListItem(type, data, item_status, icon, title) {
    var str = '<div class="ld-editable-list-item">' +
        '<input type="hidden" class="editable-list-type" value="' + type + '"/>' +
        '<input type="hidden" class="editable-list-data" value="' + data + '"/>' +
        '<div class="editable-circle editable-circle-' + item_status + '"></div>' +
        '<div class="editable-icon"><img src="' + SERVER_ROOT + icon + '"/></div>' +
        '<div class="editable-title">' + title + '</div>' +
        '</div>';
    return str;
}

function ShowPostReviewEditor() {
    if ($(".post_review_editor").length == 0) {
        var str = '<div class="post_review_editor_bk"></div><div class="post_review_editor">' +
            '<div class="pre_input" placeholder="请输入评论内容,100个字符以内" maxlength="20" contenteditable="true"></div>' +
            '<div class="pre_bar"><div class="post_review_icon"></div>' +
            '<button id="pre_release_btn">发表</button><button id="pre_cancel_btn">取消</button>' +
            '</div><div class="post_review_emotion"></div></div>';
        $(document.body).append(str);
        var emTarget = ".pre_input";
        var emContainer = ".post_review_emotion";
        $(".post_review_icon").mobileEmotion({
            target: emTarget, container: emContainer
        });
    }
    $(".post_review_editor_bk").fadeIn();
    $(".post_review_editor").css({"top": "100%", "display": "block"});
    $(".post_review_editor").animate({"top": '0%'}, 300);
}

function UpdatePostReview(post_id, leader_id, arrReview) {
    // 如果没有人评论过，增加评论，否则先移除再评论
    var $post = $(".post-id-" + post_id);
    var $review = $post.find(".post_review");
    var strReview = '<div class="post_review"><div class="triangle-up"></div>';
    $(arrReview).each(function (i, v) {
        strReview += '<div class="review_item">' +
            '<input class="review_id" type="hidden" val="' + v.review_id + '"/><span class="reviewer_name">' + v.reviewer_name + ': </span>' +
            '<span class="review_content">' + filterEmotion(htmlspecialchars_decode(v.review_content)) + '</span></div>';
    });
    strReview += '</div>';
    if ($review.length != 0) {
        $review.remove();
    }
    $post.find('.post_right .post_body').append(strReview);
    gFriendCircleManager.RefreshAllWnd();
}

function NewPostItem(post_id, leader_id, avatar, nickname, post_time, text, arrPic, arrFavorite, arrReview) {
    var str = '<div class="post post-id-' + post_id + '">' +
        '<input class="post_id" type="hidden" value="' + post_id + '"/>' +
        '<input class="post_leader_id" type="hidden" value="' + leader_id + '"/>' +
        '<img class="post_avatar" src="' + SERVER_ROOT + avatar + '"/>' +
        '<div class="post_right">' +
        '<div class="post_head">' +
        '<div class="post_user">' + nickname + '</div>' +
        '<div class="post_time">' + FormatTime(post_time) + '</div></div>' +
        '<div class="post_text">' + filterEmotion(htmlspecialchars_decode(text)) + '</div>' +
        '<div class="post_body">';
    $(arrPic).each(function (i, v) {
        str += '<img class="post_img" src="' + SERVER_ROOT + v.post_img + '"/>';
    });
    var strFavorite = '';
    var bFavorite = false;
    $(arrFavorite).each(function (i, v) {
        if (v.leader_id == gUserInfo.leader_id) {
            bFavorite = true;
        }
        strFavorite = strFavorite + '<div class="favoriter_avatar"><input type="hidden" value="' + v.leader_id + '" class="favoriter_id">'
            + '<img src="' + SERVER_ROOT + v.favoriter_avatar + '"/></div>';
    });
    strFavorite = strFavorite.replace(/\*$/gi, '');
    str += '<div class="post_btns">' + strFavorite + '<div class="btn_post_review"></div>';
    if (bFavorite) {
        str += '<div class="btn_post_favorite" style="background-image: url(img/favorite.2.png);"></div></div>';
    } else {
        str += '<div class="btn_post_favorite"></div></div>';
    }
    var strReview = '<div class="post_review"><div class="triangle-up"></div>';
    $(arrReview).each(function (i, v) {
        strReview += '<div class="review_item">' +
            '<input class="review_id" type="hidden" val="' + v.review_id + '"/><span class="reviewer_name">' + v.reviewer_name + ': </span>' +
            '<span class="review_content">' + filterEmotion(htmlspecialchars_decode(v.review_content)) + '</span></div>';
    });
    strReview += '</div>';
    strReview = (arrReview.length) ? strReview : '';
    str = str + strReview + '</div></div></div>';
    console.log(str);
    return str;
}

function GetOfflineAvatar(onlineAvatarPath) {
    var path = onlineAvatarPath;
    var dot = path.lastIndexOf(".");
    return path.substr(0, dot) + "_off" + path.substring(dot);
}


//显示注册对话框
function ShowRegisterDialog() {
    ShowPage($("#page-2"));
}
function ShowTabBom(idx) {
    $(".tab-btn-active").removeClass("tab-btn-active");
    if (idx == 0) {
        $(".tab-btn-icon").eq(0).css("background-image", 'url("img/notice.active.png")');
        $(".tab-btn-icon").eq(1).css("background-image", 'url("img/group.1.png")');
        $(".tab-btn-icon").eq(2).css("background-image", 'url("img/me.png")');
    } else if (idx == 1) {
        $(".tab-btn-icon").eq(1).css("background-image", 'url("img/group.active.1.png")');
        $(".tab-btn-icon").eq(0).css("background-image", 'url("img/notice.png")');
        $(".tab-btn-icon").eq(2).css("background-image", 'url("img/me.png")');
    } else if (idx == 2) {
        $(".tab-btn-icon").eq(2).css("background-image", 'url("img/me.active.png")');
        $(".tab-btn-icon").eq(0).css("background-image", 'url("img/notice.png")');
        $(".tab-btn-icon").eq(1).css("background-image", 'url("img/group.1.png")');
    }
    $(".ld-tab-head .tab-btn").eq(idx).addClass("tab-btn-active");
}
//显示首页tab通知
function ShowPageNotice() {
    ShowPage($("#page-index"));
    ShowTab(0);
    ShowTabBom(0);
}
//显示首页tab联系人
function ShowPageRelation() {
    ShowPage($("#page-index"));
    ShowTab(1);
    ShowTabBom(1);
}
//显示首页tab我
function ShowPageMe() {
    ShowPage($("#page-index"));
    ShowTab(2);
    ShowTabBom(2);
}
//显示用户详情页
function ShowPageUserDetail(leader_id) {
    if (leader_id == gUserInfo.leader_id) {
        $(".btn-talk-with-user").hide();
        $(".btn-follow-user").hide();
    } else {
        $(".btn-talk-with-user").show();
        $(".btn-follow-user").show();
    }
    SendUserDetailMsg(leader_id);
    if (leader_id == gUserInfo.leader_id) {
        $(".ud-bottom").hide();
        $(".eud-bottom").show();
    } else {
        $(".ud-bottom").show();
        $(".eud-bottom").hide();
    }

    //打开用户详细资料窗口
    var o = {
        leader_id: leader_id,
        title: '详细资料'
    };
    SaveHistory(PS_USER_DETAIL, o);
    ShowPage($("#page-user-detail"));
}
function ShowTab(i) {
    $(".ld-tab").hide().eq(i).show();
}
function GetWinRatio() {
    return $(document).width() / 320;
}

function SaveHistory(page, obj) {
    var str = '';
    for (var key in obj) {
        str = str + "&" + key + "=" + obj[key];
    }
    var url = SERVER_ROOT + "index.php?page=" + page + str;
    PageManager.State(page, obj, url);
}

// 新建一条群聊内容
function NewGroupChatItem(leader_id, avatar, user_name, chat_msg, chat_type, msg_dir) {
    if (chat_type == MSG_TYPE_NORMAL_CHAT) {
        var str = '<div class="chat-item"><div class="user-icon user-icon-' + msg_dir + '">'
            + '<img src="' + SERVER_ROOT + avatar + '"/></div>'
            + '<input type="hidden" value="' + leader_id + '" class="leader_id_hidden"/>'
            + '<div class="' + msg_dir + '-chat-item">'
            + '<div class="user-name">' + user_name + '</div>'
            + '<div class="' + msg_dir + '-chat">' +
            '<img class="arrow-' + msg_dir + '" src="img/arrow_' + msg_dir + '.png"/>' +
            '<div class="chat-content">' + chat_msg + '</div>'
            + '</div></div></div>';
        return str;
    } else if (chat_type == MSG_TYPE_SYSTEM) {
        var str = '<div class="chat-item"><div class="chat-sys">' + chat_msg + '</div></div>';
        return str;
    }
}
// 新建一条私聊内容
function NewUserChatItem(leader_id, avatar, chat_msg, chat_type, msg_dir) {
    //console.log("Enter User Chat Item =" + leader_id + ",chat_msg = " + chat_msg + ", chat_type = " + chat_type);
    if (chat_type == MSG_TYPE_NORMAL_CHAT) {
        var str = '<div class="chat-item"><div class="user-icon user-icon-' + msg_dir + '">'
            + '<img src="' + SERVER_ROOT + avatar + '"/></div>'
            + '<input type="hidden" value="' + leader_id + '" class="leader_id_hidden"/>'
            + '<div class="' + msg_dir + '-chat-item">'
            + '<div class="' + msg_dir + '-chat">' +
            '<img class="arrow-' + msg_dir + '" src="img/arrow_' + msg_dir + '.png"/>' +
            '<div class="chat-content">' + chat_msg + '</div>'
            + '</div></div></div>';
        //console.log("user chat item = " + str);
        return str;
    } else if (chat_type == MSG_TYPE_SYSTEM) {
        var str = '<div class="chat-item">+chat_msg+</div>';
        return str;
    }
}


/***********************************
 * 动态创建群成员列表窗口
 * @param group_id
 * @constructor
 ***********************************/
function GetGroupMemberListWnd(group_id) {
    if ($("#gmlist-" + group_id).length == 0) {
        var wnd = '<div class="page" id="gmlist-' + group_id + '">'
            + '<div class="gmlist-top"></div><div class="gmlist-bottom></div>'
            + '</div>';
        $(document.body).append(wnd);
    }
    return $("#gmlist-" + group_id);
}

//获取列表项目
function NewLeaderListItem(type, ext_data, icon, title, content, bHilight) {
    bHilight = !!(arguments[5] ? arguments[5] : false);
    var str_title = bHilight ? '<div class="item-title hilight-item-title">' + title + '</div>' :
    '<div class="item-title">' + title + '</div>';
    var _html = '<div class="ld-list-item">' +
        '<input type="hidden" class="item-hide-type" value="' + type + '"/>' +
        '<input type="hidden" class="item-hide-data" value="' + ext_data + '"/>' +
        '<div class="item-icon"><img src="' + SERVER_ROOT + icon + '"/></div>' +
        '<div class="item-right">' +
        str_title +
        '<div class="item-content">' + content + '</div></div></div>';

    return _html;
}


//新建一条通知内容
function NewNoticeItem(notice_type, notice_ext, icon, title, content, time, count) {
    var str_count = '';
    if (count != 0) {
        str_count = '<div class="i-count" style="background-color:#FF0000;">' + count + '</div>';
    } else {
        str_count = '<div class="i-count" style="background-color:#FFF;"></div>';
    }

    var notice = '<div class="ld-notice" id="' + notice_type + '_' + notice_ext + '">' +
        '<input type="hidden" class="notice-type" value="' + notice_type + '"/>' +
        '<input type="hidden" class="notice-ext" value="' + notice_ext + '"/>' +
        '<div class="notice-icon"><img src="' + SERVER_ROOT + icon + '"/></div>' +
        '<div class="notice-info"><div class="info-top">' +
        '<div class="i-title">' + title + '</div>' +
        '<div class="i-time">' + time + '</div>' +
        '</div><div class="info-bom">' +
        '<div class="i-content">' + content + '</div>' +
        str_count + '</div></div></div>';
    return notice;
}
//新建一条群通知内容
function NewGroupNoticeItem(group_notice_type, gid, uid, iconGrp, iconUser, title, sender_name) {
    var notice_event = '';
    var sender_pre = '';
    var icon = '';
    var id = '';
    switch (group_notice_type) {
        case GROUP_NOTICE_INVITE:
            notice_event = '邀请你加群';
            sender_pre = '邀请人';
            icon = iconGrp;
            id = gid;
            break;
        case GROUP_NOTICE_REMOVE:
            notice_event = '已将你移出群';
            sender_pre = '处理人';
            id = uid;
            icon = iconUser;
            break;
        case GROUP_NOTICE_JOIN:
            break;
    }

    var button = '同意';
    var gNotice = '<div class="ld-g-notice">' +
        '<input type="hidden" class="ld-gn-type" value = "' + group_notice_type + '"/>' +
        '<input type="hidden" class="ld-gn-id" value="' + id + '"/>'
        + '<div class="ld-gn-icon"><img src="' + SERVER_ROOT + icon + '"/></div>' +
        '<div class="ld-gn-title">' + title + '</div>' +
        '<div class="ld-gn-event">' + notice_event + '</div>' +
        '<div class="ld-gn-sender">' + sender_pre + ':' + sender_name + '</div>' +
        '<div class="ld-gn-btn">' + button + '</div></div>';
    return gNotice;
}
//新建一条群通知
function NewGroupAnnounceItem(announce_id, user, time, title, content) {
    var reg = new RegExp("\n", "g");
    var ct = content.replace(reg, "<br/>");
    return '<div class="group-announce-item">' +
        '<input type="hidden" class="hidden-announce-id" val="' + announce_id + '"/>' +
        '<div class="gai-title">' + title + '</div>' +
        '<div class="gai-center"><div class="gai-user">' + user + '</div>' +
        '<div class="gai-time">' + FormatTime2(time) + '</div></div>' +
        '<div class="gai-content">' + ct + '</div></div>';
}

//新建一条群文件
function NewGroupFileItem(group_id, leader_id, file_id,file_icon, file_name, file_size, file_time) {
    return '<div class="group-file-item">' +
        '<input type="hidden" class="gfi-group-id" value="' + group_id + '"/>' +
        '<input type="hidden" class="gfi-leader-id" value="' + leader_id + '"/>' +
        '<input type="hidden" class="gfi-file-id" value="' + file_id + '"/>' +
        '<div class="gfi-icon"><img src="' + file_icon + '"/></div>' +
        '<div class="gfi-right">' +
        '<div class="gfi-file-name">' + file_name + '</div>' +
        '<div class="gfi-file-time">' + file_time + '</div>' +
        '<div class="gfi-file-size">' + file_size + '</div>' +
        '</div></div>';
}

function ClearNoticeItem(notice_type, notice_ext) {
    if (IsNoticeItemExist(notice_type, notice_ext)) {
        var $target = $("#" + notice_type + "_" + notice_ext);
        console.log("ClearNoticeItem: " + $target.length);
        $target.find(".i-count").html();
        var count = trim($target.find(".i-count").html());
        if (count == '') {
            console.log("我不会再更新了!");
        } else {
            $target.find(".i-count").empty().css("background", "#FFF");
            //更新远程数据库,未读用户消息数据
            if (notice_type == NOTICE_UNREAD_USER_CHAT) {
                SendResetUnReadUserChatMsg(notice_ext, gUserInfo.leader_id);
            } else if (notice_type == NOTICE_UNREAD_GROUP_CHAT) {
                SendResetUnReadGroupChatMsg(notice_ext, gUserInfo.leader_id);
            } else if (notice_type == NOTICE_JOIN_GROUP_SUCCESS) {

            }
        }
    }
}

function IsNoticeItemExist(notice_type, notice_ext) {
    if ($("#" + notice_type + "_" + notice_ext).length > 0) {
        return true;
    }
    return false;
}
function UpdateNoticeItem(notice_type, notice_ext, icon, title, content, time) {
    if (IsNoticeItemExist(notice_type, notice_ext)) {
        var $target = $("#" + notice_type + "_" + notice_ext);
        var str_count = trim($target.find(".i-count").html());
        var count = 1;
        if (notice_type != NOTICE_NEW_INVITE_JOIN_GROUP) {
            if (str_count != '') {
                count = parseInt(str_count);
                count = count + 1;
            }
        }
        console.log("count = " + count);
        $target.find(".i-content").empty().html(content);
        $target.find(".i-count").empty().html(count);
        $target.find(".i-count").css("background", "#FF0000");
        Log1("time = " + time);
        $target.find('.i-time').empty().html(time);
        var $item = $target.remove(); //将它排到最前面！
        $(".tab-notice-inner").prepend($item);
    } else {
        var strNetItem = NewNoticeItem(notice_type, notice_ext, icon, title, content, time, 1);
        $(".tab-notice-inner").prepend(strNetItem);
    }
}


WEB_SOCKET_SWF_LOCATION = "/swf/WebSocketMain.swf";
WEB_SOCKET_DEBUG = true;
var ws, client_list = null;

var SERVER_ROOT = window.location.protocol + "//" + window.location.hostname + ":" + window.location.port + "/";

// 连接服务端
var gConnCount = 0;
function connect() {
    // 创建websocket
    ws = new WebSocket("ws://" + document.domain + ":7272");
    // 当socket连接打开时，输入用户名
    ws.onopen = onopen;
    // 当有消息时根据消息类型显示不同信息
    ws.onmessage = onmessage;
    ws.onclose = function () {
        console.log("连接关闭，定时重连");
        if (gConnCount < 10) {
            connect();
            gConnCount++;
        } else {
            swal('', "连接失败，请重新登录.", 'error');
        }
    };
    ws.onerror = function () {
        console.log("出现错误");
    };
}

// 连接建立时发送登录信息
function onopen() {
    if (gUserNeedRegister) { // 发送注册消息
        SendRegisterInfo();
    } else {
        SendLoginInfo();
    }
}


// 消息处理中心
function onmessage(e) {
    var data = eval("(" + e.data + ")");
    switch (data['type']) {
        case MSG_S_PING: // 服务端ping客户端
        {
            // ws.send('{"type":"' + MSG_C_PING + '"}');
            gKeepAliveCount = gKeepAliveCount - 1;
            if (gKeepAliveCount == 0) {
                gKeepAliveCount = 5;
            }
            Log("心跳数据包.");
            break;
        }
        case MSG_S_REGISTER: //用户注册
        {
            gUserInfo.version = data["version"];
            gUserInfo.leader_id = data['content']['leader_id'];
            gUserInfo.nickname = data['content']['user_name'];
            gUserInfo.mobile = data['content']['user_mobile'];
            gUserInfo.avatar = data['content']['user_avatar'];
            gUserInfo.register_time = data['content']['user_register_time'];
            SetDataToLocalStorage(gUserInfo); //保存到浏览器缓存
            SendLoginInfo();
            ShowPageNotice();
            InitFriendCircle();
            PageManager.Init();
            gInRegister = false; //不再注册
            Log("用户注册: " + JSON.stringify(data["content"]));
            break;
        }
        case MSG_S_NOTICE_JOIN_GROUP_SUCCESS: //入群成功
        {
            var gs = data['content'];
            var icon = gs["icon"];
            var title = gs["title"];
            var content = FormatNotice(gs["content"]);
            var time = FormatTime(gs["time"]);
            var ext = gs["ext"];
            Log("入群成功: " + JSON.stringify(gs));
            var _notice = NewNoticeItem(NOTICE_JOIN_GROUP_SUCCESS, ext, icon, title, content, time, 0);
            $(".tab-notice-inner").prepend(_notice);
            break;
        }
        case MSG_S_LOGIN_IN: //用户登录
        {
            var content = data['content'];
            var _html = '';
            $.each(content, function (i, val) {
                var leader_id = val["leader_id"];
                var user_name = val["name"];
                var online = val["online"];
                var str_online = (online == 0) ? "[离线请留言]" : "在线";
                if (leader_id == gUserInfo.leader_id) {
                    return true;
                } //自己置顶
                var user_avatar = (online == 1) ? val["avatar"] : GetOfflineAvatar(val["avatar"]);
                _html = _html + NewLeaderListItem(LLI_ALL_REGISTER_USER, leader_id, user_avatar, user_name, str_online, online);
            });
            $("#all_register_user_list").empty().append(_html);
            $("#all_register_user_list").prepend(NewLeaderListItem(LLI_ALL_REGISTER_USER, gUserInfo.leader_id, gUserInfo.avatar, gUserInfo.nickname, "在线", true));
            Log("用户登录了!");
            break;
        }
        case MSG_S_USER_NONE_EXIST:
        { //用户不存在
            var content = data['content'];
            Log("user does not exist");
            Log(content);
            ClearAllLocalStorageData();
            gUserNeedRegister = true;
            ShowRegisterDialog();
        }
        case MSG_S_LOGIN_OUT: //用户退出
        {
            Log("用户退出了! ");
            break;
        }
        case MSG_S_UNREAD_GROUP_CHAT_LIST:
        {
            var content = data['content'];
            $.each(content, function (i, val) {
                var group_id = val["group_id"]; //群ID
                var group_avatar = val["group_avatar"]; //群头像
                var group_name = val["group_name"]; //群名称
                var msg_count = val["msg_count"]; //未读消息数
                var msg = val["msg_newest"]; //最新的消息
                var msg_newest = FormatNotice(msg);
                var msg_time = val["msg_time"]; //消息时间
                var notice = new CNotice(NOTICE_UNREAD_GROUP_CHAT, group_id, group_avatar, group_name, msg_newest, msg_time, msg_count);
                gNoticeManager.Push(notice);
            });
            Log("未读--群聊记录: " + JSON.stringify(content));
            break;
        }
        case MSG_S_UNREAD_USER_CHAT_LIST:
        {
            var content = data['content'];
            $.each(content, function (i, val) {
                var sender_leader_id = val["sender_leader_id"]; //发送人的leader_id
                var sender_avatar = val["sender_avatar"]; //发送人的头像
                var sender_name = val["sender_name"]; //群名称
                var msg_count = val["msg_count"]; //未读消息数
                var msg = val["msg_newest"]; //最新的消息
                var msg_newest = FormatNotice(msg);
                var msg_time = val["msg_time"]; //消息时间
                var notice = new CNotice(NOTICE_UNREAD_USER_CHAT, sender_leader_id, sender_avatar, sender_name, msg_newest, msg_time, msg_count);
                gNoticeManager.Push(notice);
            });
            Log("未读--私聊记录: " + JSON.stringify(content));
            break;
        }
        case MSG_S_GROUP_NOTICE_LIST: //群通知列表
        {
            Log('未读--群通知列表:');
            var d = data['content'];
            Log(d);
            var leader_id = d['leader_id'];
            var stage = d['stage'];
            var notice_list = d['notice_list'];
            if (stage == '') {
                var str = '';
                $(notice_list).each(function (i, v) {
                    var grp_id = v['group_id'];
                    var grp_name = v['group_name'];
                    var grp_avatar = v['group_avatar'];
                    var user_id = v['user_id'];
                    var user_name = v['user_name'];
                    var user_avatar = v['user_avatar'];
                    var notice_type = v['notice_type'];
                    var sender_id = v['sender_id'];
                    var notice_title = v['notice_title'];
                    var notice_content = v['notice_content'];
                    var receiver_id = v['receiver_id'];
                    var is_viewed = v['is_viewed'];
                    var notice_time = v['notice_time'];
                    str += NewGroupNoticeItem(notice_type, grp_id, user_id, grp_avatar, user_avatar, notice_title, user_name);
                });
                $("#page-group-notice-list").empty().html(str);
            } else if (stage == 'init') {
                var count = 0;
                var grp_id, grp_name, notice_type, notice_title, notice_content, is_viewed;
                $(notice_list).each(function (i, v) {
                    grp_id = v['group_id'];
                    grp_name = v['group_name'];
                    notice_type = v['notice_type'];
                    notice_title = v['notice_title'];
                    notice_content = FormatNotice(v['notice_content']);
                    notice_time = v['notice_time'];
                    is_viewed = v['is_viewed'];
                    count++;
                });
                if (count > 0) {
                    var icon = 'img/group_notice.png'
                    var notice = new CNotice(NOTICE_GROUP, '', icon, '群通知', notice_content, notice_time, count);
                    gNoticeManager.Push(notice);
                }
                if (gNoticeManager.GetCount()) {
                    gNoticeManager.Dump();
                    $("#page-index .tab-notice-inner").empty().append(gNoticeManager.Html()); //这里不能empty(),登录的时候转发消息是有顺序的。
                }
                if ($("#page-index .tab-notice-inner .ld-notice").length == 0) {
                    $("#page-index .tab-notice-inner").empty().append('<div class="no-notice"><img src="img/no-msg.png"/><div>没有新消息</div></div>')
                }
                ShowPageNotice();
                gIScrollContainer[ISCROLL_TAB_NOTICE].refresh();
            }
            break;
        }
        case MSG_S_UNREAD_SYS_NOTICE:
        {
            var content = data["content"];
            Log("未读系统通知信息!");
            break;
        }
        case MSG_S_GENERAL_CONTACTS: //常用联系人
        { //下载常用联系人
            var persons = data['content'];
            $.each(persons, function (i, val) {
                var leader_id = val["leader_id"];
                var user_name = val["name"];
                var user_mobile = val["mobile"];
                var user_avatar = val["avatar"];
                var user_create_time = val["register_time"];
                $_html = '<div class="contact-item"><div class="user-avatar">"' + user_avatar +
                    '</div><div class="user-name">' + user_name + '</div></div>';
            });
            Log("常用联系人:" + JSON.stringify(persons));
            break;
        }
        case MSG_S_GROUP_LIST: //加入的群组列表
        {
            /*************************************************************
             * group_id|group_name|group_avatar|group_intro|group_create_time
             *************************************************************/
            var content = data['content'];
            Log("加入的群组列表:" + JSON.stringify(content));
            var grpPublic = '<div class="group-public"><div class="group-category-name">公共群</div>';
            var grpPrivate = '<div class="group-private"><div class="group-category-name">私聊群</div>';
            $.each(content, function (i, val) {
                var group_id = val["group_id"];
                var group_name = val["group_name"];
                var group_avatar = val["group_avatar"];
                var group_intro = val["group_intro"];
                var create_leader_id = val["create_by"];
                var group_create_time = val["create_date"];
                var group_type = (group_id == 10000) ? "GROUP_PUBLIC" : "GROUP_PRIVATE";
                var group_item = '<div class="group-item">' +
                    '<input type="hidden" class="group-type" value="' + group_type + '"/>' +
                    '<input type="hidden" class="group-id" value="' + group_id + '"/>' +
                    '<div class="group-avatar"><img src="' + SERVER_ROOT + group_avatar +
                    '"/></div><div class="group-name">' + group_name + '</div></div>';
                if (group_id == 10000) {
                    grpPublic += group_item;
                } else {
                    grpPrivate += group_item;
                }
            });
            grpPublic += '</div>';
            grpPrivate += '</div>';
            $("#page-groups .pg-top").empty().append(grpPublic + grpPrivate);
            if ($(".group-private .group-item").length == 0) {
                $(".group-private .group-category-name").hide();
            }
            if ($("#page-groups .group-item").length == 1) {
                $(".group-item .group-name").css("border-bottom", "none");
            }
            break;
        }
        case MSG_S_GROUP_MEMBER_LIST: //群成员列表
        {
            var content = data['content'];
            Log("群用户列表:"); //+JSON.stringify(content)+"\n");
            var _html = '';
            var o_group_id = '';
            $.each(content, function (i, val) {
                var leader_id = val["leader_id"];
                var group_id = val["group_id"];
                o_group_id = group_id;
                var user_name = val["name"];
                var user_mobile = val["mobile"];
                var user_avatar = val["avatar"];
                _html = _html + '<div class="user-item">' +
                    '<input type="hidden" class="user-leader-id" value="' + leader_id + '"/>' +
                    '<div class="user-avatar"><img src="' + SERVER_ROOT + user_avatar + '"/></div>' +
                    '<div class="user-name">' + user_name + '</div></div>';
                Log("[" + leader_id + "," + user_name + "," + group_id + "]\n");
            });
            var $gmlistWnd = GetGroupMemberListWnd(o_group_id);
            $gmlistWnd.find(".gmlist-top").empty().append(_html);
            break;
        }
        case MSG_S_ALL_REGISTER_USER_LIST: //所有注册用户列表
        {
            var content = data['content'];
            Log("所有--注册用户--列表\n");
            var _html = '';
            //Log(JSON.stringify(content));
            $.each(content, function (i, val) {
                var leader_id = val["leader_id"];
                var user_name = val["name"];
                var online = val["online"];
                var str_online = (online == 0) ? "[离线请留言]" : "在线";
                if (leader_id == gUserInfo.leader_id) {
                    return true;
                } //不添加自己到列表中
                var user_avatar = (online == 1) ? val["avatar"] : GetOfflineAvatar(val["avatar"]);
                _html = _html + NewLeaderListItem(LLI_ALL_REGISTER_USER, leader_id, user_avatar, user_name, str_online, online);
                Log("[" + leader_id + "," + user_name + "," + online + "]\n");
            });
            $("#all_register_user_list").empty().append(_html);
            setTimeout(function () {
                gIScrollContainer[ISCROLL_TAB_RELATION].refresh();
                gIScrollContainer[ISCROLL_TAB_RELATION].scrollToElement(".ld-list-item:last-child", 1000);
            }, MIN_ISCROLL_DELAY);
            break;
        }
        case MSG_S_GROUP_CHAT: //群聊消息
        {
            RemoveNoNoticeTip();
            var v = data['content'];
            var group_id = v["group_id"];
            var group_avatar = v["group_avatar"];
            var group_name = v["group_name"];
            var leader_id = v["leader_id"];
            var user_name = v["user_name"];
            var avatar = v["user_avatar"];
            var chat_msg = filterEmotion(htmlspecialchars_decode(v["chat"]));
            var chat_type = v["chat_type"];
            var chat_time = FormatTime(v["chat_time"]);
            var db_chat_id = v["db_chat_id"];
            var msg = v['chat'];
            msg = FormatNotice(msg);
            // 更新通知列表
            Log1(JSON.stringify(v));
            UpdateNoticeItem(NOTICE_UNREAD_GROUP_CHAT, group_id, group_avatar, group_name, msg, chat_time);
            var $groupWnd = gChatRoomManager.GetChatWnd("group", group_name, group_id);
            var $chat_room = $groupWnd.find(".chat-room");
            if ($groupWnd.find('.chat-item').length == 0) {
                console.log("db_chat_id = " + db_chat_id);
                gChatRoomManager.SetChatId("group", group_id, db_chat_id);
            }
            //增加聊天数据
            var msg_dir = (leader_id == gUserInfo.leader_id) ? "self" : "other";
            var chat_item = NewGroupChatItem(leader_id, avatar, user_name, chat_msg, chat_type, msg_dir);
            gChatRoomManager.AppendDataToChatRoom("group", group_id, chat_item, true);
            if ($groupWnd.is(":visible")) {
                gChatRoomManager.RefreshChatRoom("group", group_id, "last");
            }
            break;
        }
        case MSG_S_USER_CHAT:
        {
            RemoveNoNoticeTip();
            var content = data["content"];
            var from_leader_id = content["from_leader_id"];
            var from_user_avatar = content["from_user_avatar"];
            var from_user_name = content["from_user_name"];
            var to_user_name = content["to_user_name"];
            var to_leader_id = content["to_leader_id"];
            var db_chat_id = content["db_chat_id"];
            var chat = filterEmotion(htmlspecialchars_decode(content["chat"]));
            var chat_type = content["chat_type"];
            var chat_time = FormatTime(content["chat_time"]);
            var msg_dir = (from_leader_id == gUserInfo.leader_id) ? "self" : "other";

            var chat_item = NewUserChatItem(from_leader_id, from_user_avatar, chat, chat_type, msg_dir);
            var wnd_leader_id = msg_dir == "self" ? to_leader_id : from_leader_id;
            var title_user_name = (msg_dir == "self" ? to_user_name : from_user_name);
            var $userWnd = gChatRoomManager.GetChatWnd("user", title_user_name, wnd_leader_id);
            if ($userWnd.find('.chat-item').length == 0) {
                gChatRoomManager.SetChatId("user", wnd_leader_id, db_chat_id);
            }
            var notice_chat = FormatNotice(content['chat']);
            UpdateNoticeItem(NOTICE_UNREAD_USER_CHAT, wnd_leader_id, from_user_avatar, from_user_name, notice_chat, chat_time);
            if ($userWnd.is(":visible")) {
                gChatRoomManager.AppendDataToChatRoom("user", wnd_leader_id, chat_item, true);
                gChatRoomManager.RefreshChatRoom("user", wnd_leader_id, "last");
            }
            Log("用户私聊内容:" + content["chat"]);
            Log("emotion filter = " + chat);
            break;
        }
        case MSG_S_GROUP_CHAT_HISTORY: //群聊历史记录
        {
            Log('群聊历史记录:'); //+ JSON.stringify(content));
            var content = data['content'];
            var chat_items = '';
            var last_chat_id = 'max';
            var group_id = data['group_id'];
            var group_name = content['group_name'];
            var $gWnd = gChatRoomManager.GetChatWnd('group', group_name, group_id);
            var history = content['data'];
            var last_time = '';
            $.each(history, function (i, val) {
                var chat_id = val['chat_id']; //消息的id
                last_chat_id = chat_id;
                var avatar = val['avatar']; //消息发送人的头像
                var leader_id = val['leader_id']; //消息发送人的leader_id
                var name = val['name']; //消息发送人的昵称
                var chat_content = filterEmotion(htmlspecialchars_decode(val['chat_content'])); //消息内容
                var chat_type = val['chat_type'];
                var msg_dir = (leader_id == gUserInfo.leader_id) ? "self" : "other";
                Log1(val['chat_time']);
                var timeItem = '';
                /*if(last_time == ''){
                 last_time = val['chat_time'];
                 }else{
                 var cur_time = val['chat_time']
                 if(parseInt(Math.abs(cur_time - last_time))/1000/60>2){
                 timeItem = '<div class="time-stamp">'+last_time+'</div>';
                 last_time = val['chat_time'];
                 }else{
                 timeItem = '';
                 }
                 }*/
                chat_items = chat_items + NewGroupChatItem(leader_id, avatar, name, chat_content, chat_type, msg_dir, chat_time) + timeItem;
            });
            Log1("last_chat_id = " + last_chat_id);
            if (history.length > 0) {
                gChatRoomManager.UpdateGroupChatID(group_id, last_chat_id); //更新缓存
                gChatRoomManager.AppendDataToChatRoom("group", group_id, chat_items, false); //在聊天窗口的前面插入聊天历史记录
            } else { //第一次加载的时候滚动屏幕
                gChatRoomManager.AppendDataToChatRoom("group", group_id, chat_items, true);
            }
            gChatRoomManager.RefreshChatRoom("group", group_id, history.length);
            break;
        }
        case MSG_S_USER_CHAT_HISTORY:
        {
            var content = data["content"];
            var self_leader_id = content["self_leader_id"];
            var other_leader_id = content["other_leader_id"];
            var other_user_name = content["other_user_name"];
            var history = content["history"];
            var last_chat_id = "max";
            var chat_items = '';
            $.each(history, function (i, val) {
                last_chat_id = val["id"];
                var sender_leader_id = val["sender_id"];
                var sender_name = val["user_name"];
                var sender_chat = filterEmotion(htmlspecialchars_decode(val["chat_content"]));
                var sender_chat_type = val["chat_type"];
                var sender_avatar = val["avatar"];
                var msg_dir = (sender_leader_id == gUserInfo.leader_id) ? "self" : "other";
                //排列顺序是倒序的
                chat_items = NewUserChatItem(sender_leader_id, sender_avatar, sender_chat, sender_chat_type, msg_dir) + chat_items;
            });

            var $userWnd = gChatRoomManager.GetChatWnd("user", other_user_name, other_leader_id);
            var $chat_room = $userWnd.find(".chat-room");
            if (history.length > 0) {
                gChatRoomManager.UpdateUserChatID(other_leader_id, last_chat_id);
                gChatRoomManager.AppendDataToChatRoom("user", other_leader_id, chat_items, false); //在聊天窗口的前面插入聊天历史记录
            } else {
                gChatRoomManager.AppendDataToChatRoom("user", other_leader_id, chat_items, true);
            }
            gChatRoomManager.RefreshChatRoom("user", other_leader_id, history.length);
            Log("私聊历史记录\n");
            break;
        }
        case MSG_S_ABOUT_ME:
        {
            var info = data["content"];
            $.each(info, function (i, val) {
                var leader_id = val["leader_id"];
                var user_name = val["user_name"];
                var user_mobile = val["user_mobile"];
                var user_field = val["user_field"];
                var user_job = val["user_job"];
                var user_company = val["user_company"];
                var avatar = val["avatar"];
                var register_time = val["register_time"].substr(0, 10);
                $(".tab-me .ud-top .user-avatar").empty().html('<img src="' + SERVER_ROOT + avatar + '"/>');
                $(".tab-me .ud-top .user-name").empty().html(user_name);
                $(".tab-me .ud-top .user-leader-id").empty().html("斗信号: &nbsp;" + leader_id);
                $(".tab-me .ud-top .user-mobile").empty().html("手机号: &nbsp;" + user_mobile);
                $(".tab-me .ud-bottom .user-company .sub-item-2").empty().html(user_company);
                $(".tab-me .ud-bottom .user-job .sub-item-2").empty().html(user_job);
                $(".tab-me .ud-bottom .user-field .sub-item-2").empty().html(user_field);
                $(".tab-me .ud-bottom .user-register-time .sub-item-2").empty().html(register_time);
                $(".tab-me .eud-bottom .user-company .sub-item-2").empty().html(user_company == '' ? "未填写" : user_company);
                $(".tab-me .eud-bottom .user-job .sub-item-2").empty().html(user_job == '' ? "未填写" : user_job);
                $(".tab-me .eud-bottom .user-field .sub-item-2").empty().html(user_field == '' ? "未填写" : user_field);
                $(".tab-me .eud-bottom .user-register-time .sub-item-2").empty().html(register_time);
                if (leader_id == gUserInfo.leader_id) {
                    $(".ud-bottom").hide();
                    $(".eud-bottom").show();
                } else {
                    $(".ud-bottom").show();
                    $(".eud-bottom").hide();
                }
            });
            Log("个人信息" + JSON.stringify(info));
            break;
        }
        case MSG_S_USER_DETAIL:
        {
            var info = data["content"];
            var user_detail = info["user_info"];
            var my_follow_list = info["my_follow_list"];
            var other_leader_id = '';
            $.each(user_detail, function (i, val) {
                var leader_id = val["leader_id"];
                other_leader_id = leader_id;
                var user_name = val["user_name"];
                var user_mobile = val["user_mobile"];
                var user_field = val["user_field"];
                var user_job = val["user_job"];
                var user_company = val["user_company"];
                var avatar = val["avatar"];
                var register_time = (val["register_time"]).substr(0, 10);
                $("#page-user-detail .ud-top .user-avatar").empty().html('<img src="' + SERVER_ROOT + avatar + '"/>');
                $("#page-user-detail .ud-top .user-name").empty().html(user_name);
                $("#page-user-detail .ud-top .user-leader-id").val(leader_id);
                $("#page-user-detail .ud-top .user-mobile").empty().html("手机号: &nbsp;&nbsp;" + user_mobile);
                $("#page-user-detail  .ud-bottom .user-company .sub-item-2").empty().html(user_company);
                $("#page-user-detail .ud-bottom .user-job .sub-item-2").empty().html(user_job);
                $("#page-user-detail .ud-bottom .user-field .sub-item-2").empty().html(user_field);
                $("#page-user-detail .ud-bottom .user-register-time .sub-item-2").empty().html(register_time);
                $("#page-user-detail .eud-bottom .user-company .sub-item-2").empty().html(user_company == '' ? "未填写" : user_company);
                $("#page-user-detail .eud-bottom .user-job .sub-item-2").empty().html(user_job == '' ? "未填写" : user_job);
                $("#page-user-detail .eud-bottom .user-field .sub-item-2").empty().html(user_field == '' ? "未填写" : user_field);
                $("#page-user-detail .eud-bottom .user-register-time .sub-item-2").empty().html(register_time);
            });
            if (other_leader_id != gUserInfo.leader_id) {
                var has_followed = false;
                $.each(my_follow_list, function (i, val) {
                    var follow_leader_id = val["follow_id"];
                    if (other_leader_id == follow_leader_id) {
                        has_followed = true;
                    }
                });
                if (has_followed) {
                    $("#page-user-detail .btn-unfollow-user").show();
                    $("#page-user-detail .btn-follow-user").hide();
                } else {
                    $("#page-user-detail .btn-unfollow-user").hide();
                    $("#page-user-detail .btn-follow-user").show();
                }
            }
            Log("用户详细资料" + JSON.stringify(info));
            break;
        }
        case MSG_S_GROUP_DETAIL: //群详细资料
        {
            var content = data["content"];
            var group_info = content["group_info"];
            var group_member_info = content["group_member_info"];
            var group_id,
                group_name,
                group_intro,
                group_avatar,
                group_create_by,
                create_date;
            var _html = '';
            $.each(group_info, function (i, val) {
                group_id = val["group_id"];
                group_name = val["group_name"];
                group_intro = val["group_intro"];
                group_avatar = val["group_avatar"];
                group_create_by = val["create_by"];
                create_date = val["create_date"];
            });
            var member_count = 0;
            $.each(group_member_info, function (i, val) {
                member_count++;
                var leader_id = val["leader_id"];
                var user_name = val["user_name"];
                user_name = user_name.length >= 5 ? user_name.substring(0, 3) + "..." : user_name;
                var user_avatar = val["user_avatar"];
                //Log("[leader_id,name,avatar] = [" + leader_id + " , " + user_name + " , " + user_avatar + "]");
                _html = _html + '<div class="user-item">' +
                    '<input type="hidden" class="user-leader-id" value="' + leader_id + '"/>' +
                    '<div class="user-avatar"><img src="' + SERVER_ROOT + user_avatar + '"/></div>' +
                    '<div class="user-name">' + user_name + '</div></div>';
            });
            $("#page-group-detail .hidden-group-id").val(group_id);
            $("#page-group-detail .hidden-group-name").val(group_name);
            $("#page-group-detail .gd-group-avatar img").attr("src", group_avatar);
            $("#page-group-detail .gd-group-member-list").empty().append(_html);
            var btn_invite = '';
            if (group_id != 10000) {
                btn_invite = '<div class="btn-invite-group-member"><img src="img/add.png"/><div>邀请</div></div>';
            }
            $("#page-group-detail .gd-group-member-list").append(btn_invite);
            $("#page-group-detail .gd-group-intro").empty().append(group_intro);
            //Log($("#page-group-detail .gml-title span"));
            $("#page-group-detail .gml-title span").eq(1).empty().html(member_count + "人");
            break;
        }
        case MSG_S_MODIFY_USER_COMPANY:
        {
            var company = data["content"];
            $(".eud-bottom .user-company .sub-item-2").empty().html(company);
            Log("修改用户公司:" + company + "\n");
            break;
        }
        case MSG_S_MODIFY_USER_FIELD:
        {
            var field = data["content"];
            $(".eud-bottom .user-field .sub-item-2").empty().html(field);
            Log("修改用户行业:" + field + "\n");
            break;
        }
        case MSG_S_MODIFY_USER_JOB:
        {
            var job = data["content"];
            $(".eud-bottom .user-job .sub-item-2").empty().html(job);
            Log("修改用户职位:" + job + "\n");
            break;
        }
        case MSG_S_USER_FOLLOW_LIST:
        {
            var follow = data["content"];
            var _html = '';
            $.each(follow, function (i, val) {
                var follow_leader_id = val["follow_id"];
                var name = val["user_name"];
                var online = val["is_online"];
                var str_online = (online == 0) ? "[离线请留言]" : "在线";
                var avatar = (online == 1) ? val["user_avatar"] : GetOfflineAvatar(val["user_avatar"]);
                Log(gUserInfo);
                if (follow_leader_id == gUserInfo.leader_id) {
                    return true;
                } //不添加自己到列表中
                _html = _html + NewLeaderListItem(LLI_ALL_USER_FOLLOW, follow_leader_id, avatar, name, str_online, online);
            });
            if (follow.length == 0) {
                $("#page-user-follow-list .exist-user-follow").hide();
                $("#page-user-follow-list .no-user-follow").show();
                $("#page-user-follow-list").css("background-color", "#FFF");
            } else {
                $("#page-user-follow-list .exist-user-follow").show();
                $("#page-user-follow-list .no-user-follow").hide();
                $("#page-user-follow-list").css("background-color", "#F2F2F2");
                $("#page-user-follow-list .ufl-top").empty().append(_html);
                $("#page-user-follow-list .ufl-top").empty().append(_html);
            }
            Log("关注用户列表:" + JSON.stringify(follow) + "\n");
            break;
        }
        case MSG_S_CREATE_PRIVATE_GROUP: //创建用户私聊群
        {
            var g = data["content"];
            var group_id = g["group_id"];
            var group_name = g["group_name"];
            var create_leader_id = g["create_leader_id"];
            Log("创建私聊群成功! 新的群ID是: " + group_id + "\n");
            $("#page-group-detail").find(".hidden-group-id").val(group_id);
            var o = {
                group_id: group_id,
                leader_id: create_leader_id,
                title: group_name
            };
            SaveHistory(PS_GROUP_DETAIL, o);
            ShowPage($("#page-group-detail"));
            SendGroupDetailMsg(group_id);
            break;
        }
        case MSG_S_FOLLOW_SINGLE_USER:
        {
            var page = data["content"];
            if (page == "page_user_detail") {
                $("#page-user-detail .btn-unfollow-user").show();
                $("#page-user-detail .btn-follow-user").hide();
            }
            gFriendCircleManager.ReInit();
            Log("关注单个用户成功!");
            break;
        }
        case MSG_S_FOLLOW_MULTI_USER:
        {
            var data = data["content"];
            gFriendCircleManager.ReInit();
            Log("关注多个用户成功!");
            break;
        }
        case MSG_S_INVITE_NEW_GROUP_MEMBER:
        {
            RemoveNoNoticeTip();
            Log("*********MSG_S_INVITE_NEW_GROUP_MEMBER*********");
            Log(data);
            var v = data["content"];
            var invitee_ids = v['invitee_id_list'];
            var inviteme = false;
            $(invitee_ids).each(function (i, v) {
                if (parseInt(v) == gUserInfo.leader_id) {
                    inviteme = true;
                    return false;
                }
            });
            if (inviteme) {
                var iGrp_id = v['group_id'];
                var iGrp_name = v['group_name'];
                //var iGrp_avatar = v['group_avatar'];
                var ct = v['notice_content'];
                var icon = 'img/group_notice.png';
                var notice_type = v['notice_type'];
                var sender_id = v['sender_id'];
                var notice_title = '群通知';//v['notice_title'];
                var notice_content = FormatNotice(ct);
                var notice_time = FormatTime(v['notice_time']);
                UpdateNoticeItem(NOTICE_NEW_INVITE_JOIN_GROUP, iGrp_id + '_' + sender_id, icon, notice_title, notice_content, notice_time, 1);
            }
            break;
        }
        case MSG_S_RESET_UNREAD_USER_MSG:
        {
            var content = data["content"];
            Log("清空未读用户消息数据成功!");
            break;
        }
        case MSG_S_RESET_UNREAD_GROUP_MSG:
        {
            var content = data["content"];
            Log("清空未读群消息数据成功!");
            break;
        }
        case MSG_S_UNFOLLOW_SINGLE_USER:
        {
            var page = data["content"];
            if (page == "page_user_detail") {
                $("#page-user-detail .btn-unfollow-user").hide();
                $("#page-user-detail .btn-follow-user").show();
            }
            Log("取消关注单个用户成功!");
            break;
        }
        case MSG_S_UNFOLLOW_MULTI_USER:
        {
            var follows = data["content"];
            Log("取消关注 多个用户成功!");
            break;
        }
        case MSG_S_USER_LIST_ABOUT_FOLLOW:
        {
            var follows = data["content"];
            //Log(JSON.stringify(follows));
            var _html = '';
            $.each(follows, function (i, val) {
                var leader_id = val["leader_id"];
                var user_name = val["user_name"];
                var avatar = val["avatar"];
                var isFollow = val["isFollow"];
                var i_s = (isFollow) ? ELI_STATE_DISABLE : ELI_STATE_UNSELECT;
                _html = _html + NewEditableListItem(ELI_TYPE_FOLLOW_LIST, leader_id, i_s, avatar, user_name);
            });
            $("#page-add-multi-follow .follow-list").empty().append(_html);
            ShowPage($("#page-add-multi-follow"));
            Log("所有用户是否关注的列表");
            break;
        }
        case MSG_S_USER_LIST_ABOUT_INVITE:
        {
            var user_list = data["content"];
            var _html = '';
            $.each(user_list, function (i, val) {
                var group_id = val["group_id"];
                var leader_id = val["leader_id"];
                var user_name = val["user_name"];
                var user_avatar = val["avatar"];
                var isInGroup = val["isInGroup"];
                var i_s = (isInGroup) ? ELI_STATE_DISABLE : ELI_STATE_UNSELECT;
                _html = _html + NewEditableListItem(ELI_TYPE_GROUP_MEMBER_LIST, leader_id, i_s, user_avatar, user_name);
            });
            $("#page-invite-new-group-member .invite-group-member-list").empty().append(_html);
            //ShowPage($("#page-invite-new-group-member"));
            break;
        }
        case MSG_S_POST_LIST: //朋友圈说说列表
        {
            var content = data["content"];
            var circle_type = content["circle_type"];
            var post_id = content["post_id"]; // max or digit
            var leader_id = content["leader_id"];
            var avatar = content["avatar"];
            var name = content["name"];
            var direction = content["direction"];
            var list = content["list"];
            Log("**********朋友圈说说列表内容详情**********\n");
            var _html = '';
            if (list.length > 0) {
                var startPostId = list[0].post_id;
                var endPostId = list[list.length - 1].post_id;
                $(list).each(function (i, v) {
                    _html += NewPostItem(v.post_id, v.leader_id, v.poster_avatar, v.poster_name, v.post_time, v.post_content, v.post_imgs, v.post_favorites, v.post_reviews);
                });
                Log("startPostId = " + startPostId);
                Log("endPostId = " + endPostId);
                var $page = gFriendCircleManager.GetFriendCircleWnd(circle_type, leader_id, avatar, name);
                if (direction == "dir_up") {
                    if (post_id != 0) {
                        $page.find(".friend-post").prepend(_html);
                    } else {
                        $page.find(".friend-post").empty().prepend(_html);
                        gFriendCircleManager.UpdatePostId(circle_type, leader_id, endPostId, false);
                    }
                    gFriendCircleManager.UpdatePostId(circle_type, leader_id, startPostId, true);
                } else {
                    $page.find(".friend-post").append(_html);
                    gFriendCircleManager.UpdatePostId(circle_type, leader_id, endPostId, false);
                }
                gFriendCircleManager.RefreshWnd(circle_type, leader_id);
                var width = 5 * GetWinRatio() * 16;
                var height = 5 * GetWinRatio() * 16;
                $(".post_img").jqthumb({
                    width: width,
                    height: height
                });
            }
            Log("朋友圈说说列表");
            break;
        }
        case MSG_S_NEW_POST: //发布朋友圈说说
        {
            var post = data["content"];
            var post_id = post["post_id"];
            var leader_id = post["leader_id"];
            var avatar = post["avatar"];
            var nickname = post["user_name"];
            var post_time = post["post_time"];
            var text = post["text"];
            var imgs = post["imgs"];
            var _html = NewPostItem(post_id, leader_id, avatar, nickname, post_time, text, imgs, [], []);
            $("#pfc-all-" + gUserInfo.leader_id + " .friend-post").prepend(_html);
            gFriendCircleManager.RefreshAllWnd();
            var width = 5 * GetWinRatio() * 16;
            var height = 5 * GetWinRatio() * 16;
            $(".post").eq(0).find(".post_img").jqthumb({
                width: width,
                height: height
            });
            Log("朋友圈说说");
            Log(JSON.stringify(post));
            break;
        }
        case MSG_S_DELETE_POST:
        {
            var post = data["content"];
            gFriendCircleManager.RefreshAllWnd();
            Log("删除朋友圈说说");
            break;
        }
        case MSG_S_POST_FAVORITE:
        {
            var post = data["content"];
            Log("朋友圈说说点赞");
            break;
        }
        case MSG_S_POST_UN_FAVORITE:
        {
            var post = data["content"];
            Log("取消朋友圈说说点赞");
            break;
        }
        case MSG_S_POST_REVIEW:
        {
            var post = data["content"];
            Log("说说评论" + JSON.stringify(post));
            UpdatePostReview(post.post_id, post.leader_id, post.reviews);
            Log("朋友圈说说评论");
            break;
        }
        case MSG_S_DELETE_POST_REVIEW:
        {
            var post = data["content"];

            Log("删除朋友圈说说评论");
            break;
        }
        case MSG_S_POST_IMG_FAVORITE:
        {
            var post = data["content"];

            Log("朋友圈说说图片点赞");
            break;
        }
        case MSG_S_POST_IMG_UN_FAVORITE:
        {
            var post = data["content"];

            Log("取消朋友圈说说图片点赞");
            break;
        }
        case MSG_S_POST_IMG_REVIEW:
        {
            var post = data["content"];

            Log("朋友圈说说图片评论");
            break;
        }
        case MSG_S_DELETE_POST_IMG_REVIEW:
        {
            var post = data["content"];

            Log("删除朋友圈说说图片评论");
            break;
        }
        case MSG_S_GROUP_ANNOUNCE_LIST: //群公告列表
        {
            Log('群公告列表');
            var a = data['content'];
            var s = '';
            if (a.announce.length > 0) {
                $(a.announce).each(function (i, v) {
                    s += NewGroupAnnounceItem(v.announce_id, v.user_name, v.create_time, v.title, v.content);
                });
                s += '<input type="hidden" class="hidden-group-id" value="' + a.group_id + '"><div class="btn-add-new-group-announce">添加群公告</div>';

            } else {//没有群公告
                s = '<div class="no-group-announce"><img src="img/announce.png"/><div>暂无群公告</div></div>' +
                    '<input type="hidden" class="hidden-group-id" value="' + a.group_id + '"><div class="btn-add-new-group-announce">添加群公告</div>';

            }
            $("#page-group-announce-list").empty().html(s);
            Log(JSON.stringify(a));
            break;
        }
        case MSG_S_GROUP_IMAGE_LIST:
        {
            Log('群图片列表');
            var d = data['content'];
            var l = d['imageList'];
            Log(d);
            var s = '';
            if (l.length == 0) {
                s = '<div class="no-group-image"><img src="img/gimage.png"/><div>暂无照片</div></div>' +
                    '<input type="hidden" class="hidden-group-id" value="' + d.group_id + '">' +
                    '<div class="btn-add-new-group-image">上传照片</div>' +
                    '<div class="btn-add-new-group-album">新建相册</div>';
            } else {
                var items = '';
                var t = '';
                $(l).each(function (i, v) {
                    if (!!!IsSameDay(t, v['create_time'])) {
                        t = v['create_time'];
                        items += '<div class="gil-time">' + FormatTime3(v['create_time']) + '</div>';
                    }
                    items += '<div class="gil-item"><img src="' + v['path'] + '"/></div>';
                });
                s = '<div class="group-image-list">' + items + '</div>' +
                    '<input type="hidden" class="hidden-group-id" value="' + d.group_id + '">' +
                    '<div class="btn-add-new-group-image">上传照片</div>' +
                    '<div class="btn-add-new-group-album">新建相册</div>';
            }
            $("#page-group-image-list").empty().html(s);
            var w = 6 * 16 * GetWinRatio();
            var h = 6 * 16 * GetWinRatio();
            console.log("w = " + w + ",h=" + h);
            $(".gil-item img").jqthumb({
                width: w,
                height: h
            });
            break;
        }
        case MSG_S_GROUP_FILE_LIST:
        {
            Log("群文件列表");
            var d = data['content'];
            var l = d['fileList'];
            Log(d);
            if (l.length == 0) {
                s = '<div class="no-group-file"><img src="img/gfile.png"/><div>暂无文件</div></div>' +
                    '<input type="hidden" class="hidden-group-id" value="' + d.group_id + '">' +
                    '<div class="btn-add-new-group-file">上传文件</div>';
            } else {
                var items = '';
                $(l).each(function(i,v){
                    var file_icon = GetUploadFileIcon(v.file_type);
                     items += NewGroupFileItem(v.group_id, v.leader_id, v.file_id,file_icon,v.file_name, v.file_size, FormatTime2(v.create_time));
                });
                s = '<div class="group-file-list">'+items+'</div>'+
                    '<input type="hidden" class="hidden-group-id" value="' + d.group_id + '">' +
                    '<div class="btn-add-new-group-file">上传文件</div>';
            }
            $("#page-group-file-list").empty().html(s);
            break;
        }
        case MSG_S_NEW_GROUP_FILE:
        {
            Log('上传群文件成功!');
            var f = data['content'];
            Log(f);
            break;
        }
        case MSG_S_NEW_GROUP_ANNOUNCE://新的群公告
        {
            var a = data['content'];
            Log(a);
            Log("新群公告");
            break;
        }
        case MSG_S_NEW_GROUP_ALBUM: //新的群相册
        {
            Log('新群相册');
            var a = data['content'];
            Log(a);
            break;
        }
        case MSG_S_GROUP_ALBUM_LIST: //群相册列表
        {
            Log("群相册列表");
            var a = data['content'];
            Log(a);
            var s = '';
            if (a.album_list.length == 0) {
                s = '<div class="no-group-album"><img src="img/gfile.png"/><div>暂无相册</div></div>' +
                    '<input type="hidden" class="hidden-group-id" value="' + a.group_id + '"/>' +
                    '<input type="hidden" class="stage" value="' + a.stage + '"/>' +
                    '<div class="btn-add-new-group-album-2">新建相册</div>';
            } else {
                var list = '';
                $(a.album_list).each(function (i, v) {
                    var album_id = v['album_id'];
                    var group_id = v['group_id'];
                    var album_name = v['album_name'];
                    var album_desc = v['album_desc'];
                    var album_cover = v['path'] == null ? 'img/gimage.png' : v['path'];
                    var img_count = v['img_count'];
                    list += '<div class="group-album-item">' +
                        '<input type="hidden" class="hidden-album-id" value="' + album_id + '"/>' +
                        '<div class="album-cover"><img src="' + album_cover + '"/></div>' +
                        '<div class="album-name">' + album_name + '</div>' +
                        '<div class="album-img-count">' + img_count + '张</div>' +
                        '<div class="album-next"></div></div>';
                });
                s = '<div class="group-album-item-wrapper">' + list + '</div><input type="hidden" class="hidden-group-id" value="' + a.group_id + '"/>' +
                    '<input type="hidden" class="stage" value="' + a.stage + '"/>' +
                    '<div class="btn-add-new-group-album-2">新建相册</div>';
            }
            $("#page-group-album-list").empty().append(s);
            break;
        }
        case MSG_S_NEW_GROUP_ALBUM: //新建群相册
        {
            Log("新建群相册");
            var a = data['content'];
            Log(a);
            break;
        }
        case MSG_S_UPLOAD_IMG_TO_GROUP_ALBUM: //上传群图片
        {
            Log('上传群图片');
            var i = data['content'];
            Log(i);
            break;
        }
        case MSG_S_ERROR_MSG:
            var error = data["content"];
            Log(error);
            Log(JSON.stringify(error));
            break;
        default:
            break;
    }
}

/*************** 客户端消息请求 ***********************/
function SendClientMsg(msg, comment) {
    var json_msg = JSON.stringify(msg);
    if (console) {
        console.log("[客户端]" + comment + " : " + json_msg + "\n");
    }
    ws.send(json_msg);
}
//关注单个用户
function SendFollowSingleUser(leader_id, follow_leader_id, page) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_FOLLOW_SINGLE_USER,
        "leader_id": leader_id,
        "page": page,
        "follow_leader_id": follow_leader_id
    };
    SendClientMsg(msg, "发送 关注单个用户 消息");
}
//取消关注单个用户
function SendUnfollowSingleUser(leader_id, follow_leader_id, page) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_UNFOLLOW_SINGLE_USER,
        "leader_id": leader_id,
        "page": page,
        "follow_leader_id": follow_leader_id
    };
    SendClientMsg(msg, "发送 取消关注单个用户 消息");
}
//关注多个用户
function SendFollowMultiUserMsg(leader_id, follow_list) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_FOLLOW_MULTI_USER,
        "leader_id": leader_id,
        "follow_list": follow_list
    };
    SendClientMsg(msg, "发送关注多个用户消息");
}
//取消关注多个用户
function SendUnfollowMultiUserMsg(leader_id, follow_list) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_UNFOLLOW_MULTI_USER,
        "leader_id": leader_id,
        "follow_list": follow_list
    };
    SendClientMsg(msg, "发送取消关注多个用户消息");
}
function SendUserListAboutFollowMsg(leader_id, follow_list) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_USER_LIST_ABOUT_FOLLOW,
        "leader_id": leader_id,
    };
    SendClientMsg(msg, "请求自己好友是否关注的列表");
}
//发送注册信息
function SendRegisterInfo() {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_REGISTER,
        "client_name": gUserInfo.nickname,
        "mobile": gUserInfo.mobile,
        "avatar": gUserInfo.avatar
    };
    SendClientMsg(msg, "发送注册消息");
}
//发送登陆信息
function SendLoginInfo() {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_LOGIN_IN,
        "leader_id": gUserInfo.leader_id,
        "client_name": gUserInfo.nickname,
        "mobile": gUserInfo.mobile,
        "avatar": gUserInfo.avatar
    };
    SendClientMsg(msg, "发送登录信息");
}
//发送创建私密群的消息
function SendCreatePrivateGroupMsg(group_avatar, group_name, group_intro, create_by) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_CREATE_PRIVATE_GROUP,
        "avatar": group_avatar,
        "name": group_name,
        "intro": group_intro,
        "create_by": create_by
    };
    SendClientMsg(msg, "发送创建私密群消息");
}
//发送个人信息
function SendAboutMeMsg() {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_ABOUT_ME,
        "leader_id": gUserInfo.leader_id,
    };
    SendClientMsg(msg, "发送个人信息");
}
//发送关注用户列表
function SendUserFollowListMsg() {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_USER_FOLLOW_LIST,
        "leader_id": gUserInfo.leader_id
    };
    SendClientMsg(msg, "发送关注用户列表");
}
//邀请新成员之前，先要获取用户列表
function SendUserListAboutInviteMsg(group_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_USER_LIST_ABOUT_INVITE,
        "group_id": group_id,
    };
    SendClientMsg(msg, "邀请新群成员");
}
//邀请新成员
function SendInviteNewGroupMember(group_id, group_name, group_avatar, invitor_id, invitor_name, invitee_id_list) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_INVITE_NEW_GROUP_MEMBER,
        "group_id": group_id,
        "group_name": group_name,
        "group_avatar": group_avatar,
        "invitor_id": invitor_id,
        "invitor_name": invitor_name,
        "invitee_id_list": invitee_id_list
    };
    SendClientMsg(msg, "邀请新群成员");
}
//同意加入新群
function SendAgreeJoinNewGroupMsg(group_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_AGREE_JOIN_NEW_GROUP,
        "leader_id": gUserInfo.leader_id,
        "user_avatar": gUserInfo.avatar,
        "user_name": gUserInfo.nickname,
        "group_id": group_id
    }
    SendClientMsg(msg, '同意加入群组');
}
//获取群组信息
function SendGroupListMsg() {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_GROUP_LIST,
        "leader_id": gUserInfo.leader_id
    };
    SendClientMsg(msg, "获取用户加入的群组");
}
//发送群聊消息
function SendGroupChatMsg(group_id, group_name, msg, msg_type) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_GROUP_CHAT,
        "group_id": group_id,
        "group_name": group_name,
        "leader_id": gUserInfo.leader_id,
        "client_name": gUserInfo.nickname,
        "avatar": gUserInfo.avatar,
        "chat": msg,
        "chat_type": msg_type
    };
    SendClientMsg(msg, "发送群聊内容");
}
//发送私聊信息
function SendUserChatMsg(to_leader_id, to_user_name, msg, msg_type) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_USER_CHAT,
        "from_leader_id": gUserInfo.leader_id,
        "to_leader_id": to_leader_id,
        "from_user_name": gUserInfo.nickname,
        "to_user_name": to_user_name,
        "from_user_avatar": gUserInfo.avatar,
        "chat": msg,
        "chat_type": msg_type
    };
    SendClientMsg(msg, "发送私聊内容");
}
//发送获取群成员列表消息
function SendGroupMemberListMsg(group_id, leader_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_GROUP_MEMBER_LIST,
        "group_id": group_id,
        "leader_id": leader_id
    };
    SendClientMsg(msg, "获取群成员列表");
}
//获取群聊历史记录
function SendGroupChatHistoryMsg(group_id, group_name, leader_id, last_chat_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_GROUP_CHAT_HISTORY,
        "register_time": gUserInfo.register_time,
        "group_id": group_id,
        "group_name": group_name,
        "leader_id": leader_id,
        "last_chat_id": last_chat_id
    };
    SendClientMsg(msg, "获取群聊历史记录");
}
//获取私聊历史记录
function SendUserChatHistoryMsg(self_leader_id, other_user_name, other_leader_id, last_chat_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_USER_CHAT_HISTORY,
        "self_leader_id": self_leader_id,
        "other_leader_id": other_leader_id,
        "other_user_name": other_user_name,
        "last_chat_id": last_chat_id
    };
    SendClientMsg(msg, "获取私聊历史记录");
}
//查看用户详细资料
function SendUserDetailMsg(other_leader_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_USER_DETAIL,
        "leader_id": gUserInfo.leader_id,
        "other_leader_id": other_leader_id
    };
    SendClientMsg(msg, "获取 用户 详细资料");
}
//查看群详情信息
function SendGroupDetailMsg(group_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_GROUP_DETAIL,
        "group_id": group_id
    };
    SendClientMsg(msg, "获取 群 详细资料");
}
//修改用户公司
function SendModifyUserCompanyMsg(leader_id, company) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_MODIFY_USER_COMPANY,
        "leader_id": leader_id,
        "company": company
    };
    SendClientMsg(msg, "修改用户公司");
}
//修改用户职位
function SendModifyUserJobMsg(leader_id, job) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_MODIFY_USER_JOB,
        "leader_id": leader_id,
        "job": job
    };
    SendClientMsg(msg, "修改用户职位");
}
//修改用户行业
function SendModifyUserFieldMsg(leader_id, field) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_MODIFY_USER_FIELD,
        "leader_id": leader_id,
        "field": field
    };
    SendClientMsg(msg, "修改用户行业");
}
//重置未读聊天数据
function SendResetUnReadUserChatMsg(sender_id, receiver_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_RESET_UNREAD_USER_MSG,
        "sender_id": sender_id,
        "receiver_id": receiver_id
    };
    SendClientMsg(msg, "重置未读聊天数据");
}
//重置群未读消息记录
function SendResetUnReadGroupChatMsg(group_id, leader_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_RESET_UNREAD_GROUP_MSG,
        "group_id": group_id,
        "leader_id": leader_id
    }
    SendClientMsg(msg, "重置未读群聊天数据");
}
//朋友圈说说列表
function SendPostListMsg(circle_type, leader_id, avatar, name, direction, post_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_POST_LIST,
        "circle_type": circle_type,
        "leader_id": leader_id,
        "avatar": avatar,
        "name": name,
        "direction": direction,
        "post_id": post_id,
    }
    SendClientMsg(msg, "朋友圈说说列表");
}
//朋友圈说说
function SendNewPostMsg(leader_id, avatar, user_name, text, arrPic) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_NEW_POST,
        "leader_id": leader_id,
        "avatar": avatar,
        "user_name": user_name,
        "text": text,
        "imgs": arrPic
    }
    SendClientMsg(msg, "朋友圈新说说");
}
//删除朋友圈说说
function SendDeletePostMsg(post_id, leader_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_DELETE_POST,
        "post_id": post_id,
        "leader_id": leader_id
    }
    SendClientMsg(msg, "删除朋友圈说说");
}
//朋友圈说说点赞
function SendPostFavoriteMsg(post_id, leader_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_POST_FAVORITE,
        "post_id": post_id,
        "leader_id": leader_id
    };
    SendClientMsg(msg, "朋友圈说说点赞");
}
//朋友圈说说取消点赞
function SendPostUnFavoriteMsg(post_id, leader_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_POST_UN_FAVORITE,
        "post_id": post_id,
        "leader_id": leader_id
    };
    SendClientMsg(msg, "朋友圈说说取消点赞");
}
//朋友圈说说评论
function SendPostReviewMsg(post_id, leader_id, review) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_POST_REVIEW,
        "post_id": post_id,
        "leader_id": leader_id,
        "review": review
    };
    SendClientMsg(msg, "朋友圈说说评论");
}
//朋友圈说说取消评论
function SendDeletePostReviewMsg(post_id, review_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_DELETE_POST_REVIEW,
        "post_id": post_id,
        "review_id": review_id
    };
    SendClientMsg(msg, "朋友圈说说取消评论");
}
//朋友圈说说图片点赞
function SendPostImgFavoriteMsg(img_id, leader_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_POST_IMG_FAVORITE,
        "img_id": img_id,
        "leader_id": leader_id
    };
    SendClientMsg(msg, "朋友圈说说图片点赞");
}
//朋友圈说说图片取消点赞
function SendPostImgUnFavoriteMsg(img_id, leader_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_POST_IMG_UN_FAVORITE,
        "img_id": img_id,
        "leader_id": leader_id
    };
    SendClientMsg(msg, "朋友圈说说图片取消点赞");
}
//朋友圈说说图片评论
function SendPostImgReviewMsg(img_id, leader_id, content) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_POST_IMG_REVIEW,
        "img_id": img_id,
        "leader_id": leader_id,
        "content": content
    };
    SendClientMsg(msg, "朋友圈说说图片评论");
}
//朋友圈说说图片取消评论
function SendDeletePostImgReviewMsg(img_id, leader_id) {
    var msg = {
        "version": gUserInfo.version,
        "type": MSG_C_DELETE_POST_IMG_REVIEW,
        "img_id": img_id,
        "leader_id": leader_id
    };
    SendClientMsg(msg, "删除朋友圈说说图片评论");
}
//群通知列表
function SendGroupNoticeListMsg() {
    var msg = {
        'version': gUserInfo.version,
        'type': MSG_C_GROUP_NOTICE_LIST,
        'leader_id': gUserInfo.leader_id
    };
    SendClientMsg(msg, '群通知详情列表');
}
//群公告列表
function SendGroupAnnounceListMsg(group_id) {
    var msg = {
        'version': gUserInfo.version,
        'type': MSG_C_GROUP_ANNOUNCE_LIST,
        'group_id': group_id,
        'leader_id': gUserInfo.leader_id
    };
    SendClientMsg(msg, '群公告列表');
}
//新建群公告
function SendNewGroupAnnounceMsg(group_id, title, content) {
    var msg = {
        'version': gUserInfo.version,
        'type': MSG_C_NEW_GROUP_ANNOUNCE,
        'group_id': group_id,
        'leader_id': gUserInfo.leader_id,
        'user_name': gUserInfo.nickname,
        'user_avatar': gUserInfo.avatar,
        'title': title,
        'content': content
    };
    SendClientMsg(msg, '新建群公告');
}
//新建群相册
function SendNewGroupAlbumMsg(group_id, album_name, album_desc) {
    var msg = {
        'version': gUserInfo.version,
        'type': MSG_C_NEW_GROUP_ALBUM,
        'group_id': group_id,
        'album_name': album_name,
        'album_desc': album_desc,
        'leader_id': gUserInfo.leader_id
    };
    SendClientMsg(msg, '新建群相册');
}
//群文件列表
function SendGroupFileListMsg(group_id) {
    var msg = {
        'version': gUserInfo.version,
        'type': MSG_C_GROUP_FILE_LIST,
        'group_id': group_id,
        'leader_id': gUserInfo.leader_id
    };
    SendClientMsg(msg, '群文件列表');
}
//上传群文件
function SendNewGroupFileMsg(group_id, file_name, file_path, file_type, file_size) {
    var msg = {
        'version': gUserInfo.version,
        'type': MSG_C_NEW_GROUP_FILE,
        'group_id': group_id,
        'leader_id': gUserInfo.leader_id,
        'file_name': file_name,
        'file_path': file_path,
        'file_type': file_type,
        'file_size': file_size
    };
    SendClientMsg(msg, '上传群文件');
}
//上传群图片
function SendUploadImgToGroupAlbumMsg(group_id, path, album_id) {
    var msg = {
        'version': gUserInfo.version,
        'type': MSG_C_UPLOAD_IMG_TO_GROUP_ALBUM,
        'group_id': group_id,
        'leader_id': gUserInfo.leader_id,
        'path': path,
        'album_id': album_id
    };
    SendClientMsg(msg, '上传群相册图片');
}
//群相册图片列表
function SendGroupImageListMsg(group_id) {
    var msg = {
        'version': gUserInfo.version,
        'type': MSG_C_GROUP_IMAGE_LIST,
        'group_id': group_id,
        'leader_id': gUserInfo.leader_id
    };
    SendClientMsg(msg, '群图片列表');
}
//群相册列表
function SendGroupAlbumListMsg(group_id, stage) {
    var msg = {
        'version': gUserInfo.version,
        'type': MSG_C_GROUP_ALBUM_LIST,
        'group_id': group_id,
        'leader_id': gUserInfo.leader_id,
        'stage': stage
    };
    SendClientMsg(msg, '群相册列表');
}
//发送短信
function SendSm() {
    gVerifyCode = GetRandCode();
    console.log("验证码:" + gVerifyCode);
    //alert("验证码:" + gVerifyCode);
    //return;
    gMobile = trim($("#mobile").val());
    $.ajax({
        type: "get",
        async: true,
        url: "http://www.ld-kj.cn/API/index.php?function=smscode&mobile=" + gMobile + "&content=" + gVerifyCode,
        dataType: "json",
        timeout: 3000,
        success: function (json) {
            console.log("json result = " + JSON.stringify(json));
        }
    });
}
/******* 获取本地用户信息 *******/
function InitUser() {
    //ClearAllLocalStorageData(); //return;
    var user = JSON.parse(GetDataFromLocalStorage());
    if (user == null) {
        gUserNeedRegister = true;
    } else {
        gUserInfo = user;
        var version = gUserInfo.version ? gUserInfo.version : ''; //版本比对
        var leader_id = gUserInfo.leader_id ? gUserInfo.leader_id : '';
        var avatar = gUserInfo.avatar ? gUserInfo.avatar : '';
        var mobile = gUserInfo.mobile ? gUserInfo.mobile : '';
        if (version != "1.0.0" || !leader_id || !avatar || !mobile) {
            gUserNeedRegister = true;
        }
        console.log("Init User Info = " + JSON.stringify(user) + "\n");
    }
    if (gUserNeedRegister) {
        ShowRegisterDialog();
    } else {
        connect(); //打开对话框
        ShowPageNotice(); //目前调试阶段，需要打开它
    }
}

// @注册界面  用户头像上传
function UploadUserAvatar(jsonData) {
    UploadBase64Img("user_avatar", jsonData, UploadUserAvatarCallback);
}
function UploadGroupAvatar(jsonData) {
    UploadBase64Img("group_avatar", jsonData, UploadGroupAvatarCallback);
}
// @创建群界面
function UploadGroupAvatarCallback(jsonData) {
    if (jsonData.status = "success") {
        gCreatePrivateGroup.avatarUploadSuccess = true; //用户头像上传成功
        gCreatePrivateGroup.avatarPath = jsonData.path; //用户头像服务器路径
        AutoLog("用户头像上传成功,路径为: " + jsonData.path);
    } else {
        gCreatePrivateGroup.avatarUploadSuccess = false; //用户头像上传成功
        gCreatePrivateGroup.avatarPath = ''; //用户头像服务器路径
        AutoLog("用户头像上传失败!");
    }
}
// @注册界面 用户头像上传回调函数
function UploadUserAvatarCallback(jsonData) {
    if (jsonData.status = "success") {
        gUserAvatarUploadSuccess = true; //用户头像上传成功
        gUserAvatarUploadPath = jsonData.path; //用户头像服务器路径
        AutoLog("用户头像上传成功,路径为: " + jsonData.path);
    } else {
        gUserAvatarUploadSuccess = false; //用户头像上传失败
        gUserAvatarUploadPath = ""; //清空头像服务器路径
        AutoLog("用户头像上传失败!");
    }
}
//  上传图片,图片内容为base64字符串
function UploadBase64Img(type, strBase64, callback) {
    $.ajax({
        type: 'POST',
        url: 'upload.avatar.php',
        data: {
            type: type,
            avatar: strBase64
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
var PageManager = {
    curState: {},
    Init: function () {
        var url = window.location.href;
        var urlNoSlash = SERVER_ROOT.substr(0, SERVER_ROOT.length - 1);
        var url = SERVER_ROOT + "index.php?page=" + PS_INDEX + "&title=斗信&leader_id=" + gUserInfo.leader_id;
        window.history.replaceState({
            url: url,
            page: PS_INDEX,
            title: "斗信",
            index: 0,
            data: {url: url, page: PS_INDEX, title: "斗信", index: 0}
        }, "", url);
        PageManager.StateListen();
        window.history.pushState({page: PS_INDEX, data: {url: url, page: PS_INDEX, title: "斗信", index: 0}}, "斗信", url);
        ShowPageNotice();
    },
    State: function (page, obj, url) { //无刷新改变URL
        if (window.history.pushState) {
            this.curState = {page: page, data: obj};
            window.history.pushState({page: page, data: obj}, obj.title, url);
            var $body = $('body');
            document.title = obj.title;
            // hack在微信等webview中无法修改document.title的情况
            var $iframe = $('<iframe src="/favicon.ico"></iframe>').on('load', function () {
                setTimeout(function () {
                    $iframe.off('load').remove()
                }, 0)
            }).appendTo($body);
        } else {
            location.href = url;
        }
    },
    StateListen: function () { //监听地址
        var that = this;
        window.addEventListener('popstate', function (e) {
            if (history.state) {
                var cstate = that.curState;
                var cdata = cstate.data;
                console.log(cstate);
                console.log(cdata);
                if (cstate.page == PS_GROUP_CHAT) {
                    if (cdata.notice && cdata.notice == NOTICE_UNREAD_GROUP_CHAT)
                        gChatRoomManager.ExitChatRoom("group", cdata.group_id);
                } else if (cstate.page == PS_USER_CHAT && cdata.notice && cdata.notice == NOTICE_UNREAD_USER_CHAT) {
                    gChatRoomManager.ExitChatRoom("user", cdata.leader_id);
                } else if (cstate.page == PS_GROUP_CHAT && cdata.notice && cdata.notice == NOTICE_JOIN_GROUP_SUCCESS) {
                    ClearNoticeItem(NOTICE_JOIN_GROUP_SUCCESS, cdata.group_id); //如果用户的通知存在就更新
                }

                var page = e.state.page;
                var o = e.state.data;
                var $body = $('body');
                document.title = o.title;
                // hack在微信等webview中无法修改document.title的情况
                var $iframe = $('<iframe src="/favicon.ico"></iframe>').on('load', function () {
                    setTimeout(function () {
                        $iframe.off('load').remove()
                    }, 0)
                }).appendTo($body);
                if (o.page == "index") {
                    o.title = "斗信";
                }
                switch (page) {
                    case PS_GROUP_CHAT:
                        var $wnd = gChatRoomManager.GetChatWnd("group", o.title, o.group_id);
                        ShowPage($wnd);
                        break;
                    case PS_USER_CHAT:
                        var $wnd = gChatRoomManager.GetChatWnd("user", o.title, o.leader_id);
                        ShowPage($wnd);
                        break;
                    case PS_GROUP_MEMBER_LIST:
                        var $wnd = GetGroupMemberListWnd(o.group_id);
                        ShowPage($wnd);
                        break;
                    case PS_GROUP_DETAIL:
                        SendGroupDetailMsg(o.group_id);
                        ShowPage($("#page-group-detail"));
                        break;
                    case PS_INDEX:
                        ShowPageNotice();
                        console.log("ShowPageNotice");
                        break;
                    case PS_TAB_RELATION:
                        ShowPageRelation();
                        break;
                    case PS_TAB_ME:
                        ShowPageMe();
                        break;
                    case PS_USER_DETAIL:
                        window.history.back(); //再回退一步
                        //ShowPage($("#page-user-detail"));
                        break;
                    case PS_USER_FOLLOW_LIST:
                        SendUserFollowListMsg();
                        ShowPage($("#page-user-follow-list"));
                        break;
                    case PS_GROUP_LIST:
                        SendGroupListMsg();
                        ShowPage($("#page-groups"));
                        break;
                    case PS_FOLLOW_MULTI_USER:
                        ShowPage($("#page-add-multi-follow"));
                        break;
                    case PS_ALL_FRIEND_CIRCLE:
                        var $wnd = gFriendCircleManager.GetFriendCircleWnd("all", o.leader_id, o.avatar, o.name);
                        ShowPage($wnd);
                        break;
                    case PS_SINGLE_FRIEND_CIRCLE:
                        var $wnd = gFriendCircleManager.GetFriendCircleWnd("single", o.leader_id, o.avatar, o.name);
                        ShowPage($wnd);
                        break;
                    case PS_GROUP_ANNOUNCE_LIST:
                        SendGroupAnnounceListMsg(o.group_id);
                        ShowPage($("#page-group-announce-list"));
                        break;
                    case PS_GROUP_IMAGE_LIST:
                        SendGroupImageListMsg(o.group_id);
                        ShowPage($("#page-group-image-list"));
                        break;
                    case PS_UPLOAD_GROUP_IMAGE:
                        ShowPage($("#page-upload-group-image"));
                        break;
                    case PS_GROUP_ALBUM_LIST:
                        SendGroupAlbumListMsg(o.group_id, o.stage);
                        ShowPage($("#page-group-album-list"));
                        break;
                    case PS_GROUP_FILE_LIST:
                        SendGroupFileListMsg(o.group_id);
                        ShowPage($("#page-group-file-list"));
                        break;
                    default:
                        break;
                }
            }
        }, false);
    }
};

/***********
 * 页面总入口
 ***********/
function InitFriendCircle() {
    $(".fc-cover .cover-avatar").attr("src", gUserInfo.avatar);
}
$(function () {
    initHtml5();
    InitUser();
    InitFriendCircle();
    $(".ld-icon-btn-group").ldIconBtn({
        base: ["img"],
        unactiveIcons: ["btn-img", "emotion"],
        activeIcons: ["btn-img.2", "emotion.2"],
        activeIndex: 1,
        callback: function (index) {
            if (index == 1) {
                $(".publish-circle-image").hide();
                $(".circle-emotion").show();
            } else if (index == 0) {
                $(".publish-circle-image").show();
                $(".circle-emotion").hide();
            }
            console.log("click icon btn = " + index);
        }
    });
    var emTarget = ".publish-circle-text";
    var emContainer = ".circle-emotion";
    $(".publish-circle-release .ld-icon-btn:nth-child(2)").mobileEmotion({
        target: emTarget, container: emContainer
    });
    if (gIScrollContainer[ISCROLL_TAB_NOTICE] == undefined) {
        setTimeout(function () {
            gIScrollContainer[ISCROLL_TAB_NOTICE] = new IScroll(".tab-notice", {
                click: true,
                preventDefault: true
            });
        }, 0);
    }
    if (!gUserNeedRegister) {
        PageManager.Init();
    }
    $(".ld-tab-head .tab-btn").eq(0).addClass("tab-btn-active");
    $(".ld-tab-head .tab-btn-icon").eq(0).css("background-image", 'url("img/notice.active.png")');
    //页面创建
    var last_tab_index = 0;
    $(".ld-tab-head .tab-btn").click(function () {
        var idx = $(this).index();
        $(".tab-btn-active").removeClass("tab-btn-active");
        if (idx == 0) {
            $(this).find(".tab-btn-icon").css("background-image", 'url("img/notice.active.png")');
            $(".tab-btn-icon").eq(1).css("background-image", 'url("img/group.1.png")');
            $(".tab-btn-icon").eq(2).css("background-image", 'url("img/me.png")');
        } else if (idx == 1) {
            $(this).find(".tab-btn-icon").css("background-image", 'url("img/group.active.1.png")');
            $(".tab-btn-icon").eq(0).css("background-image", 'url("img/notice.png")');
            $(".tab-btn-icon").eq(2).css("background-image", 'url("img/me.png")');
            if (gIScrollContainer[ISCROLL_TAB_RELATION] == undefined) {
                setTimeout(function () {
                    gIScrollContainer[ISCROLL_TAB_RELATION] = new IScroll("#arul-wrapper", {
                        click: true,
                        preventDefault: true
                    });
                    gIScrollContainer[ISCROLL_TAB_RELATION].refresh();
                    console.log(gIScrollContainer[1]);
                }, 0);
            }
        } else if (idx == 2) {
            $(this).find(".tab-btn-icon").css("background-image", 'url("img/me.active.png")');
            $(".tab-btn-icon").eq(0).css("background-image", 'url("img/notice.png")');
            $(".tab-btn-icon").eq(1).css("background-image", 'url("img/group.1.png")');
            setTimeout(function () {
                gIScrollContainer[ISCROLL_TAB_ME] = new IScroll(".tab-me", {
                    click: true,
                    preventDefault: true
                });
            }, 0);
        }
        $(this).addClass("tab-btn-active");
        if (idx != last_tab_index) {
            if (idx == 0) {
                var o = {
                    leader_id: gUserInfo.leader_id,
                    title: '斗信',
                    index: 0
                };
                SaveHistory(PS_INDEX, o);
            } else if (idx == 1) {
                var o = {
                    leader_id: gUserInfo.leader_id,
                    title: '通讯录',
                    index: 1
                };
                SaveHistory(PS_TAB_RELATION, o);
            } else if (idx == 2) {
                var o = {
                    leader_id: gUserInfo.leader_id,
                    title: '我',
                    index: 2
                };
                SaveHistory(PS_TAB_ME, o);
            }
        }
        last_tab_index = idx;
        ShowTab(idx);
    });
    //用户头像裁剪
    var wThumb = 8 * GetWinRatio() * 16;
    $(document).on('click', '.btn-emotion', function (event) {
        var $container = $(this).siblings(".ld-em-wrapper");
        if ($container.is(":visible")) {
            $container.hide();
        } else {
            $(this).siblings(".textarea").blur();
            $container.show();
        }
    });
    //查看群组详情
    $(document).on('click', '.group-item', function () {
        var group_id = $(this).find(".group-id").val();
        var group_name = trim($(this).find(".group-name").html());
        var $wndGroupChat = gChatRoomManager.GetChatWnd("group", group_name, group_id);
        $(".page").hide();
        var o = {
            group_id: group_id,
            leader_id: gUserInfo.leader_id,
            title: group_name
        };
        if ($wndGroupChat.is(":hidden")) {
            SaveHistory(PS_GROUP_CHAT, o);
        }
        $wndGroupChat.show(); //获取历史聊天记录
        if (gChatRoomManager.GetChatId("group", group_id) == "max") { //如果没有加载过聊天历史记录就开始加载
            SendGroupChatHistoryMsg(group_id, group_name, gUserInfo.leader_id, "max");
        }
    });
    //群相册列表
    $(document).on('click', '.gd-btn-image-list', function (event) {
        var group_id = $(this).parent().siblings(".hidden-group-id").val();
        var o = {
            group_id: group_id,
            leader_id: gUserInfo.leader_id,
            title: '群相册'
        };
        Log(o);
        SaveHistory(PS_GROUP_IMAGE_LIST, o);
        SendGroupImageListMsg(group_id);
        ShowPage($("#page-group-image-list"));
    });
    //上传群照片
    $(document).on('click', '.btn-add-new-group-image', function (event) {
        var group_id = $(this).siblings(".hidden-group-id").val();
        var o = {
            group_id: group_id,
            leader_id: gUserInfo.leader_id,
            title: '上传群照片'
        };
        Log(o);
        $("#page-upload-group-image .hidden-group-id").val(group_id);
        SaveHistory(PS_UPLOAD_GROUP_IMAGE, o);
        ShowPage($("#page-upload-group-image"));
    });
    //上传群照片到服务器
    $(document).on('click', '.btn-finish-upload-group-image', function (event) {
        var group_id = $(this).siblings(".hidden-group-id").val();
        var $li = $(".ugi-container .file-item");
        if ($li.length == 0) {
            swal('', '请添加上传图片', 'error');
            return;
        } else {
            var path = [];
            $li.each(function (i, v) {
                var id = $(v).attr('id');
                path.push(gilContainer[id]);
            });
            var album_id = $(this).siblings(".hidden-group-album-id").val();
            SendUploadImgToGroupAlbumMsg(group_id, path, album_id);
            history.back();
            gilContainer.length = 0;
        }
    });
    //打开群相册列表
    $(document).on('click', '.ugi-album .group-album-name', function (event) {
        var group_id = $(this).parent().siblings(".hidden-group-id").val();
        SendGroupAlbumListMsg(group_id, 'select');
        var o = {
            group_id: group_id,
            leader_id: gUserInfo.leader_id,
            title: '选择相册',
            stage: 'select'
        };
        SaveHistory(PS_GROUP_ALBUM_LIST, o);
        ShowPage($("#page-group-album-list"));
    });
    //打开群相册列表
    $(document).on('click', '.ugi-album .select-group-album', function (event) {
        $('.ugi-album .group-album-name').trigger('click');
    });
    //新建群相册
    $(document).on('click', '.btn-add-new-group-album', function (event) {
        var group_id = $(this).siblings(".hidden-group-id").val();
        var o = {
            group_id: group_id,
            leader_id: gUserInfo.leader_id,
            title: '新建群相册'
        };
        Log(o);
        $("#page-new-group-album .hidden-group-id").val(group_id);
        SaveHistory(PS_NEW_GROUP_ALBUM, o);
        ShowPage($("#page-new-group-album"));
    });
    //新建群相册2
    $(document).on('click', '.btn-add-new-group-album-2', function (event) {
        var group_id = $(this).siblings(".hidden-group-id").val();
        var o = {
            group_id: group_id,
            leader_id: gUserInfo.leader_id,
            title: '新建群相册'
        };
        Log(o);
        $("#page-new-group-album .hidden-group-id").val(group_id);
        SaveHistory(PS_NEW_GROUP_ALBUM, o);
        ShowPage($("#page-new-group-album"));
    });
    //选择相册名
    $(document).on('click', '#page-group-album-list .group-album-item', function (event) {
        var stage = $(this).parent().siblings(".stage").val();
        if (stage == 'select') {
            var group_album_id = $(this).find(".hidden-album-id").val();
            var album_name = trim($(this).find(".album-name").html());
            $("#page-upload-group-image span.group-album-name").empty().html(album_name);
            $("#page-upload-group-image .hidden-group-album-id").val(group_album_id);
            history.back();
        }
    });
    //完成群相册的建立
    $(document).on('click', '.btn-finish-new-group-album', function (event) {
        var group_id = $(this).siblings(".hidden-group-id").val();
        var album_name = trim($(this).siblings(".nga-wrapper").find(".nga-album-name").val());
        var album_desc = trim($(this).siblings(".nga-wrapper").find(".nga-album-desc").val());
        if (album_name.length == 0) {
            swal('', '相册名称不能为空', 'error');
            return;
        }
        if (album_desc.length == 0) {
            swal('', '相册描述不能为空', 'error');
            return;
        }
        if (album_name.length > 10) {
            swal('', '相册名称字数超过10个字', 'error');
            return;
        }
        if (album_desc.length > 50) {
            swal('', '相册描述字数超过50个字', 'error');
            return;
        }
        SendNewGroupAlbumMsg(group_id, album_name, album_desc);
        history.back();
    });
    //群文件列表
    $(document).on('click', '.gd-btn-file-list', function (event) {
        var group_id = $(this).parent().siblings(".hidden-group-id").val();
        var o = {
            group_id: group_id,
            leader_id: gUserInfo.leader_id,
            title: '群文件'
        };
        Log(o);
        SaveHistory(PS_GROUP_FILE_LIST, o);
        SendGroupFileListMsg(group_id);
        ShowPage($("#page-group-file-list"));
    });
    //上传群文件
    $(document).on('click', '.btn-add-new-group-file', function () {
        var group_id = $(this).siblings(".hidden-group-id").val();
        var o = {
            group_id: group_id,
            leader_id: gUserInfo.leader_id,
            title: '群文件'
        };
        Log(o);
        SaveHistory(PS_UPLOAD_GROUP_FILE, o);
        $("#page-upload-group-file .hidden-group-id").val(group_id);
        ShowPage($("#page-upload-group-file"));
    });
    //群公告列表
    $(document).on('click', '.gd-btn-announce-list', function (event) {
        var group_id = $(this).parent().siblings(".hidden-group-id").val();
        var o = {
            group_id: group_id,
            leader_id: gUserInfo.leader_id,
            title: "群公告"
        };
        Log(o);
        SaveHistory(PS_GROUP_ANNOUNCE_LIST, o);
        SendGroupAnnounceListMsg(group_id);
        ShowPage($("#page-group-announce-list"));
    });
    //发表群公告
    $(document).on('click', '.btn-add-new-group-announce', function (event) {
        var group_id = $(this).siblings(".hidden-group-id").val();
        var o = {
            group_id: group_id,
            leader_id: gUserInfo.leader_id,
            title: '添加群公告'
        };
        SaveHistory(PS_ADD_NEW_GROUP_ANNOUNCE, o);
        $("#page-new-group-announce .hidden-group-id").val(group_id);
        ShowPage($("#page-new-group-announce"));
    });
    $(document).on('click', '.btn-finish-new-group-announce', function (event) {
        var group_id = $(this).siblings(".hidden-group-id").val();
        var title = trim($(this).siblings(".new-group-announce-title").val());
        var content = trim($(this).siblings(".new-group-announce-content").val());
        if (title.length == 0) {
            swal('', '标题不能为空', 'error');
            return;
        }
        if (title.length < 4) {
            swal('', '标题字数不足', 'error');
            return;
        }
        if (title.length > 30) {
            swal('', '标题字数超过30字', 'error');
            return;
        }
        if (content.length == 0) {
            swal('', '正文不能为空', 'error');
            return;
        }
        if (content.length < 15) {
            swal('', '正文字数不足', 'error');
            return;
        }
        if (content.length > 300) {
            swal('', '正文字数超过300字', 'error');
            return;
        }
        SendNewGroupAnnounceMsg(group_id, title, content);
        history.back();
    });
    //创建群界面头像上传功能实现
    $(".ld-thumbnail-container").photoClip({
        width: wThumb * 0.7,
        height: wThumb * 0.7,
        file: ".ld-file",
        view: ".ld-thumbnail-view",
        ok: ".ld-thumbnail-save",
        outputType: "png",
        loadStart: function () {
            console.log("照片读取中");
        },
        loadComplete: function () {
            $(".ld-thumbnail-blur").hide();
            $(".ld-thumbnail-opacity").hide();
            $(".ld-thumbnail-view").hide();
            $(".ld-thumbnail-container").show();
        },
        clipFinish: function (dataURL) {
            $(".ld-thumbnail-container").hide();
            $(".ld-thumbnail-blur").css({
                "background-image": "url(" + dataURL + ")",
                "background-size": "cover"
            }).show();
            $(".ld-thumbnail-opacity").show();
            $(".ld-thumbnail-view").show();
            UploadGroupAvatar(dataURL);
        }
    });
    //注册界面用户头像上传功能实现
    $(".thumbnail-container").photoClip({
        width: wThumb * 0.7,
        height: wThumb * 0.7,
        file: "#file",
        view: ".thumbnail-view",
        ok: ".thumbnail-save",
        outputType: "png",
        loadStart: function () {
            console.log("照片读取中");
        },
        loadComplete: function () {
            $(".thumbnail-blur").hide();
            $(".thumbnail-opacity").hide();
            $(".thumbnail-view").hide();
            $(".thumbnail-container").show();
        },
        clipFinish: function (dataURL) {
            $(".thumbnail-container").hide();
            $(".thumbnail-blur").css({
                "background-image": "url(" + dataURL + ")",
                "background-size": "cover"
            }).show();
            $(".thumbnail-opacity").show();
            $(".thumbnail-view").show();
            UploadUserAvatar(dataURL);
        }
    });
    var select_client_id = 'all';
    $("#client_list").change(function () {
        select_client_id = $("#client_list option:selected").attr("value");
    });
    $(".btn-setting").click(function () {
        var $settingMore = $(".setting-more");
        if ($settingMore.is(":visible")) {
            $settingMore.css('display', 'none');
        } else {
            $settingMore.css('display', 'block');
        }
    });
    //创建私聊群
    $(".create-private-group-btn").click(function () {
        var o = {
            leader_id: gUserInfo.leader_id,
            title: '创建私聊群'
        };
        SaveHistory(PS_CREATE_PRIVATE_GROUP, o);
        ShowPage($("#page-create-private-group"));
    });
    $(".menu-item").click(function () {
        var idx = $(this).index();
        var $centerItem = $(".center-item");
        $centerItem.css("display", "none");
        $centerItem.eq(idx).css("display", "block");
    });
    //单击所有注册用户，显示用户详细资料，用户详情
    $(document).on('click', '#all_register_user_list .ld-list-item', function () {
        var item_type = trim($(this).find(".item-hide-type").val());
        var leader_id = trim($(this).find(".item-hide-data").val());
        var title = trim($(this).find(".item-title").html());
        if (item_type == LLI_ALL_REGISTER_USER) {
            ShowPageUserDetail(leader_id);
        }
    });
    //单击特别关注用户，显示用户详细资料，用户详情
    $(document).on('click', '.exist-user-follow .ufl-top .ld-list-item', function () {
        var item_type = trim($(this).find(".item-hide-type").val());
        var leader_id = trim($(this).find(".item-hide-data").val());
        var title = trim($(this).find(".item-title").html());
        if (item_type == LLI_ALL_USER_FOLLOW) {
            ShowPageUserDetail(leader_id);
        }
    });
    //获取群组信息
    $(document).on('click', '.tab-relation #btn-group', function () {
        var o = {
            leader_id: gUserInfo.leader_id,
            title: '群组'
        };
        SaveHistory(PS_GROUP_LIST, o);
        SendGroupListMsg();
        ShowPage($("#page-groups"));
    });
    //单击群聊通知 ld-notice
    $(document).on('click', '.ld-notice', function () {
        var type = trim($(this).find(".notice-type").val());
        var ext = trim($(this).find(".notice-ext").val());
        var title = trim($(this).find(".i-title").html());
        var o = {
            group_id: ext,
            leader_id: ext,
            title: title,
            notice: type
        };
        if (type == NOTICE_UNREAD_GROUP_CHAT || type == NOTICE_JOIN_GROUP_SUCCESS) {
            SaveHistory(PS_GROUP_CHAT, o); //ext = group_id
            ShowPage(gChatRoomManager.GetChatWnd("group", title, ext)); //打开窗口
            gChatRoomManager.EnterChatRoom("group", ext); //进入聊天室
        } else if (type == NOTICE_UNREAD_USER_CHAT) {
            SaveHistory(PS_USER_CHAT, o); //ext = user_id
            ShowPage(gChatRoomManager.GetChatWnd("user", title, ext)); //打开窗口
            gChatRoomManager.EnterChatRoom("user", ext); //进入聊天室
        } else if (type == NOTICE_NEW_INVITE_JOIN_GROUP) {

        } else if (type == NOTICE_GROUP) { //群通知列表
            o.title = '群通知详情列表';
            SendGroupNoticeListMsg();//群通知列表详情
            SaveHistory(PS_GROUP_NOTICE_LIST, o);
            ShowPage($("#page-group-notice-list"));
        }
    });
    //发送群消息
    $(document).on('click', '.btn-send-group-msg', function () {
        var group_id = $(this).siblings(".group-id-hidden").val();
        var $wndMsg = $(this).siblings(".textarea");
        var group_name = trim($(this).parent().siblings(".chat-wnd-title").find("span").html());
        var msg = trim($wndMsg.html());
        var msg_type = MSG_TYPE_NORMAL_CHAT;
        if (msg.length) {
            SendGroupChatMsg(group_id, group_name, msg, msg_type);
            $wndMsg.empty();
        }
    });
    //发送私聊信息
    $(document).on("click", '.btn-send-user-msg', function () {
        var to_leader_id = $(this).siblings(".user-id-hidden").val();
        var $wndMsg = $(this).siblings(".textarea");
        var to_user_name = trim($(this).parent().siblings(".chat-wnd-title").find("span").html());
        var msg_type = MSG_TYPE_NORMAL_CHAT;
        var msg = trim($wndMsg.html());
        if (msg.length) {
            console.log("to_leader_id" + to_leader_id);
            console.log("self leader id" + gUserInfo.leader_id);
            SendUserChatMsg(to_leader_id, to_user_name, msg, msg_type);
            $wndMsg.empty();
        }
    });
    //查看详细资料的时候想要和用户发送消息
    $(document).on("click", '.btn-talk-with-user', function () {
        var to_leader_id = trim($(this).parent().find(".user-leader-id").val());
        var to_user_name = trim($(this).parent().find(".user-name").html());
        var $chatWnd = gChatRoomManager.GetChatWnd("user", to_user_name, to_leader_id);
        gChatRoomManager.EnterChatRoom("user", to_leader_id);
        var o = {
            leader_id: to_leader_id,
            title: to_user_name
        };
        SaveHistory(PS_USER_DETAIL, o);
        ShowPage($chatWnd);
    });
    //查看用户详细资料
    $(document).on('click', ".chat-item .user-icon", function () {
        var leader_id = trim($(this).siblings(".leader_id_hidden").val());
        ShowPageUserDetail(leader_id);
    });
    //修改资料
    $(".eud-bottom .ud-item").click(function () {
        var msg_type = trim($(this).find("input:hidden").val());
        var idx = $(this).index();
        $("#page-modify-text .modify-text").val(trim($(this).find(".sub-item-2").html()));
        $(".modify-text-msg").val(msg_type);
        var title = '';
        if (idx == 0) {
            title = "公司";
        } else if (idx == 1) {
            title = "职位";
        } else if (idx == 2) {
            title = "行业";
        }
        var o = {
            leader_id: gUserInfo.leader_id,
            title: title
        };
        SaveHistory(PS_MODIFY_gUserInfo, o);
        ShowPage($("#page-modify-text"));
    });
    //添加多个圈圈
    $(document).on('click', '.ld-editable-list-item', function () {
        var type = trim($(".editable-list-type").val());
        if (type == ELI_TYPE_FOLLOW_LIST || type == ELI_TYPE_GROUP_MEMBER_LIST) { //添加多个关注用户
            var circle = $(this).find(".editable-circle");
            if (circle.hasClass("editable-circle-unselect")) {
                circle.removeClass("editable-circle-unselect").addClass("editable-circle-select");
            } else {
                circle.removeClass("editable-circle-select").addClass("editable-circle-unselect");
            }
        }
    });
    //关注多个用户添加
    $(document).on('click', ".finish-add-multi-follow", function () {
        var $select = $(".follow-list").find(".editable-circle-select");
        var follow_list = [];
        $select.each(function () {
            var leader_id = trim($(this).siblings(".editable-list-data").val());
            follow_list.push(leader_id);
        });
        if (follow_list.length) {
            SendFollowMultiUserMsg(gUserInfo.leader_id, follow_list);
        } else {
            console.log("你 没有关注任何人哦！");
        }
        window.history.back();
    });
    //要求多个人关注公众号
    $(document).on('click', ".finish-invite-group-member", function () {
        var $select = $(".invite-group-member-list").find(".editable-circle-select");
        var invite_list = [];
        $select.each(function () {
            var leader_id = trim($(this).siblings(".editable-list-data").val());
            invite_list.push(leader_id);
        });
        if (invite_list.length) {
            var gId = $(".invite-grp-id").val();
            var gName = $(".invite-grp-name").val();
            var gAvatar = $(".invite-grp-avatar").val();
            SendInviteNewGroupMember(gId, gName, gAvatar, gUserInfo.leader_id, gUserInfo.nickname, invite_list);
        } else {
            Log1("你 没有邀请任何群成员哦!");
        }
        window.history.back();
    });
    //完成关注多个用户
    $(".btn-add-multi-follow").click(function () {
        SendUserListAboutFollowMsg(gUserInfo.leader_id);
        var o = {
            leader_id: gUserInfo.leader_id,
            title: '添加关注好友'
        };
        SaveHistory(PS_FOLLOW_MULTI_USER, o);
    });
    //保存修改用户信息
    $("#save-modify-text-btn").click(function () {
        var content = trim($("#page-modify-text .modify-text").val());
        var msg_type = trim($(".modify-text-msg").val());
        switch (msg_type) {
            case MSG_C_MODIFY_USER_COMPANY:
                SendModifyUserCompanyMsg(gUserInfo.leader_id, content);
                break;
            case MSG_C_MODIFY_USER_JOB:
                SendModifyUserJobMsg(gUserInfo.leader_id, content);
                break;
            case MSG_C_MODIFY_USER_FIELD:
                SendModifyUserFieldMsg(gUserInfo.leader_id, content);
                break;
            default:
                break;
        }
        window.history.back();
    });
    //关注用户列表
    $(document).on('click', "#btn-follow", function () {
        var o = {
            leader_id: gUserInfo.leader_id,
            title: '特别关注'
        };
        SaveHistory(PS_USER_FOLLOW_LIST, o);
        SendUserFollowListMsg();
        ShowPage($("#page-user-follow-list"));
    });
    //查看群成员列表
    $(document).on('click', ".chat-wnd-title .btn-view-group-detail", function () {
        var group_id = trim($(this).parent().parent().find(".group-id-hidden").val());
        var group_name = $(this).siblings('span').html();
        console.log("group_id = " + group_id);
        //访问记录压栈
        var leader_id = gUserInfo.leader_id;
        var o = {
            group_id: group_id,
            leader_id: leader_id,
            title: group_name
        };
        SaveHistory(PS_GROUP_DETAIL, o);
        ShowPage($("#page-group-detail"));
        SendGroupDetailMsg(group_id);
    });
    //私密群邀请新成员
    $(document).on('click', '.btn-invite-group-member', function () {
        var group_id = trim($(this).parent().siblings(".hidden-group-id").val());
        SendUserListAboutInviteMsg(group_id);
        var o = {
            group_id: group_id,
            leader_id: gUserInfo.leader_id,
            title: '邀请新成员'
        };
        SaveHistory(PS_INVITE_NEW_GROUP_MEMBER, o);
        var grp_id = $(this).parent().siblings(".hidden-group-id").val();
        var grp_avatar = $(this).parent().siblings(".gd-group-avatar").find("img").attr("src");
        var grp_name = $(this).parent().siblings(".hidden-group-name").val();
        $("#page-invite-new-group-member .invite-grp-id").val(grp_id);
        $("#page-invite-new-group-member .invite-grp-name").val(grp_name);
        $("#page-invite-new-group-member .invite-grp-avatar").val(grp_avatar);
        ShowPage($("#page-invite-new-group-member"));
    });
    //同意加入私密群
    $(document).on('click', '.ld-gn-btn', function () {
        var type = $(this).siblings(".lg-gn-type").val();
        var id = $(this).siblings(".ld-gn-id").val();
        if (type == NOTICE_NEW_INVITE_JOIN_GROUP) {
            SendAgreeJoinNewGroup(group_id, gUserInfo.leader_id);
        }
    });
    //下载用户历史记录
    $(document).on('click', ".chat-wnd-title .btn-more-user-history", function () {
        var other_leader_id = $(this).parent().parent().find(".user-id-hidden").val();
        var to_user_name = trim($(this).siblings("span").html());
        //获取历史记录
        var last_chat_id = gChatRoomManager.GetChatId("user", other_leader_id);
        console.log("btn-more-user-history");
        //SendUserChatHistoryMsg(gUserInfo.leader_id, to_user_name, other_leader_id, last_chat_id);
    });
    //下载更多群聊天记录
    $(document).on('click', ".chat-wnd-title .btn-more-group-history", function () {
        var group_id = $(this).parent().parent().find(".group-id-hidden").val();
        var group_name = trim($(this).siblings("span").html());
        //获取历史记录
        var last_chat_id = gChatRoomManager.GetChatId("group", group_id);
        SendGroupChatHistoryMsg(group_id, group_name, gUserInfo.leader_id, last_chat_id);
    });
    //聊天室输入框
    $(document).on('focus', '.textarea', function () {
        $(document.body).animate({
            scrollTop: 900
        });
    });
    //查看所有人的朋友圈
    $(document).on("click", "#btn-friend-circle", function () {
        var o = {
            leader_id: gUserInfo.leader_id,
            avatar: gUserInfo.avatar,
            name: gUserInfo.nickname,
            title: '朋友圈'
        };
        SaveHistory(PS_ALL_FRIEND_CIRCLE, o);
        var $page = gFriendCircleManager.GetFriendCircleWnd("all", gUserInfo.leader_id, gUserInfo.avatar, gUserInfo.nickname);
        ShowPage($page);
        gFriendCircleManager.EnterFriendCircle("all", gUserInfo.leader_id, gUserInfo.avatar, gUserInfo.nickname);
    });
    //查看单个人的朋友圈
    $(document).on("click", ".post_avatar", function () {
        var callback = function (that) {
            console.log("post-avatar");
            var leader_id = $(that).siblings(".post_leader_id").val();
            var avatar = $(that).attr("src");
            var name = trim($(that).siblings(".post_right").find(".post_head .post_user").html());
            var o = {
                leader_id: leader_id,
                avatar: avatar,
                name: name,
                title: name
            };
            SaveHistory(PS_SINGLE_FRIEND_CIRCLE, o);
            var $page = gFriendCircleManager.GetFriendCircleWnd("single", leader_id, avatar, name);
            ShowPage($page);
            gFriendCircleManager.EnterFriendCircle("single", leader_id, avatar, name);
        }
        fireIScroll(callback, this);
    });
    //朋友圈点赞
    $(document).on("click", ".btn_post_favorite", function (event) {
        var callback = function (that) {
            console.log("enter btn_post_favorite");
            console.log(that);
            /*event.preventDefault();*/
            var post_id = trim($(that).parent().parent().parent().parent().find(".post_id").val());
            if ($(that).css("background-image").indexOf("favorite.png") != -1) {
                $(that).css("background-image", 'url("img/favorite.2.png")'); //点赞
                var lf = $(that).siblings(".favoriter_avatar");
                var avatar = gUserInfo.avatar;
                var f = '<div class="favoriter_avatar">' +
                    '<input type="hidden" value="' + gUserInfo.leader_id + '" class="favorite_id"/>' +
                    '<img src="' + avatar + '"</div>';
                $(that).parent().prepend(f);
                if (lf.length > 6) {
                    $(this).siblings(".favoriter_avatar").eq(7).hide();
                }
                //发送点赞消息
                SendPostFavoriteMsg(post_id, gUserInfo.leader_id);
            } else { //取消点赞
                $(that).css("background-image", 'url("img/favorite.png")');
                $(that).siblings(".favoriter_avatar").eq(0).remove();
                SendPostUnFavoriteMsg(post_id, gUserInfo.leader_id);
            }
        }
        fireIScroll(callback, this);
    });
    //发表朋友圈说说
    $("#publish-circle-btn").click(function () {
        var callback = function (that) {
            var imgs = [], text = '';
            $("#page-publish-circle .file-url").each(function (i, val) {
                imgs.push($(this).val());
            });
            text = trim($("#page-publish-circle .publish-circle-text").html());
            if (imgs.length == 0 && text.length == 0) {
                swal("", "文字和内容不能同时为空!", "error");
                return;
            }
            SendNewPostMsg(gUserInfo.leader_id, gUserInfo.avatar, gUserInfo.nickname, text, imgs);
            window.history.back(); //再回退一步
        }
        fireIScroll(callback, this);
    });
    //打开朋友圈评论编辑窗口
    $(document).on('click', ".btn_post_review", function () {
        var callback = function (that) {
            ShowPostReviewEditor();
            //给gPostId赋值;
            gPostId = trim($(that).parent().parent().parent().parent().find(".post_id").val());
        }
        fireIScroll(callback, this);
    });
    //对说说开始评论
    $(document).on('click', '#pre_release_btn', function () {
        var str_review = $(".post_review_editor .pre_input").html();
        console.log("str_review = " + str_review);
        var review = trim(str_review);
        Log("gPostId = " + gPostId);
        if (review.length > 0 && gPostId > 0) {
            Log("gPostId=" + gPostId);
            Log("review = " + review);
            SendPostReviewMsg(gPostId, gUserInfo.leader_id, review);
            $(".post_review_editor .pre_input").empty();
            $("#pre_cancel_btn").trigger("click");
        } else {
            swal('', '评论内容不能为空', 'error');
        }
    });
    //取消说说评论
    $(document).on('click', '#pre_cancel_btn', function () {
        $(".post_review_editor_bk").hide();
        $(".post_review_editor").hide();
    });
    //进入朋友圈说说编辑页面
    $(document).on("click", ".btn-new-post", function () {
        var callback = function (that) {
            var o = {
                leader_id: gUserInfo.leader_id,
                title: '发表说说'
            };
            console.log("发表说说了");
            SaveHistory(PS_PUBLISH_CIRCLE, o);
            ShowPage($("#page-publish-circle"));
        }
        fireIScroll(callback, this);
    });
    //单击群成员开始私聊
    $(document).on("click", '.gmlist-top .user-item', function () {
        var other_leader_id = trim($(this).find(".user-leader-id").val());
        var user_name = trim($(this).find(".user-name").html());
        var $userChatWnd = gChatRoomManager.GetChatWnd("user", user_name, other_leader_id);
        gChatRoomManager.EnterChatRoom("user", other_leader_id);
        //浏览记录压栈
        var o = {
            leader_id: other_leader_id,
            title: "与" + user_name + '私聊中...'
        };
        SaveHistory(PS_USER_CHAT, o);
        ShowPage($userChatWnd);
        //获取历史记录
        var last_chat_id = gChatRoomManager.GetChatId("user", other_leader_id);
        if (last_chat_id == "max") {
            console.log("gmlist-top .user-item");
            SendUserChatHistoryMsg(gUserInfo.leader_id, user_name, other_leader_id, "max");
        }
    });
    //打开一斗投资介绍窗口
    $(".setting-about").click(function () {
        $(".page").css('display', 'none');
        $("#page-3").css('display', 'block');
    });
    $(".go-back").click(function () {
        $(".page").css('display', 'none');
        $("#page-1").css('display', 'block');
    });
    $(".setting-qrcode").click(function () {
        $(".page").css('display', 'none');
        $("#page-4").css('display', 'block');
    });
    $(".setting-group").click(function () {
        $(".page").css('display', 'none');
        $("#page-5").css('display', 'block');
    });
    //获取验证码
    $("#get-verify-code").click(function () {
        var mobile = trim($("#mobile").val());
        if (mobile.length != 11) {
            swal("", "请输入11位的手机号码!", "error");
            return;
        }
        if (gEnableSendSm) {
            SendSm();
            gEnableSendSm = false;
            var $verifyCode = $("#get-verify-code");
            $verifyCode.removeClass("btn-primary");
            $verifyCode.addClass("btn-disable-gray");
            var cInterval = setInterval(function () {
                gSendSmStep = gSendSmStep - 1;
                $verifyCode.empty().html("剩余" + gSendSmStep + "秒");
                if (gSendSmStep == 0) {
                    gSendSmStep = 30;
                    $verifyCode.removeClass("btn-disable-gray");
                    $verifyCode.addClass("btn-primary");
                    $verifyCode.empty().html("获取验证码");
                    clearInterval(cInterval);
                    gEnableSendSm = true;
                }
            }, 1000);
        } else {
            return false;
        }
    });
    //注册按钮
    $("#register-btn").click(function () {
        if (gInRegister) {
            swal('', "浏览器版本过低，请使用最新浏览器注册!", "error");
            return;
        }
        var name = trim($("#nickname").val());
        var mobile = trim($("#mobile").val());
        var verifyCode = trim($("#verify-code").val());
        if (gUserNeedRegister && gUserAvatarUploadSuccess == false) {
            swal("", "请上传用户头像!", "error");
            return;
        }
        if (name.length < 2 || name.length > 6) {
            swal("", "昵称长度为2-6个字符!", "error"); //$("#nickname").focus();
            return;
        }
        if (mobile.length != 11) {
            swal("", "手机号码长度为11位!", "error"); //$("#mobile").focus();
            return;
        }
        if (verifyCode != gVerifyCode) {
            swal("", "手机验证码有误!", "error") //$("#verify-code").focus();
            return;
        }
        gUserInfo.version = "1.0.0";
        gUserInfo.nickname = name;
        gUserInfo.mobile = mobile;
        gUserInfo.avatar = gUserAvatarUploadPath;
        gInRegister = true;
        connect();
    });
    $(".btn-follow-user").click(function () {
        var leader_id = gUserInfo.leader_id;
        var follow_leader_id = trim($(this).siblings(".ud-top").find(".user-leader-id").val());
        SendFollowSingleUser(leader_id, follow_leader_id, "page_user_detail");
        //alert("leader_id = "+leader_id + ", follow_leader_id = "+follow_leader_id);
    });
    $(".btn-unfollow-user").click(function () {
        var leader_id = gUserInfo.leader_id;
        var follow_leader_id = trim($(this).siblings(".ud-top").find(".user-leader-id").val());
        SendUnfollowSingleUser(leader_id, follow_leader_id, "page_user_detail");
    });
    var register_count = 0;
    $(".btn-finish-create-group").click(function () {
        if (gCreatePrivateGroup.in_register) {
            return;
        }
        var group_name = trim($(".create-group-name").val());
        var group_intro = trim($(".create-group-intro").val());
        if (gCreatePrivateGroup.avatarUploadSuccess == false) {
            swal("", "请上传群用户头像!", "error");
            return;
        }
        if (group_name.length < 2 || group_name.length > 8) {
            swal("", "群名称长度为2-8个字符!", "error");
            return;
        }
        if (group_intro.length < 6 || group_intro.length > 60) {
            swal("", "群介绍长度为6-60个字符!", "error");
            return;
        }
        gCreatePrivateGroup.in_register = true;
        if (register_count == 0) {
            ++register_count;
            SendCreatePrivateGroupMsg(gCreatePrivateGroup.avatarPath, group_name, group_intro, gUserInfo.leader_id);
        }
    });
});
