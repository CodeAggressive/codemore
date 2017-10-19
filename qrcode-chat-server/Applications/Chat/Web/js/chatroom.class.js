var CChatRoom = function (roomType, roomTitle, roomID) {
    this._roomType = roomType;
    this._roomTitle = roomTitle;
    this._roomID = roomID;
    this._iScroll = null;
    this._lastChatId = "max";
    this._hasMoreData = true;
    this._loadingMore = false;
}
CChatRoom.prototype = {
    UpdateChatId: function (chatId) {
        this._lastChatId = chatId;
    },
    GetChatId: function () {
        return this._lastChatId;
    },
    SetChatId: function (chat_id) {
        this._lastChatId = chat_id;
    },
    NoMoreData: function () {
        this._hasMoreData = false;
    },
    _newChatWnd: function () {
        var btnGroup = (this._roomType == "group") ? '<img class="btn-view-group-detail" src="img/icon_group_active.png"/>' : '';
        var wnd = '<div class="page" id="' + this._roomType + '-chat-' + this._roomID + '">'
            + '<div class="chat-room">'
            + '<div class="pull-down">'
            //+ '<div class="pull-down-icon"></div>'
            + '<div class="pull-down-text">加载更多</div>'
            + '</div></div>'
            + '<div class="chat-submit">'
            + '<input type="hidden" value="' + this._roomID + '" class="' + this._roomType + '-id-hidden"/>'
            + '<div class="btn-emotion"></div>'
            + '<div  contenteditable="true" class="textarea"  placeholder="请输入文字"></div>'
            + '<div class="btn-send-' + this._roomType + '-msg">发送</div>'
            + '<div class="swiper-container ld-em-wrapper"></div>'
            + '</div>'
            + '<div class="chat-wnd-title"><span style="color:#D81E06;">' + this._roomTitle + '</span>' + btnGroup + '</div>'
            + '</div>';
        $(document.body).append(wnd);
        var emContainer = "#" + this._roomType + "-chat-" + this._roomID +" .ld-em-wrapper";
        var emTarget = "#" + this._roomType + "-chat-" + this._roomID + " .textarea";
        $("#" + this._roomType + "-chat-" + this._roomID).find(".btn-emotion").mobileEmotion(
            {target: emTarget, container: emContainer}
        );
        return ($('#' + this._roomType + '-chat-' + this._roomID));
    },
    _newIScroll: function () {
        var $pullDown = $('.pull-down');
        var topOffset = $pullDown[0].offsetHeight;
        var that = this;
        setTimeout(function () {
            that._iScroll = new IScroll('#' + that._roomType + '-chat-' + that._roomID, {
                preventDefault: true,
                click: true,
                topOffset: topOffset,
                probeType: 2,
                bounce:true,
                bindToWrapper: true,
                preventDefaultException: {
                    tagName: /^(img)$/,
                    className: /(^|\s)textarea|btn-send-user-msg|btn-send-group-msg(\s|$)/
                }
            });
            that._iScroll.on('scroll', function () {
                if (this.y > topOffset) {
                    that._loadingMore = true;
                }
            });
            that._iScroll.on('scrollEnd', function () {
                if (that._loadingMore && that._roomType == "group") {
                    SendGroupChatHistoryMsg(that._roomID, that._roomTitle, that._roomID, that._lastChatId);
                }else if(that._loadingMore && that._roomType == "user"){
                    SendUserChatHistoryMsg(gUserInfo.leader_id,that._roomTitle,that._roomID,that._lastChatId);
                }
            });
        }, 0);
    },
    GetChatWnd: function () {
        var $wnd = $("#" + this._roomType + "-chat-" + this._roomID);
        if ($wnd.length == 0) {
            $wnd = this._newChatWnd();
            this._newIScroll();
            console.log("New Iscroll = " + this._iScroll);
        }
        return $wnd;
    },
    AppendData: function (content, bDirection) {
        var $chat_room = this.GetChatWnd().find(".chat-room");
        if (bDirection) {
            $chat_room.append(content);
        } else {
            $chat_room.find(".pull-down").after(content);
        }
    },
    Refresh: function (idx) {
        var that = this;
        setTimeout(function () {
            that._iScroll.refresh();
            // We should avoid this pitfall here.
            if(idx == "last"){
                that._iScroll.scrollToElement(".chat-item:last-child", 0);
            }else {
                that._iScroll.scrollToElement(".chat-item:nth-child(" + idx + ")", 0);
            }
        }, 0);
    }
}
//原型模式，全局唯一
var CChatRoomManager = function () {
}
CChatRoomManager.prototype = {
    _chatRooms:[], //所有聊天窗口
    _roomEnter:[], //所有聊天窗口的进入状态

    GetChatWnd: function (roomType, roomTitle, roomId) {
        if (IsPageExist("#" + roomType + '-chat-' + roomId)) {
            return this._chatRooms[roomType+roomId].GetChatWnd();
        } else {
            this._chatRooms[roomType+roomId] = new CChatRoom(roomType, roomTitle, roomId);
            console.log(this._chatRooms);
            return this._chatRooms[roomType+roomId].GetChatWnd();
        }
    },
    GetChatId: function (roomType, roomId) {
        return this._chatRooms[roomType+roomId].GetChatId();
    },
    SetChatId: function (roomType, roomId, chat_id) {
        this._chatRooms[roomType+roomId].SetChatId(chat_id);
    },
    UpdateGroupChatID: function (group_id, chat_id) {
        this._chatRooms["group"+group_id].UpdateChatId(chat_id);
    },
    UpdateUserChatID: function (user_id, chat_id) {
        this._chatRooms["user"+user_id].UpdateChatId(chat_id);
    },
    AppendDataToChatRoom: function (roomType, roomId, content, bDirection) {
        this._chatRooms[roomType+roomId].AppendData(content,bDirection);
    },
    RefreshChatRoom: function (roomType, roomId,idx) {
        this._chatRooms[roomType+roomId].Refresh(idx);
    },
    EnterChatRoom: function (roomType, roomId) {
        Log1("进入用户聊天室了 [" +roomType+','+ roomId+']');
        this._roomEnter[roomType+roomId] = true;
        var room = this._chatRooms[roomType+roomId];
        var last_chat_id = this.GetChatId(roomType, roomId);
        if(last_chat_id == "max")//如果没有加载过聊天历史记录就开始加载
        {
            if(roomType == "user"){
                SendUserChatHistoryMsg(gUserInfo.leader_id, room._roomTitle, room._roomID, "max");
            }else if(roomType == "group"){
                SendGroupChatHistoryMsg(room._roomID, room._roomTitle, gUserInfo.leader_id, "max");
            }
        }
    },
    ExitChatRoom: function (roomType,roomId) {
        this._roomEnter[roomType+roomId] = false;
        if(roomType == "user"){
            ClearNoticeItem(NOTICE_UNREAD_USER_CHAT, roomId); //如果用户的通知存在就更新.
        }else if(roomType == "group"){
            ClearNoticeItem(NOTICE_UNREAD_GROUP_CHAT, roomId); //如果用户的通知存在就更新
        }
        Log1("退出聊天室了 " +roomType+','+ roomId);

    }
} // end of CChatRoomManager

//首页通知类
var CNotice = function (type, hideData, avatar, title, content, time, count) {
    this._type = type;
    this._hideData = hideData;
    this._avatar = avatar;
    this._title = title;
    this._content = content;
    this._time = time;
    this._count = count;
}


var CNoticeManager = function () {
}
//消息管理器
CNoticeManager.prototype = {
    notices: [], //所有通知消息
    sorted: false, //是否排序
    notice_count: 0, //通知个数
    Push: function (notice) {
        if (notice instanceof CNotice) {
            this.notices.push(notice);
            this.notice_count++;
        }
    },
    GetCount:function(){
      return this.notice_count;
    },
    Sort: function () {
        if (this.sorted) //只排序一次就够了
            return;
        this.notices.sort(function (a, b) { //原地排序，不生成副本
            var ta = new Date(a._time).getTime();
            var tb = new Date(b._time).getTime();
            if ((ta < tb)) {
                return 1;
            } else if (ta > tb) {
                return -1;
            } else {
                return 0;
            }
        })
    },
    Html: function () {
        this.Sort();
        var _html = '';
        for (var i = 0; i < this.notices.length; i++) {
            var obj = this.notices[i];
            _html += NewNoticeItem(obj._type, obj._hideData, obj._avatar, obj._title, obj._content, FormatTime(obj._time), obj._count);
        }
        return _html;
    },
    Dump: function () {
        //console.log(JSON.stringify(this.notices));
    }
};